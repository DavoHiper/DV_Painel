<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

    case    'listar':        
						
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro =   $this->session->userdata('filtroExtensao');   
        //Variaveis para Paginação
        $qtdeRegistros  =   $this->M7->retornaFiltro(0,0,$filtro)->num_rows;
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
                DV_form_input('Código'		, array('name'=>'T057_codigo')	, NULL, DV_set_value('T057_codigo', $filtro)	, 1	, TRUE),
                DV_form_input('Nome'		, array('name'=>'T057_nome')	, NULL, DV_set_value('T057_nome', $filtro)		, 3	, TRUE),
                DV_form_input('Descrição'	, array('name'=>'T057_desc')	, NULL, DV_set_value('T057_desc', $filtro)		, 3	, TRUE),
             ));

        ($this->uri->segment(3) != '')? $inicio = $this->uri->segment(3) : $inicio = 0; 

        //Seleção de Dados               
        $query = $this->M7->retornaFiltro($qtdeLinha, $inicio, $filtro);
		       
        //Consutrução da Tabela em HTML
        echo DV_monta_tabela(   'T057_codigo',  //Id de Referencia do Item na tabela
                                //Cabeçalho da Tabela
                                array(  'Código',
                                        'Nome',
                                        'Descrição'), 
                                //Corpo da Tabela (campos da tabela)
                                array(  'T057_codigo',
                                        'T057_nome',
                                        'T057_desc'), 
                                //Seleção de Dados
                                $query                
                            );

        break;    
    
    case    'novo':  

        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0007/novo', array('class'=>'custom'));
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T057_nome')	, NULL, set_value('T057_nome'), 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T057_desc')	, NULL, set_value('T057_desc'), 6	, FALSE);
        
        echo form_close();
                
        echo '</div>';                

    break;
    
    case    'editar':  
                    
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');           
        
        echo form_open('C0007/editar/'.$this->uri->segment(3), array('class'=>'custom'));
        
        echo DV_form_input('Nome (*)'       , array('name'=>'T057_nome')	, NULL, set_value('T057_nome',$dados->T057_nome), 6	, FALSE);
        echo DV_form_input('Descrição (*)'  , array('name'=>'T057_desc')	, NULL, set_value('T057_desc',$dados->T057_desc), 6	, FALSE);
        
        echo form_close();
                
        echo '</div>';                

    break;
    
    case    'excluir':  
                    
        echo '<div class="row">';
        
        echo '<div>Tem certeza que deseja excluir os item(s) selecionado(s)?</div>';        
                
        echo '</div>';  
                
    break;
    
endswitch;