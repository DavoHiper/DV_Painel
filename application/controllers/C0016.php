<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C0016 extends CI_Controller {

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
                        
        //Validação de Formulário
        $this->form_validation->set_rules('status', 'Status (*)', 'trim');
        $this->form_validation->set_rules('T008_codigo', 'AP', 'trim|numeric');
        $this->form_validation->set_rules('T008_nf_numero', 'NF', 'trim|numeric');
        $this->form_validation->set_rules('T026_rms_razao_social', 'Fornecedor (Contém)', 'trim');
        $this->form_validation->set_rules('T026_rms_cgc_cpf', 'CNPJ/CPF', 'trim');

//        $this->form_validation->set_rules('vencto_inicial'          , 'Vencto Inicial'      , 'trim|valid_date');
//        $this->form_validation->set_rules('vencto_final'            , 'Vencto Final'        , 'trim|valid_date');
//        $this->form_validation->set_rules('valor_inicial'           , 'Valor Inicial'       , 'trim');
//        $this->form_validation->set_rules('valor_final'             , 'Valor Final'         , 'trim');

        $dados = array();
        if ($this->form_validation->run() == TRUE):

            //Captura elementos enviados pelo formulário
            $dados = elements(array('status'
                , 'T008_codigo'
                , 'T008_nf_numero'
                , 'T026_rms_razao_social'
                , 'T026_rms_cgc_cpf'
//                                   ,'vencto_inicial'
//                                   ,'vencto_final'
//                                   ,'valor_inicial'
//                                   ,'valor_final'
                    ), $this->input->post());

            $this->session->set_userdata(array('filtroAp' => $dados));

        endif;

        //Cria view
        DV_set_tema('conteudo', DV_load_modulo('V0016', 'listar', $dados));
        DV_load_template();
    }

    public function novo() {

        $this->form_validation->set_rules('T026_rms_cgc_cpf', 'CNPJ (*)', 'trim|required');
        $this->form_validation->set_rules('T026_rms_codigo', 'Código RMS (*)', 'trim|required');
        $this->form_validation->set_rules('T026_rms_razao_social');
        $this->form_validation->set_rules('T026_rms_insc_est_ident');
        $this->form_validation->set_rules('T026_rms_insc_mun');

        $this->form_validation->set_rules('T008_nf_numero');
        $this->form_validation->set_rules('T026_nf_serie');
        $this->form_validation->set_rules('T008_ft_numero');
        $this->form_validation->set_rules('T008_tp_nota');

        $this->form_validation->set_rules('T008_nf_dt_emiss', 'Data Emissão (*)', 'trim|required|valid_date');
        $this->form_validation->set_rules('T008_nf_dt_receb', 'Data Recebimento (*)', 'trim|required|valid_date');
        $this->form_validation->set_rules('T008_nf_dt_vencto', 'Data Vencimento (*)', 'trim|required|valid_date');

        $this->form_validation->set_rules('T008_nf_valor_bruto', 'Valor (*)', 'trim|required');
        $this->form_validation->set_rules('T008_forma_pagto');
        $this->form_validation->set_rules('T006_codigo', 'Loja (*)', 'trim|required');
        $this->form_validation->set_rules('T008_num_contrato');
        $this->form_validation->set_rules('T008_tp_despesa');
        $this->form_validation->set_rules('T059_codigo', 'Grupo Workflow (*)', 'trim|required');
        $this->form_validation->set_rules('T120_codigo');

        $this->form_validation->set_rules('T008_desc');
        $this->form_validation->set_rules('T008_justificativa');
        $this->form_validation->set_rules('T008_inst_controladoria');
        $this->form_validation->set_rules('T008_dados_controladoria');

        $dados = array();
        if ($this->form_validation->run() == TRUE):

            //Insere fornecedor caso não exista
            $dados_fornecedor = elements(array('T026_rms_cgc_cpf', 'T026_rms_codigo', 'T026_rms_razao_social', 'T026_rms_insc_est_ident', 'T026_rms_insc_mun'), $this->input->post());

            //Inicia Begin Transaction
            $query = $this->M16->retorna_fornecedor($dados_fornecedor['T026_rms_codigo']);

            if ($query->num_rows() == 0) {
                $this->msis->do_insert('T026_fornecedor', $dados_fornecedor, FALSE, 'Fornecedor incluído na tabela da intranet', TRUE);
                $codigo_fornecedor = $this->msis->db->insert_id();
            } else {
                foreach ($query->result() as $row) {
                    $codigo_fornecedor = $row->T026_codigo;
                }
            }

            $user = $this->session->userdata('user');

            $dados = elements(array('T008_nf_numero'
                , 'T026_nf_serie'
                , 'T008_ft_numero'
                , 'T008_nf_dt_emiss'
                , 'T008_nf_dt_receb'
                , 'T008_nf_dt_vencto'
                , 'T008_forma_pagto'
                , 'T008_nf_valor_bruto'
                , 'T008_num_contrato'
                , 'T008_tp_nota'
                , 'T008_tp_despesa'
                , 'T008_desc'
                , 'T008_justificativa'
                , 'T008_inst_controladoria'
                , 'T008_dados_controladoria'
                , 'T120_codigo'
                    ), $this->input->post());

            $loja = element('T006_codigo', $this->input->post());
            $codigo_grupo_workflow = element('T059_codigo', $this->input->post());

            $hoje = date('Y-m-d H:i:s');

            DV_array_associativo($dados, array('T004_login' => $user));
            DV_array_associativo($dados, array('T026_codigo' => $codigo_fornecedor));
            DV_array_associativo($dados, array('T008_status' => '0'));
            DV_array_associativo($dados, array('T008_dt_elaboracao' => $hoje));
            DV_array_associativo($dados, array('T008_T026T059_T026_codigo' => $codigo_fornecedor));
            DV_array_associativo($dados, array('T008_T026T059_T061_codigo' => 1));
            DV_array_associativo($dados, array('T008_T026T059_T059_codigo' => $codigo_grupo_workflow));
            DV_array_associativo($dados, array('T008_T026T059_T006_codigo' => $loja));

            $dados = DV_format_field_db($dados, array('T008_nf_dt_emiss', 'T008_nf_dt_receb', 'T008_nf_dt_vencto'), 'date');
            $dados = DV_format_field_db($dados, array('T008_nf_valor_bruto'), 'decimal');

            $this->msis->db->trans_begin();

            $this->msis->do_insert('T008_approval', $dados, FALSE, "Inserido com sucesso");

            $codigo_ap = $this->msis->db->insert_id();           
                        
            $data = array(
                  'T008_codigo'         => $codigo_ap
                , 'T008_T060_status'    => '0'
                , 'T004_login'          => $user
            );

            $this->DV_cria_workflow_ap($codigo_grupo_workflow, 'T008_T060', $data);

            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Inserido!', 'sucesso');
                $this->db->trans_commit();
                echo '1'; //Retorno para JS
            endif;

        else:

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0016', 'novo', $dados));
            DV_load_template();

        endif;
    }

    public function editar() {

        $idRef = $this->uri->segment(3);
        if ($idRef == NULL):
            DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
            redirect($this->router->class . "/listar");
        else:
            $dados = $this->M16->retorna_ap($idRef)->row();                
        endif;

        $this->form_validation->set_rules('T026_rms_codigo');
        $this->form_validation->set_rules('T026_rms_razao_social');
        $this->form_validation->set_rules('T026_rms_insc_est_ident');
        $this->form_validation->set_rules('T026_rms_insc_mun');

        $this->form_validation->set_rules('T008_nf_numero');
        $this->form_validation->set_rules('T026_nf_serie');
        $this->form_validation->set_rules('T008_ft_numero');
        $this->form_validation->set_rules('T008_tp_nota');

        $this->form_validation->set_rules('T008_nf_dt_emiss', 'Data Emissão (*)', 'trim|required|valid_date');
        $this->form_validation->set_rules('T008_nf_dt_receb', 'Data Recebimento (*)', 'trim|required|valid_date');
        $this->form_validation->set_rules('T008_nf_dt_vencto', 'Data Vencimento (*)', 'trim|required|valid_date');

        $this->form_validation->set_rules('T008_nf_valor_bruto', 'Valor (*)', 'trim|required');
        $this->form_validation->set_rules('T008_forma_pagto');
        $this->form_validation->set_rules('T006_codigo');
        $this->form_validation->set_rules('T008_num_contrato');
        $this->form_validation->set_rules('T008_tp_despesa');
        $this->form_validation->set_rules('T059_codigo');
        $this->form_validation->set_rules('T120_codigo');

        $this->form_validation->set_rules('T008_desc');
        $this->form_validation->set_rules('T008_justificativa');
        $this->form_validation->set_rules('T008_inst_controladoria');
        $this->form_validation->set_rules('T008_dados_controladoria');

        if ($this->form_validation->run() == TRUE) {

            $dados = elements(array('T008_nf_numero'
                , 'T026_nf_serie'
                , 'T008_ft_numero'
                , 'T008_nf_dt_emiss'
                , 'T008_nf_dt_receb'
                , 'T008_nf_dt_vencto'
                , 'T008_nf_valor_bruto'
                , 'T008_forma_pagto'
                , 'T008_num_contrato'
                , 'T008_tp_nota'
                , 'T008_tp_despesa'
                , 'T008_desc'
                , 'T008_justificativa'
                , 'T008_inst_controladoria'
                , 'T008_dados_controladoria'
                , 'T120_codigo'
                    ), $this->input->post());

            $dados = DV_format_field_db($dados, array('T008_nf_dt_emiss', 'T008_nf_dt_receb', 'T008_nf_dt_vencto'), 'date');
            $dados = DV_format_field_db($dados, array('T008_nf_valor_bruto'), 'decimal');

            if ($this->msis->do_update('T008_approval', $dados, array('T008_codigo' => $idRef))) {
                echo '1';
            }
        } else {

            $dados = DV_format_field_vw($dados, array('T008_nf_dt_emiss', 'T008_nf_dt_receb', 'T008_nf_dt_vencto'),'date');
            $dados = DV_format_field_vw($dados, array('T008_nf_valor_bruto'),'decimal');

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0016', 'editar', $dados));
            DV_load_template();
        }
    }

    public function detalhes() {

        $idRef = $this->uri->segment(3);
        if ($idRef == NULL):
            DV_set_msg('msgerro', 'Escolha um item para editar', 'erro');
            redirect($this->router->class . "/listar");
        else:
            $dados = $this->M16->retorna_ap($idRef)->row();
        endif;
        
        $this->form_validation->set_rules('T026_rms_cgc_cpf');
        $this->form_validation->set_rules('T026_rms_codigo');
        $this->form_validation->set_rules('T026_rms_razao_social');
        $this->form_validation->set_rules('T026_rms_insc_est_ident');
        $this->form_validation->set_rules('T026_rms_insc_mun');

        $this->form_validation->set_rules('T008_nf_numero');
        $this->form_validation->set_rules('T026_nf_serie');
        $this->form_validation->set_rules('T008_ft_numero');
        $this->form_validation->set_rules('T008_tp_nota');

        $this->form_validation->set_rules('T008_nf_dt_emiss');
        $this->form_validation->set_rules('T008_nf_dt_receb');
        $this->form_validation->set_rules('T008_nf_dt_vencto');

        $this->form_validation->set_rules('T008_nf_valor_bruto');
        $this->form_validation->set_rules('T008_forma_pagto');
        $this->form_validation->set_rules('T006_codigo');
        $this->form_validation->set_rules('T008_num_contrato');
        $this->form_validation->set_rules('T008_tp_despesa');
        $this->form_validation->set_rules('T059_codigo');
        $this->form_validation->set_rules('T120_codigo');

        $this->form_validation->set_rules('T008_desc');
        $this->form_validation->set_rules('T008_justificativa');
        $this->form_validation->set_rules('T008_inst_controladoria');
        $this->form_validation->set_rules('T008_dados_controladoria');

        $dados = DV_format_field_vw($dados, array('T008_nf_dt_emiss', 'T008_nf_dt_receb', 'T008_nf_dt_vencto'), 'date');

        //Cria view
        DV_init_dialog();
        DV_set_tema('conteudo', DV_load_modulo('V0016', 'detalhes', $dados));
        DV_load_template();
        
    }

    public function cancelar() {

        $dados = $this->input->post();

        if (!empty($dados['arr_data'])):

            $this->msis->db->trans_begin();

            foreach ($dados['arr_data'] as $key => $value):
                $this->msis->do_update('T008_approval', array('T008_status' => 4), array('T008_codigo' => $value), FALSE, TRUE);
            endforeach;

            //caso houver algum erro durante as transações do db
            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Itens Cancelados!', 'sucesso');
                $this->db->trans_commit();
                echo '1';
            endif;

        else:

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0016', 'cancelar'));
            DV_load_template();

        endif;
    }

    public function transferir() {

        $dados = $this->input->post();

        if (!empty($dados['arr_data'])):

            $this->msis->db->trans_begin();

            foreach ($dados['arr_data'] as $key => $value):

                $codigo_grupo_workflow = $dados['T059_codigo'];

                $this->msis->do_delete('T008_T060', array('T008_codigo' => $value), FALSE);
                
                $user = $this->session->userdata('user');
                
                $data = array(
                      'T008_codigo'         => $value
                    , 'T008_T060_status'    => '0'
                    , 'T004_login'          => $user
                );                

                $this->DV_cria_workflow_ap($codigo_grupo_workflow, 'T008_T060', $data);

            endforeach;

            //caso houver algum erro durante as transações do db
            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Aps Transferidas!', 'sucesso');
                $this->db->trans_commit();
                echo '1';
            endif;

        else:

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0016', 'transferir'));
            DV_load_template();

        endif;
    }

    public function aprovar() {

        $dados = $this->input->post();

        if (!empty($dados['arr_data'])):
            
            $this->msis->db->trans_begin();

            foreach ($dados['arr_data'] as $key => $value):

                $ap             =   $value['ap'];
                $etapa          =   $value['etapa'];
                $tpnota         =   $value['tpnota'];

                $data           =   date('Y-m-d H:i:s');

                $user           =   $this->session->userdata('user');
                
                $remote_addr    =  $_SERVER['REMOTE_ADDR']     ;
                $request_Time   =  $_SERVER['REQUEST_TIME']    ;
                $request_uri    =  $_SERVER['REQUEST_URI']     ;
                
                $dados  =   array(
                    'T008_T060_status'          =>  1,
                    'T008_T060_dt_aprovacao'    =>  $data,
                    'T004_login'                =>  $user,
                    'T008_T060_REMOTE_ADDR'     =>  $remote_addr,
                    'T008_T060_REQUEST_TIME'    =>  $request_Time,
                    'T008_T060_REQUEST_URI'     =>  $request_uri,
                );
                
                $this->msis->do_update('T008_T060', $dados, array('T008_codigo' => $ap,'T060_codigo'=>$etapa), FALSE, TRUE);
                
                $prox_etapa =   $this->M16->get_approval_last($ap)->T060_codigo;
                
                if($tpnota==2 && $prox_etapa==3){
                    
                    $dados['T008_T060_REQUEST_URI'] =   '[Aprovado Automaticamente] - '.$request_uri;
                    
                    $this->msis->do_update('T008_T060', $dados, array('T008_codigo' => $ap,'T060_codigo'=>$prox_etapa), FALSE, TRUE);
                    
                }
                
                $ultima_etapa   =   $this->M16->get_last_stage($ap)->T060_codigo;
                
                if($etapa   ==  $ultima_etapa)
                    $status =   9;
                else
                    $status =   1;
                
                $this->msis->do_update('T008_approval', array('T008_status'=>$status), array('T008_codigo' => $ap), FALSE, TRUE);

            endforeach;

            //caso houver algum erro durante as transações do db
            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Aps Aprovadas!', 'sucesso');
                $this->db->trans_commit();
                echo '1';
            endif;

        else:

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0016', 'aprovar'));
            DV_load_template();

        endif;
    }

    public function fluxo() {

        $idRef = $this->uri->segment(3);

        $dados = $this->M16->get_flux($idRef);

        DV_init_dialog();
        DV_set_tema('conteudo', DV_load_modulo('V0016', 'fluxo', $dados));
        DV_load_template();
    }

    public function upload() {

        $idRef = $this->uri->segment(3);

        $this->form_validation->set_rules('T056_codigo', 'Tipo de Arquivo (*)', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            DV_upload('arquivo', 'T008_T055', 'T008', $idRef, 1);
        }

        DV_init_dialog();
        DV_set_tema('conteudo', DV_load_modulo('V0016', 'upload'));
        DV_load_template();
    }

    public function combo_workflow() {

        $cnpj = DV_retira_mascara(element('cnpj', $this->input->post()));
        $loja = element('loja', $this->input->post());

        $query = $this->M16->retorna_dados_cmb_wkf($cnpj, $loja);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[DV_format_digits($row->T059_codigo)] = $row->T059_nome;
            }
        } else {
            $data[''] = 'Fornecedor sem Grupo de Workflow';
        }
        echo json_encode($data);
    }

    public function combo_categoria_fornecedor() {

        $cnpj = DV_retira_mascara(element('cnpj', $this->input->post()));

        $query = $this->M16->retorna_dados_cat_forn($cnpj);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[DV_format_digits($row->T120_codigo)] = $row->T120_nome;
            }
        } else {
            $data[''] = 'Fornecedor sem categoria';
        }

        echo json_encode($data);
    }

    public function imprimir() {

        $idRef = $this->uri->segment(3);

        $query = $this->M16->retorna_ap($idRef);

        if ($query->num_rows > 0) {
            $dados = $query->row();

            $dados = DV_format_field_vw($dados, array('T008_nf_dt_emiss', 'T008_nf_dt_receb', 'T008_nf_dt_vencto'), 'date');
            $dados = DV_format_field_vw($dados, array('T026_rms_cgc_cpf'), 'cnpj');
            $dados = DV_format_field_vw($dados, array('T008_nf_valor_bruto'), 'decimal');

            DV_set_tema('conteudo', DV_load_modulo('V0016', 'imprimir', $dados, FALSE));
            DV_load_template();
        } else {
            exit('Problemas ao gerar PDF, contate a equipe Web');
        }
    }
    
    public function excluir_arquivo() {

        $dados = $this->input->post();

        if (!empty($dados)){

            $this->msis->db->trans_begin();
                    
            foreach($dados as $file){
                
                $path_file =   DV_get_path_file($file);
                
                $this->msis->do_delete('T008_T055',array('T055_codigo'=>$file),FALSE);

                $this->msis->do_delete('T055_arquivos',array('T055_codigo'=>$file),FALSE);                
                
            }
            
            //caso houver algum erro durante as transações do db
            if ($this->msis->db->trans_status() === FALSE){
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            }else{ //senao
                DV_set_msg('msgok', 'Arquivo Excluído!', 'sucesso');
                $this->db->trans_commit();                                
            
                unlink($path_file);
                
                echo '1';

            }
        }else{

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0016', 'excluir_arquivo'));
            DV_load_template();

        }
    }
    
    public function DV_cria_workflow_ap($grupo_workflow = NULL, $table = NULL, $data = array(), $id = NULL) {
       
        $data['T060_codigo']    =   3;
        $data[$table.'_ordem']  =   1;
        
        $this->msis->do_insert($table, $data, FALSE);
        
        $data['T060_codigo']    =   2;
        $data[$table.'_ordem']  =   2;
        
        $this->msis->do_insert($table, $data, FALSE);            
                
        //Retorna Etapa do Grupo
        $etapa = $this->msis->retornaEtapaGrpWkf($grupo_workflow);       
                           
        function cria_fluxo($table, $data = array(), $id = NULL, $etapa = NULL, $ordem = 3) {
                        
            $CI = & get_instance();
            
            if (!is_null($etapa)) {
                               
                $data['T060_codigo'] = $etapa->T060_codigo;
                                
                $data[$table . "_ordem"] = $ordem;

                $CI->msis->do_insert($table, $data, FALSE);                                
                
                $etapa = $CI->msis->retornaProximasEtapas($etapa->T060_proxima_etapa);
                
                cria_fluxo($table, $data, $id, $etapa, $ordem + 1); 
            }

            return TRUE;
        }
                
        cria_fluxo($table, $data, $id, $etapa);
    }

}

/* Final do Arquivo C0016.php
/* Localização: ./application/controllers/C0016.php */
/* Data Criação: 12/08/2013 */