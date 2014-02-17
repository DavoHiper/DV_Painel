<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0031 extends CI_Model{
    
    public function get_data($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){
        
        $this->db->select(' T015.T006_codigo_origem  
                          , T06A.T006_nome T006_nome_origem 
                          , T015.T006_codigo_destino
                          , T06B.T006_nome T006_nome_destino
                          , T015.T015_km')
                ->from('T015_deslocamentos T015')
                ->join('T006_loja T06A','T015.T006_codigo_origem = T06A.T006_codigo')
                ->join('T006_loja T06B','T015.T006_codigo_destino = T06B.T006_codigo')
        ;
        
        if(!empty($dados)){
            foreach($dados as $key => $value){
                if(!empty($value)){
                    $this->db->where($key,$value);
                }
            }                        
        }
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
        
//        echo $this->db->return_query();
        
        return $this->db->get();                       
                       
    }     
    
}

/* Final do Arquivo M0031.php
/* Localização: ./application/models/M0031.php */
/* Data Criação: 11/11/2013 */