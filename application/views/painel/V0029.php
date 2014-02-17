<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

switch ($tela):

    case 'listar':

        //Query do filtro guardada em uma seção (session[filtro])
        $filtro = $this->session->userdata('filtroArquivar');
        //Variaveis para Paginação
        $qtdeRegistros = $this->M29->get_filter(0, 0, $filtro)->num_rows;
        $qtdeLinha = 11;

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        //Cria Barar de Botões
        echo DV_barra_botoes(array(
            DV_botao_acao(FALSE, 'ocultarFiltros', 'triangle-2-n-s', 'Ocultar Filtros'),
            DV_botao_acao(FALSE, 'novo', 'plusthick', 'Novo', 'novo'),
        ));

        echo DV_paginacao($qtdeRegistros, $qtdeLinha);

        //Cria formulário de Filtros               
        echo DV_form(array(
            array(3, 'columns', DV_form_input('Descrição', array('name' => 'T055_desc'), NULL, DV_set_value('T055_desc', $filtro))),
            array(3, 'columns', DV_form_dropdown_departamento(array(), set_value('T077_codigo'), array(), TRUE)),
            array(3, 'columns', DV_form_dropdown_tp_arquivo(array(), set_value('T056_codigo'), array(), TRUE)),
            array(3, 'columns', DV_form_input_login('Proprietário', array('name' => 'T004_owner'), NULL, DV_set_value('T004_owner', $filtro))),
            array('row'),
            array(2, 'columns', DV_form_input('Nome do Arquivo', array('name' => 'T055_nome'), NULL, DV_set_value('T055_nome', $filtro))),
            array(1, 'columns', DV_form_input('Data Inicial', array('name' => 'T055_dt_inicial','class'=>'customDate'), NULL, DV_set_value('T055_dt_inicial', $filtro))),
            array(1, 'columns', DV_form_input('Data Final', array('name' => 'T055_final','class'=>'customDate'), NULL, DV_set_value('T055_final', $filtro))),
            array(1, 'columns', DV_form_submit('Filtrar', array('name' => 'filtrar'))),
                ), 'filters');

        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;

        //Seleção de Dados               
        $query = $this->M29->get_filter($qtdeLinha, $inicio, $filtro);

        //Consutrução da Tabela em HTML
        echo DV_construct_table_vw('T055_codigo', //Id de Referencia do Item na tabela
                //Cabeçalho da Tabela
                array('Nome',
            'Data Upload',
            'Proprietário'),
                //Corpo da Tabela (campos da tabela)
                array(  'T055_codigo',
                        array('DV_format_field_vw'=>array('','T055_dt_upload','date')),
                        'T004_owner'),
                //Seleção de Dados
                $query
        );

        break;

    case 'novo':

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo form_open('C0004/novo', array('class' => ''));

        echo DV_form_input('Nome (*)', array('name' => 'T007_nome'), NULL, set_value('T007_nome'), 2, FALSE);
        echo DV_form_input('Descrição (*)', array('name' => 'T007_desc'), NULL, set_value('T007_desc'), 2, FALSE);
        echo DV_form_input('Título (*)', array('name' => 'T007_titulo'), NULL, set_value('T007_titulo'), 2, FALSE);

        echo DV_form_dropdown_menu(array('id' => 'dropPai'), set_value('T007_pai'));

        echo DV_form_radio('Tipo (*)', array('name' => 'T007_tp', 'id' => 'radio'), array('Público', 'Privado'), array(0, 1), set_value('T007_tp'));

        echo DV_form_checkbox('Extranet', array('name' => 'T007_extranet'), 1);

        echo form_close();



        break;

    case 'editar':

        echo '<div class="row">';

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo form_open('C0004/editar/' . $this->uri->segment(3), array('class' => ''));

        echo DV_form_input('Nome (*)', array('name' => 'T007_nome'), NULL, set_value('T007_nome', $dados->T007_nome), 6, FALSE);
        echo DV_form_input('Descrição (*)', array('name' => 'T007_desc'), NULL, set_value('T007_desc', $dados->T007_desc), 6, FALSE);
        echo DV_form_input('Título (*)', array('name' => 'T007_titulo'), NULL, set_value('T007_titulo', $dados->T007_titulo), 4, FALSE);

        echo DV_form_dropdown_menu(array('id' => 'dropPai'), set_value('T007_pai', $dados->T007_pai));

        echo DV_form_radio('Tipo (*)', array('name' => 'T007_tp', 'id' => 'radio'), array('Público', 'Privado'), array(0, 1), set_value('T007_tp', $dados->T007_tp));

        echo DV_form_checkbox('Extranet', array('name' => 'T007_extranet'), 1, 3, set_value('T007_extranet', $dados->T007_extranet));

        echo form_close();

        echo '</div>';

        break;

    case 'excluir':

        echo '<div class="row">';

        echo '<div>Tem certeza que deseja excluir os item(s) selecionado(s)?</div>';

        echo '</div>';

        break;

endswitch;