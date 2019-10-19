<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
class MY_Controller extends REST_Controller
{
    /**
     * Usuario autenticado
     *
     * @var array
     */
    public $user;


    public function __construct()
    {
        parent::__construct();
        // $this->_checks();

    }

    /**
     * verificações antes de continuar
     */
    private function _checks()
    {
        $payload = $this->_check_token();
        $this->user =  $payload;
    }

    /**
     * Verifica o token do usuário
     * @return boolean|void
     */
    private function _check_token()
    {
        try
        {
            $authorization = $this->input->get_request_header('Authorization', TRUE);

            if ($authorization) {
                $key = $this->config->item('api_key');
                list($jwt) = sscanf($authorization, 'Bearer %s');
                $decoded = JWT::decode($jwt, $key, array('HS256'));

                if (property_exists($decoded,'data')) {
                     return $decoded->data;
                }
                else
                {
                    $this->response(
                        [
                            'status' => FALSE,
                            'erro' => 'Token inválido'
                        ],
                        $this::HTTP_UNAUTHORIZED
                    );
                }
            }else {
                $this->response(
                    [
                        'status' => FALSE,
                        'erro' => 'Token não informado'
                    ],
                    $this::HTTP_UNAUTHORIZED
                );
            }

        }
        catch(\Firebase\JWT\ExpiredException $e)
        {
            $this->response(
                [
                    'status' => FALSE,
                    'erro' => 'Acesso expirado'
                ],
                $this::HTTP_UNAUTHORIZED
            );
        }
        catch(\Firebase\JWT\SignatureInvalidException $e)
        {
            $this->response(
                [
                    'status' => FALSE,
                    'erro' => 'Assinatura Inválida'
                ],
                $this::HTTP_UNAUTHORIZED
            );
        }
        catch(Throwable $e)
        {
            $this->response(
                [
                    'status' => FALSE,
                    'erro' => 'Token Inválido'
                ],
                $this::HTTP_UNAUTHORIZED
            );
        }
    }

    //devolve uma exeção para o usuário de forma amigável
    protected function excecao(Throwable $th)
    {
        $this->response(
            [
                'erro' => $th->getMessage()
            ],
            REST_Controller::HTTP_INTERNAL_SERVER_ERROR
        );
    }


}
