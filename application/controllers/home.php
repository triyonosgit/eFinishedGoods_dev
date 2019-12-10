<?php
class Home extends MY_Controller
{
	public $layout = 'layout';

    public $data = array(
        'halaman' => 'home',
        'main_view' => 'home'
    );

    public function __construct()
    {
        parent::__construct();

        //session_start();

        // Cek status login user.
        $username = $this->session->userdata('username');
        //$user_level = $this->session->userdata('user_level');
        $login_status = $this->session->userdata('login_status');

        //if ( ($login_status !== true) && empty($username) && ( ($user_level !== 'operator') || ($user_level !== 'administrator') ) ) {
        if ( ($login_status !== true) && empty($username) ) {
            //redirect('admin/login');
            redirect('login');
        }
    }
    
    public function index()
    {
        $this->load->view($this->layout, $this->data);
    }
}