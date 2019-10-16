<?php

class ClienteModel extends MY_Model
{
    public function getClientes() : array
    {
        return $this->db->select()
                ->from('cliente')
                ->get()
                ->result();
    }

    public function cadCliente(array $dados) : int
    {
        return $this->insert('cliente', $dados);
    }
}
