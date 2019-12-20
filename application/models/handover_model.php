<?php
class Handover_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBstHdr()
    {
        $this->db->select('a.hvr_id, a.hvr_nbr, a.hvr_status, b.code_cmmt, date_format(a.hvr_adddt, \'%Y-%m-%d %H:%i\') as hvr_adddt, a.hvr_useradd,
                           a.hvr_moddt, a.hvr_usermod, ifnull(date_format(a.hvr_aprvdt, \'%Y-%m-%d %H:%i\'), \'-\') as hvr_aprvdt, ifnull(a.hvr_useraprv, \'-\') as hvr_useraprv');
        $this->db->from('hvr_mstr a');
        $this->db->join('code_mstr b', 'b.code_fldname = \'hvr_status\' and a.hvr_status = b.code_value');
        $this->db->where('a.hvr_nbr > ', '19100000');
        $this->db->where_in('a.hvr_status', array('CREATE', 'REVISION'));
        $this->db->order_by('a.hvr_id', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getBstDetail($nbr)
    {
        $this->db->select('a.hod_id, a.hod_nbr, a.hod_item, a.hod_desc, a.hod_uom, a.hod_qty,
                           a.hod_spk, a.hod_wo, a.hod_packnbr, a.hod_rmks, a.hod_status,
                           a.hod_adddt, a.hod_useradd, a.hod_moddt, a.hod_usermod');
        $this->db->from('hod_det a');
        $this->db->where('a.hod_nbr', $nbr);

        $query = $this->db->get();

        // print_r($this->db_gss->last_query()); die();

        return $query->result();
    }

    public function delBstItem($nbr, $itm)
    {
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

    public function deleteBst($nbr)
    {
        $this->db->trans_begin();

        $this->db->where('hvr_nbr', $nbr);
        $this->db->delete('hvr_mstr');

        $this->db->where('hod_nbr', $nbr);
        $this->db->delete('hod_det');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function sendBST($nbr)
    {
        $this->db->trans_begin();

        $data = array('hvr_status' => 'SENT');
        $this->db->where('hvr_nbr', $nbr);
        $this->db->update('hvr_mstr', $data);

        $data = array('hod_status' => 'SENT');
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

    public function getBstHdrPdf($nbr)
    {
        $this->db->select('a.hvr_nbr, date_format(a.hvr_adddt, \'%Y-%m-%d\') as tgl_input, weekday(date(a.hvr_adddt)) as weekday,
                           a.hvr_useradd');
        $this->db->from('hvr_mstr a');
        $this->db->where('a.hvr_nbr', $nbr);

        $query = $this->db->get();

        // return $this->db->last_query();

        return $query->row();
    }

    public function getBstByDate($fr, $to)
    {
        $this->db->select('a.hvr_nbr, c.code_cmmt, date_format(a.hvr_adddt, \'%Y-%m-%d\') as hvr_adddt, a.hvr_useradd,
                           b.hod_item, b.hod_desc, b.hod_qty, b.hod_uom, b.hod_spk, b.hod_wo, b.hod_packnbr, b.hod_rmks')
            ->from('hvr_mstr a')
            ->join('hod_det b', 'a.hvr_nbr = b.hod_nbr')
            ->join('code_mstr c', 'c.code_fldname = \'hvr_status\' and c.code_value = a.hvr_status')
            ->where('date_format(a.hvr_adddt, \'%Y-%m-%d\') >= ', $fr)
            ->where('date_format(a.hvr_adddt, \'%Y-%m-%d\') <= ', $to)
            ->order_by('a.hvr_adddt');
        $query = $this->db->get();

        return $query->result();
    }


    public function getTodayBst()
    {
        $sql = " SELECT a.hvr_nbr as NOBST, b.hod_item as PARENT_CODE, b.hod_desc as DESCRIPTION, b.hod_uom as UOM,
                        b.hod_qty as QTY, ifnull(c.pl_price, 0) as SO_MINPRICE, b.hod_qty * ifnull(c.pl_price, 0) as AMOUNT,
                        c.pl_desc as GSS_DESCRIPTION
                   from hvr_mstr a
                   join hod_det b on a.hvr_nbr = b.hod_nbr
                   left join pl_mstr c on b.hod_item = c.pl_item
                  where date(a.hvr_adddt) = '" . date('Y-m-d') . "'
                    and a.hvr_status IN ('SENT', 'SUBMITED') ";
        // ".date('Y-m-d')."
        // print_r($sql); die();
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getTotAmount()
    {
        $sql = " select sum( b.hod_qty * ifnull(c.pl_price, 0) ) as TOT_AMOUNT
                   from hvr_mstr a
                   join hod_det b on a.hvr_nbr = b.hod_nbr
                   left join pl_mstr c on b.hod_item = c.pl_item
                  where date(a.hvr_adddt) = '" . date('Y-m-d') . "'
                    and a.hvr_status IN ('SENT', 'SUBMITED') ";
        $query = $this->db->query($sql);

        return $query->row('TOT_AMOUNT');
    }

    public function IsiReviewPdfdetail_today()
    {
        $query = "SELECT b.hod_nbr,date_format(a.created_at, '%Y-%m-%d') as created_at ,b.hod_item, b.hod_desc, a.qty, b.hod_uom, b.hod_spk, b.hod_wo, b.hod_packnbr, a.bin_code
                    FROM hod_det b
                    JOIN item_trans a ON b.hod_nbr = SUBSTRING(a.reference ,5)
                    WHERE a.trans_type = 'R' AND date_format(a.created_at, '%Y-%m-%d') = '" . date('Y-m-d') . "'
                    order by b.hod_nbr";


        return $this->db->query($query)->result_array();
    }

    public function Sum_BstToday()
    {
        $query = "SELECT a.hod_item, a.hod_desc , a.hod_uom, SUM(a.hod_qty) as total_qty 
                    FROM hod_det a
                    JOIN hvr_mstr b ON b.hvr_nbr = a.hod_nbr
                    WHERE date_format(b.hvr_aprvdt, '%Y-%m-%d') = '" . date('Y-m-d') . "' AND b.hvr_status = 'SUBMITED'
                    GROUP BY a.hod_item  ORDER BY a.hod_item";

        return $this->db->query($query)->result_array();
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function ItemHistory__model()
    {
        //a.created_at//,
        $query = "SELECT date_format(a.created_at, '%Y-%m-%d') as created_att, a.item_code ,  a.trans_type, a.bin_code, b.description, b.uom, a.old_qty, a.qty, a.new_qty, a.reference, a.vendor,
        a.spknbr, a.wonbr ,a.from_bin_code, a.to_bin_code, a.created_by
        FROM item_trans a
        JOIN item_master b ON a.item_code = b.item_code
        WHERE date_format(a.created_at, '%Y-%m-%d') = '2019-11-26'
        order by a.created_at
        ";

        return $this->db->query($query)->result_array();
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function ItemHistory__modelByDate($fr, $to)
    {
        $this->db->select('a.created_at, date_format(a.created_at, \'%Y-%m-%d\')  as created_att, a.item_code, a.trans_type, a.bin_code, b.description, b.uom, a.old_qty, a.qty, a.new_qty, a.reference, a.vendor,a.spknbr, a.wonbr, a.from_bin_code, a.to_bin_code, a.created_by')
            ->from('item_trans a')
            ->join('item_master b', 'a.item_code = b.item_code')
            ->where('date_format(a.created_at, \'%Y-%m-%d\') >= ', $fr)
            ->where('date_format(a.created_at, \'%Y-%m-%d\') <= ', $to)
            ->order_by('a.created_at');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function ItemDetail__model()
    {
        $query = "SELECT a.item_code, b.description, b.category, b.uom, a.bin_code, a.qty
                    from item_detail a
                    JOIN item_master b ON a.item_code = b.item_code
                    order by a.item_code
        ";

        return $this->db->query($query)->result_array();
    }

    public function BinDesc__model()
    {
        $query = "SELECT `bin_code`, `description` FROM `bin`";

        return $this->db->query($query)->result_array();
    }
}
