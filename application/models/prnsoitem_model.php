<?php
class Prnsoitem_model extends MY_Model
{
    public function getBinItems($stonbr, $frrack, $torack) {
        $this->db->select('s.sto_rack as rack, s.sto_bin as bin_code,
                           s.sto_item as item_code, m.description, m.category, m.uom, 
                           truncate(s.sto_qty, 2) as qty,
                           truncate(s.sto_qtyreal, 2) as qtyreal,
                           truncate(s.sto_qtyng, 2) as qtyng, s.sto_rmks');
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

    public function getRackList($nbr, $fr, $to)  {
        $this->db->select('rack_code, '."'".$nbr."'". " as stonbr"  );
        $this->db->from('rack_master');
        $this->db->where('rack_code >=', $fr);
        $this->db->where('rack_code <=', $to);
        $query = $this->db->get();
        $data = $query->result_array();

        //return $this->db->last_query();

        return $this->improve_data($data);
    }

    public function improve_data($data) {
        foreach ($data as $key => $val) {
            $this->db->select('s.sto_bin as bin_code, s.sto_item as item_code, 
                               m.description, m.category, m.uom, truncate(s.sto_qty, 2) as qty');
            $this->db->from('sto_hist s');
            $this->db->join('item_master m', 's.sto_item = m.item_code');
            $this->db->where('s.sto_nbr', $val['stonbr']);
            $this->db->where('substring(s.sto_bin, 1, 5) = ', $val['rack_code']);
            $this->db->order_by('s.sto_bin, s.sto_item');

            $query = $this->db->get();
            $detail = $query->result_array();
            $data[$key]['detail'] = $detail;
        }

        return $data;
    }

    public function getMaxStoNbr() {
        $sql = " select max(sto_nbr) as maxNbr
                   from sto_hist ";
        $query = $this->db->query($sql);

        return $query->row('maxNbr');
    }

}
