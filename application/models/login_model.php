<?php
class Login_model extends MY_Model
{
    protected $_tabel = 'user';

    public $form_rules = array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|xss_clean|required|max_length[45]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|xss_clean|required|max_length[45]'
        ),
    );

    public function login($login)
    {
        $login = (object)$login;
        $login->password = md5($login->password);

        $where = array(
            'username' => $login->username,
            'password' => $login->password,
            'enable' => 1
        );

        // User ada / cocok?
        if ($user = $this->get($where)) {
            // Buat data session
            $data = array(
                'user_id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'user_level' => $user->level,
                'login_status' => true,
                'timestamp' => time()
            );
            $this->session->set_userdata($data);

            // Return login status, sukses.
            return true;
        }
        // Return false jika gagal.
        return false;
    }

    public function logout()
    {
        $this->session->unset_userdata(
            array('user_id' => '', 'username' => '', 'nama' => '', 'user_level' => '', 'login_status' => false, 'timestamp' => '')
        );
        $this->session->sess_destroy();
    }
}
