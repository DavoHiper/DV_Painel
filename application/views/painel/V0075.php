<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):

    case    'pagamentos':        
						
        //Query do filtro guardada em uma seção (session[filtro])
    //    $filtro =   $this->session->userdata('filtro_0075_vendas');   
        //Variaveis para Paginação
     //   $qtdeRegistros  =   $this->M75->teste(0,0,$filtro)->num_rows;
        $qtdeLinha      =   11;          
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');         

        //Cria Barar de Botões
        echo DV_barra_botoes(array( 
                DV_botao_acao(FALSE, 'ocultarFiltros'   , 'triangle-2-n-s'  , 'Ocultar Filtros'),
                DV_botao_acao(TRUE , 'pagamentos'       , 'plusthick'       , 'Pagamentos'      ,'pagamentos' ),
                DV_botao_acao(TRUE , 'vendas'           , 'plusthick'       , 'Vendas'          ,'vendas'     ),
             ));
        
   //     echo DV_paginacao($qtdeRegistros, $qtdeLinha);
        
        
        $arr_buscar =   array(
            ''  => 'Selecione...',
            '1' => 'Diferenças',
            '2' => 'Todos' 
        );
    
        //Cria formulário de Filtros               
//        echo DV_form_filters(array(
//               DV_form_input('Data (*)'	, array('name'=>'DAT_PAG')      , NULL, DV_set_value('DAT_PAG', $filtro)        , 1	, TRUE),
//               DV_form_dropdown('Buscar',  'buscar',    $arr_buscar, array()  , DV_set_value('buscar', $filtro)         , 3),
//               DV_form_dropdown('Loja (*)', 'T006_codigo' , array(), array(), DV_set_value('T006_codigo', $filtro)	, 3),
//             ));
//                   
        $dadosCmb   =   array('valor1'=>'rotulo1',
                                'valor2'=>'rotulo2',
                                'valor2'=>'rotulo2',
                                'valor2'=>'rotulo2',
                                'valor2'=>'rotulo2',
                                'valor2'=>'rotulo2',
                                'valor2'=>'rotulo2',
            );
        
        echo DV_form_dropdown('teste', 'seila',$dadosCmb);
        
        ($this->uri->segment(3) != '')? $inicio = $this->uri->segment(3) : $inicio = 0; 

        //Seleção de Dados               
    //    $query = $this->M75->teste($qtdeLinha, $inicio, $filtro);
		       
        //Consutrução da Tabela em HTML
//        echo DV_monta_tabela(   'T007_codigo',  //Id de Referencia do Item na tabela
//                                //Cabeçalho da Tabela
//                                array(  'Código',
//                                        'Nome',
//                                        'Descrição',
//                                        'Título',
//                                        'Tipo/Extranet'), 
//                                //Corpo da Tabela (campos da tabela)
//                                array(  'T007_codigo',
//                                        'T007_nome',
//                                        'T007_desc',
//                                        'T007_titulo',
//                                        'T007_tp'), 
//                                //Seleção de Dados
//                                $query                
//                            );

        //Mostra Paginação                 
//        echo DV_paginacao($qtdeRegistros, $qtdeLinha);
        
        break;    
    
endswitch;