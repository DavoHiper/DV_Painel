<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0141 extends CI_Model{
     
    public function get_values(){
        
        $this->db->select(  ' T89.T006_codigo
                            , T06.T006_nome
                            , T89.T089_dt_inicio
                            , T89.T089_dt_fim
                            , T89.T089_valor')
                ->from('T089_parametro_detalhe T89')
                ->join('T003_parametros T03','T03.T003_codigo = T89.T003_codigo')
                ->join('T006_loja T06','T06.T006_codigo = T89.T006_codigo')
                ->where('T03.T003_codigo',7);
        
        return $this->db->get();
        
    }
    
}

/* Final do Arquivo M0141.php
/* Localização: ./application/models/M0141.php */
/* Data Criação: 06/12/2013 */