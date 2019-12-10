<?php
class Item_Master extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'item_master',
        'main_view' => 'item_master_list',
        'title' => 'Data Item Master'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_master_model', 'item');

    }

    /*
    public function index($offset = null)
    {
        $item = $this->item->get_all_paged($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('biasa', site_url('item_master/halaman/'), 3);
        } else {
            $this->data['item'] = 'Tidak ada data item.';
        }
        $this->data['form_action'] = site_url('item_master/cari');
        $this->load->view($this->layout, $this->data);
    }

    public function cari($offset = 0)
    {
        $item = $this->item->cari($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('pencarian', site_url('item_master/cari/'), 3);
        } else {
            $this->data['item'] = 'Data tidak ditemukan.'. anchor('item_master', ' Tampilkan semua item.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('item_master/cari');
        $this->load->view($this->layout, $this->data);
    }
    */

    public function index($offset = null)
    {
        
        $this->data['form_action'] = site_url('item_master');
        $this->load->view($this->layout, $this->data);
    }


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

    public function edit($id = null)
    {
        // Pastikan data warehouse ada.
        $item = $this->item->get($id);
        if (! $item) {
            $this->session->set_flashdata('pesan_error', 'Data item tidak ada. Kembali ke halaman ' . anchor('item_master', 'item.', 'class="alert-link"'));
            redirect('item/error');
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
            $this->data['main_view'] = 'item_form';
            $this->data['form_action'] = site_url('item_master/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->item->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'Item berhasil disimpan. Kembali ke halaman ' . anchor('item_master', 'item.', 'class="alert-link"'));
            redirect('item_master/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item gagal disimpan. Kembali ke halaman ' . anchor('item_master', 'item.', 'class="alert-link"'));
            redirect('item_master/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data Item';
        $this->load->view($this->layout, $this->data);
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data Item';
        $this->load->view($this->layout, $this->data);
    }



    public function _item_code_unik()
    {

        $item_code = $this->input->post('item_code');

        $id = $this->uri->segment(3);
        $this->db->where('item_code', $item_code);
        !$id || $this->db->where('id !=', $id);
        $item = $this->item->get_all();

        if (count($item)) {
            $this->form_validation->set_message('_item_code_unik', '%s sudah digunakan.');
            return false;
        }
        return true;
    }

    public function select($offset = null)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'item_master',
            'main_view' => 'item_select',
            'title' => 'Data Item'
        );

        $item = $this->item->get_all();
        if ($item) {
            $this->data['item'] = $item;
        } else {
            $this->data['item'] = 'Tidak ada data item.';
        }
        $this->load->view($this->layout, $this->data);
    }

    /*
    public function select($offset = null)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'item_master',
            'main_view' => 'item_select',
            'title' => 'Data Item'
        );

        $item = $this->item->get_all_paged($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('biasa', site_url('item_master/select/'), 3);
        } else {
            $this->data['item'] = 'Tidak ada data item.';
        }
        $this->data['form_action'] = site_url('item_master/select_cari');
        $this->load->view($this->layout, $this->data);
    }

    public function select_cari($offset = 0)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'item_master',
            'main_view' => 'item_select',
            'title' => 'Data Item'
        );

        $item = $this->item->cari($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('pencarian', site_url('item_master/select_cari'), 3);
        } else {
            $this->data['item'] = 'Data tidak ditemukan.'. anchor('item_master/select_cari', ' Tampilkan semua item.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('item_master/select_cari');
        $this->load->view($this->layout, $this->data);
    }
    */



    /*
    public function receive()
    {

        $this->data['halaman'] = 'receive_item';
        $this->data['main_view'] = 'item_transaction';
        $this->data['form_action'] = site_url('item_master/receive');

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

        // Simpan ke Database
        if ($this->item->receive($item)) {
            $this->session->set_flashdata('pesan', 'Transaksi berhasil diproses. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Transaksi gagal diproses. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }
    }

    public function issue()
    {
        $this->data['halaman'] = 'issue_item';
        $this->data['main_view'] = 'item_transaction';
        $this->data['form_action'] = site_url('item/issue');

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

        // Simpan ke Database
        if ($this->item->issue($item)) {
            $this->session->set_flashdata('pesan', 'Transaksi berhasil diproses. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Transaksi gagal diproses. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }
    }
    */
}
