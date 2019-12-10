<?php
class Addhandover_model extends MY_Model
{
    public function chkIsItemExist($itm) {
        $sql = " select count(*) as cnt
                   from tmp_bst
                  where tmp_item = '".$itm."'
                    and tmp_user = '".$this->session->userdata('username')."' ";
        $query = $this->db->query($sql);

        if ((int)$query->row('cnt') > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function chkIsItemBSTExist() {
        $sql = " select count(*) as cnt
                   from tmp_bst
                  where tmp_user = '".$this->session->userdata('username')."' ";
        $query = $this->db->query($sql);

        if ((int)$query->row('cnt') > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function chkNotEmptyItm($nbr) {
        $sql = " select count(*) as cnt
                   from tmp_bst
                  where tmp_nbr = '".$nbr."' ";
        $query = $this->db->query($sql);

        if ((int)$query->row('cnt') > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getNewBstNbr() {
        $sql = " select concat(substring(year(now()), 3,2), month(now())) as str_yymm,
					    IFNULL(LPAD(cast(max(substring(hvr_nbr, 5, 4)) + 1 as char), 4, '0'), '0001') as str_seq
				   from hvr_mstr
				  where hvr_nbr like concat(substring(year(now()), 3,2), '%') ";
        $query = $this->db->query($sql);
        $result = $query->row();

		$newbstnbr = $result->str_yymm.$result->str_seq;

        // print_r($newreqnbr); die();
        return $newbstnbr;
    }

    public function delTmpBstItem() {
        $this->db->trans_begin();

        $this->db->where('tmp_nbr >', '19100000');
        $this->db->delete('tmp_bst');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function addTmpItmBst($nbr, $itm, $desc, $uom, $qty, $spk, $wo, $pack, $rmk) {
        $this->db->trans_begin();

        $data = array (	'tmp_nbr' => $nbr,
                        'tmp_item' => $itm,
						'tmp_desc' => $desc,
                        'tmp_uom' => $uom,
                        'tmp_qty' => $qty,
                        'tmp_spk' => $spk,
                        'tmp_wo' => $wo,
                        'tmp_packnbr' => $pack,
                        'tmp_rmks' => $rmk,
                        'tmp_user' => $this->session->userdata('username')
                        );
        $this->db->insert('tmp_bst', $data);

        // print_r($this->db->last_query()); die();

        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
            return false;
		} else {
			$this->db->trans_commit();
            return true;
		}
    }

    public function loadTmpBstItem() {
        $this->db->select('a.*');
        $this->db->from('tmp_bst a');

        $query = $this->db->get();

        return $query->result();
    }

    public function submitBst($nbr) {
        $this->db->trans_begin();

        $data = array (
                    'hvr_nbr' => $nbr,
                    'hvr_useradd' => $this->session->userdata('username'),
                    'hvr_usermod' => $this->session->userdata('username')
                );
        $this->db->insert('hvr_mstr', $data);

        $sql = " insert into hod_det (hod_nbr, hod_item, hod_desc, hod_uom, hod_qty, hod_spk, hod_wo, hod_packnbr, hod_rmks, hod_status, hod_useradd, hod_usermod)
                               select tmp_nbr, tmp_item, tmp_desc, tmp_uom, tmp_qty, tmp_spk, tmp_wo, tmp_packnbr, tmp_rmks, 'CREATE', '".$this->session->userdata('username')."', '".$this->session->userdata('username')."'
                                 from tmp_bst
                                where tmp_nbr = '".$nbr."' ";
        $query = $this->db->query($sql);

        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
            return false;
		} else {
			$this->db->trans_commit();
            return true;
		}
    }

    public function delTmpBst($nbr) {
        $this->db->trans_begin();

        $this->db->where('tmp_nbr', $nbr);
        $this->db->delete('tmp_bst');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getTmpItmDtl($nbr, $itm) {
        $this->db->select('a.tmp_nbr, a.tmp_item, a.tmp_desc, a.tmp_uom, a.tmp_qty,
                           a.tmp_spk, a.tmp_wo, a.tmp_packnbr, a.tmp_rmks');
        $this->db->from('tmp_bst a');
		$this->db->where('a.tmp_nbr', $nbr);
        $this->db->where('a.tmp_item', $itm);
		$query = $this->db->get();

		return $query->row();
    }

    public function updTmpItm($nbr, $itm, $qty, $spk, $wo, $pack, $rmk) {
        $this->db->trans_begin();

        $data = array (	'tmp_qty' => $qty,
                        'tmp_spk' => $spk,
                        'tmp_wo' => $wo,
                        'tmp_packnbr' => $pack,
                        'tmp_rmks' => $rmk );
        $this->db->where('tmp_nbr', $nbr);
        $this->db->where('tmp_item', $itm);
        $this->db->update('tmp_bst', $data);

        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
            return false;
		} else {
			$this->db->trans_commit();
            return true;
		}
    }

    public function deleteItemTmp($nbr, $itm) {
        $this->db->trans_begin();

        $this->db->where('tmp_nbr', $nbr);
        $this->db->where('tmp_item', $itm);
        $this->db->delete('tmp_bst');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


}
