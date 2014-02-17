<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

    case    'listar':        
						
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro =   $this->session->userdata('filtroSeguroDesemprego');  
                
        //Variaveis para Paginação
        $qtdeRegistros  =   $this->M139->get_data(0,0,$filtro)->num_rows;
        $qtdeLinha      =   11;          
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');         

        //Cria Barar de Botões
        echo DV_barra_botoes(array( 
                DV_botao_acao(FALSE, 'ocultarFiltros'   , 'triangle-2-n-s'  , 'Ocultar Filtros'),
                DV_botao_acao(TRUE , 'pagamentos no-multiple'       , 'plusthick'       , 'Pagamentos'      ,'pagamentos' ),
                DV_botao_acao(TRUE , 'vendas multiple'           , 'plusthick'       , 'Vendas'          ,'vendas'     ),
             ));
        
        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
    
        echo DV_form_open('','','id="filters"');
        
        echo DV_form_fields(array(
            array(3,'columns',  DV_form_dropdown_lojas(array(), DV_set_value('T006_codigo', $filtro), NULL, FALSE)),
            array(1,'columns',  DV_form_submit('Filtrar', array('name' => 'filtrar'))),
        ));
        
        echo DV_form_close();
        
        ($this->uri->segment(3) != '')? $inicio = $this->uri->segment(3) : $inicio = 0; 

        //Seleção de Dados               
        $query = $this->M139->get_data($qtdeLinha, $inicio, $filtro);
		       
        echo DV_construct_table_vw('T006_codigo'
                            , array( 'Codigo'
                                    ,'Nome')
                
                            , array('T006_codigo'
                                    ,'T006_nome')
                
                            , $query
                
                            , TRUE);
        
        break;    
    
endswitch;