<?php
class Chgitmnbr_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        // $CI = &get_instance();
        // $this->db_gss = $CI->load->database('GSS', TRUE);
    }

    public function getListItemChg() {
        $this->db->select('id, chg_itmefg, chg_itmgss');
        $this->db->from('chg_item');
        $this->db->order_by('chg_itmefg', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }

    public function execChgItmNbr() {
		$this->db->select('id, chg_itmefg, chg_itmgss');
        $this->db->from('chg_item');
        $this->db->order_by('chg_itmefg', 'ASC');

        $query = $this->db->get();



		$this->db->trans_begin();

        foreach ($query->result() as $item) {
			$data = array (
                            'item_code' => $item->chg_itmgss
                        );
            $this->db->where('item_code', $item->chg_itmefg);
            $this->db->update('item_detail', $data);

			// print_r($this->db->last_query()); die();

            // $sql = " update item_master
            //             set item_codeold = item_code
            //           where item_code = $item->chg_itmefg ";
            // $query = $this->db->query()

            $data = array (
                            'item_codeold' => $item->chg_itmefg,
                            'item_code' => $item->chg_itmgss
                        );
            $this->db->where('item_code', $item->chg_itmefg);
            $this->db->update('item_master', $data);

			$data = array (
                            'item_code' => $item->chg_itmgss
                        );
            $this->db->where('item_code', $item->chg_itmefg);
            $this->db->update('item_trans', $data);

			$data = array (
                            'sto_item' => $item->chg_itmgss
                        );
            $this->db->where('sto_item', $item->chg_itmefg);
			// $this->db->where('sto_nbr', '2019053101');
            $this->db->update('sto_hist', $data);


            $data = array (
                            'hod_item' => $item->chg_itmgss
                        );
            $this->db->where('hod_item', $item->chg_itmefg);
            $this->db->update('hod_det', $data);




		}

		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
	}

}
