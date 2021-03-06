<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0004 extends CI_Model{
    
    public function retornaFiltro($limit=QT_LINHA_PAGINADOR, $inicio=0, $dados=NULL){

        if (is_array($dados)):
            foreach ($dados as $campo => $valor):
                if(!empty($valor)):
                    if (is_numeric($valor)):
                        $this->db->like(array($campo=>$valor));
                    else:
                        $this->db->like(array($campo=>$valor));
                    endif;
                endif;
            endforeach;        
        endif;
        
        if ($limit>0):
            $this->db->limit($limit, $inicio);
        endif;                           
                              
        return $this->db->get('T007_estrutura');
                       
    } 
    
    public function retornaTodos(){

        return $this->db->get('T007_estrutura');
        
    }

	public function get_by_id($id=NULL){
		if ($id != NULL):
			$this->db->where('T007_codigo', $id);
			$this->db->limit(1);
			return $this->db->get('T007_estrutura');
		else:
			return FALSE;
		endif;
	}    
    
    
    
}

/* Final do Arquivo M0004.php
/* Localização: ./application/models/M0004.php */
/* Data Criação: 15/08/2013 */