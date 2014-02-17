<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

    case    'listar':        
						
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro =   $this->session->userdata('filtroPerfil');   
        //Variaveis para Paginação
        $qtdeRegistros  =   $this->M5->retornaFiltro(0,0,$filtro)->num_rows;
        $qtdeLinha      =   11;          
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');         

        //Cria Barar de Botões
        echo DV_barra_botoes(array( 
                DV_botao_acao(FALSE, 'ocultarFiltros'       , 'triangle-2-n-s'  , 'Ocultar Filtros'             ),
                DV_botao_acao(FALSE, 'novo', 'plusthick'    , 'Novo'            ,'novo'                         ),
                DV_botao_acao(FALSE, 'editar no-multiple'   , 'pencil'          , 'Editar'          ,'editar'   ),
                DV_botao_acao(FALSE, 'associar no-multiple' , 'circle-plus'     , 'Associar'        ,'associar' ),
                DV_botao_acao(FALSE, 'excluir'              , 'close'           , 'Excluir'         ,'excluir'  ),                
             ));
        
        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
    
        //Cria formulário de Filtros               
        echo DV_form_filters(array(
                DV_form_input('Código'		, array('name'=>'T009_codigo')	, NULL, DV_set_value('T009_codigo', $filtro)	, 1	, TRUE),
                DV_form_input('Nome'		, array('name'=>'T009_nome')	, NULL, DV_set_value('T009_nome', $filtro)		, 3	, TRUE),
                DV_form_input('Descrição'	, array('name'=>'T009_desc')	, NULL, DV_set_value('T009_desc', $filtro)		, 3	, TRUE),
             ));          
                   
        ($this->uri->segment(3) != '')? $inicio = $this->uri->segment(3) : $inicio = 0; 

        //Seleção de Dados               
        $query = $this->M5->retornaFiltro($qtdeLinha, $inicio, $filtro);
		       
        //Consutrução da Tabela em HTML
        echo DV_monta_tabela(   'T009_codigo',  //Id de Referencia do Item na tabela 
                                //Cabeçalho da Tabela
                                array(  'Código',
                                        'Nome',
                                        'Descrição'), 
                                //Corpo da Tabela (campos da tabela)
                                array(  'T009_codigo',
                                        'T009_nome',
                                        'T009_desc'), 
                                //Seleção de Dados
                                $query                
                            );

        //Mostra Paginação                 
//        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
        
        break;    
    
    case    'novo':  
                
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0005/novo', array('class'=>'custom'));
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T009_nome')	, NULL, set_value('T009_nome'), 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T009_desc')	, NULL, set_value('T009_desc'), 6	, FALSE);
                
        echo DV_form_multiselect('Usuário (*)','T004_login[]',$dados['T004_login'],array(),'Digite usuário/nome para buscar colaborador...','class="listUser"');
        
        echo form_close(); 
                
        echo '</div>';                

    break;
    
    case    'editar':  
        
        $idRef  =   $this->uri->segment(3);
        
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0005/editar/'.$idRef, array('class'=>'custom'));
        
        echo form_hidden('idRefDialog', $idRef);
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T009_nome')	, NULL, $dados->T009_nome, 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T009_desc')	, NULL, $dados->T009_desc, 6	, FALSE);
                
//        echo DV_form_multiselect('Usuário (*)','T004_login[]',$dados->T004_login,array(),'Digite usuário/nome para buscar colaborador...','class="listUser"');
        
        echo form_close(); 
                
        echo '</div>';                

    break;
    
    case    'associar':  
        
        $idRef  =   $this->uri->segment(3);
        
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0005/associar/'.$idRef, array('class'=>'custom'));
        
        echo form_hidden('idRefDialog', $idRef); 
        
        echo DV_form_multiselect('Usuário (*)','T004_login[]',$dados->T004_login,array(),'Digite usuário/nome para buscar colaborador...','class="listUser"');
        
        echo form_close();   
                
        echo '</div>';                

    break;
            
    case    'excluir':  
                    
        echo '<div class="row">';
        
        echo '<div>Tem certeza que deseja excluir os item(s) selecionado(s)?</div>';        
                
        echo '</div>';  
                
    break;
    
endswitch;