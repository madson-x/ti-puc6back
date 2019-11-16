<?php

class Cliente extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClienteModel');
    }

    public function index_get($id=null)
    {
        try {
            $this->form_validation->set_data(['id' => $id]);
            $this->form_validation->set_rules('id', 'id', 'numeric');
            $this->form_validation->runValidation();

            if (is_numeric($id))
            {
                $clientes = $this->ClienteModel->getCliente($id);
                $this->response($clientes);
            }
            $clientes = $this->ClienteModel->getClientes();
            $this->response($clientes);
        } catch (\Throwable $th) {
            //throw $th;
            $this->excecao($th);
        }
        
    }

    public function index_post()
    {
        try {
            $this->form_validation->set_data($this->post());         
            $this->form_validation->set_rules('cpf', 'CPF', 'required|exact_length[11]|numeric|is_unique[pessoa.cpf]');
            $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[45]|alpha_numeric_spaces');
            $this->form_validation->set_rules('nascimento', 'Data de nascimento', 'required|regex_match[/\d{4}-\d{2}-\d{2}/]');
            $this->form_validation->set_rules('tel', 'Telefone', 'required|min_length[10]|max_length[11]|numeric');
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[pessoa.email]');
            $this->form_validation->set_rules('senha', 'Senha', 'required|min_length[8]|max_length[16]');
            $this->form_validation->runValidation();
            
            $senha = $this->post("senha");
    
            $senha=password_hash($senha, PASSWORD_DEFAULT);
    
            
            $pessoa = [
                'nome' => $this->post("nome"),
                'cpf' => $this->post("cpf"),
                'nascimento' => $this->post("nascimento"),
                'senha' => $senha,
                'email' => $this->post("email")
            ];
            
            $telefone = [
                'telefonecol' => $this->post("telefone")
            ];

            $endereco = [
                'cep' => $this->post("cep"),
                'numero' => $this->post("numero"),
                'logradouro' => $this->post("endereco"),
                'bairro' => $this->post("bairro"),
                'cidade' => $this->post("cidade"),
                'complemento' => $this->post("complemento")

            ];
    
            $id = $this->ClienteModel->cadCliente($pessoa, $telefone, $endereco);
            $this->response(['id'=> $id],$this::HTTP_CREATED);
        } catch (\Throwable $th) {
            //throw $th;
            $this->excecao($th);
        }
    }
    
}
