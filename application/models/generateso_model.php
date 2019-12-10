<?php
class Generateso_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

        // $CI = &get_instance();
        // $this->db_gss = $CI->load->database('GSS', TRUE);
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
        
        // $this->db->select('item_code');
        // $this->db->from('item_master');
        // $this->db->where('id > ', 0);
        // $this->db->order_by('item_code');

        // $query = $this->db->get();

        $sql = " select item_code
                   from item_master
                  where item_code in (
                        '000101801',
                        '00010196198-00-00',
                        '00206171000-A0-00',
                        '00206215000-A0-00',
                        '00208215098-00-00',
                        '011002000',
                        '01100362000-A0-00',
                        '01100739098-00-00',
                        '011007400',
                        '01100819098-00-00',
                        '01100820000-A0-00',
                        '01100821000-A0-00',
                        '011010720',
                        '011010970',
                        '011013440',
                        '011013480',
                        '011013500',
                        '011014030',
                        '01101633000-A0-00',
                        '011017020',
                        '011017030',
                        '01101709098-00-00',
                        '01101866098-00-00',
                        '01101867000-A0-00',
                        '01102046000-A0-00',
                        '01102560098-00-00',
                        '01102675000-A0-00',
                        '01102677098-00-00',
                        '011026780',
                        '011027970',
                        '01103024000-A0-00',
                        '01103025000-A0-00',
                        '01103874000-A0-00',
                        '011039310',
                        '011040250',
                        '01104026098-00-00',
                        '011040270',
                        '01104232098-00-00',
                        '01104233000-A0-00',
                        '011046760',
                        '011047170',
                        '01104720000-A0-00',
                        '011049620',
                        '011049640',
                        '01105231000-A0-00',
                        '011052330',
                        '011052400',
                        '01105271000-A0-00',
                        '01105441098-00-00',
                        '01105442000-A0-00',
                        '011059720',
                        '01105976000-A0-00',
                        '011059770',
                        '011640573',
                        '011670500',
                        '011911500',
                        '011911670',
                        '01191414098-00-00',
                        '01191415000-A0-00',
                        '011914170',
                        '011926020',
                        '011926023',
                        '01192629000-A0-00',
                        '011926300',
                        '01193151098-00-00',
                        '01193735098-00-00',
                        '011937990',
                        '01193800000-A0-00',
                        '011938010',
                        '01195122098-00-00',
                        '012635890',
                        '05002728000-A0-00',
                        '050027700',
                        '050046940',
                        '052646240',
                        '05264626000-A0-00',
                        '05264712000-00-00',
                        '083410150',
                        '08343445000-A0-00',
                        '08343446000-A0-00',
                        '08345320000-A0-00',
                        '083453340',
                        '08345335000-A0-00',
                        '083455500',
                        '087232640',
                        '08741264098-00-00',
                        '087412970',
                        '08742173000-A0-00',
                        '08742267098-00-00',
                        '08744410000-A0-00',
                        '08744412000-A0-00',
                        '08870128000-A0-00',
                        '088701513',
                        '08870340000-A0-00',
                        '088703590',
                        '08870410000-A0-00',
                        '08870429098-00-00',
                        '08870469000-A0-00',
                        '08870482000-A0-00',
                        '08870496000-A0-00',
                        '08870498000-A0-00',
                        '08870587000-A0-00',
                        '08870611000-A0-00',
                        '08870642000-A0-00',
                        '08870643000-A0-00',
                        '08870678000-A0-00',
                        '08871001098-00-00',
                        '08871002098-00-00',
                        '08871029098-00-00',
                        '08871030000-A0-00',
                        '088710310',
                        '08871128000-A0-00',
                        '08871130000-A0-00',
                        '08871131000-A0-00',
                        '08871132000-A0-00',
                        '08871142000-A0-00',
                        '08871144000-A0-00',
                        '08871155000-A0-00',
                        '08872117200-A0-00',
                        '08872131298-00-00',
                        '08873080000-A0-00',
                        '088733992',
                        '088733995',
                        '08873399698-00-00',
                        '088733997',
                        '08873493000-A0-00',
                        '08873494098-00-00',
                        '088738252',
                        '088738253',
                        '088818380',
                        '088818390',
                        '096021313',
                        '11054410',
                        '242911',
                        '82002JA0198-00-00',
                        '82002JA0398-00-00',
                        '82004JA14',
                        '82004JA15',
                        '82004JA16',
                        '82004JA17',
                        '82007JA7798-00-00',
                        '82011JA48',
                        '82011JA50',
                        '82011JA51',
                        '82011JA54',
                        '88704360',
                        '88704770',
                        '88706110',
                        '91104AA8000-A0-00',
                        '91104AA83',
                        '91106AA3700-A0-00',
                        '91116AA7100-A0-00',
                        '91116AA7200-A0-00',
                        '91117AA1600-A0-00',
                        '91117AA17',
                        '91183AA2400-A0-00',
                        '91248AA6300-A0-00',
                        '91280AA3000-A0-00',
                        'D8PT12582',
                        'D8PT13254',
                        'D8PT15322',
                        'D8PT17900',
                        'D8PT20567',
                        'D8PT20568',
                        'D8PT2274300-A0-00',
                        'D8PT25370',
                        'D8PT54533',
                        'D8PT54534',
                        'PTD8PT205',
                        'PTD8PT308',
                        'PTD8PT461',
                        'PTD8PT53900-A0-00',
                        'TD8PT2718',
                        'TD8PT3216',
                        'TD8PT3677',
                        'TD8PT3862',
                        'TD8PT5066',
                        'TD8PT5370',
                        'TD8PT5371',
                        'TD8PT5397',
                        'TD8PT5475',
                        'TD8PT5544',
                        'TD8PT5640',
                        'TD8PT5943',
                        'TD8PT5944',
                        'TD8PT5958',
                        'TD8PT6017',
                        'TD8PT6539',
                        'TD8PT6540',
                        'TD8PT6698',
                        'TD8PT6699',
                        'TD8PT6789',
                        'TD8PT6887',
                        'TD8PT9617',
                        'PTD0002067800',
                        'PTD0002084630',
                        'PTD0002084640',
                        'PTD0011000920',
                        'PTD0011000930',
                        'PTD0011000940',
                        'PTD0011000950',
                        'PTD0011005520',
                        'PTD0011015440',
                        'PTD0011028950',
                        'PTD0011029030',
                        'PTD0011029040',
                        'PTD0011037750',
                        'PTD0011039120',
                        'PTD0011042980',
                        'PTD0011053530',
                        'PTD0011053540',
                        'PTD0011053560',
                        'PTD0011055110',
                        'PTD0011055120',
                        'PTD0011055200',
                        'PTD0011933320',
                        'PTD0011936190',
                        'PTD0011936290',
                        'PTD0087500240',
                        'PTD0087500250',
                        'PTD0088701330',
                        'PTD0088703080',
                        'PTD0088703090',
                        'PTD0088703180',
                        'PTD0088703190',
                        'PTD0088703270',
                        'PTD0088703550',
                        'PTD0088703790',
                        'PTD0088703860',
                        'PTD0088704060',
                        'PTD0088704300',
                        'PTD0088704310',
                        'PTD0088704320',
                        'PTD0088704330',
                        'PTD0088704340',
                        'PTD0088704350',
                        'PTD0088704360',
                        'PTD0088704540',
                        'PTD0088704700',
                        'PTD0088704750',
                        'PTD0088704810',
                        'PTD0088704830',
                        'PTD0088704840',
                        'PTD0088705110',
                        'PTD0088705510',
                        'PTD0088706660',
                        'PTD0088706720',
                        'PTD0088706740',
                        'PTD0088706750',
                        'PTD0088706910',
                        'PTD0088706920',
                        'PTD0088710710',
                        'PTD0088711330',
                        'PTD0088711640',
                        'PTD0088711890',
                        'PTD0088711900',
                        'PTD0088735020',
                        'PTD0089124190',
                        'PTD8PT205',
                        'PTD8PT308',
                        'PTD8PT461',
                        'PTD8PT53900-A0-00',
                        'PTDOO2069020' )
                order by item_code ";
        $query = $this->db->query($sql);

        $this->db->trans_begin();

        foreach ($query->result() as $row) {
            $sqlchk = " select count(*) as cnt
                          from item_detail
                         where item_code = '".$row->item_code."' ";
            $query = $this->db->query($sqlchk);

            if ((int) $query->row('cnt') > 0) {
                $sqldtl = " select d.item_code, m.description, m.uom,
                                   d.bin_code, d.qty 
                              from item_detail d
                              left join item_master m on d.item_code = m.item_code
                             where d.item_code = '".$row->item_code."' ";
                $querydtl = $this->db->query($sqldtl);

                foreach ($querydtl->result() as $rowdtl) {
                    $bincode = $rowdtl->bin_code;
                    $rackcode = substr($bincode, 0, 5);
                    $binqty  = $rowdtl->qty;
                    // $gssbinqty = $this->getGssBinQty($bincode, $rowdtl->item_code);
					$gssbinqty = 0;

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
