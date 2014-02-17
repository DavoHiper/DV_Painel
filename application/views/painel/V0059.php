<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

    case    'listar':          
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro =   $this->session->userdata('filtroParametro');   
        //Variaveis para Paginação
        $qtdeRegistros  =   $this->M59->retornaFiltro(0,0,$filtro)->num_rows;
        $qtdeLinha      =   11;          
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           

        //Cria Barar de Botões
        echo DV_barra_botoes(array( 
                DV_botao_acao(FALSE, 'ocultarFiltros'       , 'triangle-2-n-s'  , 'Ocultar Filtros'             ),
                DV_botao_acao(FALSE, 'novo', 'plusthick'    , 'Novo'            ,'novo'                         ),
                DV_botao_acao(FALSE, 'editar no-multiple'   , 'pencil'          , 'Editar'          ,'editar'   ),
                DV_botao_acao(FALSE, 'attValue no-multiple' , 'note'            , 'Atribuir Valor'  ,'attValue' ),
                DV_botao_acao(FALSE, 'excluir'              , 'close'           , 'Excluir'         ,'excluir'  ),                
             ));
        
        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
    
        
        //Cria formulário de Filtros               
        echo DV_form_open('','','id="filters"');
                
        echo DV_form_fields(array(
            array(3,'columns',DV_form_input('Código'		, array('name'=>'T003_codigo')	, NULL, DV_set_value('T003_codigo', $filtro)	, 1	, TRUE)),
            array(1,'columns',DV_form_input('Nome'		, array('name'=>'T003_nome')	, NULL, DV_set_value('T003_nome', $filtro))),
            array(1,'columns',DV_form_input('Descrição'	, array('name'=>'T003_desc')	, NULL, DV_set_value('T003_desc', $filtro))),
        ));
        
        echo DV_form_close();        
                   
        ($this->uri->segment(3) != '')? $inicio = $this->uri->segment(3) : $inicio = 0; 

        //Seleção de Dados               
        $query = $this->M59->retornaFiltro($qtdeLinha, $inicio, $filtro);
		       
        echo '<div id="tableFilter" class="large-12 columns">';
        echo '<table class="large-12 data-table">';
            echo '<thead>';
            echo '<tr>';
                echo '<th>' . form_checkbox(array('id' => 'chkAll')) . '</th>';
                echo '<th>Código</th>';
                echo '<th>Nome</th>';
                echo '<th>Descrição</th>';
                echo '<th>Datatype</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                
            foreach($query->result() as $row){                            
                echo '<tr>';

                echo '<td>'.form_checkbox(array('class' => 'chkItm')).'</td>';
                echo '<td class="idRef" style="display:none;">'.$row->T003_codigo.'</td>';
                echo '<td>'.$row->T003_codigo.'</td>';
                echo '<td>'.$row->T003_nome.'</td>';
                echo '<td>'.$row->T003_desc.'</td>';
                echo '<td>'.$row->T002_codigo.'</td>';
                
                echo '</tr>';
            }
            echo '</tbody>';
        echo '</table>';
        
        //Mostra Paginação                 
//        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
        
        break;    
    
    case    'novo':  
                
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0059/novo');
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T003_nome')	, NULL, set_value('T003_nome')  , 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T003_desc')	, NULL, set_value('T003_desc')  , 6	, FALSE);
        
        echo DV_form_dropdown_datatype(array('id'=>''),set_value('T002_codigo')); 
        
        echo form_close();
                
        echo '</div>';
                
    break;
    
    case    'editar':  
           
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0059/editar/'.$this->uri->segment(3), array('class'=>''));
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T003_nome')	, NULL, set_value('T003_nome',$dados->T003_nome), 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T003_desc')	, NULL, set_value('T003_desc',$dados->T003_desc), 6	, FALSE);
        
        echo form_close();
                
        echo '</div>';                

    break;
    
    case    'atribuir':  
           
        echo '<div class="row columns">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        $idRef= $this->uri->segment(3);
        
        //Seleção de Dados               
        $query = $this->M59->retornaValoresParametro($idRef);
		                             
        echo form_open('C0059/atribuir/'.$this->uri->segment(3), array('class'=>''));
        
        echo form_hidden('T003_codigo', $idRef);
        
        echo DV_form_dropdown_lojas(array(), set_value('T006_codigo'));
        echo DV_form_input('Data Início', array('name'=>'T089_dt_inicio','class'=>'customDate') , NULL, set_value('T089_dt_inicio') , 6, FALSE);
        echo DV_form_input('Data Final' , array('name'=>'T089_dt_fim','class'=>'customDate')    , NULL, set_value('T089_dt_fim')    , 6, FALSE);
        echo DV_form_input('Valor (*)'      , array('name'=>'T089_valor')                           , NULL, set_value('T089_valor')     , 6, FALSE);            
        
        echo form_close();
        
        //Consutrução da Tabela em HTML
        echo DV_monta_tabela(   'T003_codigo',  //Id de Referencia do Item na tabela
                                //Cabeçalho da Tabela
                                array(  'Loja',
                                        'Data Inicio',
                                        'Data Fim', 
                                        'Valor'), 
                                //Corpo da Tabela (campos da tabela)
                                array(  'T006_codigo',
                                        array('DV_format_vw_datetime','T089_dt_inicio'),
                                        array('DV_format_vw_datetime','T089_dt_fim'), 
                                        'T089_valor'), 
                                //Seleção de Dados
                                $query                
                            );          
                
        echo '</div>';                

    break;
    
    case    'excluir':  
                    
        echo '<div class="row">';
        
        echo '<div>Tem certeza que deseja excluir os item(s) selecionado(s)?</div>';        
                
        echo '</div>';  
                
    break;
    
endswitch;