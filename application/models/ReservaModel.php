<?php

class ReservaModel extends MY_Model
{
    public function getReservas(int $id)
    {
        $sql = "SELECT * FROM vw_reservas WHERE pessoa_idpessoa =  ?";
        return $this->db->query($sql, [$id])->result();
    }
}