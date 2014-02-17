<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M0005 extends CI_Model{
    
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
                              
        return $this->db->get('T009_perfil');  
                       
    } 
    
    public function retornaTodos(){

        return $this->db->get('T009_perfil');
        
    }

	public function get_by_id($id=NULL){
		if ($id != NULL):
			$this->db->where('T009_codigo', $id);
			$this->db->limit(1);
			return $this->db->get('T009_perfil');
		else:
			return FALSE; 
		endif;
	}  
    
    public function retornaAssociados($id=NULL){

        $this->db->select(array('T04.T004_login','T04.T004_nome'));
        $this->db->from('T004_T009 T0409');
        $this->db->join('T004_usuario T04', 'T0409.T004_login = T04.T004_login');
        $this->db->join('T009_perfil T09', 'T0409.T009_codigo = T09.T009_codigo');
        $this->db->where('T09.T009_codigo',$id);        
        $this->db->order_by('T04.T004_nome','ASC');  
        
        return $this->db->get();
        
    }    
            
}

/* Final do Arquivo M0005.php
/* Localização: ./application/models/M0005.php */
/* Data Criação: 11/09/2013 */