<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0059 extends CI_Controller{

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
		$this->form_validation->set_rules('T003_codigo'	, 'Codigo'		, 'trim|numeric');
		$this->form_validation->set_rules('T003_nome'	, 'Nome'		, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T003_desc'	, 'Descrição'	, 'trim|alpha_numeric');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

            //Captura elementos enviados pelo formulário
			$dados = elements(array('T003_codigo','T003_nome','T003_desc'), $this->input->post());			
            
            $this->session->set_userdata(array('filtroParametro'=>$dados));	
            
		endif;
		
        //Cria view
        DV_set_tema('conteudo', DV_load_modulo('V0059','listar',$dados));
        DV_load_template();                        
        
    }

    public function novo(){
        
        $this->form_validation->set_rules('T003_nome'       , 'Nome (*)'         , 'trim|required');
        $this->form_validation->set_rules('T003_desc'       , 'Descrição (*)'    , 'trim|required');
        $this->form_validation->set_rules('T002_codigo'     , 'Datatype (*)'     , 'trim|required');
                
        $dados = array();                   
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T003_nome','T003_desc','T002_codigo'), $this->input->post());  
        
            //Faz insert
            $this->msis->do_insert('T003_parametros',$dados,FALSE, '',TRUE);                
            
            echo '1';
            
        else:            
            
            echo DV_load_modulo('V0059','novo',$dados);
        
        endif;
                              
    }

    public function editar(){
        
        $idRef = $this->uri->segment(3);
        if ($idRef == NULL):
            DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
            redirect($this->router->class . "/listar");
        else:
            $dados = $this->M59->get_by_id($idRef)->row();
        endif;

        $this->form_validation->set_rules('T003_nome'       , 'Nome(*)'         , 'trim|required');
        $this->form_validation->set_rules('T003_desc'       , 'Descrição(*)'    , 'trim|required');
                                        
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T003_nome','T003_desc'), $this->input->post());  
        
            $this->msis->do_update('T003_parametros',$dados,array('T003_codigo'=>$idRef),FALSE);                

            echo '1';
            
        else:            
            
            echo DV_load_modulo('V0059','editar',$dados);
        
        endif;
                                                      
        
    }

    public function excluir(){
        
        $dados  =   $this->input->post();
        
        if(!empty($dados)):
            
            foreach($dados['arrSegments'] as $key => $value):
                $this->msis->do_delete('T007_estrutura',array('T007_codigo'=>$value),FALSE);
            endforeach;
            
        endif;
        
        echo DV_load_modulo('V0059','excluir');
        
    }

    public function atribuir(){

        $idRef = $this->uri->segment(3);
        if ($idRef == NULL):
            DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
            redirect($this->router->class . "/listar");
        else:
            $dados = $this->M59->retornaValoresParametro($idRef)->row();
        endif;

        $this->form_validation->set_rules('T006_codigo'     , 'Loja (*)' , 'trim|required');
        $this->form_validation->set_rules('T089_dt_inicio'  , 'Datatype' , 'trim|valid_date');
        $this->form_validation->set_rules('T089_dt_fim'     , 'Data Fim' , 'trim|valid_date');
        $this->form_validation->set_rules('T089_valor'      , 'Valor (*)', 'trim|required');
                                        
        if ($this->form_validation->run()==TRUE):

            $dados  =   elements(array('T003_codigo','T006_codigo','T089_dt_inicio','T089_dt_fim','T089_valor'),$this->input->post());                            
        
            $dados  =   DV_format_field_db($dados,array('T089_dt_inicio','T089_dt_fim'),'datetime');
        
            $this->msis->do_insert('T089_parametro_detalhe',$dados,FALSE);    
            
            echo '1';
        else:  
            
            echo DV_load_modulo('V0059','atribuir',$dados);
        
        endif;
        
    }

}

/* Final do Arquivo C0059.php
/* Localização: ./application/controllers/C0059.php */
/* Data Criação: 12/08/2013 */