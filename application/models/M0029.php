<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0029 extends CI_Model{
    
    public function get_filter($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){
        
        $user   =   $this->session->userdata('user');
        
        $this->db->select('T0455.T055_codigo')
                 ->from('T004_T055 T0455')
                 ->where('T0455.T004_login',$user)
                 ->where('T0455.T004_T055_visualizar',1);

        $subquery = $this->db->_compile_select();

        $this->db->_reset_select(); 
        
        $this->db->select('T0955.T055_codigo, T0955.T009_codigo')
                 ->from('T009_T055 T0955')
                 ->join('T004_T009 T0409','T0409.T009_codigo = T0955.T009_codigo')
                 ->where('T0409.T004_login',$user)
                 ->where('T009_T055_visualizar',1);

        $subquery1 = $this->db->_compile_select();

        $this->db->_reset_select(); 
        
        $this->db->select('T550677.T055_codigo, T550677.T077_codigo, T550677.T006_codigo')
                 ->from('T055_T006T077  T550677')
                 ->join('T004_T006_T077 T040677','T040677.T077_codigo = T550677.T077_codigo AND T040677.T006_codigo = T550677.T006_codigo')
                 ->where('T040677.T004_login',$user)
                 ->where('T550677.T055_T006T077_visualizar',1);

        $subquery2 = $this->db->_compile_select();

        $this->db->_reset_select(); 

        $this->db->distinct()
                 ->select('T55.T055_codigo
                         , T55.T055_nome
                         , T55.T055_desc 
                         , T55.T055_dt_upload
                         , T55.T004_owner
                         , T04.T004_nome
                         , T55.T056_codigo
                         , T56.T056_nome
                         , T55.T057_codigo
                         , T57.T057_nome 
                         , T55.T055_publico
                         , T55.T055_tags')
                 ->from('T055_arquivos T55')

                 ->join("($subquery)  SE","SE.T055_codigo = T55.T055_codigo",'left')
                 ->join("($subquery1)  SE1","SE1.T055_codigo = T55.T055_codigo",'left')
                 ->join("($subquery2)  SE2","SE2.T055_codigo = T55.T055_codigo",'left')

                 ->join('T056_categoria_arquivo   T56'    ,'T56.T056_codigo   = T55.T056_codigo')
                 ->join('T057_extensao 	        T57'    ,'T57.T057_codigo   = T55.T057_codigo')
                 ->join('T004_usuario            T04'    ,'T04.T004_login = T55.T004_owner')
                 ->where('T55.T061_codigo IS NULL',NULL)
                 ->where("(T55.T004_owner	= '$user') OR
                          (SE.T055_codigo IS NOT NULL) OR
                          (SE1.T055_codigo IS NOT NULL )OR
                          (SE2.T055_codigo IS NOT NULL ) OR 
                          (T55.T055_publico = 1)",NULL);
                
//                 $dados = DV_format_field_db($dados, array('T026_rms_cgc_cpf'), 'cnpj');
//        
//                if(strlen($dados['T008_codigo'])>0)
//                    $this->db->like('T08.T008_codigo',$dados['T008_codigo']);
//                
//                if(strlen($dados['T008_nf_numero'])>0)
//                    $this->db->like('T08.T008_nf_numero',$dados['T008_nf_numero']);
//                
//                if(strlen($dados['T026_rms_razao_social'])>0)
//                    $this->db->like('T26.T026_rms_razao_social',$dados['T026_rms_razao_social']);
//                
//                if(strlen($dados['T026_rms_cgc_cpf'])>0)
//                    $this->db->like('T26.T026_rms_cgc_cpf',$dados['T026_rms_cgc_cpf']);
        
//        echo $this->db->return_query();
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
        return $this->db->get();                       
                       
    }     
    
}

/* Final do Arquivo M0029.php
/* Localização: ./application/models/M0029.php */
/* Data Criação: 29/10/2013 */