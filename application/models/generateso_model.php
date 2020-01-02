<?php
class Generateso_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        $CI = &get_instance();
        $this->db_gss = $CI->load->database('GSS', TRUE);
    }

    public function getSOHistHdr() {
        $this->db->select('sto_nbr, sto_strdate, sto_findate, sto_status');
        $this->db->from('sto_hist');
        // $this->db->where('sto_status', 'OPN');
        $this->db->group_by('sto_nbr');
        $this->db->order_by('sto_nbr', 'DESC');

        $query = $this->db->get();

        return $query->result();
    }

    function isAnyOpenSO() {
        $sql = " select count(*) as cnt
                   from sto_hist
                  where sto_status = 'OPN' ";
        $query = $this->db->query($sql);

        return $query->row('cnt');
    }
    
    function downloadData() {
        
        $this->db->select('item_code');
        $this->db->from('item_master');
        $this->db->where('id > ', 0);
		$this->db->where('enable', 'Y');
        $this->db->order_by('item_code');

        $query = $this->db->get();
		
        $this->db->trans_begin();

        foreach ($query->result() as $row) {
            $sqlchk = " select count(*) as cnt
                          from item_detail
                         where item_code = '".$row->item_code."' ";
            $query = $this->db->query($sqlchk);

            if ((int) $query->row('cnt') > 0) {
                $sqldtl = " select ucase(d.item_code) as item_code, m.description, m.uom,
                                   d.bin_code, d.qty 
                              from item_detail d
                              left join item_master m on d.item_code = m.item_code
                             where d.item_code = '".$row->item_code."' ";
                $querydtl = $this->db->query($sqldtl);

                foreach ($querydtl->result() as $rowdtl) {
                    $bincode = $rowdtl->bin_code;
                    $rackcode = substr($bincode, 0, 5);
                    $binqty  = $rowdtl->qty;
                    $gssbinqty = $this->getGssBinQty($bincode, $rowdtl->item_code);
					// $gssbinqty = 0;

                    $data = array(
                        'sto_nbr' => date('Ymd').'01',
                        'sto_strdate' => date('Y-m-d'),
                        'sto_rack' => $rackcode,
                        'sto_bin' => $bincode,
                        'sto_item' => $rowdtl->item_code,
                        'sto_desc' => $rowdtl->description,
                        'sto_uom' => $rowdtl->uom,
                        'sto_qty' => $rowdtl->qty,
                        'sto_qtygss' => $gssbinqty,
                        'sto_createdby' => 'admin'
                    );
                    $this->db->insert('sto_hist', $data);
                }

            } else {
                $sqlmst = " select item_code, description, uom, 
                                   'ZZZZZ' as rack, 'ZZZZZ1' as bin, qty_eStockCard as qty
                              from item_master
                             where item_code = '".$row->item_code."' ";
                $querymst = $this->db->query($sqlmst);
                
                if ($querymst->row('qty') > 0) {
                    $data = array(
                        'sto_nbr' => date('Ymd').'01',
                        'sto_strdate' => date('Y-m-d'),
                        'sto_rack' => $querymst->row('rack'),
                        'sto_bin' => $querymst->row('bin'),
                        'sto_item' => $querymst->row('item_code'),
                        'sto_desc' => $querymst->row('description'),
                        'sto_uom' => $querymst->row('uom'),
                        'sto_qty' => $querymst->row('qty'),
                        'sto_qtygss' => $querymst->row('qty'),
                        'sto_rmks2' => 'not check gss qty',
                        'sto_createdby' => 'admin'
                    );
                    $this->db->insert('sto_hist', $data);
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }



    function getGssBinQty($bin, $itm) {
        $sql = "select count(*) as cnt
				  from ITEM_MASTER
                 where BIN = '".$bin."'
                   and PART = '".$itm."' ";
		$query = $this->db_gss->query($sql);

		if ((int) $query->row('cnt') > 0) {
			$sql = " select QUANTITY 
                       from ITEM_MASTER
                      where BIN = '".$bin."'
                        and PART = '".$itm."' ";
            $query = $this->db_gss->query($sql);

            $qty = $query->row('QUANTITY');
		} else {
			$qty = 0;
        }
        
        return $qty;
    }

}
