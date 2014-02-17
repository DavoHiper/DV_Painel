<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0139 extends CI_Controller{

    public function __construct(){
        
        parent::__construct();
        DV_init_painel($this->router->class);                           
        
    }    
    
    public function _remap($method){
                                        
        DV_esta_logado();
        
        $this->$method();

    }

    public function index(){
        $this->teste();       
    }
        
    public function teste(){
        
        //Validação de Formulário
        $this->form_validation->set_rules('T006_codigo'	, 'Loja', 'trim|required');
				
        $dados = array();               
        if ($this->form_validation->run()==TRUE){

            //Captura elementos enviados pelo formulário
            $dados = elements(array('T006_codigo'), $this->input->post());			

            $this->session->set_userdata(array('filtroSeguroDesemprego'=>$dados));	

        }
		
        //Cria view
        DV_set_tema('titulo','Seguro Desemprego'); 
        DV_set_tema('conteudo', DV_load_modulo('V0139','listar',$dados));
        DV_load_template();                        
        
    }
    
    public function pagamentos(){
        echo '<div>teste</div>';
    }

}

/* Final do Arquivo C0139.php
/* Localização: ./application/controllers/C0139.php */
/* Data Criação: 07/11/2013 */