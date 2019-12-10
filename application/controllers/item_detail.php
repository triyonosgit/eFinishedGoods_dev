<?php
class Item_Detail extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'item_detail',
        'main_view' => 'item_detail_list',
        'title' => 'Data Item Detail'
    );


    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_detail_model', 'item');

    }

    public function index($item_code = null)
    {
        $search = array (
            'item_detail.item_code' => $item_code
        );

        $item = $this->item->get_all_item($search);
        if ($item) {
            $this->data['item'] = $item;
        } else {
            $this->data['item'] = 'Tidak ada data item detail.';
        }
        $this->data['form_action'] = site_url('item_detail/'.$item_code);
        $this->load->view($this->layout, $this->data);
    }

    /*
    public function index($item_code = null, $offset = null)
    {
        $search = array (
            'item_detail.item_code' => $item_code
        );

        $item = $this->item->get_all_paged($search, $offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('biasa', site_url('item_detail/halaman/'.$item_code.'/'), 4, $search);
        } else {
            $this->data['item'] = 'Tidak ada data item detail.';
        }
        $this->data['form_action'] = site_url('item_detail/cari/'.$item_code);
        $this->load->view($this->layout, $this->data);
    }




    public function cari($item_code = null, $offset = 0)
    {
        $search = array (
            'item_detail.item_code' => $item_code
        );

        $item = $this->item->cari($search, $offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('pencarian', site_url('item_detail/cari/'.$item_code), 4, $search);
        } else {
            //$this->data['item'] = 'Data tidak ditemukan.'. anchor('item_detail', ' Tampilkan semua item detail.', 'class="alert-link"');
            $this->data['item'] = 'Data tidak ditemukan.'. anchor('item_detail/cari/'.$item_code, ' Tampilkan semua item detail.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('item_detail/cari/'.$item_code);
        $this->load->view($this->layout, $this->data);
    }
    */

    /*
    public function tambah()
    {
        $this->data['main_view'] = 'item_form';
        $this->data['form_action'] = site_url('item_master/tambah');

        // Data untuk form.
        if (! $_POST) {
            $item = (object) $this->item->default_value;
        } else {
            $item = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->item->validate('form_rules')) {
            $this->data['values'] = (object) $item;
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan ke DB.
        if ($this->item->tambah($item)) {
            $this->session->set_flashdata('pesan', $values->item_code . ' Item berhasil disimpan. Kembali ke halaman ' . anchor('item_master', 'item.', 'class="alert-link"'));
            redirect('item/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item gagal disimpan. Kembali ke halaman ' . anchor('item_master', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }
    }
    */

    public function edit($id = null)
    {
        // Pastikan data warehouse ada.
        $item = $this->item->get($id);
        if (! $item) {
            $this->session->set_flashdata('pesan_error', 'Data item detail tidak ada. Kembali ke halaman ' . anchor('item_detail', 'item.', 'class="alert-link"'));
            redirect('item_detail/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $item;
        } else {
            $data = (object) $this->input->post(null, true);

        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->item->validate('form_rules')) {
            $this->data['main_view'] = 'item_detail_form';
            $this->data['form_action'] = site_url('item_detail/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->item->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'Item Detail berhasil disimpan. Kembali ke halaman ' . anchor('item_detail', 'item detail.', 'class="alert-link"'));
            redirect('item_detail/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item Detail gagal disimpan. Kembali ke halaman ' . anchor('item_detail', 'item detail.', 'class="alert-link"'));
            redirect('item_detail/error');
        }
    }





    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data Item Detail';
        $this->load->view($this->layout, $this->data);

    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data Item Detail';
        $this->load->view($this->layout, $this->data);

    }



    public function _key_unik()
    {

        $item_code = $this->input->post('item_code');
        $wh_code = $this->input->post('wh_code');
        $bin_code = $this->input->post('bin_code');

        $id = $this->uri->segment(3);
        $this->db->where('item_code', $item_code);
        $this->db->where('wh_code', $wh_code);
        $this->db->where('bin_code', $bin_code);
        !$id || $this->db->where('id !=', $id);
        $item = $this->item->get_all();

        if (count($item)) {
            $this->form_validation->set_message('_key_unik', 'Kombinasi Item, Warehouse, dan Bin sudah digunakan.');
            return false;
        }
        return true;
    }

    public function select($offset = null)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'item_detail',
            'main_view' => 'item_detail_select',
            'title' => 'Data Item Detail'
        );

        $item = $this->item->get_all_paged($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('biasa', site_url('item_detail/select/'), 3);
        } else {
            $this->data['item'] = 'Tidak ada data item detail.';
        }
        $this->data['form_action'] = site_url('item_detail/select_cari');
        $this->load->view($this->layout, $this->data);
    }

    public function select_cari($offset = 0)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'item_detail',
            'main_view' => 'item_detail_select',
            'title' => 'Data Item Detail'
        );

        $item = $this->item->cari($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('pencarian', site_url('item_detail/select_cari/'), 3);
        } else {
            $this->data['item'] = 'Data tidak ditemukan.'. anchor('item_detail', ' Tampilkan semua item detail. ', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('item_detail/select_cari');
        $this->load->view($this->layout, $this->data);
    }



}
