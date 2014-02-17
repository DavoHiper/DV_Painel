<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class C0141 extends CI_Controller {

    public function __construct() {

        parent::__construct();
        DV_init_painel($this->router->class);
    }

    public function _remap($method) {

        DV_esta_logado();

        $this->$method();
    }

    public function index() {
        $this->listar();
    }

    public function listar() {
                      
        
        $dados  =   $this->M141->get_values();
        
        //Cria view
        DV_set_tema('conteudo', DV_load_modulo('V0141', 'listar',$dados));
        DV_load_template();
        
    }
    
    public function salvar_km(){
        
        $dados  = elements(array('T089_dt_inicio','T089_dt_fim','T089_valor'), $this->input->post());
                
        DV_array_associativo($dados, array('T003_codigo'=>7));
        $dados  = DV_format_field_db($dados, array('T089_dt_inicio','T089_dt_fim'), 'datetime');
        $dados  = DV_format_field_db($dados, array('T089_valor'), 'decimal');
        
        $this->msis->do_insert('T089_parametro_detalhe', $dados, FALSE, 'Valor inserido com sucesso!');
        
        redirect('C0141/listar');
        
    }

    public function novo() {
        
        $user   =   $this->session->userdata('user');
                        
        if($this->M26->get_group_user($user)->num_rows > 0){
            
            $this->form_validation->set_rules('T016_cpf'            , 'CPF (*)'             , 'trim|required');
            $this->form_validation->set_rules('T016_dt_lancamento'  , 'Data Lançamento (*)' , 'trim|required');

            $dados = array();
            if ($this->form_validation->run() == TRUE){

                $data_despesa   =   elements(array('T016_cpf','T004_login','T016_status','T016_dt_lancamento','T016_vl_total_km','T016_vl_total_diversos'),$this->input->post());
                
                $data_despesa   =   DV_format_field_db($data_despesa, array('T016_vl_total_km','T016_vl_total_diversos'), 'money');
                $data_despesa   =   DV_format_field_db($data_despesa, array('T016_cpf'), 'cpf');
                $data_despesa   =   DV_format_field_db($data_despesa, array('T016_dt_lancamento'), 'date');
                
                $total_geral    =   $data_despesa['T016_vl_total_km']+$data_despesa['T016_vl_total_diversos'];
                
                DV_array_associativo($data_despesa, array('T016_dt_elaboracao' => date('Y-m-d h:i:s')));
                DV_array_associativo($data_despesa, array('T016_vl_total_geral' => $total_geral));
                
                $this->msis->db->trans_begin();                                
                
                $this->msis->do_insert('T016_despesa', $data_despesa, FALSE, "Inserido com sucesso",TRUE);
                
                $codigo_despesa = $this->msis->db->insert_id();
                                                                                         
                $data_deslocamento      =   elements(array('T015_T016_saida','T015_T016_chegada','T015_T016_desc','T015_T016_origem','T015_T016_destino','T015_T016_km','T006_codigo_origem','T006_codigo_destino'),$this->input->post());
                
                if(!empty($data_deslocamento['T015_T016_saida'])){
                    
                    $linhas =   count($data_deslocamento['T015_T016_saida']);

                    for($i=0;$i<$linhas;$i++){
                        $data   =  array();
                        foreach($data_deslocamento as $key => $value){
                            $data[$key] =   $value[$i];
                        }

                        DV_array_associativo($data, array('T016_codigo' => $codigo_despesa));

                        $data   =  DV_format_field_db($data, array('T015_T016_saida','T015_T016_chegada'), 'datetime');

                        $this->msis->do_insert('T015_T016', $data, FALSE, "Inserido com sucesso",TRUE);

                    }
                }
                                               
                $data_despesa_diversa   =   elements(array('T014_codigo','T017_data','T017_desc','T017_valor'),$this->input->post());

                    if(!empty($data_despesa_diversa['T014_codigo'])){

                    $linhas =   count($data_despesa_diversa['T014_codigo']);

                    for($i=0;$i<$linhas;$i++){
                        $data   =  array();
                        foreach($data_despesa_diversa as $key => $value){
                            $data[$key] =   $value[$i];
                        }

                        DV_array_associativo($data, array('T016_codigo' => $codigo_despesa));

                        $data   =  DV_format_field_db($data, array('T017_data'), 'datetime');
                        $data   =  DV_format_field_db($data, array('T017_valor'), 'money');

                        $this->msis->do_insert('T017_despesa_detalhe', $data, FALSE, "Inserido com sucesso",TRUE);

                    }                     

                }                
                             
                //Inseri Workflow
                $data_workflow = array(
                      'T016_codigo'         => $codigo_despesa
                    , 'T016_T060_ordem'     => 1
                    , 'T016_T060_status'    => '0'
                );                
                
                $codigo_grupo_workflow  =   $this->M26->get_group_workflow_user($user);
                
                DV_cria_workflow($codigo_grupo_workflow, 'T016_T060', $data_workflow);                
                
                if ($this->msis->db->trans_status() === FALSE):
                    DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                    $this->db->trans_rollback();
                else: //senao
                    DV_set_msg('msgok', 'Inserido!', 'sucesso');
                    $this->db->trans_commit();
                    echo '1'; //Retorno para JS
                endif;                    
                
            }else{

                //Cria view
                DV_init_dialog();
                DV_set_tema('conteudo', DV_load_modulo('V0026', 'novo', $dados));
                DV_load_template();

            }            
            
        }else{
            DV_set_msg('msgerro', 'Você não está associado á nenhum grupo Elaborador, favor entrar em contato com o Help Desk!');
            redirect('C0026');
        }
                        
    }

    public function editar() {

        $idRef = $this->uri->segment(3);
        if ($idRef == NULL){
            DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
            redirect($this->router->class . "/listar");
        }else{
            $dados['cabec'] = $this->M26->get_expense($idRef)->row();
            
            $dados['cabec']->T016_dt_lancamento = DV_format_field_vw($dados['cabec'], array('T016_dt_lancamento'), 'date');
            
            $dados['km'] = $this->M26->get_displacement_expenses($idRef);
            $dados['div'] = $this->M26->get_miscellaneous_expenses($idRef);
        }

        $this->form_validation->set_rules('T016_dt_lancamento'  , 'Data Lançamento (*)' , 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $this->msis->db->trans_begin();     
            
            //Limpa Tabelas
            $this->msis->do_delete('T015_T016',array('T016_codigo'=>$idRef),FALSE);
            $this->msis->do_delete('T017_despesa_detalhe',array('T016_codigo'=>$idRef),FALSE);
            
            //Captura dados Header
            $dados  = elements(array('T016_dt_lancamento','T016_vl_total_km','T016_vl_total_diversos','T016_vl_total_geral'),$this->input->post());
            
            $dados  = DV_format_field_db($dados, array('T016_vl_total_km','T016_vl_total_diversos','T016_vl_total_geral'), 'money');
       
            $dados  = DV_format_field_db($dados, array('T016_dt_lancamento'), 'date');
            
                        
            //Atualiza dados Header
            $this->msis->do_update('T016_despesa',$dados,array('T016_codigo'=>$idRef), FALSE, TRUE);

            $data_deslocamento      =   elements(array('T015_T016_saida','T015_T016_chegada','T015_T016_desc','T015_T016_origem','T015_T016_destino','T015_T016_km','T006_codigo_origem','T006_codigo_destino','T015_T016_status','T015_T016_obs_status'),$this->input->post());

            if(!empty($data_deslocamento['T015_T016_saida'])){

                $linhas =   count($data_deslocamento['T015_T016_saida']);

                for($i=0;$i<$linhas;$i++){
                    $data   =  array();
                    foreach($data_deslocamento as $key => $value){
                        $data[$key] =   $value[$i];
                    }

                    DV_array_associativo($data, array('T016_codigo' => $idRef));

                    $data   =  DV_format_field_db($data, array('T015_T016_saida','T015_T016_chegada'), 'datetime');

                    $this->msis->do_insert('T015_T016', $data, FALSE, "Inserido com sucesso",TRUE);

                }
            }

            $data_despesa_diversa   =   elements(array('T014_codigo','T017_data','T017_desc','T017_valor','T017_status','T017_obs_status'),$this->input->post());

                if(!empty($data_despesa_diversa['T014_codigo'])){

                $linhas =   count($data_despesa_diversa['T014_codigo']);

                for($i=0;$i<$linhas;$i++){
                    $data   =  array();
                    foreach($data_despesa_diversa as $key => $value){
                        $data[$key] =   $value[$i];
                    }

                    DV_array_associativo($data, array('T016_codigo' => $idRef));

                    $data   =  DV_format_field_db($data, array('T017_data'), 'datetime');
                    $data   =  DV_format_field_db($data, array('T017_valor'), 'money');

                    $this->msis->do_insert('T017_despesa_detalhe', $data, FALSE, "Inserido com sucesso",TRUE);

                }                     

            }              
            
            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Alterado com sucesso!', 'sucesso');
                $this->db->trans_commit();
                echo '1'; //Retorno para JS
            endif;               
            
        } else {

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'editar', $dados));
            DV_load_template();
        }
    }


}

/* Final do Arquivo C0141.php
/* Localização: ./application/controllers/C0141.php */
/* Data Criação: 06/12/2013 */