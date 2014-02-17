<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0026 extends CI_Model{
     
    public function get_awaiting_approval($limit=QT_LINHA_PAGINADOR, $init=0, $data=NULL){
        
        $user   =   $this->session->userdata('user');
        
        $this->db->select('T016_codigo')
                 ->select_min('T016_T060_ordem')
                 ->from('T016_T060 T1660')
                 ->where('T016_T060_dt_aprovacao IS NULL',NULL)
                 ->where('T016_T060_status','0')                 
                 ->group_by('T016_codigo');

        $subquery = $this->db->_compile_select();

        $this->db->_reset_select(); 

        $this->db->distinct()
                 ->select(' T16.T016_codigo
                          , T16.T004_login
                          , T16.T016_dt_lancamento
                          , T60.T060_codigo
                          , T16.T016_vl_total_geral
                          , T60.T059_codigo')
                 ->from('T016_T060 T1660')
                 ->from('T004_T059 T0459')

                 ->join("($subquery)  SE1","SE1.T016_codigo = T1660.T016_codigo AND SE1.T016_T060_ordem = T1660.T016_T060_ordem")

                 ->join('T060_workflow T60'    ,'T60.T059_codigo  =  T0459.T059_codigo')
                 ->join('T016_despesa T16 '    ,'T16.T016_codigo  =  T1660.T016_codigo')
                 ->where('T1660.T060_codigo = T60.T060_codigo',NULL)
                 ->where_in('T16.T016_status',array(0,1))
                 ->where('T0459.T004_login', $user);
                       
                if(strlen($data['T016_codigo'])>0)
                    $this->db->like('T16.T016_codigo',$data['T016_codigo']);
                
                if(strlen($data['T016_dt_lancamento'])>0){
                    $data=  DV_format_field_db($data,array('T016_dt_lancamento'),'date');
                    $this->db->where('T16.T016_dt_lancamento',$data['T016_dt_lancamento']);
                }
                
                if(strlen($data['T004_login'])>0)
                    $this->db->like('T16.T004_login',$data['T004_login']);
                
        if ($limit > 0):
            $this->db->limit($limit, $init);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function get_my_typed($limit=QT_LINHA_PAGINADOR, $init=0, $data=NULL){

        $user   =   $this->session->userdata('user');       

        $this->db->distinct()
                 ->select("T16.T016_codigo
                          ,T16.T004_login
                          ,T16.T016_dt_lancamento
                          ,T16.T016_vl_total_geral")
                 ->from('T016_despesa T16')
                 ->from('T004_T059 T0459')
                 ->where('T16.T016_status','0')
                 ->where('T16.T004_login',$user);       
        
                if(strlen($data['T016_codigo'])>0)
                    $this->db->like('T16.T016_codigo',$data['T016_codigo']);
                
                if(strlen($data['T016_dt_lancamento'])>0){
                    $data=  DV_format_field_db($data,array('T016_dt_lancamento'),'date');
                    $this->db->where('T16.T016_dt_lancamento',$data['T016_dt_lancamento']);
                }
                
                if(strlen($data['T004_login'])>0)
                    $this->db->like('T16.T004_login',$data['T004_login']);
                
        if ($limit > 0):
            $this->db->limit($limit, $init);
        endif;

        return $this->db->get();
    }
     
    public function get_previous($limit=QT_LINHA_PAGINADOR, $init=0, $data=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->select('T016_codigo')
                 ->select_max('T016_T060_ordem')
                 ->from('T016_T060')
                 ->where('T016_T060_ordem IS NOT NULL',NULL)
                 ->where('T016_T060_dt_aprovacao IS NULL',NULL)
                 ->group_by('T016_codigo');

        $subquery1 = $this->db->_compile_select();

        $this->db->_reset_select();
        
        $this->db->select('T1660.T016_codigo')
                 ->select_max('T1660.T016_T060_ordem')
                 ->from('T016_T060 T1660')
                 ->from('T004_T059 T0459')
                 ->join("($subquery1) SE1",'SE1.T016_codigo  = T1660.T016_codigo')
                 ->join('T060_workflow T60','T60.T059_codigo  =  T0459.T059_codigo')
                 ->where('T1660.T060_codigo  = T60.T060_codigo',NULL)
                 ->where('T1660.T016_T060_dt_aprovacao IS NULL',NULL)
                 ->where('T0459.T004_login',$user)
                 ->group_by('T1660.T016_codigo');
        
        $subquery   =   $this->db->_compile_select();
        
        $this->db->_reset_select();

        $this->db->distinct()
                 ->select('T16.T016_codigo
                          ,T16.T004_login
                          ,T16.T016_dt_lancamento
                          ,T16.T016_vl_total_geral
                          ,T1660_2.T060_codigo')
                 ->from("($subquery) SE2")
                 ->join('T016_T060 T1660_2'    ,'T1660_2.T016_codigo     = SE2.T016_codigo AND T1660_2.T016_T060_ordem < SE2.T016_T060_ordem')
                 ->join('T016_despesa T16'    ,'T16.T016_codigo  =  T1660_2.T016_codigo')
                 ->where_in('T16.T016_status',array(0,1))
                 ->where('T1660_2.T016_T060_dt_aprovacao IS NULL',NULL);

                if(strlen($data['T016_codigo'])>0)
                    $this->db->like('T16.T016_codigo',$data['T016_codigo']);
                
                if(strlen($data['T016_dt_lancamento'])>0){
                    $data=  DV_format_field_db($data,array('T016_dt_lancamento'),'date');
                    $this->db->where('T16.T016_dt_lancamento',$data['T016_dt_lancamento']);
                }
                
                if(strlen($data['T004_login'])>0)
                    $this->db->like('T16.T004_login',$data['T004_login']);
        
        if ($limit > 0):
            $this->db->limit($limit, $init);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function get_later($limit=QT_LINHA_PAGINADOR, $init=0, $data=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->select('T016_codigo')
                 ->select_max('T016_T060_ordem')
                 ->from('T016_T060')
                 ->where('T016_T060_ordem IS NOT NULL',NULL)
                 ->group_by('T016_codigo');

        $subquery1 = $this->db->_compile_select();

        $this->db->_reset_select();
        
        $this->db->select('T1660.T016_codigo')
                 ->select_max('T1660.T016_T060_ordem')
                 ->from('T016_T060 T1660')
                 ->from('T004_T059 T0459')
                 ->join("($subquery1) SE1",'SE1.T016_codigo  = T1660.T016_codigo')
                 ->join('T060_workflow T60','T60.T059_codigo  =  T0459.T059_codigo')
                 ->where('T1660.T060_codigo  = T60.T060_codigo',NULL)
                 ->where('T1660.T016_T060_dt_aprovacao IS NOT NULL',NULL)
                 ->where('T0459.T004_login',$user)
                 ->group_by('T1660.T016_codigo');
        
        $subquery   =   $this->db->_compile_select();
        
        $this->db->_reset_select();

        $this->db->distinct()
                 ->select('T16.T016_codigo
                          ,T16.T004_login
                          ,T16.T016_dt_lancamento
                          ,T16.T016_vl_total_geral
                          ,T1660_2.T060_codigo')
                 ->from("($subquery) SE2")
                 ->join('T016_T060 T1660_2'    ,'T1660_2.T016_codigo     = SE2.T016_codigo AND T1660_2.T016_T060_ordem > SE2.T016_T060_ordem')
                 ->join('T016_despesa T16'    ,'T16.T016_codigo  =  T1660_2.T016_codigo')
                 ->where_in('T16.T016_status',array(1))
                 ->where('T16.T004_login',$user)
                 ->group_by('T16.T016_codigo');    
        
                if(strlen($data['T016_codigo'])>0)
                    $this->db->like('T16.T016_codigo',$data['T016_codigo']);
                
                if(strlen($data['T016_dt_lancamento'])>0){
                    $data=  DV_format_field_db($data,array('T016_dt_lancamento'),'date');
                    $this->db->where('T16.T016_dt_lancamento',$data['T016_dt_lancamento']);
                }
                
                if(strlen($data['T004_login'])>0)
                    $this->db->like('T16.T004_login',$data['T004_login']);                           
        
        if ($limit > 0):
            $this->db->limit($limit, $init);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function get_finalized($limit=QT_LINHA_PAGINADOR, $init=0, $data=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->distinct()
                 ->select('T16.T016_codigo
                          ,T16.T004_login
                          ,T16.T016_dt_lancamento
                          ,T16.T016_vl_total_geral')
                 ->from('T016_despesa T16')
                 ->from('T004_T059 T0459')
                 ->join('T016_T060 T1660'    ,'T1660.T016_codigo = T16.T016_codigo')
                 ->join('T060_workflow T60'    ,'T60.T059_codigo    =  T0459.T059_codigo AND T1660.T060_codigo  =  T60.T060_codigo')
                 ->join('T004_usuario T04'       ,'T16.T004_login    =  T04.T004_login')
                 ->where_in('T16.T016_status',9)
                 ->where("T16.T004_login = '$user'");

                if(strlen($data['T016_codigo'])>0)
                    $this->db->like('T16.T016_codigo',$data['T016_codigo']);
                
                if(strlen($data['T016_dt_lancamento'])>0){
                    $data=  DV_format_field_db($data,array('T016_dt_lancamento'),'date');
                    $this->db->where('T16.T016_dt_lancamento',$data['T016_dt_lancamento']);
                }
                
                if(strlen($data['T004_login'])>0)
                    $this->db->like('T16.T004_login',$data['T004_login']);
                
        if ($limit > 0):
            $this->db->limit($limit, $init);
        endif;
        
        return $this->db->get();                       
                       
    } 
     
    public function get_canceled($limit=QT_LINHA_PAGINADOR, $init=0, $data=NULL){

        $user   =   $this->session->userdata('user');
        
        $this->db->distinct()
                 ->select('T16.T016_codigo
                          ,T16.T004_login
                          ,T16.T016_dt_lancamento
                          ,T16.T016_vl_total_geral')
                 ->from('T016_despesa T16')
                 ->from('T004_T059 T0459')
                 ->join('T016_T060 T1660'    ,'T1660.T016_codigo = T16.T016_codigo')
                 ->join('T060_workflow T60'    ,'T60.T059_codigo    =  T0459.T059_codigo AND T1660.T060_codigo  =  T60.T060_codigo')
                 ->join('T004_usuario T04'       ,'T16.T004_login    =  T04.T004_login')
                 ->where_in('T16.T016_status',4)
                 ->where("T16.T004_login = '$user'");

                if(strlen($data['T016_codigo'])>0)
                    $this->db->like('T16.T016_codigo',$data['T016_codigo']);
                
                if(strlen($data['T016_dt_lancamento'])>0){
                    $data=  DV_format_field_db($data,array('T016_dt_lancamento'),'date');
                    $this->db->where('T16.T016_dt_lancamento',$data['T016_dt_lancamento']);
                }
                
                if(strlen($data['T004_login'])>0)
                    $this->db->like('T16.T004_login',$data['T004_login']);
                
        if ($limit > 0):
            $this->db->limit($limit, $init);
        endif;
        
        return $this->db->get();                       
                       
    } 
    
    public function get_approval_first($expense = ''){
        
        if(!empty($expense)){
            $data   =   array(
                'T016_T060_ordem'   =>  1,
                'T016_T060_status'  =>  1,
                'T016_codigo'       =>  $expense,
            );
            $this->db->where($data);
            $this->db->from('T016_T060');           
            
            $query = $this->db->get();
            
            if($query->num_rows()>0){
                return $query->row();
            }else
                return FALSE;
            
        }else
            return FALSE;
        
    }
    
    public function get_flux($expense    =   ''){
        if(!empty($expense)){
            
            $this->db->select('
                        T1660.T016_T060_ordem
                    ,   T59.T059_codigo
                    ,   T59.T059_nome
                    ,   T1660.T016_T060_dt_aprovacao
                    ,   T04.T004_login
                    ,   T04.T004_nome'
            );
            
            $this->db->from('T016_T060 T1660');
            $this->db->join('T060_workflow T60','T1660.T060_codigo = T60.T060_codigo');
            $this->db->join('T059_grupo_workflow T59','T60.T059_codigo = T59.T059_codigo');
            $this->db->join('T004_usuario T04','T1660.T004_login = T04.T004_login');
            $this->db->where('T1660.T016_codigo',$expense);
            $this->db->order_by('T1660.T016_T060_ordem');
            
            return $this->db->get();
            
        }else
            return FALSE;
    }
    
    public function get_last_approval($expense = NULL){
        if(!is_null($expense)){
            
            return $this->db->query(" SELECT  '000'                                             GrupoCodigo
                                            , 'Despesa digitada e não aprovada'                 GrupoNome
                                            , date_format(T16.T016_dt_lancamento,'%d/%m/%Y')    DtAprovacao
                                            , time(T16.T016_dt_lancamento)                      TimeAprovacao
                                            , T16.T004_login                                    Login
                                            , T60.T060_num_dias
                                         FROM T016_approval       T16
                                         JOIN T059_grupo_workflow T59 ON  ( T59.T059_codigo  = T16.T016_T026T059_T059_codigo   )
                                         JOIN T008_T060 T0860 ON (T08.T008_codigo = T0860.T008_codigo)
                                         JOIN T060_workflow  T60      ON  ( T60.T060_codigo  = T0860.T060_codigo )
                                         WHERE T08.T008_codigo  = $expense
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
                                                    AND T008_codigo            = $expense
                                               GROUP BY T.T008_codigo
                                              ) SE1 ON ( SE1.etapa  = T0860.T060_codigo )
                                         JOIN T060_workflow  T60      ON  ( T60.T060_codigo  = T0860.T060_codigo )
                                         JOIN T059_grupo_workflow T59 ON  ( T59.T059_codigo  = T60.T059_codigo   )
                                         JOIN T008_approval       T08 ON  ( T08.T008_codigo  = $expense             )
                                       WHERE T0860.T008_codigo  = $expense
                                         AND T08.T008_status    IN ('1','4','9')");                   
                        
        }
    }
    
    public function get_files($expense = NULL){
        if(!is_null($expense)){
            $this->db->where('T016_codigo',$expense);
            $this->db->from('T016_T055');
            
            return $this->db->get();
        }
    }
    
    public function get_approval_last($expense=NULL){
        
        if(!is_null($expense)){
            
            $this->db->select_max('T1660.T060_codigo');
            $this->db->select_min('T1660.T016_T060_ordem');
            $this->db->from('T016_T060 T1660');
            $this->db->where('T1660.T016_codigo',$expense);
            $this->db->where('T1660.T016_T060_status',0);
            
//            echo $this->db->return_query();
            
            return $this->db->get()->row();
            
        }else
            return FALSE;
        
    }
    
    public function get_last_stage($expense=NULL){
        
        if(!is_null($expense)){
            
            $this->db->select('T016_codigo')
                     ->select_max('T016_T060_ordem')
                     ->from('T016_T060')
                     ->where('T016_codigo',$expense)
                     ->group_by('T016_codigo');

            $subquery = $this->db->_compile_select();

            $this->db->_reset_select(); 
            
            $this->db->select('T1660.T060_codigo')
                     ->from("($subquery) SE")
                     ->join('T016_T060 T1660','T1660.T016_codigo     = SE.T016_codigo AND T1660.T016_T060_ordem = SE.T016_T060_ordem');

            return $this->db->get()->row();
            
        }else
            return FALSE;
        
    }
    
    public function get_rms_cpf($cpf=NULL){
        
        //set database
        if(!empty($cpf)){
            
            $this->dbora    =   $this->load->database('oracle', TRUE); 

            $this->dbora->select('TIP_RAZAO_SOCIAL')
                        ->from('RMS.AA2CTIPO')
                        ->where('TIP_LOJ_CLI','F')
                        ->where('TIP_NATUREZA','FS')
                        ->where('TIP_CGC_CPF',$cpf);

            return $this->dbora->get()->row();            
            
        }else
            return FALSE;
        
        
    }
    
    public function get_group_user($user=NULL){
        if(!empty($user)){
            $this->db   ->select('T0459.T059_codigo, T59.T059_nome')
                        ->from('T004_T059 T0459')
                        ->join('T059_grupo_workflow T59','T0459.T059_codigo = T59.T059_codigo')
                        ->where('T0459.T004_login',$user)
                        ->like('T59.T059_nome','Elaborador')
                        ->where('T59.T061_codigo',2);
            
            return $this->db->get();
            
        }else
            
            return FALSE;
    }
    
    public function get_displacement($origin = NULL, $destination = NULL){
                
        if(!empty($origin) && !empty($destination)){
        
            $this->db   ->select('T015_km')
                        ->from('T015_deslocamentos')
                        ->where('T006_codigo_destino',$origin)
                        ->where('T006_codigo_origem',$destination);
            
            $subQuery1 = $this->db->_compile_select();            
            
            $this->db->_reset_select();   
            
            $this->db   ->select('T015_km')
                        ->from('T015_deslocamentos ')
                        ->where('T006_codigo_origem ',$origin)
                        ->where('T006_codigo_destino',$destination);   
            
            $subQuery2 = $this->db->_compile_select();            
            
            $this->db->_reset_select();
            
            return $this->db->query("SELECT * FROM ($subQuery1 UNION $subQuery2) AS unionTable");           
            
        }                               
    }
    
    public function get_group_workflow_user($user = NULL){
        if(!empty($user)){

            $this->db   ->from('T004_T059 T0459')
                        ->join('T059_grupo_workflow T59','T0459.T059_codigo = T59.T059_codigo')
                        ->join('T060_workflow T60','T59.T059_codigo = T60.T059_codigo')
                        ->where('T0459.T004_login',$user)
                        ->where('T0459.T061_codigo',2)
                        ->where('T60.T060_ordem',1);
            
            return $this->db->get()->row()->T059_codigo;
        }
    } 
    
    public function check_status_km($expense = NULL, $status = NULL){
        if(!empty($expense)){
            
            $this->db   ->from('T015_T016 T1516')
                        ->join('T016_despesa T16','T1516.T016_codigo = T16.T016_codigo');
                    
            if(!empty($status)){
                $this->db->where('T1516.T015_T016_status',$status);
            }
        
            $this->db->where('T1516.T016_codigo',$expense);
            
//            echo $this->db->return_query();
            
            return $this->db->get();
            
        }else
            return FALSE;        
    }
    
    public function check_status_div($expense = NULL, $status = NULL){
        if(!empty($expense)){
            
            $this->db   ->from('T017_despesa_detalhe T17');

            if(!empty($status)){
                $this->db->where('T17.T017_status',$status);
            }
                                    
            $this->db->where('T17.T016_codigo',$expense);
            
//            echo $this->db->return_query();
            
            return $this->db->get();
            
        }else
            return FALSE;
    }
    
    public function check_exists_cpf($cpf   =   NULL){
        
        $user   =   $this->session->userdata('user');
        
        if(!empty($cpf)){
            
            $this->db   ->from('T004_usuario')
                        ->where('T004_login',$user)
                        ->where('T004_cpf',$cpf);
                                    
            $query  =   $this->db->get();
            
            if($query->num_rows()>0){
                return $query->row();
            }else{
                return FALSE;
            }
            
        }else
            return FALSE;
        
        
    }
    
    public function get_expense($expense = NULL){
        if(!empty($expense)){
            $where  =   array('T016_codigo'=>$expense);
            
            return $this->db->get_where('T016_despesa',$where);
            
        }  else {            
            return FALSE;        
        }
    }
    
    public function get_miscellaneous_expenses($expense = NULL, $sequence = NULL){
        if(!empty($expense)){
            $where['T016_codigo']   =   $expense;
            
            if(!empty($sequence))
                $where['T017_seq']   =   $sequence;
            
            return $this->db->get_where('T017_despesa_detalhe',$where);
            
        }  else {            
            return FALSE;        
        }        
    }
    
    public function get_displacement_expenses($expense = NULL, $sequence = NULL){
        if(!empty($expense)){
            $where['T016_codigo']   =   $expense;
            
            if(!empty($sequence))
                $where['T017_seq']   =   $sequence;
            
            return $this->db->get_where('T015_T016',$where);
            
        }  else {            
            return FALSE;        
        }          
    }
    
}

/* Final do Arquivo M0026.php
/* Localização: ./application/models/M0026.php */
/* Data Criação: 12/11/2013 */