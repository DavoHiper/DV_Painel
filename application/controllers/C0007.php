<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0007 extends CI_Controller{

    public function __construct(){
        
        parent::__construct();
        DV_init_painel($this->router->class);                           
        
    }    
    
    public function _remap($method){
                                        
        DV_esta_logado();
        
        //Limpa variavel de filtro
        $this->session->set_userdata(array('filtro'=>NULL));	          
        
        $this->$method();

    }

    public function index(){
        $this->listar();       
    }
        
    public function listar(){
        
        //Validação de Formulário
		$this->form_validation->set_rules('T057_codigo'	, 'Código'		, 'trim|numeric');
		$this->form_validation->set_rules('T057_nome'	, 'Nome'		, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T057_desc'	, 'Descrição'	, 'trim|alpha_numeric');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

            //Captura elementos enviados pelo formulário
			$dados = elements(array('T057_codigo','T057_nome','T057_desc'), $this->input->post());			
            
            $this->session->set_userdata(array('filtroExtensao'=>$dados));	
            
		endif;
		
        //Cria view
        DV_set_tema('titulo','Extensão'); 
        DV_set_tema('conteudo', DV_load_modulo('V0007','listar',$dados));
        DV_load_template();                        
        
    }

    public function novo(){
        
        $this->form_validation->set_rules('T057_nome'   , 'Nome(*)'        , 'trim|required');
        $this->form_validation->set_rules('T057_desc'   , 'Descrição(*)'   , 'trim|required');
                
        $dados = array();           
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T057_nome','T057_desc'), $this->input->post());  
            
            if($this->msis->do_insert('T057_extensao',$dados,FALSE, "Inserido com sucesso")):
                
                
                echo TRUE;exit(); //Retorno para JS
            endif;
        
        endif;
              
        
        echo DV_load_modulo('V0007','novo',$dados);
    }

    public function editar(){
        
		$idRef = $this->uri->segment(3);
		if ($idRef==NULL):
			DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
			redirect($this->router->class."/listar");
        else:
            $dados  =   $this->M7->get_by_id($idRef)->row();                
		endif;        
                
        $this->form_validation->set_rules('T057_nome'   , 'Nome(*)'        , 'trim|required');
        $this->form_validation->set_rules('T057_desc'   , 'Descrição(*)'   , 'trim|required');
                                        
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T057_nome','T057_desc'), $this->input->post());  
            
            if($this->msis->do_update('T057_extensao',$dados,array('T057_codigo'=>$idRef), FALSE)):
                echo TRUE;exit();
            endif;
            
        endif;
                                                      
        echo DV_load_modulo('V0007','editar',$dados);
    }

    public function excluir(){

        
        $dados  =   $this->input->post();
        
        if(!empty($dados)):
            
            foreach($dados['arrIdRef'] as $key => $value):
                $this->msis->do_delete('T057_extensao',array('T057_codigo'=>$value),FALSE);
            endforeach;
            
        endif;
        
        echo DV_load_modulo('V0007','excluir');
    }

}

/* Final do Arquivo C0007.php
/* Localização: ./application/controllers/C0007.php */
/* Data Criação: 12/08/2013 */