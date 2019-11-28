<?php

class ReservaModel extends MY_Model
{
    public function getReservas(int $id)
    {
        $sql = "SELECT * FROM reserva 
        INNER JOIN cliente ON 
        reserva.cliente_idcliente = cliente.idcliente
        INNER JOIN acomodacao ON reserva.acomodacao_idacomodacao = acomodacao.idacomodacao
        WHERE cliente.pessoa_idpessoa = ?";
        return $this->db->query($sql, [$id])->result();
    }
}