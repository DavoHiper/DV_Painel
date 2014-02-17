<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0029 extends CI_Controller{

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
        $this->form_validation->set_rules('T055_desc'       , 'Descrição'	, 'trim');
        $this->form_validation->set_rules('T077_codigo'     , 'Departamento'	, 'trim');
        $this->form_validation->set_rules('T056_codigo'     , 'Tipo Arquivo'	, 'trim');
        $this->form_validation->set_rules('T004_owner'      , 'Proprietário'	, 'trim');
        $this->form_validation->set_rules('T055_nome'       , 'Nome Arquivo'	, 'trim');
        $this->form_validation->set_rules('T055_dt_inicial' , 'Data Inicial'	, 'trim');
        $this->form_validation->set_rules('T055_dt_final'   , 'Data Final'	, 'trim');
				
        $dados = array();               
        if ($this->form_validation->run()==TRUE){

            //Captura elementos enviados pelo formulário
            $dados = elements(array('T055_desc','T077_codigo','T056_codigo','T004_owner','T055_nome','T055_dt_inicial','T055_dt_final'), $this->input->post());			
            
            $this->session->set_userdata(array('filtroArquivar'=>$dados));	
            
        }
		
        //Cria view
        DV_set_tema('titulo','Arquivar'); 
        DV_set_tema('conteudo', DV_load_modulo('V0029','listar',$dados));
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

/* Final do Arquivo C0029.php
/* Localização: ./application/controllers/C0029.php */
/* Data Criação: 29/10/2013 */