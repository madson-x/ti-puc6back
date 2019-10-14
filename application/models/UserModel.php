<?php

class UserModel extends CI_Model
{
    public function getUsers() :array
    {
        return $this->db->select('idpessoa, nome, cpf, email')
                ->from('pessoa')
                ->get()
                ->result();
    }
}
