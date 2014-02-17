<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0004 extends CI_Controller{

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
        
    public function listar(){
        
        //Validação de Formulário
		$this->form_validation->set_rules('T007_codigo'	, 'Codigo'		, 'trim|numeric');
		$this->form_validation->set_rules('T007_nome'	, 'Nome'		, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T007_desc'	, 'Descrição'	, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T007_titulo'	, 'Título'		, 'trim|alpha_numeric');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

            //Captura elementos enviados pelo formulário
			$dados = elements(array('T007_codigo','T007_nome','T007_desc','T007_titulo'), $this->input->post());			
            
            $this->session->set_userdata(array('filtroEstrutura'=>$dados));	
            
		endif;
		
        //Cria view
        DV_set_tema('titulo','Programas e Menus'); 
        DV_set_tema('conteudo', DV_load_modulo('V0004','listar',$dados));
        DV_load_template();                        
        
    }

    public function novo(){
        
        $this->form_validation->set_rules('T007_nome'   , 'Nome(*)'        , 'trim|required');
        $this->form_validation->set_rules('T007_desc'   , 'Descrição(*)'   , 'trim|required');
        $this->form_validation->set_rules('T007_titulo' , 'Título(*)'      , 'trim|required');
        $this->form_validation->set_rules('T007_pai'    , 'Pai(*)'         , 'trim');
        $this->form_validation->set_rules('T007_tp'     , 'Tipo(*)'        , 'trim');
        $this->form_validation->set_rules('T007_extranet', 'Extranet(*)'        , 'trim');
                
        $dados = array();                   
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T007_nome','T007_desc','T007_titulo','T007_pai','T007_tp','T007_extranet'), $this->input->post());  
            
            if($this->msis->do_insert('T007_estrutura',$dados,FALSE, "Inserido com sucesso")):                                

                echo '1';//Retorno para JS
                
            endif;
            
        else:
            
        DV_init_dialog();    
        DV_set_tema('conteudo', DV_load_modulo('V0004','novo',$dados));
        DV_load_template();             
            
        endif;
                              
    }

    public function editar(){
        
		$idRef = $this->uri->segment(3);
		if ($idRef==NULL):
			DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
			redirect($this->router->class."/listar");
        else:
            $dados  =   $this->M4->get_by_id($idRef)->row();                
		endif;        
                
        $this->form_validation->set_rules('T007_nome'   , 'Nome(*)'        , 'trim|required');
        $this->form_validation->set_rules('T007_desc'   , 'Descrição(*)'   , 'trim|required');
        $this->form_validation->set_rules('T007_titulo' , 'Título(*)'      , 'trim|required');
        $this->form_validation->set_rules('T007_pai'    , 'Pai(*)'         , 'trim');
        $this->form_validation->set_rules('T007_tp'     , 'Tipo(*)'        , 'trim');
        $this->form_validation->set_rules('T007_extranet', 'Extranet (*)'        , 'trim');
                                        
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T007_nome','T007_desc','T007_titulo','T007_pai','T007_tp','T007_extranet'), $this->input->post());  

            if($this->msis->do_update('T007_estrutura',$dados,array('T007_codigo'=>$idRef), FALSE)):
                echo '1';
            endif;
        else:            
            echo DV_load_modulo('V0004','editar',$dados);
        endif;
                                                      
        
    }

    public function excluir(){
        
        $dados  =   $this->input->post();
        
        if(!empty($dados)):
            
            foreach($dados['arr_data'] as $key => $value):
                $this->msis->do_delete('T007_estrutura',array('T007_codigo'=>$value),FALSE);
            endforeach;
            
            echo '1';
        else:
            echo DV_load_modulo('V0004','excluir');
        endif;
        
        
        
    }

}

/* Final do Arquivo C0004.php
/* Localização: ./application/controllers/C0004.php */
/* Data Criação: 12/08/2013 */