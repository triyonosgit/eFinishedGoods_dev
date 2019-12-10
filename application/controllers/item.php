<?php
class Item extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'item_admin',
        'main_view' => 'item_list',
        'title' => 'Data Item'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_master_model', 'item');
        $this->load->model('item_trans_model', 'item_trans');
        $this->load->model('uom_model', 'uom');
        $this->load->model('item_category_model', 'item_category');

    }

    /*
    public function index($offset = null)
    {
        $item = $this->item->get_all_paged($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('biasa', site_url('item/halaman/'), 3);
        } else {
            $this->data['item'] = 'Tidak ada data item.';
        }
        $this->data['form_action'] = site_url('item/cari');
        $this->load->view($this->layout, $this->data);
    }

    public function cari($offset = 0)
    {
        $item = $this->item->cari($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('pencarian', site_url('item/cari/'), 3);
        } else {
            $this->data['item'] = 'Data tidak ditemukan.'. anchor('item', ' Tampilkan semua item.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('item/cari');
        $this->load->view($this->layout, $this->data);
    }
    */

    /*
    public function index($offset = null)
    {
        $item = $this->item->get_all();
        if ($item) {
            $this->data['item'] = $item;
        } else {
            $this->data['item'] = 'Tidak ada data item.';
        }
        $this->data['form_action'] = site_url('item');
        $this->load->view($this->layout, $this->data);
    }
    */

    public function index($offset = null)
    {
        $this->data['form_action'] = site_url('item');
        $this->load->view($this->layout, $this->data);
    }


    public function tambah()
    {

        $this->data['main_view'] = 'item_form';
        $this->data['form_action'] = site_url('item/tambah');


        // Data untuk form.
        if (! $_POST) {
            $item = (object) $this->item->default_value;
        } else {
            $item = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->item->validate('form_rules')) {
            $this->data['values'] = (object) $item;

            //Get UoM from database
            $uom = $this->uom->populate_dropdown();
            $uom_options = array('' => '-- Pilih --');
            //$uom_options['-- Pilih --'] = '-- Pilih --';

            foreach ($uom as $row) {
                $uom_options[$row['uom']] = $row['uom'];
            }

            $this->data['uom'] = $uom_options;

            // Item Type Options
            $item_type_options = array('' => '-- Pilih --',
                                       'COMPLETE' => 'COMPLETE',
                                       'PARTS' => 'PARTS'
                                      );

            $this->data['item_type'] = $item_type_options;


            //Get Item Category from database
            $item_category = $this->item_category->populate_dropdown();
            $item_category_options = array('' => '-- Pilih --');
            //$uom_options['-- Pilih --'] = '-- Pilih --';

            foreach ($item_category as $row) {
                $item_category_options[$row['category']] = $row['category'];
            }

            $this->data['category'] = $item_category_options;



            $this->load->view($this->layout, $this->data);
            return;
        }

        $item = (object) $item;

        if (! isset($item->qty_eStockCard)) {
          $item->qty_eStockCard = 0;
        }
        if (! isset($item->qty_external)) {
          $item->qty_external = 0;
        }

        // Simpan ke DB.
        if ($this->item->tambah($item)) {
            $this->session->set_flashdata('pesan', $values->item_code . ' Item berhasil disimpan. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item gagal disimpan. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }
    }

    public function edit($id = null)
    {
        // Pastikan data warehouse ada.
        $item = $this->item->get($id);
        if (! $item) {
            $this->session->set_flashdata('pesan_error', 'Data item tidak ada. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $item;
        } else {
            $data = (object) $this->input->post(null, true);

        }

        $this->data['values'] = $data;

        // Get UoM from database
        $uom = $this->uom->populate_dropdown();
        $uom_options = array('' => '-- Pilih --');

        foreach ($uom as $row) {
            $uom_options[$row['uom']] = $row['uom'];
        }

        $this->data['uom'] = $uom_options;


        // Item Type Options
        $item_type_options = array('' => '-- Pilih --',
                                   'COMPLETE' => 'COMPLETE',
                                   'PARTS' => 'PARTS'
                                  );

        $this->data['item_type'] = $item_type_options;


        // Get Item Category from database
        $item_category = $this->item_category->populate_dropdown();
        $item_category_options = array('' => '-- Pilih --');

        foreach ($item_category as $row) {
            $item_category_options[$row['category']] = $row['category'];
        }

        $this->data['category'] = $item_category_options;


        // Validasi.
        if (! $this->item->validate('form_rules')) {
            $this->data['main_view'] = 'item_form_edit';
            $this->data['form_action'] = site_url('item/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->item->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'Item berhasil disimpan. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Item gagal disimpan. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }
    }


    public function hapus($id)
    {
        // Pastikan data bin ada.
        $item = $this->item->get($id);

        //if (! $this->bin->get($id)) {
        if (is_null($item)) {
            $this->session->set_flashdata('pesan_error', 'Data Item tidak ada. Kembali ke halaman ' . anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        }

        // Pastikan apakah sudah ada history transaksi untuk Bin & Warehouse ini
        $search = array (
                    'item_code' => $item->item_code
                    );
        if ($this->item_trans->get($search)) {
            //Kalau sudah pernah ada transaksi, tidak boleh dihapus lagi
            $this->session->set_flashdata('pesan_error', 'Item ini tidak boleh dihapus karena sudah ada transaksi data. Kembali ke halaman '. anchor('item', 'item.', 'class="alert-link"'));
            redirect('item/error');
        } else {
            // Hapus
            if ($this->item->delete($id)) {
                $this->session->set_flashdata('pesan', 'Data berhasil dihapus. Kembali ke halaman '. anchor('item', 'item.', 'class="alert-link"'));
                redirect('item/sukses');
            } else {
                $this->session->set_flashdata('pesan_error', 'Data gagal dihapus. Kembali ke halaman '. anchor('item', 'item.', 'class="alert-link"'));
                redirect('item/error');
            }
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data Item';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/item');
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data Item';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/item');
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


    public function _cek_uom()
    {
        $uom = $this->input->post('uom');

        if (($uom != '') || (! empty($uom))) {
            return true;
        } else {
            $this->form_validation->set_message('_cek_uom', "UoM harus dipilih.");
            return false;
        }
    }

    public function _cek_item_category()
    {
        $item_category = $this->input->post('category');

        if (($item_category != '') || (! empty($item_category))) {
            return true;
        } else {
            $this->form_validation->set_message('_cek_item_category', "Item Category harus dipilih.");
            return false;
        }
    }

    public function _cek_item_type()
    {
        $item_type = $this->input->post('item_type');

        if (($item_type != '') || (! empty($item_type))) {
            return true;
        } else {
            $this->form_validation->set_message('_cek_item_type', "Item Type harus dipilih.");
            return false;
        }
    }



}
