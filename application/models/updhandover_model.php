<?php
class Updhandover_model extends MY_Model {

    public function getBstHdr($nbr) {
        $this->db->select('a.hvr_nbr, a.hvr_status, a.hvr_adddt, a.hvr_useradd, a.hvr_moddt, a.hvr_usermod, a.hvr_aprvdt, a.hvr_useraprv');
        $this->db->from('hvr_mstr a');
        $this->db->where('a.hvr_nbr', $nbr);
        $query = $this->db->get();

        return $query->row();
    }

    var $order = array('hod_id' => 'asc');
    var $table = 'hod_det';
    var $idq = 'hod_id';
    var $column_order =  array('a.hod_id', 'a.hod_nbr', 'a.hod_item', 'a.hod_desc', 'a.hod_uom', 'a.hod_qty', 'a.hod_spk', 'a.hod_wo', 'a.hod_packnbr');
    var $column_search = array('a.hod_id', 'a.hod_nbr', 'a.hod_item', 'a.hod_desc', 'a.hod_uom', 'a.hod_qty', 'a.hod_spk', 'a.hod_wo', 'a.hod_packnbr');

    public function __construct()
    {
        parent::__construct();
    }

    public function loadBstDetail($nbr) {
        $this->db->select('a.hod_id, a.hod_nbr, a.hod_item, a.hod_desc, a.hod_uom, a.hod_qty,
                           a.hod_spk, a.hod_wo, a.hod_packnbr, a.hod_rmks, a.hod_status, a.hod_adddt, a.hod_useradd, a.hod_moddt, a.hod_usermod');
        $this->db->from('hod_det a');
        $this->db->where('a.hod_nbr', $nbr);

        $query = $this->db->get();

        return $query->result();
    }

    public function chkIsItemExist($nbr, $itm) {
        $sql = " select count(*) as cnt
                   from hod_det
                  where hod_nbr = '".$nbr."'
                    and hod_item = '".$itm."' ";
        $query = $this->db->query($sql);

        if ((int)$query->row('cnt') > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addBstItem($nbr, $itm, $desc, $uom, $qty, $spk, $wo, $pack, $rmk) {
		$this->db->trans_begin();

		$data = array (	'hod_nbr' => $nbr,
						'hod_item' => $itm,
						'hod_desc' => $desc,
						'hod_uom' => $uom,
						'hod_qty' => $qty,
						'hod_spk' => $spk,
						'hod_wo' => $wo,
						'hod_packnbr' => $pack,
                        'hod_rmks' => $rmk,
                        'hod_status' => 'CREATE',
						'hod_useradd' => $this->session->userdata('username'),
                        'hod_usermod' => $this->session->userdata('username')
						);
		$this->db->insert('hod_det', $data);

		// print_r($this->db->last_query()); die();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}

    public function getBstItemDtl($nbr, $itm) {
        $this->db->select('a.hod_nbr, a.hod_item, a.hod_desc, a.hod_uom, a.hod_qty,
                           a.hod_spk, a.hod_wo, a.hod_packnbr, a.hod_rmks');
        $this->db->from('hod_det a');
		$this->db->where('a.hod_nbr', $nbr);
        $this->db->where('a.hod_item', $itm);
		$query = $this->db->get();

		return $query->row();
    }

    public function updBstDtl($nbr, $itm, $qty, $spk, $wo, $pack, $rmk) {
        $this->db->trans_begin();

        $data = array (	'hod_qty' => $qty,
                        'hod_spk' => $spk,
                        'hod_wo' => $wo,
                        'hod_packnbr' => $pack,
                        'hod_rmks' => $rmk );
        $this->db->where('hod_nbr', $nbr);
        $this->db->where('hod_item', $itm);
        $this->db->update('hod_det', $data);

        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
            return false;
		} else {
			$this->db->trans_commit();
            return true;
		}
    }

    public function delBstItem($nbr, $itm) {
        $this->db->trans_begin();

        $this->db->where('hod_nbr', $nbr);
        $this->db->where('hod_item', $itm);
        $this->db->delete('hod_det');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
