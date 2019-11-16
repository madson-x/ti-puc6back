<?php

class MY_Model extends CI_Model
{

    /**
     * Efetua a inserção de dados em uma tabela
     *
     * @param string $tabela
     * @param array $dados
     * @return integer
     */
    public function insert(string $tabela, array $dados) : int
    {
        if ($this->db->insert($tabela, $dados, true)) {
            return $this->db->insert_id();
        }
        $erro = $this->db->error();
        throw new RuntimeException("Erro ao inserir os dados na tabela $tabela: {$erro['message']}");
    }

     /**
     * Efetua uma atualização simples retornando total de linhas atualizado
     *
     * @param string $tabela nome da tabela
     * @param array $where condições do where
     * @param array $dados valores
     * @return integer
     * @throws RuntimeException
     */
    public function update(string $tabela, array $where, array $dados = []) :int
    {
        if ($this->db->update($tabela, $dados, $where)) {
            return $this->db->affected_rows();
        }
        throw new RuntimeException("Erro ao atualizar os dados.");
    }

    /**
     *  Executa um delete retornando o total de linhas removidas
     *
     * @param string $tabela nome da tabela
     * @param array $where condições para exclusão
     * @return integer total de linhas removidas
     * @throws RuntimeException
     */
    public function delete(string $tabela, array $where) :int
    {
        if ($this->db->delete($tabela, $where)) {
            return $this->db->affected_rows();
        }
        throw new RuntimeException("Erro ao excluir os dados.");
    }
    
}
