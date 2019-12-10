<?php 
class Item_Trans extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'item_receive',
        'main_view' => 'item_receive',
        'title' => 'Item Transaction'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_trans_model', 'item_trans');
        $this->load->model('item_detail_model', 'item_detail');
        $this->load->model('item_master_model', 'item_master');
    
    }

    public function receive()
    {
        $this->data['halaman'] = 'item_receive';
        $this->data['main_view'] = 'item_receive';
        $this->data['form_action'] = site_url('item_trans/receive');

        // Data untuk form.
        if (! $_POST) {
            $item_trans = (object) $this->item_trans->default_value_receive;
        } else {
            $item_trans = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->item_trans->validate('form_rules_receive')) {
            $this->data['values'] = (object) $item_trans;
            $this->load->view($this->layout, $this->data);
            return;
        }

        $item_trans = (object) $item_trans;

        //Get the item_master information for the associated item code
        $item_master = $this->item_master->get('item_code', $item_trans->item_code);
        $item_trans->old_qty = $item_master->qty_eStockCard;
        $item_trans->new_qty = $item_master->qty_eStockCard + $item_trans->qty;


        // Cek apakah sudah pernah ada transaksi untuk Item Code, Bin Code, dan Warehouse Code yang di-receive
        $where = array(
            'item_code' => $item_trans->item_code,
            'bin_code' => $item_trans->bin_code
        );

        // Kalau sudah pernah ada transaksi di Item Code, Bin Code yang di-receive
        if ($item_detail = $this->item_detail->get($where)) {
            $item_detail->qty += $item_trans->qty;
            //Update ke Item Detail Table
            $id = $item_detail->id;
            if ($this->item_detail->update($id, $item_detail))  {
                //Kalau berhasil, Do Nothing
            } else {
                $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/receive', 'item receive.', 'class="alert-link"'));
                redirect('item_trans/error');      
            }
        } else {    
            // Insert transaksi baru di Item Code, Bin Code yang di-receive
            $item_detail->item_code = $item_trans->item_code;
            $item_detail->bin_code = $item_trans->bin_code;
            $item_detail->qty = $item_trans->qty;
            $item_detail->uom = $item_trans->uom;
            if ($this->item_detail->tambah($item_detail)) {
                // Kalau insert berhasil - Do Nothing     
            } else {
                $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/receive', 'item receive.', 'class="alert-link"'));
                redirect('item_trans/error');
            }
        }  

        if ($this->item_trans->tambah($item_trans)) {
            //Kalau berhasil, Do Nothing
        } else {
            $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/receive', 'item receive.', 'class="alert-link"'));
            redirect('item_trans/error');
        }
        
        // Kalau semua transaksi berhasil, update Item Master
        // Get Item Master
        if ($item_master = $this->item_master->get('item_code', $item_trans->item_code)) {
            $item_master->qty_eStockCard += $item_trans->qty;

            //Update ke Item Master table
            if ($this->item_master->update($item_master->id, $item_master)) {
                $this->session->set_flashdata('pesan', 'Transaksi berhasil disimpan. Kembali ke halaman ' . anchor('item_trans/receive', 'item receive.', 'class="alert-link"'));
                redirect('item_trans/sukses');    
            } else {
                $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/receive', 'item receive.', 'class="alert-link"'));
                redirect('item_trans/error');   
            }
        }
    }


    public function issue()
    {
        $this->data['halaman'] = 'item_issue';
        $this->data['main_view'] = 'item_issue';
        $this->data['form_action'] = site_url('item_trans/issue');

        // Data untuk form.
        if (! $_POST) {
            $item_trans = (object) $this->item_trans->default_value_issue;
        } else {
            $item_trans = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->item_trans->validate('form_rules_issue')) {
            $this->data['values'] = (object) $item_trans;
            $this->load->view($this->layout, $this->data);
            return;
        }

        $item_trans = (object) $item_trans;
        
        $trans_qty = $item_trans->qty;
        $item_trans->qty = $item_trans->qty * -1;       //Change the qty to 'negative' value for issue transaction

        //Get the item_master information for the associated item code
        $item_master = $this->item_master->get('item_code', $item_trans->item_code);
        $item_trans->old_qty = $item_master->qty_eStockCard;
        $item_trans->new_qty = $item_master->qty_eStockCard + $item_trans->qty;

        // Cek apakah sudah pernah ada transaksi untuk Item Code, Bin Code yang di-receive
        $where = array(
            'item_code' => $item_trans->item_code,
            'bin_code' => $item_trans->bin_code
        );

        // Simpan ke DB.
        if ($item_detail = $this->item_detail->get($where)) {
            $id = $item_detail->id;

            //Kalau Qty Transaksi = Qty Bin maka data Item Detail di Bin tsb di hapus
            if ($item_detail->qty == $trans_qty) {
                if ($this->item_detail->delete($id)) {
                    //Once the item detail is deleted, then insert the transaction into item transaction
                    //Update ke Item Transaction Table 
                    if ($this->item_trans->tambah($item_trans)) {
                        //Do nothing
                    }
                    else {
                        $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
                        redirect('item_trans/error');
                    }   
                } else {
                    $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
                    redirect('item_trans/error');      
                }
            } else { 
                //Update ke Item Detail Table 
                $item_detail->qty += $item_trans->qty;
                if ($this->item_detail->update($id, $item_detail))  {
                    if ($this->item_trans->tambah($item_trans)) {
                        //Do nothing
                    }
                    else {
                        $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
                        redirect('item_trans/error');
                    }   
                } else {
                    $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
                    redirect('item_trans/error');      
                }
            }
        } else {    
            // Belum pernah ada transaksi di Bin ini
            $this->session->set_flashdata('pesan_error', 'Tidak ada barang ' . $item_trans->item_code . ' di Bin ini. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
            redirect('item_trans/error');

        }
      
        // Kalau semua transaksi berhasil, update Item Master
        // Get Item Master
        if ($item_master = $this->item_master->get('item_code', $item_trans->item_code)) {
            $item_master->qty_eStockCard += $item_trans->qty;

            //Update ke Item Master table
            if ($this->item_master->update($item_master->id, $item_master)) {
                $this->session->set_flashdata('pesan', 'Transaksi berhasil disimpan. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
                redirect('item_trans/sukses');    
            } else {
                $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/issue', 'item issue.', 'class="alert-link"'));
                redirect('item_trans/error');   
            }
        }
    }

    public function transfer()
    {
        $this->data['halaman'] = 'item_transfer';
        $this->data['main_view'] = 'item_transfer';
        $this->data['form_action'] = site_url('item_trans/transfer');

        // Data untuk form.
        if (! $_POST) {
            $item_trans = (object) $this->item_trans->default_value_transfer;
        } else {
            $item_trans = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->item_trans->validate('form_rules_transfer')) {
            $this->data['values'] = (object) $item_trans;
            $this->load->view($this->layout, $this->data);
            return;
        }



        $this->db->trans_start();

        $item_trans_from_bin = (object) $item_trans;
        $item_trans_to_bin = (object) $item_trans;
        $item_trans_from_bin->bin_code = $item_trans_from_bin->from_bin_code;
        $item_trans_to_bin->bin_code = $item_trans_to_bin->to_bin_code;


        //$trans_qty = $item_trans->qty;
        //$item_trans->qty = $item_trans->qty * -1;       //Change the qty to 'negative' value for issue transaction

        //Get the item detail information for the associated item code and bin code
        $where_from_bin = array (
                'item_code' => $item_trans_from_bin->item_code,
                'bin_code' => $item_trans_from_bin->from_bin_code
            );

        $where_to_bin = array (
                'item_code' => $item_trans_to_bin->item_code,
                'bin_code' => $item_trans_to_bin->to_bin_code
            );

        $item_detail_from_bin = $this->item_detail->get($where_from_bin);
        $item_detail_to_bin = $this->item_detail->get($where_to_bin);


        if (!is_null($item_detail_from_bin)) {
            
            $item_trans_from_bin->trans_type = 'TO';
            $trans_qty_from_bin = $item_trans_from_bin->qty;
            $item_trans_from_bin->qty *= -1;
            $item_trans_from_bin->old_qty = $item_detail_from_bin->qty;
            $item_trans_from_bin->new_qty = $item_trans_from_bin->old_qty + $item_trans_from_bin->qty;


            if ($this->item_trans->tambah($item_trans_from_bin)) {
                if ($item_detail_from_bin->qty == $trans_qty_from_bin) {
                    $this->item_detail->delete($item_detail_from_bin->id);
                } else {
                    $item_detail_from_bin->qty += $item_trans_from_bin->qty;
                    $this->item_detail->update($item_detail_from_bin->id, $item_detail_from_bin);
                }
            }
        }


        if (!is_null($item_detail_to_bin)) {
            
            $item_trans_to_bin->trans_type = 'TI';
            $trans_qty_to_bin = $item_trans_to_bin->qty;
            $item_trans_to_bin->old_qty = $item_detail_to_bin->qty;
            $item_trans_to_bin->new_qty = $item_trans_to_bin->old_qty + $item_trans_to_bin->qty;

            if ($this->item_trans->tambah($item_trans_to_bin)) {
                $item_detail_to_bin->qty += $trans_qty_to_bin;
                $this->item_detail->update($item_detail_to_bin->id, $item_detail_to_bin);
            }
        } else {
            $item_trans_to_bin->trans_type = 'TI';
            $trans_qty_to_bin = $item_trans_to_bin->qty;
            $item_trans_to_bin->old_qty = 0;
            $item_trans_to_bin->new_qty = $item_trans_to_bin->old_qty + $item_trans_to_bin->qty;

            if ($this->item_trans->tambah($item_trans_to_bin)) {
                $item_detail_to_bin = array(
                    'item_code' => $item_trans_to_bin->item_code,
                    'bin_code' => $item_trans_to_bin->to_bin_code,
                    'uom' => $item_trans_to_bin->uom,
                    'qty' => $item_trans_to_bin->qty
                );
                $this->item_detail->tambah($item_detail_to_bin);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $this->session->set_flashdata('pesan_error', 'Transaksi gagal disimpan. Kembali ke halaman ' . anchor('item_trans/transfer', 'item transfer.', 'class="alert-link"'));
            redirect('item_trans/error');    
        } else {
            $this->session->set_flashdata('pesan', 'Transaksi berhasil disimpan. Kembali ke halaman ' . anchor('item_trans/transfer', 'item transfer.', 'class="alert-link"'));
            redirect('item_trans/sukses'); 
        }

        
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

    public function _cannot_greater_than_bin_qty()
    {
        
        $qty = $this->input->post('qty');
        $bin_qty = $this->input->post('bin_qty');

        if ($qty > $bin_qty) {
            $this->form_validation->set_message('_cannot_greater_than_bin_qty', 'Transaction Qty tidak boleh lebih besar dari Bin Qty.');
            return false;
        }

        return true;
    }

    public function select($offset = null)
    { 
        $this->layout = 'layout_wo_navbar';

        $this->data = array(
            'halaman' => 'item',
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
            'halaman' => 'item',
            'main_view' => 'item_select',
            'title' => 'Data Item'
        );

        $item = $this->item->cari($offset);
        if ($item) {
            $this->data['item'] = $item;
            $this->data['paging'] = $this->item->paging('pencarian', site_url('item_master/select_cari/'), 3);
        } else {
            $this->data['item'] = 'Data tidak ditemukan.'. anchor('item_master', ' Tampilkan semua item.', 'class="alert-link"');
        }
        $this->data['form_action'] = site_url('item_master/select_cari');
        $this->load->view($this->layout, $this->data);
    }    

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