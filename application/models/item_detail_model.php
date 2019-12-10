<?php
class Item_Detail_model extends MY_Model
{
    protected $_per_page = 1;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'item_detail';

    protected $form_rules_adjustment = array(
        array(
            'field' => 'from_item_code',
            'label' => 'From Item Code',
            'rules' => 'trim|xss_clean|required|max_length[20]|'
        ),
        array(
            'field' => 'to_item_code',
            'label' => 'To Item Code',
            'rules' => 'trim|xss_clean|required|max_length[20]|'
        )
    );


    public $default_value_adjustment = array(
        'from_item_code' => '',
        'to_item_code' => '',
        'trans_type' => 'A'
    );



    public function tambah($item_detail)
    {
        $item_detail = (object) $item_detail;
        return $this->insert($item_detail);
    }

    /*
    // Ambil beberapa record, dengan paging.
    public function get_all_paged()
    {

        // Mendapatkan argumen yang dilewatkan ke fungsi ini.
        $args = func_get_args();

        $this->db->from($this->_tabel);
        $this->db->join('item_master', 'item_master.item_code = item_detail.item_code');
        $this->db->where($args[0]);
        $this->db->order_by('item_detail.item_code', 'asc');
        $this->db->order_by('item_detail.bin_code', 'asc');

        // Mengembalikan beberapa / semua record.
        return $this->db->get()->result();
    }

    // Ambil beberapa record, dengan paging.
    public function get_all_paged_for_bin()
    {
        // Mendapatkan argumen yang dilewatkan ke fungsi ini.
        $args = func_get_args();

        // get_all_paged($offset)
        if (count($args) < 2) {

            $this->get_real_offset($args[0]);
            $this->db->limit($this->_per_page, $this->_offset);
        }

        // get_all_paged(array('status' => '1'), $offset)
        else {
            $this->get_real_offset($args[1]);
            $this->db->where($args[0])->limit($this->_per_page, $this->_offset);
        }

        $this->db->from($this->_tabel);
        $this->db->order_by('item_code', 'asc');
        $this->db->order_by('bin_code', 'asc');

        // Mengembalikan beberapa / semua record.
        return $this->db->get()->result();
    }


    public function cari($search, $offset)
    {
        $this->get_real_offset($offset);
        $kata_kunci = $this->input->get('kata_kunci', true);

        return $this->db->from($this->_tabel)
                        ->join('item_master', 'item_master.item_code = item_detail.item_code')
                        ->where($search)
                        //->where("( (item_detail.wh_code LIKE '%$kata_kunci%' OR item_detail.bin_code LIKE '%$kata_kunci%') )")
                        ->where("( (item_detail.bin_code LIKE '%$kata_kunci%') )")
                        ->limit($this->_per_page, $this->_offset)
                        ->order_by('item_detail.item_code', 'ASC')
                        ->get()
                        ->result();
    }

    public function cari_num_rows($search)
    {
        $kata_kunci = $this->input->get('kata_kunci', true);

        return $this->db->from($this->_tabel)
                        ->join('item_master', 'item_master.item_code = item_detail.item_code')
                        ->where($search)
                        //->where("( (item_detail.wh_code LIKE '%$kata_kunci%' OR item_detail.bin_code LIKE '%$kata_kunci%') )")
                        ->where("( (item_detail.bin_code LIKE '%$kata_kunci%') )")
                        ->order_by('item_detail.item_code', 'ASC')
                        ->get()
                        ->num_rows();
    }
    */

    // Ambil semua record, menerima beberapa pola "where".
    public function get_all_item()
    {
        // Mendapatkan argumen yang dilewatkan ke fungsi ini.
        $args = func_get_args();

        $this->db->from($this->_tabel);
        $this->db->join('item_master', 'item_master.item_code = item_detail.item_code');
        //$this->db->where($args[0]);
        $this->db->order_by('item_detail.item_code', 'asc');
        $this->db->order_by('item_detail.bin_code', 'asc');


        // Dipanggil tanpa prameter.
        if (!count($args) > 0) {
            return $this->db->get()->result();
        }

        // $this->db->where('name', $name);
        // $this->db->where('name !=', $name);
        elseif (count($args) > 1) {
            $this->db->where($args[0], $args[1]);
        }

        // $this->db->where(3);
        elseif (count($args) == 1 && is_numeric($args[0])) {
            $this->db->where('id', $args[0]);
        }

        // $this->db->where(array('id' => $id, 'nama' => $nama))
        // $this->db->where("name='Joe' AND status='boss' OR status='active'")
        elseif ((count($args) == 1) && (is_array($args[0]) || is_string($args[0]))) {
            $this->db->where($args[0]);
        }

        // Mengembalikan semua record hasil query.
        return $this->db->get()->result();
    }

    public function getItemQtyOH($selbin) {
        if ($selbin == 'ALL') {
            $this->db->select('a.item_code, b.description, b.category, b.uom, a.bin_code, format(a.qty, 0) as qty');
            $this->db->from('item_detail a');
            $this->db->join('item_master b', 'a.item_code = b.item_code');
            $this->db->where('a.qty > ', 0);
        } else {
            $this->db->select('a.item_code, b.description, b.category, b.uom, a.bin_code, format(a.qty, 0) as qty');
            $this->db->from('item_detail a');
            $this->db->join('item_master b', 'a.item_code = b.item_code');
            $this->db->where('a.bin_code', $selbin);
            $this->db->where('a.qty > ', 0);
        }
        

        return $this->db->get()->result();
    }


}
