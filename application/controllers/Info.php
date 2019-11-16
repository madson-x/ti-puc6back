<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->checks();    
    }

    public function index_get()
    {
        try {
            $this->response($this->user);
        } catch (\Throwable $th) {
            $this->excecao($th);
        }
       
    }
    

}

/* End of file Info.php */
