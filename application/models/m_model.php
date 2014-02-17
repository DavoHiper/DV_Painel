<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_model extends CI_Model {

    public function get_usuario($dados = NULL) {
        if ($dados != NULL):
            $this->db->where('T004_login', $dados['T004_login']);
            $this->db->limit(1);
            return $this->db->get('T004_usuario');
        endif;
    }

    public function do_insert($tabela = NULL, $dados = NULL, $redir = TRUE, $mensagem = NULL, $trans = FALSE) {
        if ($tabela != NULL && $dados != NULL):
            foreach ($dados as $key => $value):
                if ($value == NULL):
                    $this->db->set($key, NULL);
                    unset($dados[$key]);
                endif;
            endforeach;

            if ($this->db->insert($tabela, $dados)):

                if (!$trans && $mensagem!=''):
                    DV_set_msg('msgok', $mensagem, 'sucesso');
                endif;

                if ($redir):
                    redirect(current_url());
                endif;

                return TRUE;

            else:
                if (!$trans):
                    DV_set_msg('msgerro', $this->db->_error_number() . ' - ' . $this->db->_error_message(), 'erro');
                endif;
                if ($redir):
                    redirect(current_url());
                endif;

                return FALSE;

            endif;

            return FALSE;

        endif;

        return FALSE;
    }

    public function do_update($tabela = NULL, $dados = NULL, $condicao = array(), $redir = TRUE, $trans = FALSE) {

        if ($dados != NULL && is_array($condicao)):
            foreach ($dados as $key => $value):
                if ($value == NULL):
                    $this->db->set($key, NULL);
                    unset($dados[$key]);
                endif;
            endforeach;

            $this->db->where($condicao);
            if ($this->db->update($tabela, $dados)):                
                if ($trans):
                    DV_set_msg('msgok', 'Alteração Efetuada com sucesso', 'sucesso');
                    if ($redir)
                        redirect(current_url());
                    return TRUE;
                endif;

                return TRUE;

            endif;

            return FALSE;

        endif;

        return FALSE;
    }

    public function do_delete($tabela = NULL, $dados = NULL, $redir = TRUE) {

        if ($dados != NULL):

            foreach ($dados as $key => $value):
                if ($value == NULL):
                    $this->db->set($key, NULL);
                    unset($dados[$key]);
                endif;
            endforeach;

            if ($this->db->delete($tabela, $dados)):

                DV_set_msg('msgok', 'Item(s) Excluídos com Sucesso', 'sucesso');

                if ($redir)
                    redirect(current_url());

                return TRUE;

            else:

                DV_set_msg('msgerro', 'Não foi possivel excluir os item(s) selecionado(s)');

                if ($redir)
                    redirect(current_url());

                return FALSE;

            endif;

        endif;

        return FALSE;
    }

    public function DV_menu($user = NULL, $pai = NULL) {

        if (!empty($user)):

            $this->db->distinct();
            $this->db->select(array('T07.T007_codigo', 'T07.T007_nome', 'T07.T007_pai'));
            $this->db->from('T004_T009 T0409');
            $this->db->join('T007_T009 T0709', 'T0409.T009_codigo = T0709.T009_codigo');
            $this->db->join('T007_estrutura T07', 'T0709.T007_codigo = T07.T007_codigo');
            $this->db->where('T0409.T004_login', $user);
            $this->db->where('T07.T007_pai', $pai);
            $this->db->where('T07.T007_extranet', 0);
            $this->db->order_by('T07.T007_codigo', 'ASC');

            return $this->db->get();
        else:
            return FALSE;
        endif;
    }

    public function get_user_by_name($dados = NULL) {
        if ($dados != NULL):
            $this->db->like('T004_nome', $dados['strUsuario']);
            $this->db->or_like('T004_login', $dados['strUsuario']);

            return $this->db->get('T004_usuario');

        endif;
    }

    public function get_name_user($user = NULL) {
        if ($user != NULL):
            $this->db->where('T004_login', $user);

            return $this->db->get('T004_usuario');

        endif;
    }

    public function retornaTituloPrograma($programa) {
        if (!empty($programa)):
            return $this->db->get_where('T007_estrutura', $programa);
        else:
            return FALSE;
        endif;
    }

    public function get_parameter_present($loja = NULL, $parametro = NULL, $dataInicio = NULL) {

        $this->db->from('T089_parametro_detalhe T89')
                ->where('T006_codigo',$loja)
                ->where('T003_codigo',$parametro)
                ->where("T089_dt_inicio <='$dataInicio'",NULL)
                ->order_by('T089_dt_inicio','desc')
                ->limit(1);
        
        return $this->db->get()->row();
    }

    public function get_parameter($parameter = NULL) {

        $this->db->from('T089_parametro_detalhe T89')
                ->where('T003_codigo',$parameter)
                ->limit(1);
        
        return $this->db->get()->row();
    }

    public function retornaDadosCombo($table = NULL, $value = NULL, $label = NULL, $where = NULL) {
        if (!is_null($table) && !is_null($value) && !is_null($label)) {
            $this->db->select("$value, $label");
            if (!is_null($where)) {
                $this->db->where($where);
            }

            return $this->db->get($table);
        }
    }

    public function retornaDadosComboGrpWkf($valorRotulo=NULL, $campoRotulo=NULL, $processo=NULL) {
        if (!is_null($valorRotulo) && !is_null($campoRotulo)) {
            
            $this->db->select("T59.$valorRotulo, T59.$campoRotulo");
            $this->db->from('T060_workflow T60');
            $this->db->join('T059_grupo_workflow T59','T59.T059_codigo = T60.T059_codigo');
            $this->db->where('T60.T060_ordem',3);
            $this->db->where('T60.T061_codigo',$processo);
            $this->db->order_by('T59.T059_codigo');
            
//            echo $this->db->return_query();die;
            
            return $this->db->get();
                        
        }
    }

    public function retornaDadosFornecedor($str = NULL) {
  
        $this->dbora = $this->load->database('oracle', TRUE);

        $this->dbora->where('TIP_CGC_CPF = ', $str);
        $this->dbora->or_where('TIP_CODIGO || TIP_DIGITO = ', $str);
        $this->dbora->from('RMS.AA2CTIPO');

        return $this->dbora->get();
    }  
    
    public function retornaEtapaGrpWkf($grupo_workflow=NULL){
        if(!is_null($grupo_workflow)){
            return $this->db->get_where('T060_workflow', 'T059_codigo ='.$grupo_workflow, 1)->row();
        }
    }
    
    public function retornaProximasEtapas($etapa=NULL){
        if(!is_null($etapa)){ 
            return $this->db->get_where('T060_workflow', 'T060_codigo ='.$etapa, 1)->row();
        }
    }
    
    public function retornaCategoria($codigo=NULL){
        if (!is_null($codigo))
            $this->db->where('T056_codigo',$codigo);
        
        return $this->db->get('T056_categoria_arquivo');
    }
    
    public function retornaExtensoes($nome=NULL){
        
        if(!is_null($nome))
            $this->db->where ('T057_nome',$nome);
        
        return $this->db->get('T057_extensao');                        
    }
            
    public function check_bd_exists($table=NULL, $where=array()){
        
        $this->db->where($where);
        $this->db->from($table);
        
        $query  =   $this->db->get();
        
        if($query->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    public function get_row($table=NULL, $where=array()){
        
        $this->db->where($where);
        $this->db->from($table);

        $query  =   $this->db->get();
        
        if($query->num_rows()>0){
            return $query->row();
        }else{
            return FALSE;
        }
        
    }
    
    public function get_file($file=NULL){
        if(!empty($file)){
            $this->db->where('T055_codigo',$file);
            $this->db->from('T055_arquivos T55');
            $this->db->join('T056_categoria_arquivo T56','T56.T056_codigo = T55.T056_codigo');
            $this->db->join('T057_extensao T57','T57.T057_codigo = T55.T057_codigo');
            
            $query  =   $this->db->get();  
            
            if($query->num_rows>0){
                
                return $query->row();
                
            }else{
                return FALSE;
            }
        }
    }
     
    
}

/* Final do Arquivo m_model.php
/* Localização: ./application/models/m_model.php */
/* Data Criação: 12/08/2013 */