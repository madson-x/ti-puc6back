<?php

class LoginModel extends CI_Model
{
    public function getUser(string $login) :?object
    {
        return $this->db->select()
                ->from('usuarios')
                ->where('login', $login)
                ->get()
                ->row();
    }
}
