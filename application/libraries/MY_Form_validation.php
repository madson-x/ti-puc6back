<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * Executa um form validation
     *
     * @param string $group
     * @return void
     */
    public function runValidation($group = '')
    {
        if ($this->run() === false) {
            $this->jsonErroFormValidation();
        }

        
    }

    public function jsonErroFormValidation()
    {
        $this->ci =& get_instance();
        $resposta = [
            'status'=>false,
            'erro' => $this->error_string(false, '<br/>')
        ];
        $this->ci->response($resposta, $this->ci::HTTP_BAD_REQUEST);
    }


    /**
	 * verifica se um determinado possui valor vazio caso informado
	 *
	 * @param [type] $valor
	 * @return void
	 */
	public function no_empty($valor = "")
	{
		if (!is_null($valor) && $valor == "")
		{
			$this->set_message('no_empty', "O campo {field} não pode conter um valor em branco.");
			return false;
        }
        return true;
    }


    /**
	 * Existe
	 *
	 * Verifica  se um valor existe em um determinado campo
	 * de uma tabela
	 *
	 * @param	string	$str valor a ser pesquisado
	 * @param	string	$field tabela.campo a ser pesquisado
	 * @return	bool
	 */
	public function existe($str, $field)
	{
        sscanf($field, '%[^.].%[^.]', $table, $field);
        if (isset($this->CI->db)) {
            $existe =  $this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() !== 0;
            if ($existe) {
                return true;
            }
            $this->set_message('existe', "O {field} informado ({$str}) não existe.");
            return false;
        }
        $this->set_message('existe', "Sem acesso ao banco de dados para validação.");
        return false;
    }


     /**
     * Verifica se um item possui dependentes em outra tabela
     *
     * @param string $str
     * @param string $field tabela.campo||titulo do campo
     * @return boolean
     */
    public function semReferencias(string $str, string $field) :bool
    {
        $defaults = ["registro(s)"];
        list($field, $item) = array_merge(explode('||', $field), $defaults);
        sscanf($field, '%[^.].%[^.]', $tabela, $field);
        if (isset($this->CI->db)) {
            $rows = $this->CI->db->where([$field => $str])
                    ->from($tabela)
                    ->count_all_results();
            $semReferencias =  $rows === 0;
            if ($semReferencias) {
                return true;
            }

            $msg = "O {field} possui ${rows} ${item} vinculado(s) a ele.";
            $this->set_message(__FUNCTION__, $msg);
            return false;
        }
        $this->set_message(__FUNCTION__, "Sem acesso ao banco de dados para validação.");
        return false;
    }
}