<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 

class C0026 extends CI_Controller {

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
        $this->form_validation->set_rules('status'              , 'Status (*)'      , 'trim');
        $this->form_validation->set_rules('T016_codigo'         , 'Despesa'         , 'trim|numeric');
        $this->form_validation->set_rules('T016_dt_lancamento'  , 'Data Lançamento' , 'trim');
        $this->form_validation->set_rules('T004_login'          , 'Elaborador'      , 'trim');

        $dados = array();
        if ($this->form_validation->run() == TRUE){

            //Captura elementos enviados pelo formulário
            $dados = elements(array('status'
                , 'T016_codigo'
                , 'T004_login'
                , 'T016_dt_lancamento'
                , 'T060_codigo'
                , 'T016_vl_total_geral'
            ), $this->input->post());

            $this->session->set_userdata(array('filtroDespesa' => $dados));

        }

        //Cria view
        DV_set_tema('conteudo', DV_load_modulo('V0026', 'listar', $dados));
        DV_load_template();
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

    public function despesa_km() {

        $this->form_validation->set_rules('T015_T016_desc', 'Histórico (*)', 'trim|required');
        
        $this->form_validation->set_rules('T015_T016_saida', 'Data/Hora Saída (*)', 'trim|required|less_date[T015_T016_chegada]');        
        $this->form_validation->set_rules('T006_codigo_origem', 'Loja Origem (*)', 'trim|required');                
        if($this->input->post('T006_codigo_origem')==999)
            $this->form_validation->set_rules('T015_T016_origem', 'Externo Origem (*)', 'trim|required');
        
        $this->form_validation->set_rules('T015_T016_chegada', 'Data/Hora Chegada (*)', 'trim|required');        
        $this->form_validation->set_rules('T006_codigo_destino', 'Loja Destino (*)', 'trim|required');        
        if($this->input->post('T006_codigo_destino')==999)
            $this->form_validation->set_rules('T015_T016_destino', 'Externo Destino (*)', 'trim|required');
        
        $this->form_validation->set_rules('T015_T016_km', 'Valor KM (*)', 'trim|required');

        if ($this->form_validation->run() == TRUE){

            echo '1';
            
        }else{

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'despesa_km'));
            DV_load_template();

        }
    }

    public function despesa_div() {

        $this->form_validation->set_rules('T017_data', 'Data (*)', 'trim|required');
        $this->form_validation->set_rules('T014_codigo', 'Conta (*)', 'trim|required');
        $this->form_validation->set_rules('T017_desc', 'Histórico (*)', 'trim|required');
        $this->form_validation->set_rules('T017_valor', 'Valor (*)', 'trim|required');
        
            if ($this->form_validation->run() == TRUE){

            echo '1';
            
        }else{

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'despesa_div'));
            DV_load_template();

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

    public function detalhes() {
        
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

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'detalhes', $dados));
            DV_load_template();
    }

    public function cancelar() {

        $dados = $this->input->post();

        if (!empty($dados['arr_data'])):

            $this->msis->db->trans_begin();

            foreach ($dados['arr_data'] as $key => $value):
                $this->msis->do_update('T016_despesa', array('T016_status' => 4), array('T016_codigo' => $value), FALSE, TRUE);
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
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'cancelar'));
            DV_load_template();

        endif;
    }

    public function aprovar() {
                        
        $dados = $this->input->post();

        if (!empty($dados['arr_data'])){
                               
            $this->msis->db->trans_begin();

            $despesa        =   $dados['arr_data'][0]['expense'];
            $etapa          =   $dados['arr_data'][0]['stage'];

            $data           =   date('Y-m-d H:i:s');

            $user           =   $this->session->userdata('user');

            $remote_addr    =  $_SERVER['REMOTE_ADDR']     ;
            $request_Time   =  $_SERVER['REQUEST_TIME']    ;
            $request_uri    =  $_SERVER['REQUEST_URI']     ;

            $dados  =   array(
                'T016_T060_status'          =>  1,
                'T016_T060_dt_aprovacao'    =>  $data,
                'T004_login'                =>  $user,
                'T016_T060_REMOTE_ADDR'     =>  $remote_addr,
                'T016_T060_REQUEST_TIME'    =>  $request_Time,
                'T016_T060_REQUEST_URI'     =>  $request_uri,
            );

            $this->msis->do_update('T016_T060', $dados, array('T016_codigo' => $despesa,'T060_codigo'=>$etapa), FALSE, TRUE);

            $ultima_etapa   =   $this->M26->get_last_stage($despesa)->T060_codigo;

            if($etapa   ==  $ultima_etapa)
                $status =   9;
            else
                $status =   1;

            $this->msis->do_update('T016_despesa', array('T016_status'=>$status), array('T016_codigo' => $despesa), FALSE, TRUE);

            //caso houver algum erro durante as transações do db
            if ($this->msis->db->trans_status() === FALSE):
                DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                $this->db->trans_rollback();
            else: //senao
                DV_set_msg('msgok', 'Despesa Aprovada!', 'sucesso');
                $this->db->trans_commit();
                echo '1';
            endif;                
                
        }else{

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'aprovar'));
            DV_load_template();

        }
    }
    
    public function revisar($dados = NULL){
                               
        if(!empty($dados)){

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'revisar', $dados));
            DV_load_template();       

        }else{
            
            $idRef = $this->uri->segment(3);
            if ($idRef == NULL){
                DV_set_msg('msgerro', 'Escolha um item para aprovar', 'erro');
                redirect($this->router->class);
            }

            $queryKm    =   $this->M26->check_status_km($idRef);
            $queryDiv   =   $this->M26->check_status_div($idRef);

            $dados['km']    =   $queryKm;
            $dados['div']   =   $queryDiv;            

            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'revisar', $dados));
            DV_load_template();             
        }
        
    }

    //Revisar ou Vetar linha de um deslocamento de uma RD
    public function status_km(){
        
        $post   =   $this->input->post();
        
        if(!empty($post)){
            
            if($this->msis->do_update('T015_T016'
                                     ,array('T015_T016_status'=>$post['status']
                                           ,'T015_T016_obs_status'=>$post['obs'])
                                     ,array('T016_codigo'=>$post['despesa']
                                           ,'T015_T016_seq'=>$post['idRef'])
                                     ,FALSE)){
                echo '1';
            }
                        
        }
        
    }

    //Revisar ou Vetar linha de despesa de uma RD
    public function status_div(){
        
        $post   =   $this->input->post();
        
        if(!empty($post)){
            
            if($this->msis->do_update('T017_despesa_detalhe'
                                      ,array('T017_status'=>$post['status']
                                            ,'T017_obs_status'=>$post['obs'])
                                      ,array('T016_codigo'=>$post['despesa']
                                            ,'T017_seq'=>$post['idRef'])
                                      ,FALSE)){
                echo '1';
            }
                        
        }
        
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

            DV_upload('arquivo', 'T016_T055', 'T016', $idRef, 1);
        }

        DV_init_dialog();
        DV_set_tema('conteudo', DV_load_modulo('V0026', 'upload'));
        DV_load_template();
    }

    public function imprimir() {

        $idRef = $this->uri->segment(3);
                
        if ($idRef == NULL){
            exit('Problemas ao gerar PDF, contate a equipe Web');
        }else{
            $dados['cabec'] = $this->M26->get_expense($idRef)->row();
            
            $dados['cabec']->T016_dt_lancamento = DV_format_field_vw($dados['cabec'], array('T016_dt_lancamento'), 'date');
            
            $dados['km'] = $this->M26->get_displacement_expenses($idRef);
            $dados['div'] = $this->M26->get_miscellaneous_expenses($idRef);
        
            DV_set_tema('conteudo', DV_load_modulo('V0026', 'imprimir', $dados, FALSE));
            DV_load_template();
        }
    }
    
    public function excluir_arquivo() {

        $dados = $this->input->post();

        if (!empty($dados)){

            $this->msis->db->trans_begin();
                    
            foreach($dados as $file){
                
                $path_file =   DV_get_path_file($file);
                
                $this->msis->do_delete('T016_T055',array('T055_codigo'=>$file),FALSE);

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
    
    public function get_cpf(){
        
        $post   =   $this->input->post();
                        
        $arrCpf =   DV_format_field_db($post, array('cpf'), 'cpf');
                        
        $data   =   $this->M26->get_rms_cpf($arrCpf['cpf']);
                        
        if($data){
            
        $query  =   $this->M26->check_exists_cpf($arrCpf['cpf']);
            
            if($query){
                
                $data   = get_object_vars($data);
                
                DV_array_associativo($data,array('retorno'=>1));
                DV_array_associativo($data,array('usuario'=>$query->T004_login));
                DV_array_associativo($data,array('nome'=>$query->T004_nome));
                
                echo json_encode($data);    //retorno js
                
            }else{
                
                $data   = get_object_vars($data);
                
                $user   =   $this->session->userdata('user');
                
                $query  =   $this->msis->get_name_user($user)->row();
                
                DV_array_associativo($data,array('retorno'=>0));
                DV_array_associativo($data,array('cpf'=>  $arrCpf['cpf']));
                DV_array_associativo($data,array('nome'=>  $query->T004_nome));
                
                
                echo json_encode($data);    //retorno js
                
            }
                        
        }else{
            
            DV_array_associativo($data,array('retorno'=>'erro'));

            echo json_encode($data);    //retorno js
        }
            
    }
    
    public function get_displacement(){
        
        $origem =   $this->input->post('origem');
        $destino =   $this->input->post('destino');
        
        echo $this->M26->get_displacement($origem, $destino)->row()->T015_km;
    }
    
    public function confirm_cpf(){
        
        $dados['cpf']   =   $this->input->post('cpf');
        $dados['nome']  =   $this->input->post('nome');
        
        DV_init_dialog();
        DV_set_tema('conteudo', DV_load_modulo('V0026', 'confirm_cpf', $dados));
        DV_load_template();        
    }
    
    public function save_cpf(){
        
        $user   =   $this->session->userdata('user');
        
        $where['T004_login']    =   $user;
        
        $dados['T004_cpf']  =   $this->input->post('cpf');
        
        if($this->msis->do_update('T004_usuario',$dados,$where, FALSE)){
            
            $query  =   $this->msis->get_name_user($user)->row();
            
            DV_array_associativo($dados,array('retorno'=>1));
            DV_array_associativo($dados,array('nome'=>  $query->T004_nome));
            
            echo json_encode($dados);   //retorno js
            
        }else{
            
            DV_array_associativo($dados,array('retorno'=>0));
            
            echo json_encode($dados);   //retorno js
            
        }
        
        
    }

}

/* Final do Arquivo C0026.php
/* Localização: ./application/controllers/C0026.php */
/* Data Criação: 12/11/2013 */