<?php
class Bin extends MY_Controller
{


    public $layout = 'layout';

    public $data = array(
        'halaman' => 'bin',
        'main_view' => 'bin_list',
        'title' => 'Data Bin'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bin_model', 'bin');
        $this->load->model('item_detail_model', 'item_detail');
        $this->load->model('item_trans_model', 'item_trans');
        $this->load->model('item_master_model', 'item_master');

        /*
        if ($this->session->userdata('user_level') == 'viewer' ||
            $this->session->userdata('user_level') == 'operator') {
            $this->session->set_flashdata('pesan_error', 'Anda tidak punya hak akses ke menu yang dipilih');
            redirect(base_url());
        }
        */

    }

    public function index($offset = null)
    {
        $bin = $this->bin->get_all();

        if ($bin) {
            $this->data['bin'] = $bin;
            //$this->data['paging'] = $this->bin->paging('biasa', site_url('bin/halaman/'), 3);
        } else {
            $this->data['bin'] = 'Tidak ada data bin.';
        }
        $this->data['form_action'] = site_url('bin');
        $this->load->view($this->layout, $this->data);
    }

    public function cari($offset = 0)
    {
        $bin = $this->bin->cari($offset);
        if ($bin) {
            $this->data['bin'] = $bin;
            $this->data['paging'] = $this->bin->paging('pencarian', site_url('bin/cari/'), 3);
        } else {
            $this->data['bin'] = 'Data tidak ditemukan.'. anchor('bin', ' Tampilkan semua bin.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('bin/cari');
        $this->load->view($this->layout, $this->data);
    }


    public function tambah()
    {
        $this->data['main_view'] = 'bin_form';
        $this->data['form_action'] = site_url('bin/tambah');

        // Data untuk form.
        if (! $_POST) {
            $bin = (object) $this->bin->default_value;
        } else {
            $bin = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->bin->validate('form_rules')) {
            $this->data['values'] = (object) $bin;
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan ke DB.
        if ($this->bin->tambah($bin)) {
            $this->session->set_flashdata('pesan', 'Bin berhasil disimpan. Kembali ke halaman ' . anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Bin gagal disimpan. Kembali ke halaman ' . anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/error');
        }
    }

    public function edit($id = null)
    {
        // Pastikan data bin ada.
        $bin = $this->bin->get($id);
        if (! $bin) {
            $this->session->set_flashdata('pesan_error', 'Data bin tidak ada. Kembali ke halaman ' . anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $bin;
        } else {
            $data = (object) $this->input->post(null, true);

        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->bin->validate('form_rules')) {
            $this->data['main_view'] = 'bin_form_edit';
            $this->data['form_action'] = site_url('bin/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->bin->update($id, $data)) {
            $this->session->set_flashdata('pesan', 'Bin berhasil disimpan. Kembali ke halaman ' . anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Bin gagal disimpan. Kembali ke halaman ' . anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Data Bin';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/bin');
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Data Bin';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/bin');
    }

    public function hapus($id)
    {
        // Pastikan data bin ada.
        $bin = $this->bin->get($id);
        //if (! $this->bin->get($id)) {
        if (is_null($bin)) {
            $this->session->set_flashdata('pesan_error', 'Data bin tidak ada. Kembali ke halaman ' . anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/error');
        }

        // Pastikan apakah sudah ada history transaksi untuk Bin & Warehouse ini
        $search = array (
                    'bin_code' => $bin->bin_code
                    );
        if ($this->item_trans->get($search)) {
            //Kalau sudah pernah ada transaksi, tidak boleh dihapus lagi
            $this->session->set_flashdata('pesan_error', 'Bin ini tidak boleh dihapus karena sudah ada transaksi data. Kembali ke halaman '. anchor('bin', 'bin.', 'class="alert-link"'));
            redirect('bin/error');
        } else {
            // Hapus
            if ($this->bin->delete($id)) {
                $this->session->set_flashdata('pesan', 'Data berhasil dihapus. Kembali ke halaman '. anchor('bin', 'bin.', 'class="alert-link"'));
                redirect('bin/sukses');
            } else {
                $this->session->set_flashdata('pesan_error', 'Data gagal dihapus. Kembali ke halaman '. anchor('bin', 'bin.', 'class="alert-link"'));
                redirect('bin/error');
            }
        }
    }

    public function _bin_code_unik()
    {

        $bin_code = $this->input->post('bin_code');
        //$wh_code = $this->input->post('wh_code');

        $id = $this->uri->segment(3);
        $this->db->where('bin_code', $bin_code);
        //$this->db->where('wh_code', $wh_code);
        !$id || $this->db->where('id !=', $id);
        $bin = $this->bin->get_all();

        if (count($bin)) {
            $this->form_validation->set_message('_bin_code_unik', '%s sudah digunakan.');
            //$this->form_validation->set_message('_bin_code_unik', 'Kombinasi Bin Code dan Warehouse Code sudah digunakan.');
            return false;
        }
        return true;
    }

    public function select($item_code = null, $trans_type = null, $offset = null)
    {
        $item_detail = $this->item_detail->get('item_code', $item_code);
        $item_master = $this->item_master->get('item_code', $item_code);

        //if ($item_detail && ($trans_type <> 'A')) {
        if ($item_detail && ($trans_type <> 'R') && ($trans_type <> 'A')) {
            // Item Code tsb ada di Bin tertentu
            $this->layout = 'layout_wo_navbar';

            $this->data = array(
                'halaman' => 'Bin',
                'main_view' => 'bin_select_with_qty',
                'title' => 'Data Bin'
            );

            $search = array (
                'item_detail.item_code' => $item_code
            );

            $bin = $this->item_detail->get_all_item($search);

            if ($bin) {
                $this->data['bin'] = $bin;
            } else {
                $this->data['bin'] = 'Tidak ada data bin.';
            }
            $this->data['form_action'] = site_url('bin/select/'.$item_code.'/'.$trans_type);
            $this->load->view($this->layout, $this->data);

        } else {
            // Item Code tsb tidak ada di Bin mana pun

            if ($trans_type == 'R' || $trans_type == 'A') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $bin = $this->bin->get_all();

                if ($bin) {
                    $this->data['bin'] = $bin;
                } else {
                    $this->data['bin'] = 'Tidak ada data bin.';
                }

                $this->data['form_action'] = site_url('bin/select/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'I') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $this->data['bin'] = 'Tidak ada data bin.';
                $this->data['form_action'] = site_url('bin/select/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'T') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $this->data['bin'] = 'Tidak ada data bin.';
                $this->data['form_action'] = site_url('bin/select/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);
            }
        }
    }






    public function select2($item_code = null, $trans_type = 'R', $offset = null)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'bin_select2',
            'title' => 'Data Bin'
        );

        $bin = $this->bin->get_all();

        if ($bin) {
            $this->data['bin'] = $bin;
        } else {
            $this->data['bin'] = 'Tidak ada data bin.';
        }

        $this->data['form_action'] = site_url('bin/select2/'.$item_code.'/'.$trans_type);
        $this->load->view($this->layout, $this->data);


    }


     /* eat 20190517 */
    public function select3($offset = null)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'bin_select3',
            'title' => 'Data Bin'
        );

        // $this->data['bin'] = $this->bin->get_all();
        $this->data['bin'] = $this->bin->getAllBin();

        // $this->data['form_action'] = site_url('bin/select3');
        $this->load->view($this->layout, $this->data);


    }

    public function select4($itm)
    {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'bin_select4',
            'title' => 'Data Bin'
        );

        // $this->data['bin'] = $this->bin->get_all();
        $this->data['bin'] = $this->bin->getAllBinNQtyOH($itm);
        // print_r($this->data['bin']); die();

        // $this->data['form_action'] = site_url('bin/select3');
        $this->load->view($this->layout, $this->data);


    }



    /*
    public function select($item_code = null, $trans_type = null, $offset = null)
    {
        $item_detail = $this->item_detail->get('item_code', $item_code);

        if ($item_detail) {
            // Item Code tsb ada di Bin tertentu
            $this->layout = 'layout_wo_navbar';

            $this->data = array(
                'halaman' => 'Bin',
                'main_view' => 'bin_select_with_qty',
                'title' => 'Data Bin'
            );

            $search = array (
                'item_detail.item_code' => $item_code
            );

            $bin = $this->item_detail->get_all_paged_for_bin($search, $offset);

            if ($bin) {
                $this->data['bin'] = $bin;
                $this->data['paging'] = $this->item_detail->paging('biasa', site_url('bin/select/'.$item_code.'/'.$trans_type), 5, $search);
            } else {
                $this->data['bin'] = 'Tidak ada data bin.';
            }
            $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
            $this->load->view($this->layout, $this->data);

        } else {
            // Item Code tsb tidak ada di Bin mana pun

            if ($trans_type == 'R') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $bin = $this->bin->get_all_paged($offset);

                if ($bin) {
                    $this->data['bin'] = $bin;
                    $this->data['paging'] = $this->bin->paging('biasa', site_url('bin/select/'.$item_code.'/'.$trans_type), 5);
                } else {
                    $this->data['bin'] = 'Tidak ada data bin.';
                }

                $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'I') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $this->data['bin'] = 'Tidak ada data bin.';
                $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'T') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $this->data['bin'] = 'Tidak ada data bin.';
                $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);
            }
        }
    }
    */

    /*
    public function select_cari($item_code = null, $trans_type = null, $offset = null)
    {

        $item_detail = $this->item_detail->get('item_detail.item_code', $item_code);

        if ($item_detail) {
            // Item Code tsb ada di Bin tertentu
            $this->layout = 'layout_wo_navbar';

            $this->data = array(
                'halaman' => 'Bin',
                'main_view' => 'bin_select_with_qty',
                'title' => 'Data Bin'
            );

            $search = array (
                'item_detail.item_code' => $item_code
            );

            $bin = $this->item_detail->cari($search, $offset);

            if ($bin) {
                $this->data['bin'] = $bin;
                $this->data['paging'] = $this->item_detail->paging('pencarian', site_url('bin/select_cari/'.$item_code.'/'.$trans_type), 5, $search);
            } else {
                $this->data['bin'] = 'Tidak ada data bin.';
            }
            $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
            $this->load->view($this->layout, $this->data);

        } else {
            // Item Code tsb tidak ada di Bin mana pun
            if ($trans_type == 'R') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $bin = $this->bin->cari($offset);

                if ($bin) {
                    $this->data['bin'] = $bin;
                    $this->data['paging'] = $this->bin->paging('pencarian', site_url('bin/select_cari/'.$item_code.'/'.$trans_type), 5);
                } else {
                    $this->data['bin'] = 'Tidak ada data bin.';
                }
                $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'I') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $this->data['bin'] = 'Tidak ada data bin.';
                $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);

            } elseif ($trans_type == 'T') {
                $this->layout = 'layout_wo_navbar';

                $this->data = array(
                    'halaman' => 'Bin',
                    'main_view' => 'bin_select',
                    'title' => 'Data Bin'
                );

                $this->data['bin'] = 'Tidak ada data bin.';
                $this->data['form_action'] = site_url('bin/select_cari/'.$item_code.'/'.$trans_type);
                $this->load->view($this->layout, $this->data);
            }
        }
    }
    */

    public function selectTransferToBin($item_code = null, $from_bin_code, $offset = null)
    {

        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'bin_select_transfer',
            'title' => 'Data Bin'
        );

        $search = array (
                'bin.bin_code <>' => $from_bin_code
            );

        $bin = $this->bin->get_all($search);

        if ($bin) {
            $this->data['bin'] = $bin;
            //$this->data['paging'] = $this->bin->paging('biasa', site_url('bin/selectTransferToBin/'.$item_code.'/'.$from_bin_code), 5, $search);
        } else {
            $this->data['bin'] = 'Tidak ada data bin.';
        }


        $this->data['form_action'] = site_url('bin/selectTransferToBin/'.$item_code.'/'.$from_bin_code);
        $this->load->view($this->layout, $this->data);
    }

    /* 20181121 3ono /////////////////////////// */
    public function selectRack() {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'rack_select',
            'title' => 'Data Rack'
        );

        // $bin = $this->bin->get_all();

        $rack = $this->bin->getAllRack();
        //print_r($rack); die();
        $this->data['rack'] = $rack;
        $this->data['fromOrto'] = 'from';

        $this->data['form_action'] = site_url('bin/selectRack');
        $this->load->view($this->layout, $this->data);
    }

    public function selectRack2($fr_rack_code = null) {
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'rack_select',
            'title' => 'Data Rack'
        );

        // $bin = $this->bin->get_all();

        $rack = $this->bin->getAllRack2($fr_rack_code);

        $this->data['rack'] = $rack;
        $this->data['fromOrto'] = 'to';

        $this->data['form_action'] = site_url('bin/selectRack2/'.$fr_rack_code);
        $this->load->view($this->layout, $this->data);
    }
    /* ////////////////////////////////////////////////////// */


    public function search($phrase)
    {
        $criteria = '%'.$phrase.'%';
        $hasilQuery = $this->bin->binSearch($criteria);

        echo json_encode($hasilQuery);
    }


    /*
    public function selectTransferToBin_cari($item_code = null, $from_bin_code, $offset = null)
    {

        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'Bin',
            'main_view' => 'bin_select_transfer',
            'title' => 'Data Bin'
        );

        $search = array (
                'bin.bin_code <>' => $from_bin_code
            );

        $bin = $this->bin->cariToBin($search, $offset);

        if ($bin) {
            $this->data['bin'] = $bin;
            $this->data['paging'] = $this->bin->paging('pencarian', site_url('bin/selectTransferToBin_cari/'.$item_code.'/'.$from_bin_code), 5, $search);
        } else {
            $this->data['bin'] = 'Tidak ada data bin.';
        }

        $this->data['form_action'] = site_url('bin/selectTransferToBin_cari/'.$item_code.'/'.$from_bin_code);
        $this->load->view($this->layout, $this->data);
    }
    */

}
