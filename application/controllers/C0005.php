<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0005 extends CI_Controller{

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
		$this->form_validation->set_rules('T009_codigo'	, 'Codigo'		, 'trim|numeric');
		$this->form_validation->set_rules('T009_nome'	, 'Nome'		, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T009_desc'	, 'Descrição'	, 'trim|alpha_numeric');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

            //Captura elementos enviados pelo formulário
			$dados = elements(array('T009_codigo','T009_nome','T009_desc'), $this->input->post());			
            
            $this->session->set_userdata(array('filtroPerfil'=>$dados));	
            
		endif;
		
        //Cria view
        DV_set_tema('titulo','Programas e Menus'); 
        DV_set_tema('conteudo', DV_load_modulo('V0005','listar',$dados));
        DV_load_template();                        
        
    }

    public function novo(){ 
                
        //Regras validação formulário
        $this->form_validation->set_rules('T009_nome'   , 'Nome (*)'         , 'trim|required');
        $this->form_validation->set_rules('T009_desc'   , 'Descrição (*)'    , 'trim|required');        
        $this->form_validation->set_rules('T004_login[]', 'Usuário (*)'      , 'trim|callback_validation_list');  
        
        //Para campo usuário ao enviar fomrulario com dados na lista, preenche a lista
        $login  =   $this->input->post('T004_login');        
        $dados['T004_login']  =   array();
        if(!empty($login)):            
            foreach($login as $key => $value):
                DV_array_associativo($dados['T004_login'], array($value=>$value));
            endforeach;
        endif;        
        
        //executar validação de formulário       
        if ($this->form_validation->run()==TRUE):
            
            //Captura elemento da Tabela T009_perfil
            $dados = elements(array('T009_nome','T009_desc'), $this->input->post());  
            
            //Inicia Begin Transaction
            $this->msis->db->trans_begin();    
        
            //Faz insert
            $this->msis->do_insert('T009_perfil',$dados,FALSE, '',TRUE);                
            
            //Captura id insert
            $id =   $this->msis->db->insert_id();
            
            //Captura elemento Tabela T004_T009
            $dataUsers  =   element('T004_login',$this->input->post());
            
            //Percorre array T004_T009
            foreach($dataUsers as $key => $row):
                
                $match  =   '';
                //retira nome do usuário dos parenteses ex.: (ralfieri). retorno = ralfieri
                preg_match('#\((.*?)\)#', $row, $match);
            
                //Incrementa array
                $usuarios   =   array();
                DV_array_associativo($usuarios, array('T004_login'=>$match[1],'T009_codigo'=>$id));

//                Executa insert tabela t004_t009
                $this->msis->do_insert('T004_T009',$usuarios,FALSE, '',TRUE);    
            
            endforeach;    
            
            //caso houver algum erro durante as transações do db
            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number().' - '.$this->db->_error_message(), 'erro');  
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Inserido!', 'sucesso');  
                $this->db->trans_commit();
            endif;
            
            //retorno para o js, para dialog fechar
            echo '1';
        else:
            echo DV_load_modulo('V0005','novo',$dados);
        endif;
                
    }

    public function editar(){
        //Valida form
        $this->form_validation->set_rules('T009_nome'   , 'Nome(*)'        , 'trim|required');
        $this->form_validation->set_rules('T009_desc'   , 'Descrição(*)'   , 'trim|required');
        
        //Completa campos
		$idRef = $this->uri->segment(3);
		if ($idRef==NULL):
			DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
			redirect($this->router->class."/listar");
        else:
            $dados  =   $this->M5->get_by_id($idRef)->row();                
		endif;
                                                
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T009_nome','T009_desc'), $this->input->post());  
            
            $this->msis->do_update('T009_perfil',$dados,array('T009_codigo'=>$idRef), FALSE);

            echo '1';
            
        else:
            
            echo DV_load_modulo('V0005','editar',$dados);            
        
        endif;                                                              
    }
    
    public function associar(){
        //Valida form
        $this->form_validation->set_rules('T004_login[]', 'Usuário (*)'    , 'trim|callback_validation_list');    
        
        //Completa campos
		$idRef = $this->uri->segment(3);
		if ($idRef==NULL):
			DV_set_msg('msgerro', 'Escolha um item para associar', 'erro');
			redirect($this->router->class."/listar");
        else:
            $dados  =   $this->M5->get_by_id($idRef)->row();                
		endif;
                        
        $dadosAssociados  =   $this->M5->retornaAssociados($idRef)->result();                                
        $dados->T004_login  =   array();
        foreach($dadosAssociados as $row):
            $str    =   $row->T004_nome.' ('.$row->T004_login.')';
            DV_array_associativo($dados->T004_login,array($str=>$str));
        endforeach;
        
        //Apos post
        $login  =   $this->input->post('T004_login');        
        if(!empty($login)):            
            foreach($login as $key => $value):            
                $match  =   '';
                //retira nome do usuário dos parenteses ex.: (ralfieri). retorno = ralfieri
                if (preg_match_all('/\(([A-Za-z0-9 ]+?)\)/', $value, $match)):
                    if(isset($match[1][1]) && $match[1][1]=='novo'):
                        DV_array_associativo($dados->T004_login,array($value=>$value));
                    endif;                    
                endif;                            
            endforeach;
        endif;           
                                                
        if ($this->form_validation->run()==TRUE):

            //Captura id insert
            $id =   $idRef;
            
            //Captura elemento Tabela T004_T009
            $dataUsers  =   element('T004_login',$this->input->post());
            
            //Percorre array T004_T009
            foreach($dataUsers as $key => $row):
                $match  =   '';
                //retira nome do usuário dos parenteses ex.: (ralfieri). retorno = ralfieri
                if (preg_match_all('/\(([A-Za-z0-9 ]+?)\)/', $row, $match)):
                    
                    
                    if(isset($match[1][1]) && $match[1][1]=='novo'):

                    //Incrementa array
                    $usuarios   =   array();
                    DV_array_associativo($usuarios, array('T004_login'=>$match[1][0],'T009_codigo'=>$id));                        
                    
                    //Executa insert tabela t004_t009
                    $this->msis->do_insert('T004_T009',$usuarios,FALSE, '');                            
                    endif;
                else:                    
                    continue;
                endif;
                       
            endforeach;    
            
            echo '1';
            
        else:
            
            echo DV_load_modulo('V0005','associar',$dados);            
        
        endif;           
    }

    public function excluir(){
        
        $dados  =   $this->input->post();
        
        if(!empty($dados)):
            
            foreach($dados['arrSegments'] as $key => $value):
                $this->msis->do_delete('T009_perfil',array('T009_codigo'=>$value),FALSE);
            endforeach;
            
        endif;
        
        echo DV_load_modulo('V0005','excluir');
    }  
       
    public function validation_list($str){
        
        if(isset($str)):            
            return TRUE;              
        else:                
            $this->form_validation->set_message('validation_list','Você deve associar um %s.');        
            return FALSE;                        
        endif;
        

    }    

    
}
    
/* Final do Arquivo C0005.php
 * Localização: ./application/controllers/C0005.php 
 * Autor: Rodrigo Alfieri
 * Data Criação: 11/09/2013 
 */
 