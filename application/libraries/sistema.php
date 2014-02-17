<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DV_Sistema {
    
    protected $CI;
    public $tema    =   array();
    
    public function __construct(){
        $this->CI   =& get_instance();
        $this->CI->load->helper('DV_funcoes','DV_form', 'DV_html'); 
        $this->CI->load->model('m_model', 'msis');    //Model Geral do Sistema        
    }
    
    public function enviar_email($para, $assunto, $mensagem, $formato='html'){
        $this->CI->load->library('email');
        $config['mailtype'] =   $formato;
        $this->CI->email->initialize($config);
        $this->CI->email->from('web@davo.com.br', 'Administração da Intranet');
        $this->CI->email->to($para);
        $this->CI->email->subject($assunto);
        $this->CI->email->message($mensagem);
        if ($this->CI->email->send()):
            return TRUE;
        else:
            return $this->CI->email->print_debugger();
        endif;
    }
     
}

/* Final do Arquivo sistema.php
/* Localização: ./application/libraries/sistema.php */
/* Data Criação: 01/07/2013 */