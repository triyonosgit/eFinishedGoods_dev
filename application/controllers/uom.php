<?php 
class uom extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'uom',
        'main_view' => 'uom_list',
        'title' => 'Unit of Measure'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('uom_model', 'uom');
    }

    public function index($offset = null)
    { 
        $uom = $this->uom->get_all();
        
        if ($uom) {
            $this->data['uom'] = $uom;
            //$this->data['paging'] = $this->uom->paging('biasa', site_url('uom/halaman/'), 3);
        } else {
            $this->data['uom'] = 'Tidak ada data uom.';
        }
        //$this->data['form_action'] = site_url('uom/cari');
        $this->data['form_action'] = site_url('uom');
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
        $this->data['main_view'] = 'uom_form';
        $this->data['form_action'] = site_url('uom/tambah');

        // Data untuk form.
        if (! $_POST) {
            $uom = (object) $this->uom->default_value;
        } else {
            $uom = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->uom->validate('form_rules')) {
            $this->data['values'] = (object) $uom;
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan ke DB.
        if ($this->uom->tambah($uom)) {
            $this->session->set_flashdata('pesan', 'uom berhasil disimpan. Kembali ke halaman ' . anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'uom gagal disimpan. Kembali ke halaman ' . anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/error');
        }
    }

    public function edit($id = null)
    {
        // Pastikan data uom ada.
        $uom = $this->uom->get($id);
        if (! $uom) {
            $this->session->set_flashdata('pesan_error', 'Data uom tidak ada. Kembali ke halaman ' . anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $uom;
        } else {
            $data = (object) $this->input->post(null, true);

        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->uom->validate('form_rules')) {
            $this->data['main_view'] = 'uom_form';
            $this->data['form_action'] = site_url('uom/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->uom->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'uom berhasil disimpan. Kembali ke halaman ' . anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'uom gagal disimpan. Kembali ke halaman ' . anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data uom';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/uom');
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data uom';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/uom');
    }

    public function hapus($id)
    {
        // Pastikan data uom ada.
        $uom = $this->uom->get($id);
        //if (! $this->uom->get($id)) {
        if (is_null($uom)) {
            $this->session->set_flashdata('pesan_error', 'Data uom tidak ada. Kembali ke halaman ' . anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/error');
        }

        
        // Hapus
        if ($this->uom->delete($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus. Kembali ke halaman '. anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Data gagal dihapus. Kembali ke halaman '. anchor('uom', 'uom.', 'class="alert-link"'));
            redirect('uom/error');
        }    
    }

    public function _uom_unik()
    {
        
        $uom = $this->input->post('uom');
        //$wh_code = $this->input->post('wh_code');

        $id = $this->uri->segment(3);
        $this->db->where('uom', $uom);
        //$this->db->where('wh_code', $wh_code);
        !$id || $this->db->where('id !=', $id);
        $uom = $this->uom->get_all();

        if (count($uom)) {
            $this->form_validation->set_message('_uom_unik', '%s sudah digunakan.');
            //$this->form_validation->set_message('_uom_code_unik', 'Komuomasi uom Code dan Warehouse Code sudah digunakan.');
            return false;
        }
        return true;
    }

    /*
    public function select($item_code = null, $trans_type = null, $offset = null)
    { 
        $item_detail = $this->item_detail->get('item_code', $item_code);

        if ($item_detail) {
            // Item Code tsb ada di uom tertentu
            $this->layout = 'layout_wo_navbar';

            $this->data = array(
                'halaman' => 'uom',
                'main_view' => 'uom_select_with_qty',
                'title' => 'Data uom'
            );

            $search = array (
                'item_detail.item_code' => $item_code
            );

            $uom = $this->item_detail->get_all_paged_for_uom($search, $offset);

            if ($uom) {
                $this->data['uom'] = $uom;
                $this->data['paging'] = $this->item_detail->paging('biasa', site_url('uom/select/'.$item_code.'/'.$trans_type), 5, $search);
            } else {
                $this->data['uom'] = 'Tidak ada data uom.';
            }
            $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
            $this->load->view($this->layout, $this->data);  

        } else {
            // Item Code tsb tidak ada di uom mana pun
            
            if ($trans_type == 'R') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'uom',
                    'main_view' => 'uom_select',
                    'title' => 'Data uom'
                );

                $uom = $this->uom->get_all_paged($offset);

                if ($uom) {
                    $this->data['uom'] = $uom;
                    $this->data['paging'] = $this->uom->paging('biasa', site_url('uom/select/'.$item_code.'/'.$trans_type), 5);
                } else {
                    $this->data['uom'] = 'Tidak ada data uom.';
                }

                $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);      

            } elseif ($trans_type == 'I') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'uom',
                    'main_view' => 'uom_select',
                    'title' => 'Data uom'
                );

                $this->data['uom'] = 'Tidak ada data uom.';
                $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'T') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'uom',
                    'main_view' => 'uom_select',
                    'title' => 'Data uom'
                );

                $this->data['uom'] = 'Tidak ada data uom.';
                $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);
            }
        }
    } 


    public function select_cari($item_code = null, $trans_type = null, $offset = null)
    {


        $item_detail = $this->item_detail->get('item_detail.item_code', $item_code);

        if ($item_detail) {
            // Item Code tsb ada di uom tertentu
            $this->layout = 'layout_wo_navbar';

            $this->data = array(
                'halaman' => 'uom',
                'main_view' => 'uom_select_with_qty',
                'title' => 'Data uom'
            );

            $search = array (
                'item_detail.item_code' => $item_code
            );

            $uom = $this->item_detail->cari($search, $offset);

            if ($uom) {
                $this->data['uom'] = $uom;
                $this->data['paging'] = $this->item_detail->paging('pencarian', site_url('uom/select_cari/'.$item_code.'/'.$trans_type), 5, $search);
            } else {
                $this->data['uom'] = 'Tidak ada data uom.';
            }
            $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
            $this->load->view($this->layout, $this->data);  

        } else {
            // Item Code tsb tidak ada di uom mana pun
            if ($trans_type == 'R') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'uom',
                    'main_view' => 'uom_select',
                    'title' => 'Data uom'
                );

                $uom = $this->uom->cari($offset);

                if ($uom) {
                    $this->data['uom'] = $uom;
                    $this->data['paging'] = $this->uom->paging('pencarian', site_url('uom/select_cari/'.$item_code.'/'.$trans_type), 5);
                } else {
                    $this->data['uom'] = 'Tidak ada data uom.';
                }
                $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);       
             
            } elseif ($trans_type == 'I') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'uom',
                    'main_view' => 'uom_select',
                    'title' => 'Data uom'
                );

                $this->data['uom'] = 'Tidak ada data uom.';
                $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'T') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'uom',
                    'main_view' => 'uom_select',
                    'title' => 'Data uom'
                );

                $this->data['uom'] = 'Tidak ada data uom.';
                $this->data['form_action'] = site_url('uom/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);
            }
        }
    }    
    
    /*
    public function selectTransferTouom($item_code = null, $from_uom_code, $offset = null)
    { 
        
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'uom',
            'main_view' => 'uom_select_transfer',
            'title' => 'Data uom'
        );

        $search = array (
                'uom.uom_code <>' => $from_uom_code
            );

        $uom = $this->uom->get_all_paged_for_to_uom($search, $offset);

        if ($uom) {
            $this->data['uom'] = $uom;
            $this->data['paging'] = $this->uom->paging('biasa', site_url('uom/selectTransferTouom/'.$item_code.'/'.$from_uom_code), 5, $search);
        } else {
            $this->data['uom'] = 'Tidak ada data uom.';
        }


        $this->data['form_action'] = site_url('uom/selectTransferTouom_cari/'.$item_code.'/'.$from_uom_code);
        $this->load->view($this->layout, $this->data);      
    } 

    public function selectTransferTouom_cari($item_code = null, $from_uom_code, $offset = null)
    { 

        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'uom',
            'main_view' => 'uom_select_transfer',
            'title' => 'Data uom'
        );

        $search = array (
                'uom.uom_code <>' => $from_uom_code
            );

        $uom = $this->uom->cariTouom($search, $offset);

        if ($uom) {
            $this->data['uom'] = $uom;
            $this->data['paging'] = $this->uom->paging('pencarian', site_url('uom/selectTransferTouom_cari/'.$item_code.'/'.$from_uom_code), 5, $search);
        } else {
            $this->data['uom'] = 'Tidak ada data uom.';
        }

        $this->data['form_action'] = site_url('uom/selectTransferTouom_cari/'.$item_code.'/'.$from_uom_code);
        $this->load->view($this->layout, $this->data);      
    }
    */
}