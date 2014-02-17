<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0139 extends CI_Model{

    public function teste(){
        $this->dbmssql    =   $this->load->database('mssql', TRUE);                 
        
        if ($this->dbmssql->table_exists('tempTotaisPag')):
            $this->dbmssql->query('DROP TABLE tempTotaisPag');
            $this->dbmssql->query('CREATE TABLE tempTotaisPag(LOJA CHAR(3), VALOR_CAN MONEY, VALOR_PAG MONEY )');
        else:
            $this->dbmssql->query('CREATE TABLE tempTotaisPag(LOJA CHAR(3), VALOR_CAN MONEY, VALOR_PAG MONEY )');
        endif;
        
//        $query = $this->dbmssql->get('TB_FLASHES_CARTAO');
//        
//        foreach ($query->result() as $row)
//        {
//           echo $row->DATA;
//           echo $row->LOJA;
//           echo $row->ATIVOS;
//           echo $row->CAPTADOS;
//        }
        
    }
    
    public function get_data($limit, $inicio, $dados=NULL){
                
        if(!empty($dados)){
            $this->db->where($dados);
        }
        
        if ($limit > 0){
            $this->db->limit($limit, $inicio);
        }
        
        return $this->db->get('T006_loja');
        
    }
    
}

/* Final do Arquivo M0139.php
/* Localização: ./application/models/M0139.php */
/* Data Criação: 07/11/2013 */