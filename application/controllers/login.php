<?php
class Login extends CI_Controller
{
    public $data = array (
        'halaman' => '',
        'main_view' => ''
    );


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model', 'login');
    }

    public function index()
    {
        // Validasi.
        if (! $this->login->validate('form_rules')) {
            $data['validation_errors'] = $this->form_validation->error_array();
            $this->load->view('login_form', $data);
            return;
        }

        // Login
        $login = $this->input->post(null, true);
        if (! $this->login->login($login)) {
            $this->session->set_flashdata('pesan_error', 'Username atau Password salah. Atau akun Anda sedang di non-aktifkan.');
            redirect('login');
        }

        // Jika login benar, alihkan ke halaman dashboard.
        redirect(base_url());
    }

    public function error()
    {
        //$this->load->view('login_form');
        $this->load->view('login');
    }

    public function logout()
    {
        $this->login->logout();
        redirect(base_url());
    }

    
}