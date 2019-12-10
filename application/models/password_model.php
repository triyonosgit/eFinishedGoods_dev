<?php
class Password_model extends MY_Model
{
    protected $_tabel = 'user';
    protected $form_rules = array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|xss_clean|required|max_length[45]|matches[passconf]'
        ),
        array(
            'field' => 'passconf',
            'label' => 'Konfirmasi Password',
            'rules' => 'trim|xss_clean|required|max_length[45]|callback__is_passconf_required|matches[password]'
        ),
    );

    public function edit($id, $user)
    {
        $user = (object) $user;
        unset($user->passconf);
        $user->password = md5($user->password);
        return $this->update($id, $user);

        /*
        unset($user->passconf);

        // Cek password
        if (empty($user->password)) {
            unset($user->password);
        } else {
            $user->password = md5($user->password);
        }
        return $this->update($id, $user);
        */
    }
}