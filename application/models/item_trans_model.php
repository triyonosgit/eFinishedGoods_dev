<?php
class Item_Trans_model extends MY_Model
{
    protected $_per_page = 15;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'item_trans';

    protected $form_rules_receive = array(
        array(
            'field' => 'item_code',
            'label' => 'Item Code',
            'rules' => 'trim|xss_clean|required|max_length[17]'
        ),
        array(
            'field' => 'bin_code',
            'label' => 'Bin Code',
            'rules' => 'trim|xss_clean|required|max_length[6]'
        ),
        array(
            'field' => 'reference',
            'label' => 'Reference',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'vendor',
            'label' => 'Vendor',
            'rules' => 'trim|xss_clean|required|max_length[90]'
        ),
        array(
            'field' => 'qty',
            'label' => 'Quantity',
            'rules' => 'trim|xss_clean|required|numeric|greater_than[0]'
        ),
    );

    protected $form_rules_issue = array(
        array(
            'field' => 'item_code',
            'label' => 'Item Code',
            'rules' => 'trim|xss_clean|required|max_length[17]'
        ),
        array(
            'field' => 'bin_code',
            'label' => 'Bin Code',
            'rules' => 'trim|xss_clean|required|max_length[6]'
        ),
        array(
            'field' => 'reference',
            'label' => 'Reference',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'qty',
            'label' => 'Quantity',
            'rules' => 'trim|xss_clean|required|numeric|greater_than[0]|callback__cannot_greater_than_bin_qty'
        ),
    );

    protected $form_rules_transfer = array(
        array(
            'field' => 'item_code',
            'label' => 'Item Code',
            'rules' => 'trim|xss_clean|required|max_length[17]'
        ),
        array(
            'field' => 'reference',
            'label' => 'Reference',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'from_bin_code',
            'label' => 'From Bin Code',
            'rules' => 'trim|xss_clean|required|max_length[6]'
        ),
        array(
            'field' => 'to_bin_code',
            'label' => 'To Bin Code',
            'rules' => 'trim|xss_clean|required|max_length[6]'
        ),
        array(
            'field' => 'qty',
            'label' => 'Quantity',
            'rules' => 'trim|xss_clean|required|numeric|greater_than[0]|callback__cannot_greater_than_bin_qty'
        ),
    );


    protected $form_rules_adjustment = array(
        array(
            'field' => 'item_code',
            'label' => 'Item Code',
            'rules' => 'trim|xss_clean|required|max_length[17]'
        ),
        array(
            'field' => 'bin_code',
            'label' => 'Bin Code',
            'rules' => 'trim|xss_clean|required|max_length[6]'
        ),
        array(
            'field' => 'reference',
            'label' => 'Reference',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'qty',
            'label' => 'Final Qty',
            'rules' => 'trim|xss_clean|required|numeric|callback__qty_adjustment_valid'
        ),
    );



    public $default_value_receive = array(
                    'item_code' => '',
                    'description' => '',
                    'bin_code' => '',
                    'trans_type' => 'R',
                    'reference' => '',
                    'vendor' => '',
                    'old_qty' => 0,
                    'qty' => '',
                    'new_qty' => 0,
                    'bin_qty' => 0,
                    'uom' => '',
                    'from_bin' => '',
                    'to_bin' => ''
            );

    public $default_value_issue = array(
                    'item_code' => '',
                    'description' => '',
                    'bin_code' => '',
                    'trans_type' => 'I',
                    'reference' => '',
                    'vendor' => '',
                    'old_qty' => 0,
                    'qty' => '',
                    'new_qty' => 0,
                    'bin_qty' => 0,
                    'uom' => '',
                    'from_bin' => '',
                    'to_bin' => ''
            );

    public $default_value_transfer = array(
                    'item_code' => '',
                    'description' => '',
                    'bin_code' => '',
                    'trans_type' => 'T',
                    'reference' => '',
                    'vendor' => '',
                    'old_qty' => 0,
                    'qty' => '',
                    'new_qty' => 0,
                    'bin_qty' => 0,
                    'uom' => '',
                    'from_bin_code' => '',
                    'to_bin_code' => ''
            );

    public $default_value_adjustment = array(
                    'item_code' => '',
                    'description' => '',
                    'bin_code' => '',
                    'trans_type' => 'J',
                    'reference' => '',
                    'vendor' => '',
                    'old_qty' => 0,
                    'qty' => '',
                    'new_qty' => 0,
                    'bin_qty' => 0,
                    'uom' => '',
                    'from_bin' => '',
                    'to_bin' => ''
            );



    public function tambah($item_trans)
    {
        $item_trans = (object) $item_trans;
        unset($item_trans->description);
        unset($item_trans->bin_qty);
        unset($item_trans->uom);
        return $this->insert($item_trans);
    }


    /*
    public function cari($offset)
    {
        $this->get_real_offset($offset);
        $kata_kunci = $this->input->get('kata_kunci', true);

        return $this->db->where("(item_code LIKE '%$kata_kunci%' OR description LIKE '%$kata_kunci%')")
                        ->limit($this->_per_page, $this->_offset)
                        ->order_by('item_code', 'ASC')
                        ->get($this->_tabel)
                        ->result();
    }

    public function cari_num_rows()
    {
        $kata_kunci = $this->input->get('kata_kunci', true);

        return $this->db->where("(item_code LIKE '%$kata_kunci%' OR description LIKE '%$kata_kunci%')")
                        ->order_by('item_code', 'ASC')
                        ->get($this->_tabel)
                        ->num_rows();
    }
    */

