<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CGeral extends CI_Controller{

    public function __construct(){
        
        parent::__construct();
        DV_init_painel($this->router->class);                           
        
    }    
    
    public function _remap($method){
                                        
        DV_esta_logado();        
        
        $this->$method();

    }
    
    public function busca_usuario(){
        
        $str_usuario    =   element('data', $this->input->post());
        if (!empty($str_usuario)):

            $match  =   '';
            if (preg_match('#\((.*?)\)#', $str_usuario, $match)):
        
                $usuario    =   $match[1];
                $query  =   $this->msis->get_usuario(array('T004_login'=>$usuario),FALSE);
                
                if ($query->num_rows>0):
                    $usuarios = array();
                    foreach($query->result() as $row):
                        DV_array_associativo($usuarios,array('T004_login'=>$row->T004_login,'T004_nome'=>$row->T004_nome));
                    endforeach;
                
                else:
                
                    echo    '0';
                
                endif;       

            else:
            
                $usuario    =   $str_usuario;
                $query  =   $this->msis->get_usuario(array('T004_login'=>$usuario),FALSE);
                
                if ($query->num_rows>0):
                    $usuarios = array();
                    foreach($query->result() as $row):
                        DV_array_associativo($usuarios,array('T004_login'=>$row->T004_login,'T004_nome'=>$row->T004_nome));
                    endforeach;
                else:
                    echo    0;
                endif;       
            endif;
                                                 
        else:   /*  Para AutoComplete*/
            
            $dados  = elements(array('term'), $this->input->get());  

            $query  =   $this->msis->get_user_by_name(array('strUsuario'=>$dados['term']),FALSE);

            if($query->num_rows>0):
                $usuarios   =   array();
                foreach($query->result() as $row):
                    DV_array_associativo($usuarios,array($row->T004_login=>$row->T004_nome.' ('.$row->T004_login.')'));
                endforeach;

            else:

                DV_array_associativo($usuarios,array('T004_nome'=>'Nenhuma ocorrência encontrada...'));

            endif;
                                                            
        endif;
        
        echo json_encode($usuarios);
        
    }
    
    public function busca_fornecedor(){
        $str_fornecedor    = DV_retira_mascara(element('data', $this->input->post()));
        
        $query  =   $this->msis->retornaDadosFornecedor($str_fornecedor);
               
        foreach($query->result_array() as $data){
            
            $table  =   'T026_fornecedor';
            $where  =   array('T026_rms_cgc_cpf'=>$data['TIP_CGC_CPF']);
            
            if($this->msis->check_bd_exists($table,$where)){
                
                $id =   $this->msis->get_row($table,$where)->T026_codigo;
                
                $data['T026_codigo']    =   $id;
                
                echo json_encode($data);
                
            }else{ 
                
                $dados  =   array(
                    'T026_rms_razao_social'=>$data['TIP_RAZAO_SOCIAL'],
                    'T026_rms_codigo'=>$data['TIP_CODIGO'],
                    'T026_rms_digito'=>$data['TIP_DIGITO'],
                    'T026_rms_cgc_cpf'=>$data['TIP_CGC_CPF'],
                    'T026_rms_insc_est_ident'=>$data['TIP_INSC_EST_IDENT'],
                    'T026_rms_insc_mun'=>$data['TIP_INSC_MUN'],
                );
                
                $this->msis->do_insert('T026_fornecedor',$dados);
                
                $id =   $this->msis->db->insert_id();
                
                $data['T026_codigo']    =   $id;
                
                echo json_encode($data);
                
            }                        
        }        
    }
    
    public function excluirUserList(){
        
        $dados  =   $this->input->post();
        if(!empty($dados)):
            if (is_array($dados)):                            
                $match  =   '';
                if (preg_match('#\((.*?)\)#', $dados['arrSegments'], $match)):
                    $idRef    =   $match[1];    
                    $this->msis->do_delete('T004_T009',array('T004_login'=>$idRef),FALSE);
                else:
                    return FALSE;
                endif;                                    
            endif;
        endif;  
        
    }
    
    public function get_controller(){
        echo $this->router->class;
    }
    
    public function get_method(){
        echo $this->router->method;
    }
    
    public function get_segment($segment=NULL){
        echo $this->uri->segment($segment); 
    } 
    
    public function add_workflow(){
        
        $this->form_validation->set_rules('T059_codigo',    'Grupo Workflow (*)', 'trim|required');
        
        if ($this->form_validation->run() == TRUE):
            
            $dados  = elements(array('T006_codigo','T026_codigo','T059_codigo','T061_codigo'), $this->input->post());
        
            if($this->msis->do_insert('T026_T059',$dados,FALSE)){
                
                $dados  = $this->msis->get_row('T059_grupo_workflow',array('T059_codigo'=>$dados['T059_codigo']));
                
                $retorno  =   array(
                    'T059_codigo'=>$dados->T059_codigo,
                    'T059_nome'=>  DV_formata_codigo_nome($dados->T059_codigo, $dados->T059_nome),
                );
                
                echo json_encode($retorno);
            }else{
                echo '0';
            }
            
        else:
            DV_init_dialog();    
            DV_set_tema('conteudo', DV_load_modulo('VGeral','grupo_workflow'));
            DV_load_template();             
        endif;
                
    }
                
}
    
/* Final do Arquivo CGeral.php
 * Localização: ./application/controllers/CGeral.php 
 * Autor: Rodrigo Alfieri
 * Data Criação: 16/09/2013
 */
 