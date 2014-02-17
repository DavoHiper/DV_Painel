<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0075 extends CI_Controller{

    public function __construct(){
        
        parent::__construct();
        DV_init_painel($this->router->class);                           
        
    }    
    
    public function _remap($method){
                                        
        DV_esta_logado();
        
        $this->$method();

    }

    public function index(){
        $this->pagamentos();       
    }
        
    public function pagamentos(){
        
        //Validação de Formulário
		$this->form_validation->set_rules('DAT_PAG'     , 'Data', 'trim|required');
		$this->form_validation->set_rules('T006_codigo'	, 'Loja', 'trim|required');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

            //Captura elementos enviados pelo formulário
			$dados = elements(array('DAT_PAG','buscar','T006_codigo'), $this->input->post());			
            
            $this->session->set_userdata(array('filtro_0075_pagamentos'=>$dados));	
            
		endif;
		
        //Cria view
        DV_set_tema('titulo','CC Totais'); 
        DV_set_tema('conteudo', DV_load_modulo('V0075','pagamentos',$dados));
        DV_load_template();                        
        
    }
        
    public function vendas(){
        
        //Validação de Formulário
		$this->form_validation->set_rules('DAT_PAG'         , 'Data'        , 'trim|required');
		$this->form_validation->set_rules('finalizadora'	, 'Finalizadora', 'trim|required');
		$this->form_validation->set_rules('T006_codigo'     , 'Loja'        , 'trim|required');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

            //Captura elementos enviados pelo formulário
			$dados = elements(array('DAT_PAG','finalizadora','buscar','T006_codigo'), $this->input->post());			
            
            $this->session->set_userdata(array('filtro_0075_vendas'=>$dados));	
            
		endif;
		
        //Cria view
        DV_set_tema('titulo','CC Totaiscc'); 
        DV_set_tema('conteudo', DV_load_modulo('V0075','listar',$dados));
        DV_load_template(); 
                       
    }

    
}

/* Final do Arquivo C0004.php
/* Localização: ./application/controllers/C0004.php */
/* Data Criação: 12/08/2013 */