    public function getDtlRcvItems($fr, $to) {
        $this->db->select('cast(t.updated_at as date) as transdate,
                           t.reference, t.item_code, m.description,
                           m.item_type, m.category,
                           t.qty, m.uom, t.vendor,
                           t.wonbr, t.spknbr, t.packnbr,
                           t.updated_at, t.updated_by');
        $this->db->from('item_trans t');
        $this->db->join('item_master m', 't.item_code = m.item_code', 'left');
        $this->db->where('cast(t.updated_at as date) >= ', $fr);
        $this->db->where('cast(t.updated_at as date) <= ', $to);
        $this->db->where('t.trans_type', 'R');
        $this->db->order_by('cast(t.updated_at as date)');

        $query = $this->db->get();

        return $query->result();
    }

    public function getSmryRcvItems($fr, $to) {
        $this->db->select('cast(t.updated_at as date) as transdate, t.item_code, m.description, m.item_type, m.category, SUM(t.qty) as tot_qty, m.uom');
        $this->db->from('item_trans t');
        $this->db->join('item_master m', 't.item_code = m.item_code', 'left');
        $this->db->where('cast(t.updated_at as date) >= ', $fr);
        $this->db->where('cast(t.updated_at as date) <= ', $to);
        $this->db->where('t.trans_type', 'R');
        $this->db->group_by('cast(t.updated_at as date), t.item_code');
        $this->db->order_by('cast(t.updated_at as date)');

        $query = $this->db->get();

        return $query->result();
    }

    public function getDtlIssItems($fr, $to) {
        $this->db->select('cast(t.updated_at as date) as transdate,
                           t.reference, t.item_code, m.description,
                           m.item_type, m.category,
                           t.qty, m.uom, t.vendor,
                           t.updated_at, t.updated_by');
        $this->db->from('item_trans t');
        $this->db->join('item_master m', 't.item_code = m.item_code', 'left');
        $this->db->where('cast(t.updated_at as date) >= ', $fr);
        $this->db->where('cast(t.updated_at as date) <= ', $to);
        $this->db->where('t.trans_type', 'I');
        $this->db->order_by('cast(t.updated_at as date)');

        $query = $this->db->get();

        return $query->result();
    }

    public function getSmryIssItems($fr, $to) {
        $this->db->select('cast(t.updated_at as date) as transdate, t.item_code, m.description, m.item_type, m.category, SUM(t.qty) as tot_qty, m.uom');
        $this->db->from('item_trans t');
        $this->db->join('item_master m', 't.item_code = m.item_code', 'left');
        $this->db->where('cast(t.updated_at as date) >= ', $fr);
        $this->db->where('cast(t.updated_at as date) <= ', $to);
        $this->db->where('t.trans_type', 'I');
        $this->db->group_by('cast(t.updated_at as date), t.item_code');
        $this->db->order_by('cast(t.updated_at as date)');

        $query = $this->db->get();

        return $query->result();
    }

    public function getTransByDate($fr, $to) {
        /*
        $sql = " select w.item_code, m.description, m.uom,
                	    sum(old_qty) as saldo_awal,
                	    sum(w.qty_masuk) as qty_masuk,
                	    sum(w.qty_keluar) as qty_keluar,
                	    sum(new_qty) as saldo_akhir
                   from (
                			select item_code,
                				   old_qty,
                				   case when trans_type = 'R' then qty
                				   		else 0 end as qty_masuk,
                				   case when trans_type = 'I' then qty
                				   		else 0 end as qty_keluar,
                				   new_qty
                			  from efinishedgoods.item_trans
                			 where cast(updated_at as date) >= '".$fr."'
                			   and cast(updated_at as date) <= '".$to."'
                			   and trans_type in ('I', 'R')
                		) w
                   join item_master m on w.item_code = m.item_code
                  group by w.item_code ";
        */

        $sql = " select w.tanggal, w.item_code, m.description, m.uom, w.bin_code,
                	    fn_get_minoldqty(w.tanggal, w.item_code, w.bin_code) as saldo_awal,
                	    sum(w.qty_masuk) as qty_masuk,
                	    sum(w.qty_keluar) as qty_keluar,
                	    fn_get_maxnewqty(w.tanggal, w.item_code, w.bin_code) as saldo_akhir
                   from (
                			select cast(updated_at as date) as tanggal, item_code, bin_code,
                				   case when trans_type in ('R', 'TI') then qty
                				   		else 0 end as qty_masuk,
                				   case when trans_type in ('I', 'TO') then qty
                				   		else 0 end as qty_keluar
                			  from efinishedgoods.item_trans
                			 where cast(updated_at as date) >= '".$fr."'
                			   and cast(updated_at as date) <= '".$to."'
                			   -- and trans_type in ('I', 'R')
                		) w
                   join item_master m on w.item_code = m.item_code
                  group by w.tanggal, w.item_code, w.bin_code
                  order by 1, 2 ";
        $query = $this->db->query($sql);

        // print_r($sql); die();

        return $query->result();
    }

}
