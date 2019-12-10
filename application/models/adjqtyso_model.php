<?php
class Adjqtyso_model extends MY_Model
{
    public function getDiffItems($stonbr) {
        $this->db->select('s.sto_rack as rack, s.sto_bin as bin_code,
                           s.sto_item as item_code, m.description, m.category, m.uom, 
                           s.sto_qty, s.sto_qtyreal,
                           (s.sto_qtyreal - s.sto_qty) as qty_to_adj');
        $this->db->from('sto_hist s');
        $this->db->join('item_master m', 's.sto_item = m.item_code', 'left');
        $this->db->where('s.sto_nbr', $stonbr);
        $this->db->where('s.sto_status', 'OPN');
        $this->db->where('(s.sto_qty - s.sto_qtyreal) <> ', 0);
        $this->db->where('s.sto_updatedby IS NOT NULL', null, true);
        $this->db->order_by('s.sto_bin, s.sto_item');

        $query = $this->db->get();

        return $query->result();
    }

    public function adjStock($stonbr) {
        $this->db->select('s.sto_bin, s.sto_item, s.sto_qty,
                           s.sto_qtyreal, (s.sto_qtyreal - s.sto_qty) as qty_to_adj');
        $this->db->from('sto_hist s');
        $this->db->where('s.sto_nbr', $stonbr);
        $this->db->where('s.sto_status', 'OPN');
        $this->db->where('(s.sto_qty - s.sto_qtyreal) <> ', 0);
        $this->db->where('s.sto_updatedby IS NOT NULL', null, true);
        $this->db->order_by('s.sto_bin, s.sto_item');

        $query = $this->db->get();
		
		// print_r($this->db->last_query()); die();

        $this->db->trans_begin();

        foreach ($query->result() as $row) {
            $sql = " select qty as qtybin
                       from item_detail
                      where bin_code = '".$row->sto_bin."'
                        and item_code = '".$row->sto_item."' ";
            $query = $this->db->query($sql);

            $latest_binqty = $query->row('qtybin');
            $qty_adj = $row->qty_to_adj;
            $newqty = $latest_binqty + $qty_adj;

            $data = array(
                            'item_code' => $row->sto_item,
                            'bin_code' => $row->sto_bin,
                            'trans_type' => 'J',
                            'old_qty' => $latest_binqty,
                            'qty' => $qty_adj,
                            'new_qty' => $newqty,
                            'reference' => 'ADJSO - '.$stonbr,
                            'vendor' => '-',
                            'created_by' => $this->session->userdata('username'),
                            'updated_by' => $this->session->userdata('username')
                        );
            $this->db->insert('item_trans', $data);

            $data = array (
                            'qty' => $newqty,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'updated_by' => $this->session->userdata('username')
                        );
            $this->db->where('bin_code', $row->sto_bin);
            $this->db->where('item_code', $row->sto_item);
            $this->db->update('item_detail', $data);

            $sql = " update item_master
                        set qty_eStockCard = qty_eStockCard + (". $qty_adj .") ,
                            updated_at = '". date('Y-m-d H:i:s') ."' ,
                            updated_by = '". $this->session->userdata('username') ."'
                      where item_code = '".$row->sto_item."' ";
            $this->db->query($sql);
        }

        $data = array (
                        'sto_status' => 'CLS',
                        'sto_findate' => date('Y-m-d')
                    );
        $this->db->where('sto_status', 'OPN');
        $this->db->update('sto_hist', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
