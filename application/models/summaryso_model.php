<?php
class Summaryso_model extends MY_Model
{
    public function getSOItem($stonbr, $frrack, $torack) {
        $this->db->select('s.sto_rack as rack, s.sto_bin as bin_code,
                           s.sto_item as item_code, m.description, m.category, m.uom, 
                           s.sto_qty,
                           s.sto_qtyreal,
                           (s.sto_qtyreal - s.sto_qty) as qty_to_adj1,
                           truncate(s.sto_qtygss, 2) as sto_qtygss,
                           s.sto_qtyreal,
                           (s.sto_qtyreal - truncate(s.sto_qtygss, 2)) as qty_to_adj2');
        $this->db->from('sto_hist s');
        $this->db->join('item_master m', 's.sto_item = m.item_code', 'left');
        $this->db->where('s.sto_nbr', $stonbr);
        $this->db->where('s.sto_rack >= ', $frrack);
        $this->db->where('s.sto_rack <= ', $torack);
        $this->db->order_by('s.sto_bin, s.sto_item');

        $query = $this->db->get();

        //return $this->db->last_query();
        return $query->result();
    }

    public function getDiffItems($stonbr, $frrack, $torack) {
        $this->db->select('s.sto_rack as rack, s.sto_bin as bin_code,
                           s.sto_item as item_code, m.description, m.category, m.uom, 
                           s.sto_qty,
                           s.sto_qtyreal,
                           (s.sto_qtyreal - s.sto_qty) as qty_to_adj');
        $this->db->from('sto_hist s');
        $this->db->join('item_master m', 's.sto_item = m.item_code', 'left');
        $this->db->where('s.sto_nbr', $stonbr);
        $this->db->where('s.sto_rack >= ', $frrack);
        $this->db->where('s.sto_rack <= ', $torack);
        $this->db->where('(s.sto_qty - s.sto_qtyreal) <> ', 0);
        $this->db->where('s.sto_updatedby IS NOT NULL', null, true);
        $this->db->order_by('s.sto_bin, s.sto_item');

        $query = $this->db->get();

        return $query->result();
    }

    public function getNGItems($stonbr, $frrack, $torack) {
        $this->db->select('s.sto_rack as rack, s.sto_bin as bin_code,
                           s.sto_item as item_code, m.description, m.category, m.uom, 
                           s.sto_qty,
                           s.sto_qtyreal,
                           s.sto_qtyng');
        $this->db->from('sto_hist s');
        $this->db->join('item_master m', 's.sto_item = m.item_code', 'left');
        $this->db->where('s.sto_nbr', $stonbr);
        $this->db->where('s.sto_rack >= ', $frrack);
        $this->db->where('s.sto_rack <= ', $torack);
        $this->db->where('s.sto_qtyng > ', 0);
        $this->db->where('s.sto_updatedby IS NOT NULL', null, true);
        $this->db->order_by('s.sto_bin, s.sto_item');

        $query = $this->db->get();

        return $query->result();
    }

}
