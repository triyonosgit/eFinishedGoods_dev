<?php
class Bstsubmit_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function getBstHdr() {
        $this->db->select('a.hvr_id, a.hvr_nbr, a.hvr_status, b.code_cmmt, date_format(a.hvr_adddt, \'%Y-%m-%d %H:%i\') as hvr_adddt, a.hvr_useradd,
                           a.hvr_moddt, a.hvr_usermod, ifnull(date_format(a.hvr_aprvdt, \'%Y-%m-%d %H:%i\'), \'-\') as hvr_aprvdt, ifnull(a.hvr_useraprv, \'-\') as hvr_useraprv');
        $this->db->from('hvr_mstr a');
        $this->db->join('code_mstr b', 'b.code_fldname = \'hvr_status\' and a.hvr_status = b.code_value');
        // $this->db->where_in('a.hvr_status', array('SENT', 'SUBMITED'));
        $this->db->where('a.hvr_status', 'SENT');
        $this->db->order_by('a.hvr_id', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getBstDetail($nbr) {
        $this->db->select('a.hod_id, a.hod_nbr, a.hod_item, a.hod_desc, a.hod_uom, a.hod_qty,
                           a.hod_spk, a.hod_wo, a.hod_packnbr, a.hod_rmks, a.hod_status,
                           a.hod_adddt, a.hod_useradd, a.hod_moddt, a.hod_usermod');
        $this->db->from('hod_det a');
        $this->db->where('a.hod_nbr', $nbr);

        $query = $this->db->get();

        // print_r($this->db_gss->last_query()); die();

        return $query->result();
    }

    public function getBstDetail2($nbr) {
        $this->db->select('a.hod_id, a.hod_nbr, a.hod_item, a.hod_desc, a.hod_uom, a.hod_qty,
                           a.hod_spk, a.hod_wo, a.hod_packnbr, a.hod_status, a.hod_rmks,
                           a.hod_adddt, a.hod_useradd, a.hod_moddt, a.hod_usermod');
        $this->db->from('hod_det a');
        $this->db->where('a.hod_nbr', $nbr);

        $query = $this->db->get();

        return $query->row();
    }

    public function returnBST($nbr) {
        $this->db->trans_begin();

        $data = array (	'hvr_status' => 'REVISION' );
        $this->db->where('hvr_nbr', $nbr);
        $this->db->update('hvr_mstr', $data);

        $data = array (	'hod_status' => 'REVISION' );
        $this->db->where('hod_nbr', $nbr);
        $this->db->update('hod_det', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getListBin() {
        $this->db->select('a.bin_code');
        $this->db->from('bin a');
        $query = $this->db->get();

        return $query->result();
    }

    public function submitBST($nbr, $tableData) {
        $this->db->trans_begin();

        $totqty = 0;

        foreach ($tableData as $row) {
            // $this->db->select('qty_eStockCard');
            // $this->db->from('item_master');
            // $this->db->where('item_code',  $row['itemcode']);
            // $query = $this->db->get();
            //
			// $latestqty = (int)$query->row('qty_eStockCard');
            // $newqty = $latestqty + (int)$row['qtyrcvd'] ;



            $this->db->select('d.item_code, d.qty');
            $this->db->from('item_detail d');
            $this->db->where('d.item_code', $row['itemcode']);
            $this->db->where('d.bin_code', $row['bincode']);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $sql = " update item_detail
                            set qty = qty + ".(int)$row['qtyrcvd']." ,
                                updated_at = '". date('Y-m-d H:i:s') ."' ,
                                updated_by = '". $this->session->userdata('username') ."'
                          where item_code = '".$row['itemcode']."'
                            and bin_code = '".$row['bincode']."' ";
                $this->db->query($sql);

                $latestqty = (int)$query->row('qty');

                $data = array (	'item_code' => $row['itemcode'],
                                'bin_code' => $row['bincode'],
                                'trans_type' => 'R',
                                'old_qty' => $latestqty,
                                'qty' => (int)$row['qtyrcvd'],
        						'new_qty' => $latestqty + (int)$row['qtyrcvd'],
                                'reference' => 'BST '.$nbr,
                                'vendor' => 'SSM PRODUCTION',
                                'spknbr' => $row['spknbr'],
                                'wonbr' => $row['wonbr'],
                                'packnbr' => $row['packnbr'],
                                'created_by' => $this->session->userdata('username'),
                                'updated_by' => $this->session->userdata('username')
                                );
                $this->db->insert('item_trans', $data);
            } else {
                $data = array (	'item_code' => $row['itemcode'],
                                'bin_code' => $row['bincode'],
                                'qty' => (int)$row['qtyrcvd'],
                                'created_by' => $this->session->userdata('username'),
                                'updated_by' => $this->session->userdata('username')
                                );
                $this->db->insert('item_detail', $data);

                $data = array (	'item_code' => $row['itemcode'],
                                'bin_code' => $row['bincode'],
                                'trans_type' => 'R',
                                'old_qty' => 0,
                                'qty' => (int)$row['qtyrcvd'],
        						'new_qty' => (int)$row['qtyrcvd'],
                                'reference' => 'BST '.$nbr,
                                'vendor' => 'SSM PRODUCTION',
                                'spknbr' => $row['spknbr'],
                                'wonbr' => $row['wonbr'],
                                'packnbr' => $row['packnbr'],
                                'created_by' => $this->session->userdata('username'),
                                'updated_by' => $this->session->userdata('username')
                                );
                $this->db->insert('item_trans', $data);
            }


            $totqty = $totqty + (int)$row['qtyrcvd'];
        }

        $sql = " update item_master
                    set qty_eStockCard = qty_eStockCard + ".$totqty.",
                        updated_at = '". date('Y-m-d H:i:s') ."' ,
                        updated_by = '". $this->session->userdata('username') ."'
                  where item_code = '".$row['itemcode']."' ";
        // print_r($sql); die();
        $this->db->query($sql);

        $data = array (	'hvr_status' => 'SUBMITED',
                        'hvr_aprvdt' => date('Y-m-d H:i:s'),
                        'hvr_useraprv' => $this->session->userdata('username') );
        $this->db->where('hvr_nbr', $nbr);
        $this->db->update('hvr_mstr', $data);

        $data = array (	'hod_status' => 'SUBMITED' );
        $this->db->where('hod_nbr', $nbr);
        $this->db->update('hod_det', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getQtyOHItmBin($bin, $itm) {
        $this->db->select('qty');
        $this->db->from('item_detail');
        $this->db->where('item_code', $itm);
        $this->db->where('bin_code', $bin);
        $query = $this->db->get();

        // print_r($this->db->last_query()); die();

        if ($query->num_rows() > 0) {
            $qtyonhand = (int)$query->row('qty');
        } else {
            $qtyonhand = 0;
        }

        return $qtyonhand;
    }


}
