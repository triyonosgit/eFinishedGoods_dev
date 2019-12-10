<?php
class Item_Master_model extends MY_Model
{
    //protected $_per_page = 15;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'item_master';

    protected $form_rules = array(
        array(
            'field' => 'item_code',
            'label' => 'Item Code',
            'rules' => 'trim|xss_clean|required|max_length[17]|callback__item_code_unik'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'item_type',
            'label' => 'Item Type',
            'rules' => 'trim|xss_clean|callback__cek_item_type'
        ),
        array(
            'field' => 'category',
            'label' => 'Category',
            'rules' => 'trim|xss_clean|callback__cek_item_category'
        ),
        array(
            'field' => 'uom',
            'label' => 'UoM',
            'rules' => 'trim|xss_clean|callback__cek_uom'
        ),
        array(
            'field' => 'enable',
            'label' => 'Status',
            'rules' => 'trim|xss_clean|required'
        )
        /*
        array(
            'field' => 'qty_eStockCard',
            'label' => 'Qty in eStockCard',
            'rules' => 'trim|xss_clean|required|decimal'
        ),
        array(
            'field' => 'qty_external',
            'label' => 'Qty in FINA',
            'rules' => 'trim|xss_clean|required|decimal'
        )
        */
    );

    public $default_value = array(
        'item_code' => '',
        'description' => '',
        'item_type' => '',
        'category' => '',
        'uom' => '',
        'qty_eStockCard' => 0,
        'qty_external' => 0,
        'enable' => 'Y',
        'item_codeold' => ''
    );


    public function tambah($item)
    {
        $item = (object) $item;

        return $this->insert($item);
    }

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

    public function get_data($limit, $offset, $sort, $order, $search)
    {

        return $this->db->where("(item_code LIKE '$search' OR description LIKE '$search'
                               OR category LIKE '$search' OR uom LIKE '$search'
                               OR item_type LIKE '$search' OR qty_eStockCard LIKE '$search'
                               OR qty_external LIKE '$search' OR item_codeold LIKE '$search')
                               AND enable = 'Y'")
                        ->order_by($sort, $order)
                        ->limit($limit, $offset)
                        ->get($this->_tabel)
                        ->result();


    }

    public function get_num_rows($search)
    {

        return $this->db->where("(item_code LIKE '$search' OR description LIKE '$search'
                               OR category LIKE '$search' OR uom LIKE '$search'
                               OR item_type LIKE '$search' OR qty_eStockCard LIKE '$search'
                               OR qty_external LIKE '$search')")
                        ->get($this->_tabel)
                        ->num_rows();


    }

    public function get_data_active($limit, $offset, $sort, $order, $search)
    {

        return $this->db->where("(item_code LIKE '$search' OR description LIKE '$search'
                               OR category LIKE '$search' OR uom LIKE '$search'
                               OR item_type LIKE '$search' OR qty_eStockCard LIKE '$search'
                               OR qty_external LIKE '$search')
                               AND enable = 'Y'")
                        ->order_by($sort, $order)
                        ->limit($limit, $offset)
                        ->get($this->_tabel)
                        ->result();


    }

    public function get_num_rows_active($search)
    {

        return $this->db->where("(item_code LIKE '$search' OR description LIKE '$search'
                               OR category LIKE '$search' OR uom LIKE '$search'
                               OR item_type LIKE '$search' OR qty_eStockCard LIKE '$search'
                               OR qty_external LIKE '$search')
                               AND enable = 'Y'")
                        ->get($this->_tabel)
                        ->num_rows();


    }

}
