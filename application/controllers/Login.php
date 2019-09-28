<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
class Login extends REST_Controller {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index_post()
    {
        try {
            $this->form_validation->set_rules('usuario', 'usuario', 'required');
            $this->form_validation->set_rules('senha', 'senha', 'required');
            
            if ($this->form_validation->run() == false) {                    
                $dados = array(
                    'status'=>false,
                    'erro' => $this->form_validation->error_array()
                );
                $this->response($dados, 400);
            }

            $this->load->model('LoginModel');

            $usuario  = $this->post('usuario', true);
            $senha = $this->post('senha', true);

            $usuario = $this->LoginModel->getUser($usuario);
            
            if (is_null($usuario)) {
                $this->response(
                    [
                        'status' => false,
                        'erro' => 'Usuário inválido'
                    ]
                    ,$this::HTTP_UNAUTHORIZED
                );
            }

            if (!password_verify($senha, $usuario->senha)) {
                $this->response(
                    [
                        'status' => false,
                        'erro' => 'Senha incorreta'
                    ]
                    ,$this::HTTP_UNAUTHORIZED
                );
            }
            
            unset($usuario->senha);//remove a senha

            $dados = [
                'usuario' => $usuario
            ];

            $token = $this->generanteToken($dados);

            $response = [
                'token' => $token
            ];
            
            $this->response($response);

        } catch(Throwable $e) {
             $this->response(
                [
                    'status' => false,
                    'erro' => $e->getMessage()
                ]
                ,REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    /**
     * Gera um novo token
     * @param array $data  payload do token
     * @param int $duracao  tempo em segundos para exipiraÃ§Ã£o
     * @return string
     */
    private function generanteToken($data, $duracao = NULL)
    {
        
        $key = $this->config->item('api_key');

        $horario = time();
        $expire = $horario + $duracao;
        
        $token = array(
            "iss" => base_url(),
            "aud" => base_url(),
            "iat" => $horario,
            "exp" => $expire,
            "nbf" => $horario -1,
            'data' => $data,
        );
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }

}

