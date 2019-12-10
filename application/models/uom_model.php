<?php
class Uom_model extends MY_Model
{
 

    //protected $_per_page = 20;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'uom';

    protected $form_rules = array(
        array(
            'field' => 'uom',
            'label' => 'Unit of Measure',
            'rules' => 'trim|xss_clean|required|min_length[2]|max_length[3]|alpha_numeric|callback__uom_unik'
        )
    );

    public $default_value = array(
        'uom' => ''
    );


    public function tambah($uom)
    {
        $uom = (object) $uom;
        $uom->uom = strtoupper($uom->uom);
        return $this->insert($uom);
    }


    public function edit($id, $uom)
    {
        $uom = (object) $uom;
        $uom->uom = strtoupper($uom->uom);
        return $this->update($id, $uom);
    }


    
    public function cari($offset)
    {
        $this->get_real_offset($offset);
        $kata_kunci = $this->input->get('kata_kunci', true);
        //$id = get_no_peserta_value($kata_kunci);

        //return $this->db->where("(id = '$id' OR nisn LIKE '%$kata_kunci%' OR nama LIKE '%$kata_kunci%')")
        return $this->db->where("(uom LIKE '%$kata_kunci%')")
                        ->limit($this->_per_page, $this->_offset)
                        ->order_by('uom', 'ASC')
                        ->get($this->_tabel)
                        ->result();
    }

    public function populate_dropdown()
    {
        return $this->db->select('uom')
                        ->get($this->_tabel)
                        ->result_array();
    }

    /*
    public function cari_num_rows()
    {
        $kata_kunci = $this->input->get('kata_kunci', true);
        //$id = get_no_peserta_value($kata_kunci);

        return $this->db->where("(bin_code LIKE '%$kata_kunci%')")
                        ->order_by('bin_code', 'ASC')
                        ->get($this->_tabel)
                        ->num_rows();
    }
    */


    /*

    // Ambil beberapa record, dengan paging.
    public function get_all_paged_for_to_bin()
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
        $this->db->order_by('bin_code', 'asc');
        
        // Mengembalikan beberapa / semua record.
        return $this->db->get()->result();
    }

    public function cariToBin($search, $offset)
    {
        $this->get_real_offset($offset);
        $kata_kunci = $this->input->get('kata_kunci', true);
        //$id = get_no_peserta_value($kata_kunci);

        //return $this->db->where("(id = '$id' OR nisn LIKE '%$kata_kunci%' OR nama LIKE '%$kata_kunci%')")
        return $this->db->where($search)
                        ->where("(bin_code LIKE '%$kata_kunci%')")
                        ->limit($this->_per_page, $this->_offset)
                        ->order_by('bin_code', 'ASC')
                        ->get($this->_tabel)
                        ->result();
    }   

    public function cari_num_rows($search)
    {
        $kata_kunci = $this->input->get('kata_kunci', true);
        //$id = get_no_peserta_value($kata_kunci);

        if (is_null($search)) {
            return $this->db->where("(bin_code LIKE '%$kata_kunci%')")
                            ->order_by('bin_code', 'ASC')
                            ->get($this->_tabel)
                            ->num_rows();

        } else {
            return $this->db->where("(bin_code LIKE '%$kata_kunci%')")
                            ->where($search)
                            ->order_by('bin_code', 'ASC')
                            ->get($this->_tabel)
                            ->num_rows();
        }
    }
    */
}