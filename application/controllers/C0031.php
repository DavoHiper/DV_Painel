<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class C0031 extends CI_Controller {

    public function __construct() {

        parent::__construct();
        DV_init_painel($this->router->class);
    }

    public function _remap($method) {

        DV_esta_logado();

        $this->$method();
    }

    public function index() {
        $this->listar();
    }

    public function listar() {

        //Validação de Formulário
        $this->form_validation->set_rules('T006_codigo_origem', 'Loja Origem', 'trim');
        $this->form_validation->set_rules('T006_codigo_destino', 'Loja Destino', 'trim');

        $dados = array();
        if ($this->form_validation->run() == TRUE):

            //Captura elementos enviados pelo formulário
            $dados = elements(array('T006_codigo_origem', 'T006_codigo_destino'), $this->input->post());

            $this->session->set_userdata(array('filtroDeslocamento' => $dados));

        endif;

        //Cria view
        DV_set_tema('conteudo', DV_load_modulo('V0031', 'listar', $dados));
        DV_load_template();
    }

    public function novo() {

        $this->form_validation->set_rules('T006_codigo_origem', 'Loja Origem', 'trim|required');
        $this->form_validation->set_rules('T006_codigo_destino', 'Loja Destino', 'trim|required');
        $this->form_validation->set_rules('T015_km', 'Valor Km', 'required|numeric');

        $dados = array();
        if ($this->form_validation->run() == TRUE) {

            //Insere fornecedor caso não exista
            $dados = elements(array('T006_codigo_origem', 'T006_codigo_destino', 'T015_km'), $this->input->post());

            $this->msis->do_insert('T015_deslocamentos', $dados, FALSE, "Inserido com sucesso");

            echo '1';
        } else {
           
            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0031', 'novo', $dados));
            DV_load_template();
        }
    }

    public function editar() {

        $this->form_validation->set_rules('T015_km','Valor Km','trim|required');

        if ($this->form_validation->run() == TRUE) {

        } else {

            //Cria view
            DV_init_dialog();
            DV_set_tema('conteudo', DV_load_modulo('V0031', 'editar'));
            DV_load_template();
        }
    
    }

}

/* Final do Arquivo C0031.php
/* Localização: ./application/controllers/C0031.php */
/* Data Criação: 07/11/2013 */