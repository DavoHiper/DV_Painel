<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

    case    'listar':        
						
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro =   $this->session->userdata('filtroEstrutura');   
        //Variaveis para Paginação
        $qtdeRegistros  =   $this->M4->retornaFiltro(0,0,$filtro)->num_rows;
        $qtdeLinha      =   11;          
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');         

        //Cria Barar de Botões
        echo DV_barra_botoes(array( 
                DV_botao_acao(FALSE, 'ocultarFiltros'       , 'triangle-2-n-s'  , 'Ocultar Filtros'             ),
                DV_botao_acao(FALSE, 'novo', 'plusthick'    , 'Novo'            ,'novo'                         ),
                DV_botao_acao(FALSE, 'editar no-multiple'   , 'pencil'          , 'Editar'          ,'editar'   ),
                DV_botao_acao(FALSE, 'excluir'              , 'close'           , 'Excluir'         ,'excluir'  ),                
             ));
        
        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
    
        //Cria formulário de Filtros               
        echo DV_form_filters(array(
                DV_form_input('Código'		, array('name'=>'T007_codigo')	, NULL, DV_set_value('T007_codigo', $filtro)	, 1	, TRUE),
                DV_form_input('Nome'		, array('name'=>'T007_nome')	, NULL, DV_set_value('T007_nome', $filtro)		, 3	, TRUE),
                DV_form_input('Descrição'	, array('name'=>'T007_desc')	, NULL, DV_set_value('T007_desc', $filtro)		, 3	, TRUE),
                DV_form_input('Título'		, array('name'=>'T007_titulo')	, NULL, DV_set_value('T007_titulo', $filtro)	, 2	, TRUE),
             ));    
                   
        ($this->uri->segment(3) != '')? $inicio = $this->uri->segment(3) : $inicio = 0; 

        //Seleção de Dados               
        $query = $this->M4->retornaFiltro($qtdeLinha, $inicio, $filtro);
		       
        //Consutrução da Tabela em HTML
        echo DV_monta_tabela(   'T007_codigo',  //Id de Referencia do Item na tabela
                                //Cabeçalho da Tabela
                                array(  'Código',
                                        'Nome',
                                        'Descrição',
                                        'Título',
                                        'Pai',
                                        'Pub/Priv',
                                        'Extranet'), 
                                //Corpo da Tabela (campos da tabela)
                                array(  'T007_codigo',
                                        'T007_nome',
                                        'T007_desc',
                                        'T007_titulo',
                                        'T007_pai',
                                        'T007_tp',
                                        'T007_extranet'), 
                                //Seleção de Dados
                                $query                
                            );

        //Mostra Paginação                 
//        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
        
        break;    
    
    case    'novo':  
                
        
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0004/novo', array('class'=>''));
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T007_nome')	, NULL, set_value('T007_nome'), 2	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T007_desc')	, NULL, set_value('T007_desc'), 2	, FALSE);
        echo DV_form_input('Título (*)'     , array('name'=>'T007_titulo')	, NULL, set_value('T007_titulo'), 2	, FALSE);
           
        echo DV_form_dropdown_menu(array('id'=>'dropPai'),set_value('T007_pai')); 
        
        echo DV_form_radio('Tipo (*)',array('name'=>'T007_tp','id'=>'radio'),array('Público','Privado'),array(0,1),set_value('T007_tp'));
                
        echo DV_form_checkbox('Extranet', array('name'=>'T007_extranet'),1);
        
        echo form_close();
                
        
                
    break;
    
    case    'editar':  
           
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0004/editar/'.$this->uri->segment(3), array('class'=>''));
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T007_nome')	, NULL, set_value('T007_nome',$dados->T007_nome), 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T007_desc')	, NULL, set_value('T007_desc',$dados->T007_desc), 6	, FALSE);
        echo DV_form_input('Título (*)'     , array('name'=>'T007_titulo')	, NULL, set_value('T007_titulo',$dados->T007_titulo), 4	, FALSE);
        
        echo DV_form_dropdown_menu(array('id'=>'dropPai'),set_value('T007_pai',$dados->T007_pai)); 
        
        echo DV_form_radio('Tipo (*)',array('name'=>'T007_tp','id'=>'radio'),array('Público','Privado'),array(0,1),set_value('T007_tp',$dados->T007_tp));
        
        echo DV_form_checkbox('Extranet', array('name'=>'T007_extranet'), 1,3,set_value('T007_extranet',$dados->T007_extranet));        
        
        echo form_close();
                
        echo '</div>';                

    break;
    
    case    'excluir':  
                    
        echo '<div class="row">';
        
        echo '<div>Tem certeza que deseja excluir os item(s) selecionado(s)?</div>';        
                
        echo '</div>';  
                
    break;
    
endswitch;