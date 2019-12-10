<?php
class User extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'user',
        'main_view' => 'user_list',
        'title' => 'User',
    );

	// Perlu mendefisikan ulang, karena lokasi model tidak standar
	// yaitu di bawah folder "admin" -> model/admin
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
    }

    public function index()
    {
        $user = $this->user->get_all();
        if ($user) {
            $this->data['user'] = $user;
        } else {
            $this->data['user'] = 'Tidak ada data user.';
        }
        $this->load->view($this->layout, $this->data);
    }
    
    public function tambah()
    {
        $this->data['main_view'] = 'user_form';
        $this->data['form_action'] = site_url('user/tambah');

        // Data untuk form.
        if (! $_POST) {
            $user = (object) $this->user->default_value;
            $user->password = '';
            $user->passconf = '';
        } else {
            $user = $this->input->post(null, true);
        }

        // Validasi.
        if (! $this->user->validate('form_rules')) {
            $this->data['values'] = (object) $user;
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan ke DB.
        if ($this->user->tambah($user)) {
            $this->session->set_flashdata('pesan', 'user berhasil disimpan. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'user gagal disimpan. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }
    }

    public function edit($id = null)
    {
        // Pastikan data user ada.
        $user = $this->user->get($id);
        if (! $user) {
            $this->session->set_flashdata('pesan_error', 'Data user tidak ada. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $user;
            //$data->password = '';
            $data->passconf = $data->password;
        } else {
            $data = (object) $this->input->post(null, true);
        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->user->validate('form_rules')) {
            $this->data['main_view'] = 'user_form_edit';
            $this->data['form_action'] = site_url('user/edit/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->user->edit($id, $data)) {
            $this->session->set_flashdata('pesan', 'user berhasil disimpan. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'user berhasil disimpan. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }
    }

    public function status($id = null)
    {
        // Pastikan data user ada.
        $user = $this->user->get($id);
        if (! $user) {
            $this->session->set_flashdata('pesan_error', 'Data user tidak ada. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }

        if (($user->enable) == 0) {
            $user->enable = 1;
        } 
        else {
            $user->enable = 0;
        }

        // Update user status.
        if ($this->user->updateStatus($id, $user)) {
            $this->session->set_flashdata('pesan', 'Status user berhasil diganti. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Status user gagal diganti. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'User';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/user');
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'User';
        $this->load->view($this->layout, $this->data);
        $this->output->set_header('refresh:1; url='.base_url().'index.php/user');
    }

    public function hapus($id)
    {
        // Pastikan data user ada.
        if (! $this->user->get($id)) {
            $this->session->set_flashdata('pesan_error', 'Data user tidak ada. Kembali ke halaman ' . anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }

        // Hapus
        if ($this->user->delete($id)) {
            $this->session->set_flashdata('pesan', 'Data berhasil dihapus. Kembali ke halaman '. anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Data gagal dihapus. Kembali ke halaman '. anchor('user', 'user.', 'class="alert-link"'));
            redirect('user/error');
        }
    }

    // Kolom "password" harus diisi hanya untuk proses tambah.
    // Jika "id" ada di URL (edit), maka password tidak "required"
    public function _is_password_required()
    {
        $id = $this->uri->segment(3);
        if (empty($id)) {
            $password = $this->input->post('password', true);
            if (empty($password)) {
                $this->form_validation->set_message('_is_password_required', '%s harus diisi.');
                return false;
            }
        }
        return true;
    }

    // Jika "password" diisi, maka "passconf" harus diisi
    public function _is_passconf_required()
    {
        $password = $this->input->post('password', true);
        if (! empty($password)) {
            $passconf = $this->input->post('passconf', true);
            if (empty($passconf)) {
                $this->form_validation->set_message('_is_passconf_required', '%s harus diisi.');
                return false;
            }
        }
        return true;
    }

    public function _username_unik()
    {
        $id = $this->uri->segment(3);
        $this->db->where('username', $this->input->post('username'));
        !$id || $this->db->where('id !=', $id);
        $user = $this->user->get_all();

        if (count($user)) {
            $this->form_validation->set_message('_username_unik', '%s sudah digunakan.');
            return false;
        }
        return true;
    }
}