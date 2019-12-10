<?php
class User_model extends MY_Model
{
    protected $_per_page = 10;

     // Nama tabel database yang akan digunakan.
    protected $_tabel = 'user';

    protected $form_rules = array(
        array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'trim|xss_clean|required|max_length[60]'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|xss_clean|required|max_length[45]|callback__username_unik'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|xss_clean|callback__is_password_required|max_length[45]|matches[passconf]'
        ),
        array(
            'field' => 'passconf',
            'label' => 'Konfirmasi Password',
            'rules' => 'trim|xss_clean|callback__is_passconf_required|max_length[45]|matches[password]'
        ),
        array(
            'field' => 'level',
            'label' => 'Level',
            'rules' => 'trim|xss_clean|required'
        ),
        array(
            'field' => 'enable',
            'label' => 'Status',
            'rules' => 'trim|xss_clean|required'
        )
    );

    public $default_value = array(
        'nama' => '',
        'username' => '',
        'password' => '',
        'passconf' => '',
        'level' => 'operator',
        'enable' => 1
    );

    public function tambah($user)
    {
        $user = (object) $user;
        unset($user->passconf);
        $user->password = md5($user->password);
        return $this->insert($user);
    }

    public function edit($id, $user)
    {
        $user = (object) $user;
        unset($user->passconf);
        //$user->password = md5($user->password);
        return $this->update($id, $user);
    }

    public function updateStatus($id, $user)
    {
        $user = (object) $user;
        unset($user->passconf);
        return $this->update($id, $user);
    }
}