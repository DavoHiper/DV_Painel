<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clogin extends CI_Controller{
    
    public function __construct(){
        parent::__construct();           
        DV_set_tema('headerinc', DV_load_css('login'),FALSE);
        DV_init_painel();                
    }
        
    public function login(){ 
        //Validação Formulário
        $this->form_validation->set_rules('usuario','Usuário','trim|required|min_length[4]|strtolower');
        $this->form_validation->set_rules('senha','Senha','trim|required|min_length[4]');
        if ($this->form_validation->run()==TRUE):
            
            $usuario    =   $this->input->post('usuario', TRUE);
            $senha      =   $this->input->post('senha', TRUE);
            
            DV_autentica_usuario($usuario, $senha);              
            
        endif;
        
        DV_set_tema('titulo','Login'); 
        DV_set_tema('conteudo', DV_load_modulo('Vlogin', 'login')); 
        DV_set_tema('rodape', '');
        DV_load_template();
    }
    
    public function logoff(){
        $this->session->unset_userdata(array('user_id'      =>''
                                            ,'user_nome'    =>''
                                            ,'user_admin'   =>''
                                            ,'user_logado'  =>''
                                       ));
        $this->session->sess_destroy();
        $this->session->sess_create();
        DV_set_msg('msgerro','Logoff efetuado com sucesso', 'sucesso');
//        redirect(WP_URL);
        redirect('Clogin/login');
    }   
}

/* Final do Arquivo Clogin.php
/* Localização: ./application/controllers/Clogin.php */
/* Data Criação: 01/07/2013 */