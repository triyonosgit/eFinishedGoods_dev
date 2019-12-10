<?php 
class Item_Category extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'item_category',
        'main_view' => 'item_category_list',
        'title' => 'Item Category'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_category_model', 'item_category');
    }

    public function index($offset = null)
    { 
        $item_category = $this->item_category->get_all();
        
        if ($item_category) {
            $this->data['item_category'] = $item_category;
            //$this->data['paging'] = $this->uom->paging('biasa', site_url('uom/halaman/'), 3);
        } else {
            $this->data['item_category'] = 'Tidak ada data item category.';
        }
        //$this->data['form_action'] = site_url('uom/cari');
        $this->data['form_action'] = site_url('item_category');
        $this->load->view($this->layout, $this->data);
    }

    /*
    public function cari($offset = 0)
    {
        $uom = $this->uom->cari($offset);
        if ($uom) {
            $this->data['uom'] = $uom;
            $this->data['paging'] = $this->uom->paging('pencarian', site_url('uom/cari/'), 3);
        } else {
            $this->data['uom'] = 'Data tidak ditemukan.'. anchor('uom', ' Tampilkan semua uom.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('uom/cari');
        $this->load->view($this->layout, $this->data);
    }    
    */

    public function tambah()
    {
        $this->data['main_view'] = 'item_category_form';
        $this->data['form_action'] = site_url('item_category/tambah');

        // Data untuk form.
        if (! $_POST) {
            $item_category = (object) $this->item_category->default_value;
        } else {
            $item_category = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->item_category->validate('form_rules')) {
            $this->data['values'] = (object) $item_category;
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan ke DB.
        if ($this->item_category->tambah($item_category)) {
            $this->session->set_flashdata('pesan', 'Item category berhasil disimpan. Kembali ke halaman ' . anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item category gagal disimpan. Kembali ke halaman ' . anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/error');
        }
    }

    public function edit($id = null)
    {
        // Pastikan data uom ada.
        $item_category = $this->item_category->get($id);
        if (! $item_category) {
            $this->session->set_flashdata('pesan_error', 'Data item category tidak ada. Kembali ke halaman ' . anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $item_category;
        } else {
            $data = (object) $this->input->post(null, true);

        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->item_category->validate('form_rules')) {
            $this->data['main_view'] = 'item_category_form';
            $this->data['form_action'] = site_url('item_category/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->item_category->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'Item category berhasil disimpan. Kembali ke halaman ' . anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item category gagal disimpan. Kembali ke halaman ' . anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data item category';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/item_category');
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data item category';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/item_category');
    }

    public function hapus($id)
    {
        // Pastikan data uom ada.
        $item_category = $this->item_category->get($id);
        //if (! $this->uom->get($id)) {
        if (is_null($item_category)) {
            $this->session->set_flashdata('pesan_error', 'Data item category tidak ada. Kembali ke halaman ' . anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/error');
        }

        
        // Hapus
        if ($this->item_category->delete($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus. Kembali ke halaman '. anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Data gagal dihapus. Kembali ke halaman '. anchor('item_category', 'item category.', 'class="alert-link"'));
            redirect('item_category/error');
        }    
    }

    public function _item_category_unik()
    {
        
        $item_category = $this->input->post('category');
        //$wh_code = $this->input->post('wh_code');

        $id = $this->uri->segment(3);
        $this->db->where('category', $item_category);
        //$this->db->where('wh_code', $wh_code);
        !$id || $this->db->where('id !=', $id);
        $item_category = $this->item_category->get_all();

        if (count($item_category)) {
            $this->form_validation->set_message('_item_category_unik', '%s sudah digunakan.');
            //$this->form_validation->set_message('_uom_code_unik', 'Komuomasi uom Code dan Warehouse Code sudah digunakan.');
            return false;
        }
        return true;
    }

    
}