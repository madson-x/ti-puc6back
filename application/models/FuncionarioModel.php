<?php

class FuncionarioModel extends MY_Model
{
    public function getfuncionarios() : array
    {

        $sql = "SELECT 
        funcionario.idfuncionario,
        pessoa.nome,
        pessoa.cpf,
        pessoa.nascimento,
        pessoa.email,
        pessoa.tel
        FROM pessoa INNER JOIN funcionario ON funcionario.pessoa_idpessoa = pessoa.idpessoa
        ";
        return $this->db->query($sql)->result();

        // return $this->db->select()
        //         ->from('pessoa')
        //         ->join('funcionario','funcionario.pessoa_idpessoa = pessoa.idpessoa')
        //         ->get()
        //         ->result();
    }


    public function getfuncionario(int $id): ?object{
        $sql = "SELECT 
        funcionario.idfuncionario,
        pessoa.nome,
        pessoa.cpf,
        pessoa.nascimento,
        pessoa.email,
        pessoa.tel
        FROM pessoa INNER JOIN funcionario ON funcionario.pessoa_idpessoa = pessoa.idpessoa
        WHERE funcionario.idfuncionario = ?
        LIMIT 1
        ";
        return $this->db->query($sql, [$id])->row();
    }

    public function cadFuncionario(array $pessoa, array $telefone, array $endereco) : int
    {
        $this->db->trans_start();
        
        $id = $this->insert('pessoa',$pessoa);

        $funcionario['pessoa_idpessoa'] = $id;
        $this->insert('funcionario', $funcionario);
        
        $telefone['pessoa'] = $id;
        $this->insert('telefone', $telefone);

        $endereco['pessoa'] = $id;
        $this->insert('endereco', $endereco);

        $this->db->trans_complete();
        
        return $id;
    }
}
