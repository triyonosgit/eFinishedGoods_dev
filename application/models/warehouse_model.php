<?php
class Warehouse_model extends MY_Model
{
    protected $_per_page = 2;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'warehouse';

    protected $form_rules = array(
        array(
            'field' => 'wh_code',
            'label' => 'Warehouse Code',
            'rules' => 'trim|xss_clean|required|max_length[4]|callback__wh_code_unik'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => 'trim|xss_clean|required|max_length[30]'
        ),
    );

    public $default_value = array(
        'wh_code' => '',
        'description' => '',
        'location' => ''
    );


    public function tambah($warehouse)
    {
        $warehouse = (object) $warehouse;

        return $this->insert($warehouse);
    }


    public function cari($offset)
    {
        $this->get_real_offset($offset);
        $kata_kunci = $this->input->get('kata_kunci', true);

        return $this->db->where("(wh_code LIKE '%$kata_kunci%' OR description LIKE '%$kata_kunci%' OR location LIKE '%$kata_kunci%')")
                        ->limit($this->_per_page, $this->_offset)
                        ->order_by('wh_code', 'ASC')
                        ->get($this->_tabel)
                        ->result();
    }

    public function cari_num_rows()
    {
        $kata_kunci = $this->input->get('kata_kunci', true);

        return $this->db->where("(wh_code LIKE '%$kata_kunci%' OR description LIKE '%$kata_kunci%' OR location LIKE '%$kata_kunci%')")
                        ->order_by('wh_code', 'ASC')
                        ->get($this->_tabel)
                        ->num_rows();
    }
    
}