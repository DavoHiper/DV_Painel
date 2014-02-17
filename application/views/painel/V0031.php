<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

switch ($tela):

    case 'listar':

        //Cria Barar de Botões
        echo DV_barra_botoes(array(
            DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
            DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
            DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
            DV_botao_acao(FALSE, 'excluir           multiple    ', 'close', 'Excluir', 'excluir'),
        ));        
        
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro = $this->session->userdata('filtroDeslocamento');
        $qtdeLinha = 11;
        
        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;
        $qtdeRegistros = NULL;

        $query =  $this->M31->get_data(0, 0, $filtro); 

        if($query->num_rows>0)
            $qtdeRegistros = $query->num_rows;                                                
        else
            $qtdeRegistros  =   0;

        $query = $this->M31->get_data($qtdeLinha, $inicio, $filtro);        

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo DV_paginacao($qtdeRegistros, $qtdeLinha);

        echo DV_form_open('','','id="filters"');
        
        echo DV_form_fields(array(
            array(3,'columns',  DV_form_dropdown_lojas(array(), DV_set_value('T006_codigo_origem', $filtro), NULL, FALSE, 'T006_codigo_origem')),
            array(3,'columns',  DV_form_dropdown_lojas(array(), DV_set_value('T006_codigo_destino', $filtro), NULL, FALSE, 'T006_codigo_destino')),
            array(1,'columns',DV_form_submit('Filtrar', array('name' => 'filtrar'))),
        ));
        
        echo DV_form_close();

        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;

        $html    =   '<div id="tableFilter" class="small-12 large-12 columns">';

        $html   .=   '<table class="small-12 large-12 data-table">';

        $html   .=  '<thead>';
        $html   .=  '<tr>';
        $html   .=  '<th>'.form_checkbox(array('id' => 'chkAll')).'</th>'; 
        $html   .=  '<th>Loja Origem</th>';
        $html   .=  '<th>Loja Destino</th>';
        $html   .=  '<th>Valor KM</th>';
        $html   .=  '<tr>';

        $html   .=  '<tbody>';      
        
        if(!empty($query->num_rows)>0){
                       
            foreach($query->result() as $row){
                            
                $html   .=  '<tr>';
                
                $idRef  = json_encode(array(
                    'T006_codigo_origem'=>$row->T006_codigo_origem,
                    'T006_codigo_destino'=>$row->T006_codigo_destino,
                ));
                
                $html   .=  '<td class="arrRef" style="display:none;">'.$idRef.'</td>';                
                $html   .=  '<td>'.form_checkbox(array('class' => 'chkItm')).'</td>';                
                $html   .=  "<td>".DV_formata_codigo_nome($row->T006_codigo_origem, $row->T006_nome_origem)."</td>";
                $html   .=  "<td>".DV_formata_codigo_nome($row->T006_codigo_destino, $row->T006_nome_destino)."</td>";
                $html   .=  "<td>$row->T015_km</td>";                
                
                $html   .=  '</tr>';
                                
            }                                    
        }else{
            $html   .=  '<tr><td colspan="8" style="text-align:center;">Nenhum dado encontrado  </td</tr>';
        }
        
        $html   .=  '</tbody>';
        
        echo $html;

        break;

    case 'novo':

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo DV_form_open('C0031/novo');

        echo DV_form_fields(array(
            array(12,'columns',DV_form_dropdown_lojas(array(), set_value('T006_codigo_origem'), NULL, TRUE, 'T006_codigo_origem')),
            array('row'),
            array(12,'columns',DV_form_dropdown_lojas(array(), set_value('T006_codigo_destino'), NULL, TRUE, 'T006_codigo_destino')),
            array('row'),
            array(4,'columns',DV_form_input('Valor Km', array('name' => 'T015_km'), NULL, set_value('T015_km'))),
        ));
        
        echo DV_form_close();

        break;

    case 'editar':

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo DV_form_open('C0031/editar');
               
        echo DV_form_fields(array(
            array(10,'columns',DV_form_input('Valor Km', array('name' => 'T015_km'), NULL, set_value('T015_km',40))),
        ));
        
        echo DV_form_close();
        
        break;

endswitch;