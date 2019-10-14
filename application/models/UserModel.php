<?php

class UserModel extends CI_Model
{
    public function getUsers() :array
    {
        return $this->db->select('idpessoa, nome, cpf')
                ->from('pessoa')
                ->get()
                ->result();
    }
}
