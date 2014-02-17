<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0075 extends CI_Model{

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
    
}

/* Final do Arquivo M0004.php
/* Localização: ./application/models/M0004.php */
/* Data Criação: 15/08/2013 */