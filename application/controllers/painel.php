<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Painel extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        DV_init_painel();
    }
    
    public function index(){
        $this->inicio();
    }
    
    public function inicio(){
        if (DV_esta_logado(FALSE)):            
            DV_set_tema('titulo', 'Início');
            DV_set_tema('conteudo', '<div class="small-12 columns"></div>');
            DV_load_template();
        else:
            DV_set_msg('errologin', 'Acesso restrito, faça login antes de prosseguir!','erro');
            redirect('Clogin/login');
        endif;        
    }
    
    
    
    
}

/* Final do Arquivo painel.php
/* Localização: ./application/controllers/painel.php */
/* Data Criação: 01/08/2013 */