<?php

class ClienteModel extends MY_Model
{
    public function getClientes() : array
    {

        $sql = "SELECT 
        cliente.idcliente,
        pessoa.nome,
        pessoa.cpf,
        pessoa.nascimento,
        pessoa.email,
        pessoa.tel
        FROM pessoa INNER JOIN cliente ON cliente.pessoa_idpessoa = pessoa.idpessoa
        ";
        return $this->db->query($sql)->result();

        // return $this->db->select()
        //         ->from('pessoa')
        //         ->join('cliente','cliente.pessoa_idpessoa = pessoa.idpessoa')
        //         ->get()
        //         ->result();
    }


    public function getCliente(int $id): ?object{
        $sql = "SELECT 
        cliente.idcliente,
        pessoa.nome,
        pessoa.cpf,
        pessoa.nascimento,
        pessoa.email,
        pessoa.tel
        FROM pessoa INNER JOIN cliente ON cliente.pessoa_idpessoa = pessoa.idpessoa
        WHERE cliente.idcliente = ?
        LIMIT 1
        ";
        return $this->db->query($sql, [$id])->row();
    }

    public function cadCliente(array $pessoa, array $telefone, array $endereco) : int
    {
        $this->db->trans_start();
        
        $id = $this->insert('pessoa',$pessoa);

        $cliente['pessoa_idpessoa'] = $id;
        $this->insert('cliente', $cliente);
        
        $telefone['pessoa'] = $id;
        $this->insert('telefone', $telefone);

        $endereco['pessoa'] = $id;
        $this->insert('endereco', $endereco);

        $this->db->trans_complete();
        
        return $id;
    }
}
