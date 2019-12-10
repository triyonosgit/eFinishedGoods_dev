<?php
class Item_Category_model extends MY_Model
{
 

    //protected $_per_page = 20;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'item_category';

    protected $form_rules = array(
        array(
            'field' => 'category',
            'label' => 'Item Category',
            'rules' => 'trim|xss_clean|required|max_length[45]|callback__item_category_unik'
        )
    );

    public $default_value = array(
        'category' => ''
    );


    public function tambah($item_category)
    {
        $item_category = (object) $item_category;
        $item_category->category = strtoupper($item_category->category);
        return $this->insert($item_category);
    }


    public function edit($id, $item_category)
    {
        $item_category = (object) $item_category;
        $item_category->category = strtoupper($item_category->category);
        return $this->update($id, $item_category);
    }

    public function populate_dropdown()
    {
        return $this->db->select('category')
                        ->get($this->_tabel)
                        ->result_array();
    }

}