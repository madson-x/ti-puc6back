<?php

class Cliente extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClienteModel');
    }

    public function index_get()
    {
        $clientes = $this->ClienteModel->getClientes();
        $this->response($clientes);
    }

    public function index_post()
    {
        $dados = [
            'cartao' => 'xxxxx',
            'id_pessoa' => 'xxxx'
        ];
        //$id = $this->ClienteModel->cadCliente();
        $this->response(['id' => 2]);
    }
    
}
