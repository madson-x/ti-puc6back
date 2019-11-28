<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Reservas extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReservaModel');
        $this->checks();    
    }

    public function index_get()
    {
        try {
            $id = $this->user->usuario->idpessoa;            
            $reservas =  $this->ReservaModel->getReservas($id);
            $this->response($reservas);
        } catch (\Throwable $th) {
            $this->excecao($th);
        }
       
    }
    

}

/* End of file Reservas.php */
