<?php

class UserModel extends CI_Model
{
    public function getUsers() :array
    {
        return $this->db->select('id, login')
                ->from('usuarios')
                ->get()
                ->result();
    }
}
