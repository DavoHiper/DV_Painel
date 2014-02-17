<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0031 extends CI_Model{
     
    public function get_data($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        $this->db->select('     T15.T006_codigo_origem
                            ,   T06B.T006_nome T006_nome_origem
                            ,   T15.T006_codigo_destino
                            ,   T06A.T006_nome T006_nome_destino
                            ,   T15.T015_km');
                        
        if(!empty($dados)){
            $this->db->where($dados);
        }
        
        $this->db->from('T015_deslocamentos T15');
        $this->db->join('T006_loja T06A','T06A.T006_codigo = T15.T006_codigo_destino');
        $this->db->join('T006_loja T06B','T06B.T006_codigo = T15.T006_codigo_origem');
        
        if ($limit > 0):
            $this->db->limit($limit, $inicio);
        endif;
    
        echo $this->db->return_query();
        
        return $this->db->get();                       
                       
    } 
}

/* Final do Arquivo M0031.php
/* Localização: ./application/models/M0031.php */
/* Data Criação: 07/11/2013 */