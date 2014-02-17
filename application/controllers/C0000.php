<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C0000 extends CI_Controller{

    public function __construct(){
        
        parent::__construct();
        DV_init_painel($this->router->class);                           
        
    }    
    
    public function _remap($method){
                                        
        DV_esta_logado();
        
        $this->$method();

    }

    public function index(){
        $this->listar();       
    }
        
    public function listar(){
        
		$this->form_validation->set_rules('T007_codigo'	, 'Codigo'		, 'trim|numeric');
		$this->form_validation->set_rules('T007_nome'	, 'Nome'		, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T007_desc'	, 'Descrição'	, 'trim|alpha_numeric');
		$this->form_validation->set_rules('T007_titulo'	, 'Título'		, 'trim|alpha_numeric');
				
        $dados = array();               
		if ($this->form_validation->run()==TRUE):

			$dados = elements(array('T007_codigo','T007_nome','T007_desc','T007_titulo'), $this->input->post());			
            
            $this->session->set_userdata(array('filtro'=>$dados));	
		endif;
		        
        DV_set_tema('titulo','Programas e Menus'); 
        DV_set_tema('conteudo', DV_load_modulo('V0000','listar',$dados));
        DV_load_template();                        
        
    }

    public function novo(){
        
        $this->form_validation->set_rules('T007_codigo' , 'Codigo'      , 'trim|numeric');
        $this->form_validation->set_rules('T007_nome'   , 'Nome'        , 'trim|alpha_numeric');
        $this->form_validation->set_rules('T007_desc'   , 'Descrição'   , 'trim|alpha_numeric');
        $this->form_validation->set_rules('T007_titulo' , 'Título'      , 'trim|alpha_numeric');
                
        $dados = array();               
        if ($this->form_validation->run()==TRUE):

            $dados = elements(array('T007_codigo','T007_nome','T007_desc','T007_titulo'), $this->input->post());            
            
            $this->session->set_userdata(array('filtro'=>$dados));
              
        endif;
                
        DV_set_tema('titulo','Novo - Programas e Menus'); 
        DV_set_tema('conteudo', DV_load_modulo('V0000','novo'));
        DV_load_template(); 
    }
    
    public function pdf(){
        $pdfFilePath = FCPATH."Dados/files/teste.pdf";
        $data['page_title'] = 'Hello world'; // pass data to the view

        if (file_exists($pdfFilePath) == FALSE)
        {
            ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley firstChild">
            $html = $this->load->view('pdf_report', $data, TRUE); // render the view into HTML

            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley lastChild">
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output($pdfFilePath, 'F'); // save to file because we can
        }

        redirect("Dados/files/teste.pdf");        
    }

}

/* Final do Arquivo C0000.php
/* Localização: ./application/controllers/C0000.php */
/* Data Criação: 12/08/2013 */