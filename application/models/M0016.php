<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0016 extends CI_Model{
     
    public function retornaAguardandoAprovacao($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){
        
        $user   =   $this->session->userdata('user');
        
        $this->db->select('T008_codigo')
                 ->select_min('T008_T060_ordem')
                 ->from('T008_T060 T0860')
                 ->where('T008_T060_dt_aprovacao IS NULL',NULL)
                 ->where('T008_T060_status','0')                 
                 ->group_by('T008_codigo');

        $subquery = $this->db->_compile_select();

        $this->db->_reset_select(); 

        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T60.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from('T008_T060 T0860')
                 ->from('T004_T059 T0459')

                 ->join("($subquery)  SE1","SE1.T008_codigo = T0860.T008_codigo AND SE1.T008_T060_ordem = T0860.T008_T060_ordem")

                 ->join('T060_workflow   T60'    ,'T60.T059_codigo  =  T0459.T059_codigo')
                 ->join('T008_approval   T08'    ,'T08.T008_codigo  =  T0860.T008_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where('T0860.T060_codigo = T60.T060_codigo',NULL)
                 ->where_in('T08.T008_status',array(0,1))
                 ->where('T08.T008_T026T059_T059_codigo IS NOT NULL',NULL)
                 ->where('T0459.T004_login', $user);
                
                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function retornaMinhasDigitadas($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL, $count=FALSE){

        $user   =   $this->session->userdata('user');       

        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T60.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from('T008_approval T08')
                 ->from('T004_T059 T0459')

                 ->join('T060_workflow   T60'    ,'T60.T059_codigo  =  T0459.T059_codigo')
                 ->join('T026_fornecedor T26'   ,'T26.T026_codigo   =  T08.T026_codigo')
                 ->join('T006_loja T06'         ,'T06.T006_codigo   =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'      ,'T08.T004_login    =  T04.T004_login')
                
                 ->where('T08.T008_status','0')
                 ->where('T08.T004_login',$user)
                 ->where('T08.T008_T026T059_T059_codigo IS NOT NULL',NULL)
                 ->where('T08.T008_status <> 4',NULL);

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);        
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;

        return $this->db->get();
    }
     
    public function retornaAnteriores($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->select('T008_codigo')
                 ->select_max('T008_T060_ordem')
                 ->from('T008_T060')
                 ->where('T008_T060_ordem IS NOT NULL',NULL)
                 ->where('T008_T060_dt_aprovacao IS NULL',NULL)
                 ->group_by('T008_codigo');

        $subquery1 = $this->db->_compile_select();

        $this->db->_reset_select();
        
        $this->db->select('T0860.T008_codigo')
                 ->select_max('T0860.T008_T060_ordem')
                 ->from('T008_T060 T0860')
                 ->from('T004_T059 T0459')
                 ->join("($subquery1) SE1",'SE1.T008_codigo  = T0860.T008_codigo')
                 ->join('T060_workflow T60','T60.T059_codigo  =  T0459.T059_codigo')
                 ->where('T0860.T060_codigo  = T60.T060_codigo',NULL)
                 ->where('T0860.T008_T060_dt_aprovacao IS NULL',NULL)
                 ->where('T0459.T004_login',$user)
                 ->group_by('T0860.T008_codigo');
        
        $subquery   =   $this->db->_compile_select();
        
        $this->db->_reset_select();

        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T0860_2.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from("($subquery) SE2")
                 ->join('T008_T060 T0860_2'    ,'T0860_2.T008_codigo     = SE2.T008_codigo AND T0860_2.T008_T060_ordem < SE2.T008_T060_ordem')
                 ->join('T008_approval   T08'    ,'T08.T008_codigo  =  T0860_2.T008_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where('T08.T008_T026T059_T059_codigo IS NOT NULL ',NULL)
                 ->where_in('T08.T008_status',array(0,1))
                 ->where('T0860_2.T008_T060_dt_aprovacao IS NULL',NULL);

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);   
                
                $this->db->group_by('T08.T008_codigo');
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
//        echo $this->db->return_query();die;
        
        return $this->db->get();                       
                       
    } 
     
    public function retornaPosteriores($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->select('T008_codigo')
                 ->select_max('T008_T060_ordem')
                 ->from('T008_T060')
                 ->where('T008_T060_ordem IS NOT NULL',NULL)
                 ->group_by('T008_codigo');

        $subquery1 = $this->db->_compile_select();

        $this->db->_reset_select();
        
        $this->db->select('T0860.T008_codigo')
                 ->select_max('T0860.T008_T060_ordem')
                 ->from('T008_T060 T0860')
                 ->from('T004_T059 T0459')
                 ->join("($subquery1) SE1",'SE1.T008_codigo  = T0860.T008_codigo')
                 ->join('T060_workflow T60','T60.T059_codigo  =  T0459.T059_codigo')
                 ->where('T0860.T060_codigo  = T60.T060_codigo',NULL)
                 ->where('T0860.T008_T060_dt_aprovacao IS NOT NULL',NULL)
                 ->where("T0459.T004_login",$user)
                 ->group_by('T0860.T008_codigo');
        
        $subquery   =   $this->db->_compile_select();
        
        $this->db->_reset_select();

        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T0860_2.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from("($subquery) SE2")
                 ->join('T008_T060 T0860_2'    ,'T0860_2.T008_codigo     = SE2.T008_codigo AND T0860_2.T008_T060_ordem > SE2.T008_T060_ordem')
                 ->join('T008_approval   T08'    ,'T08.T008_codigo  =  T0860_2.T008_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where('T08.T008_T026T059_T059_codigo IS NOT NULL ',NULL)
                 ->where('T08.T008_status',1)
                 ->group_by('T08.T008_codigo');

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);        
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function retornaFinalizadas($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T60.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from('T008_approval T08')
                 ->from('T004_T059 T0459')
                 ->join('T008_T060 T0860'    ,'T0860.T008_codigo = T08.T008_codigo')
                 ->join('T060_workflow T60'    ,'T60.T059_codigo    =  T0459.T059_codigo AND T0860.T060_codigo  =  T60.T060_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where_in('T08.T008_status',9)
                 ->where("T0459.T004_login = '$user'");

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);        
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function retornaCanceladas($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T60.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from('T008_approval T08')
                 ->from('T004_T059 T0459')
                 ->join('T008_T060 T0860'    ,'T0860.T008_codigo = T08.T008_codigo')
                 ->join('T060_workflow T60'    ,'T60.T059_codigo    =  T0459.T059_codigo AND T0860.T060_codigo  =  T60.T060_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where_in('T08.T008_status',4)
                 ->where("T0459.T004_login = '$user'");

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);        
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function retornaForaPrazo($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T60.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from('T008_approval T08')
                 ->from('T004_T059 T0459')
                 ->join('T008_T060 T0860'    ,'T0860.T008_codigo = T08.T008_codigo')
                 ->join('T060_workflow T60'    ,'T60.T059_codigo    =  T0459.T059_codigo AND T0860.T060_codigo  =  T60.T060_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where_in('T08.T008_status',4)
                 ->where("T0459.T004_login = '$user'");

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);        
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function retornaTodos($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->distinct()
                 ->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T60.T060_codigo
                         , fnDV_QtDiasAp(T08.T008_codigo) QtDias')
                 ->from('T008_approval T08')
                 ->from('T004_T059 T0459')
                 ->join('T008_T060 T0860'    ,'T0860.T008_codigo = T08.T008_codigo')
                 ->join('T060_workflow T60'    ,'T60.T059_codigo    =  T0459.T059_codigo AND T0860.T060_codigo  =  T60.T060_codigo')
                 ->join('T026_fornecedor T26'    ,'T26.T026_codigo  =  T08.T026_codigo')
                 ->join('T006_loja       T06'    ,'T06.T006_codigo  =  T08.T008_T026T059_T006_codigo')
                 ->join('T004_usuario T04'       ,'T08.T004_login    =  T04.T004_login')
                 ->where('T0459.T004_login',$user)
                 ->where('T08.T008_T026T059_T059_codigo IS NOT NULL',NULL)
                 ->where('T0860.T060_codigo  = T60.T060_codigo',NULL);

                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
        
                if(strlen($dados['T008_codigo'])>0)
                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
                
                if(strlen($dados['T008_nf_numero'])>0)
                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
                
                if(strlen($dados['T026_rms_razao_social'])>0)
                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
                
                if(strlen($dados['T026_rms_cgc_cpf'])>0)
                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);        
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    } 
    
    public function retorna_dados_cmb_wkf($cnpj=NULL, $loja=NULL){
        
        if(!is_null($cnpj) && !is_null($loja)){
            
            $row_forn  =   $this->db->get_where('T026_fornecedor', 'T026_rms_cgc_cpf ='.$cnpj, 1)->row();
                                    
            $this->db->from('T026_T059 T2659');
            $this->db->join('T026_fornecedor T26','T26.T026_codigo = T2659.T026_codigo');
            $this->db->join('T059_grupo_workflow T59','T2659.T059_codigo = T59.T059_codigo');
            $this->db->where('T2659.T026_codigo',$row_forn->T026_codigo);
            $this->db->where('T2659.T006_codigo',$loja);
            
            return $this->db->get();
        }
        
    }
    
    public function retorna_dados_cat_forn($cnpj=NULL){
        
        if(!is_null($cnpj)){
            
            $row_forn  =   $this->db->get_where('T026_fornecedor', 'T026_rms_cgc_cpf ='.$cnpj, 1)->row();
                                    
            $this->db->from('T120_fornecedor_categoria T120');
            $this->db->join('T026_fornecedor T26','T120.T026_codigo = T26.T026_codigo');
            $this->db->where('T26.T026_codigo',$row_forn->T026_codigo);

            return $this->db->get();
        }
        
    }
    
    public function retorna_fornecedor($cod_rms=NULL){
        if(!is_null($cod_rms)){
            
            return $this->db->get_where('T026_fornecedor','concat(T026_rms_codigo,T026_rms_digito) = '.$cod_rms,1);

        }
        
    }
    
    public function retorna_ap($cod_ap){
        if(!is_null($cod_ap)){
            $this->db->select('T08.T008_codigo
                         , T08.T008_nf_numero
                         , T08.T026_nf_serie
                         , T08.T008_ft_numero
                         , T08.T008_nf_dt_emiss
                         , T08.T008_nf_dt_receb
                         , T08.T008_nf_dt_vencto
                         , T08.T008_tp_despesa
                         , T08.T008_forma_pagto
                         , T08.T008_num_contrato
                         , T08.T004_login
                         , T04.T004_nome
                         , T08.T008_tp_nota
                         , T08.T008_nf_valor_bruto
                         , T08.T008_nf_dt_vencto
                         , T26.T026_codigo
                         , T26.T026_rms_codigo
                         , T26.T026_rms_digito
                         , T26.T026_rms_insc_est_ident
                         , T26.T026_rms_insc_mun
                         , T26.T026_rms_cgc_cpf
                         , T26.T026_rms_razao_social
                         , T08.T008_T026T059_T006_codigo
                         , T06.T006_codigo
                         , T06.T006_nome
                         , T120.T120_codigo
                         , T120.T120_nome
                         , T08.T008_desc
                         , T08.T008_justificativa
                         , T08.T008_inst_controladoria
                         , T08.T008_dados_controladoria
                         , T59.T059_codigo
                         , T60.T060_codigo');            
            $this->db->from('T008_approval T08');
            $this->db->join('T006_loja T06','T08.T008_T026T059_T006_codigo = T06.T006_codigo');
            $this->db->join('T026_fornecedor T26','T08.T026_codigo = T26.T026_codigo');
            $this->db->join('T120_fornecedor_categoria T120','T08.T120_codigo = T120.T120_codigo', 'left');
            $this->db->join('T059_grupo_workflow T59','T08.T008_T026T059_T059_codigo = T59.T059_codigo');
            $this->db->join('T004_usuario T04','T08.T004_login = T04.T004_login');
            $this->db->join('T060_workflow T60'    ,'T60.T059_codigo    =  T59.T059_codigo');
            $this->db->where('T08.T008_codigo',$cod_ap);            
            
            return $this->db->get();
        }
    }
    
    public function get_approval_first($ap = ''){
        
        if(!empty($ap)){
            $data   =   array(
                'T008_T060_ordem'   =>  1,
                'T008_T060_status'  =>  1,
                'T008_codigo'       =>  $ap,
            );
            $this->db->where($data);
            $this->db->from('T008_T060');           
            
            $query = $this->db->get();
            
            if($query->num_rows()>0){
                return $query->row();
            }else
                return FALSE;
            
        }else
            return FALSE;
        
    }
    
    public function get_flux($ap    =   ''){
        if(!empty($ap)){
            
            $this->db->select('
                        T0860.T008_T060_ordem
                    ,   T59.T059_codigo
                    ,   T59.T059_nome
                    ,   T0860.T008_T060_dt_aprovacao
                    ,   T04.T004_login
                    ,   T04.T004_nome'
            );
            
            $this->db->from('T008_T060 T0860');
            $this->db->join('T060_workflow T60','T0860.T060_codigo = T60.T060_codigo');
            $this->db->join('T059_grupo_workflow T59','T60.T059_codigo = T59.T059_codigo');
            $this->db->join('T004_usuario T04','T0860.T004_login = T04.T004_login');
            $this->db->where('T0860.T008_codigo',$ap);
            $this->db->order_by('T0860.T008_T060_ordem');
            
            return $this->db->get();
            
        }else
            return FALSE;
    }
    
    public function get_last_approval($ap = NULL){
        if(!is_null($ap)){
            
            return $this->db->query(" SELECT '000'                                             GrupoCodigo
                                            , 'AP digitada e não aprovada'                      GrupoNome
                                            , date_format(T08.T008_dt_elaboracao,'%d/%m/%Y')    DtAprovacao
                                            , time(T08.T008_dt_elaboracao)                      TimeAprovacao
                                            , T08.T004_login                                    Login
                                            , T60.T060_num_dias
                                         FROM T008_approval       T08
                                         JOIN T059_grupo_workflow T59 ON  ( T59.T059_codigo  = T08.T008_T026T059_T059_codigo   )
                                         JOIN T008_T060 T0860 ON (T08.T008_codigo = T0860.T008_codigo)
                                         JOIN T060_workflow  T60      ON  ( T60.T060_codigo  = T0860.T060_codigo )
                                         WHERE T08.T008_codigo  = $ap
                                           AND T08.T008_status    IN (0,4)
                                       UNION
                                       SELECT T59.T059_codigo AS GrupoCodigo
                                            , T59.T059_nome   AS GrupoNome
                                            , date_format(T0860.T008_T060_dt_aprovacao,'%d/%m/%Y') dtAprovacao
                                            , time(T0860.T008_T060_dt_aprovacao)                   TimeAprovacao
                                            , T0860.T004_login        AS Login
                                            , T60.T060_num_dias
                                         FROM T008_T060 T0860
                                        JOIN  (  SELECT T060_codigo etapa, max(T008_T060_ordem) ordem
                                                   FROM T008_T060 T
                                                  WHERE T008_T060_dt_aprovacao IS NOT NULL
                                                    AND T008_T060_status       IN ('1')
                                                    AND T008_codigo            = $ap
                                               GROUP BY T.T008_codigo
                                              ) SE1 ON ( SE1.etapa  = T0860.T060_codigo )
                                         JOIN T060_workflow  T60      ON  ( T60.T060_codigo  = T0860.T060_codigo )
                                         JOIN T059_grupo_workflow T59 ON  ( T59.T059_codigo  = T60.T059_codigo   )
                                         JOIN T008_approval       T08 ON  ( T08.T008_codigo  = $ap             )
                                       WHERE T0860.T008_codigo  = $ap
                                         AND T08.T008_status    IN ('1','4','9')");                   
                        
        }
    }
    
    public function get_files($ap = NULL){
        if(!is_null($ap)){
            $this->db->where('T008_codigo',$ap);
            $this->db->from('T008_T055');
            
            return $this->db->get();
        }
    }
    
    public function get_approval_last($ap=NULL){
        
        if(!is_null($ap)){
            
            $this->db->select_max('T0860.T060_codigo');
            $this->db->from('T008_T060 T0860');
            $this->db->where('T0860.T008_codigo',$ap);
            $this->db->where('T0860.T008_T060_status',0);
            
            return $this->db->get()->row();
            
        }else
            return FALSE;
        
    }
    
    public function get_last_stage($ap=NULL){
        
        if(!is_null($ap)){
            
            $this->db->select('T008_codigo')
                     ->select_max('T008_T060_ordem')
                     ->from('T008_T060')
                     ->where('T008_codigo',$ap)
                     ->group_by('T008_codigo');

            $subquery = $this->db->_compile_select();

            $this->db->_reset_select(); 
            
            $this->db->select('T0860.T060_codigo')
                     ->from("($subquery) SE")
                     ->join('T008_T060 T0860','T0860.T008_codigo     = SE.T008_codigo AND T0860.T008_T060_ordem = SE.T008_T060_ordem');

            return $this->db->get()->row();
            
        }else
            return FALSE;
        
    }
}

/* Final do Arquivo M0016.php
/* Localização: ./application/models/M0016.php */
/* Data Criação: 15/08/2013 */