<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
class Usuarios extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }
    
    public function index_get()
    {
        try {
           $usuarios = $this->UserModel->getUsers();
           $this->response($usuarios);

        } catch(Throwable $e) {
            $this->excecao($e);
        }
    }

    public function index_post()
    {
        try {
            $this->form_validation->set_rules('id','id','required');
            $this->form_validation->runValidation();
        } catch (\Throwable $th) {
            $this->excecao($th);
        }
    }

}

