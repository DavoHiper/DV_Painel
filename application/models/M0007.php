<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0007 extends CI_Model{
    
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
                              
        return $this->db->get('T057_extensao');
                       
    } 
    
    public function retornaTodos(){

        return $this->db->get('T057_extensao');
        
    }

	public function get_by_id($id=NULL){
		if ($id != NULL):
			$this->db->where('T057_codigo', $id);
			$this->db->limit(1);
			return $this->db->get('T057_extensao');
		else:
			return FALSE;
		endif;
	}    
    
    
    
}

/* Final do Arquivo M0007.php
/* Localização: ./application/models/M0007.php */
/* Data Criação: 15/08/2013 */