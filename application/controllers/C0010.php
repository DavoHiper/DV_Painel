<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0010 extends CI_Controller{

    public function __construct(){
        
        parent::__construct();
        DV_init_painel($this->router->class);                           
        
    }    
    
    public function _remap($method){
                                        
        DV_esta_logado();
        
        $this->$method();

    }

    public function index(){
        $this->listar();       
    }
        
    public function autocomplete_user(){
        
    }
}

/* Final do Arquivo C0004.php
/* Localização: ./application/controllers/C0004.php */
/* Data Criação: 12/08/2013 */