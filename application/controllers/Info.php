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
        var_dump($this->user);
            
    }
    

}

/* End of file Info.php */
