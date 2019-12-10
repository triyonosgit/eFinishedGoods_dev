<?php
class Password extends MY_Controller
{
    public $layout = 'layout';

    public $data = array(
        'halaman' => 'password',        
        'title' => 'Password',
    );

	// Perlu mendefisikan ulang, karena lokasi model tidak standar
	// yaitu di bawah folder "admin" -> model/admin
    public function __construct()
    {
        parent::__construct();
        $this->load->model('password_model', 'password');
    }

    public function index()
    {
        // Pastikan data user ada.
        $id = $this->session->userdata('user_id');
        $user = $this->password->get($id);
        if (! $user) {
            $this->session->set_flashdata('pesan_error', 'Apa yang Anda Lakukan???. Kembali ke halaman ' . anchor('password', 'home.', 'class="alert-link"'));
            redirect('password/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $user;
            $data->password = '';
            $data->passconf = '';
        } else {
            $data = (object) $this->input->post(null, true);
        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->password->validate('form_rules')) {
            $this->data['main_view'] = 'password_form';
            $this->data['form_action'] = site_url('password');
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->password->edit($id, $data)) {
            //$this->session->set_userdata('username', $data->username);
            $this->session->set_flashdata('pesan', 'Data berhasil disimpan. Kembali ke halaman ' . anchor('home', 'Home.', 'class="alert-link"'));
            redirect('password/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Data berhasil disimpan. Kembali ke halaman ' . anchor('home', 'Home.', 'class="alert-link"'));
            redirect('password/error');
        }
    }

    public function reset($id)
    {

        $user = $this->password->get($id);
        if (! $user) {
            $this->session->set_flashdata('pesan_error', 'Apa yang Anda Lakukan???. Kembali ke halaman ' . anchor('password', 'home.', 'class="alert-link"'));
            redirect('password/error');
        }

        // Data untuk form.
        if (!$_POST) {
            $data = (object) $user;
            $data->password = '';
            $data->passconf = '';
        } else {
            $data = (object) $this->input->post(null, true);
        }
        $this->data['values'] = $data;

        // Validasi.
        if (! $this->password->validate('form_rules')) {
            $this->data['main_view'] = 'password_form';
            $this->data['form_action'] = site_url('password/reset/'.$id);
            $this->load->view($this->layout, $this->data);
            return;
        }

        // Simpan user.
        if ($this->password->edit($id, $data)) {
            //$this->session->set_userdata('username', $data->username);
            $this->session->set_flashdata('pesan', 'Data berhasil disimpan. Kembali ke halaman ' . anchor('home', 'Home.', 'class="alert-link"'));
            redirect('password/sukses');
        } else {
            $this->session->set_flashdata('pesan_error', 'Data berhasil disimpan. Kembali ke halaman ' . anchor('home', 'Home.', 'class="alert-link"'));
            redirect('password/error');
        }
    }

    public function sukses()
    {
        $this->data['main_view'] = 'sukses';
        $this->data['title'] = 'Password';
        $this->load->view($this->layout, $this->data);
    }

    public function error()
    {
        $this->data['main_view'] = 'error';
        $this->data['title'] = 'Password';
        $this->load->view($this->layout, $this->data);
    }

    // Kalau "password" diisi, maka "passconf" harus diisi
    public function _is_passconf_required()
    {
        $password = $this->input->post('password');
        if (! empty($password)) {
            $passconf = $this->input->post('passconf', true);
            if (empty($passconf)) {
                $this->form_validation->set_message('_is_passconf_required', '%s harus diisi.');
                return false;
            }
        }
        return true;
    }

    /*
    // Pastikan username unik, kecuali untuk user ini.
    public function _username_unik()
    {
        $id = $this->session->userdata('user_id');
        $this->db->where('username', $this->input->post('username'));
        !$id || $this->db->where('id !=', intval($id));
        $user = $this->myadmin->get_all();

        if (count($user)) {
            $this->form_validation->set_message('_username_unik', '%s sudah digunakan.');
            return false;
        }
        return true;
    }
    */
}