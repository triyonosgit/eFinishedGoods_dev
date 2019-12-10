<?php 
class Warehouse extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'warehouse',
        'main_view' => 'warehouse_list',
        'title' => 'Data Warehouse'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('warehouse_model', 'warehouse');
    
    }

    public function index($offset = null)
    { 
        $warehouse = $this->warehouse->get_all_paged($offset);
        if ($warehouse) {
            $this->data['warehouse'] = $warehouse;
            $this->data['paging'] = $this->warehouse->paging('biasa', site_url('warehouse/halaman/'), 3);
        } else {
            $this->data['warehouse'] = 'Tidak ada data warehouse.';
        }
        $this->data['form_action'] = site_url('warehouse/cari');
        $this->load->view($this->layout, $this->data);
    }

    public function cari($offset = 0)
    {
        $warehouse = $this->warehouse->cari($offset);
        if ($warehouse) {
            $this->data['warehouse'] = $warehouse;
            $this->data['paging'] = $this->warehouse->paging('pencarian', site_url('warehouse/cari/'), 3);
        } else {
            $this->data['warehouse'] = 'Data tidak ditemukan.'. anchor('warehouse', ' Tampilkan semua warehouse.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('warehouse/cari');
        $this->load->view($this->layout, $this->data);
    }    


    public function tambah()
    {
        $this->data['main_view'] = 'warehouse_form';
        $this->data['form_action'] = site_url('warehouse/tambah');

        // Data untuk form.
        if (! $_POST) {
            $warehouse = (object) $this->warehouse->default_value;
        } else {
            $warehouse = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->warehouse->validate('form_rules')) {
            $this->data['values'] = (object) $warehouse;
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan ke DB.
        if ($this->warehouse->tambah($warehouse)) {
            $this->session->set_flashdata('pesan', $values->wh_code . ' Warehouse berhasil disimpan. Kembali ke halaman ' . anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Warehouse gagal disimpan. Kembali ke halaman ' . anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/error');
        }
    }

    public function edit($id = null)
    {
        // Pastikan data warehouse ada.
        $warehouse = $this->warehouse->get($id);
        if (! $warehouse) {
            $this->session->set_flashdata('pesan_error', 'Data warehouse tidak ada. Kembali ke halaman ' . anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $warehouse;
        } else {
            $data = (object) $this->input->post(null, true);

        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->warehouse->validate('form_rules')) {
            $this->data['main_view'] = 'warehouse_form_edit';
            $this->data['form_action'] = site_url('warehouse/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->warehouse->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'Warehouse berhasil disimpan. Kembali ke halaman ' . anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Warehouse gagal disimpan. Kembali ke halaman ' . anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data Warehouse';
        $this->load->view($this->layout, $this->data);
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data Warehouse';
        $this->load->view($this->layout, $this->data);
    }

    public function hapus($id)
    {
        // Pastikan data warehouse ada.
        if (! $this->warehouse->get($id)) {
            $this->session->set_flashdata('pesan_error', 'Data warehouse tidak ada. Kembali ke halaman ' . anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/error');
        }

        // Hapus
        if ($this->warehouse->delete($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus. Kembali ke halaman '. anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Data gagal dihapus. Kembali ke halaman '. anchor('warehouse', 'warehouse.', 'class="alert-link"'));
            redirect('warehouse/error');
        }
    }

    public function _wh_code_unik()
    {
        
        $wh_code = $this->input->post('wh_code');

        $id = $this->uri->segment(3);
        $this->db->where('wh_code', $wh_code);
        !$id || $this->db->where('id !=', $id);
        $warehouse = $this->warehouse->get_all();

        if (count($warehouse)) {
            $this->form_validation->set_message('_wh_code_unik', '%s sudah digunakan.');
            return false;
        }
        return true;
    }

    public function select($offset = null)
    { 
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'warehouse',
            'main_view' => 'warehouse_select',
            'title' => 'Data Warehouse'
        );

        $warehouse = $this->warehouse->get_all_paged($offset);
        if ($warehouse) {
            $this->data['warehouse'] = $warehouse;
            $this->data['paging'] = $this->warehouse->paging('biasa', site_url('warehouse/select/'), 3);
        } else {
            $this->data['warehouse'] = 'Tidak ada data warehouse.';
        }
        $this->data['form_action'] = site_url('warehouse/select_cari');
        $this->load->view($this->layout, $this->data);
    }

    public function select_cari($offset = 0)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'warehouse',
            'main_view' => 'warehouse_select',
            'title' => 'Data Warehouse'
        );

        $warehouse = $this->warehouse->cari($offset);
        if ($warehouse) {
            $this->data['warehouse'] = $warehouse;
            $this->data['paging'] = $this->warehouse->paging('pencarian', site_url('warehouse/select_cari/'), 3);
        } else {
            $this->data['warehouse'] = 'Data tidak ditemukan.'. anchor('warehouse', ' Tampilkan semua warehouse.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('warehouse/select_cari');
        $this->load->view($this->layout, $this->data);
    }    
}