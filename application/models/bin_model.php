<?php
class Bin_model extends MY_Model
{


    protected $_per_page = 20;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'bin';

    protected $form_rules = array(
        array(
            'field' => 'block',
            'label' => 'Block',
            'rules' => 'trim|xss_clean|required|min_length[2]|max_length[2]|alpha'
        ),
        array(
            'field' => 'column',
            'label' => 'Column',
            'rules' => 'trim|xss_clean|required|min_length[3]|max_length[3]|alpha_numeric'
        ),
        array(
            'field' => 'level',
            'label' => 'Level',
            'rules' => 'trim|xss_clean|required|min_length[1]|max_length[1]|alpha_numeric'
        ),
        array(
            'field' => 'bin_code',
            'label' => 'Bin Code',
            'rules' => 'trim|xss_clean|required|min_length[6]|max_length[6]|callback__bin_code_unik'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|xss_clean|max_length[100]'
        ),
    );

    public $default_value = array(
        'block' => '',
        'column' => '',
        'level' => '',
        'bin_code' => '',
        'description' => ''
    );


    public function tambah($bin)
    {
        $bin = (object) $bin;
        return $this->insert($bin);

        //unset($bin->passconf);
        //$user->password = md5($user->password);

        /*
        $row = $bin->row;
        $stack = $bin->stack;
        $level = $bin->level;
        $bin->bin_code = $row . '-' . $stack . '-' . $level;
        */


    }

    /*
    public function edit($id, $bin)
    {
        $bin = (object) $bin;
        //unset($user->passconf);


        return $this->update($id, $bin);
    }
    */


    public function cari($offset)
    {
        $this->get_real_offset($offset);
        $kata_kunci = $this->input->get('kata_kunci', true);
        //$id = get_no_peserta_value($kata_kunci);

        //return $this->db->where("(id = '$id' OR nisn LIKE '%$kata_kunci%' OR nama LIKE '%$kata_kunci%')")
        return $this->db->where("(bin_code LIKE '%$kata_kunci%')")
                        ->limit($this->_per_page, $this->_offset)
                        ->order_by('bin_code', 'ASC')
                        ->get($this->_tabel)
                        ->result();
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

    public function binSearch($search) {
        return $this->db->select('bin_code')
                        ->where("bin_code LIKE '$search'")
                        ->get($this->_tabel)
                        ->result();
    }

    /* 20181121 3ono */
    public function getAllRack() {
        $sql = " select id, rack_code, rack_desc, rack_rmks
                   from rack_master
                  where id > 0 ";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getAllRack2($frrack) {
        $sql = " select id, rack_code, rack_desc, rack_rmks
                   from rack_master
                  where id > 0
                    and rack_code >= '".$frrack."' ";
        $query = $this->db->query($sql);

        return $query->result();
    }


    public function getAllBin() {
        $sql = " select bin_code
                   from bin
                   union
                 select 'ALL' ";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getAllBinNQtyOH($itm) {
        $sql = " select a.bin_code, ifnull(format(b.qty, 0), 0) as qty_oh
                  from bin a
                  left join item_detail b on (a.bin_code = b.bin_code and b.item_code = '".$itm."') ";
        $query = $this->db->query($sql);

        return $query->result();
    }

}
