<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

switch ($tela):

    case 'listar':
                
        //Query do filtro guardada em uma seção (session[filtro])
        $filtro = $this->session->userdata('filtroAp');
        $qtdeLinha = 11;
        $status = $filtro['status'];
        
        //Para filtros quando não selecionado um status, direciona para todos
        if(empty($status) && DV_check_values_array($filtro)){
            $filtro['status']   =    8;
            $status             =    8;
        }
        
        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;
        $query  =   NULL;
        $qtdeRegistros = NULL;
        switch ($status) {
            case 1:

                $query =  $this->M16->retornaAguardandoAprovacao(0, 0, $filtro); 

                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaAguardandoAprovacao($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));
                
                break;
            case 2:

                $query =  $this->M16->retornaMinhasDigitadas(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaMinhasDigitadas($qtdeLinha, $inicio, $filtro);
                
                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                
                
                break;                
            case 3:

                $query =  $this->M16->retornaAnteriores(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaAnteriores($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
//                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
//                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
//                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
//                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
//                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                
                
                break;
            case 4:

                $query =  $this->M16->retornaPosteriores(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaPosteriores($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
//                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
//                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
//                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
//                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
//                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                 
                
                break;
            case 5:

                $query =  $this->M16->retornaFinalizadas(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaFinalizadas($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
//                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
//                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
//                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
//                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
//                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                  
                
                break;
            case 6:

                $query =  $this->M16->retornaCanceladas(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaCanceladas($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
//                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
//                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
//                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
//                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
//                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                  
                
                break;
            case 7:

                $query =  $this->M16->retornaForaPrazo(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaForaPrazo($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
//                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
//                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
//                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
//                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
//                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                  
                
                break;
            case 8:

                $query =  $this->M16->retornaTodos(0, 0, $filtro); 
                
                if($query != FALSE && $query->num_rows>0)
                    $qtdeRegistros = $query->num_rows;                                                
                else
                    $qtdeRegistros  =   0;
                
                $query = $this->M16->retornaTodos($qtdeLinha, $inicio, $filtro);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
//                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
//                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
//                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
//                    DV_botao_acao(FALSE, 'transferir        multiple    ', 'transfer-e-w', 'Transferir', 'transferir'),
//                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
//                    DV_botao_acao(FALSE, 'aprovar           multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                
                
                break;
                
            default:
                
                $qtdeRegistros  =   0;
                
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                ));   
                
                break;
        }

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo DV_paginacao($qtdeRegistros, $qtdeLinha);

        $arr_status = array(
            '' => 'Selecione...',
            '1' => 'Aguardando minha aprovação',
            '2' => 'Minhas Digitadas',
            '3' => 'Anteriores à mim',
            '4' => 'Posteriores à mim',
            '5' => 'Finalizadas',
            '6' => 'Canceladas',
            '7' => 'Foras do prazo',
            '8' => 'Todas',
        );
                                      
        //Cria formulário de Filtros               
        
        echo DV_form_open('','','id="filters"');
                
        echo DV_form_fields(array(
            array(3,'columns',DV_form_dropdown('Status', 'status', $arr_status, array(), DV_set_value('status', $filtro))),
            array(1,'columns',DV_form_input('AP', array('name' => 'T008_codigo'), NULL, DV_set_value('T008_codigo', $filtro))),
            array(1,'columns',DV_form_input('NF', array('name' => 'T008_nf_numero'), NULL, DV_set_value('T008_nf_numero', $filtro))),
            array(3,'columns',DV_form_input('Fornecedor (contém)', array('name' => 'T026_rms_razao_social'), NULL, DV_set_value('T026_rms_razao_social', $filtro))),
            array(2,'columns',DV_form_input('CNPJ', array('name' => 'T026_rms_cgc_cpf', 'class'=>'cnpj'), NULL, DV_set_value('T026_rms_cgc_cpf', $filtro))),
            array(1,'columns',DV_form_submit('Filtrar', array('name' => 'filtrar'))),
//                DV_form_input('Vencto Inicial'      , array('name'=>'vencto_inicial','class'=>'customDate')       , NULL, DV_set_value('vencto_inicial'       , $filtro), 1	, TRUE),
//                DV_form_input('Vencto Final'        , array('name'=>'vencto_final'  ,'class'=>'customDate')       , NULL, DV_set_value('vencto_final'         , $filtro), 1	, TRUE),
//                DV_form_input('Valor Inicial'       , array('name'=>'valor_inicial')        , NULL, DV_set_value('valor_inicial'        , $filtro), 1	, TRUE),
//                DV_form_input('Valor Final'         , array('name'=>'valor_final')          , NULL, DV_set_value('valor_final'          , $filtro), 1	, TRUE),
        ));
        
        echo DV_form_close();

        ($this->uri->segment(3) != '') ? $inicio = $this->uri->segment(3) : $inicio = 0;

        $html    =   '<div id="tableFilter" class="small-12 large-12 columns">';

        $html   .=   '<table class="small-12 large-12 data-table">';

        $html   .=  '<thead>';
        $html   .=  '<tr>';
        $html   .=  '<th>'.form_checkbox(array('id' => 'chkAll')).'</th>'; 
        $html   .=  '<th>AP Nº</th>';
        $html   .=  '<th>Nota Fiscal / Série</th>';
        $html   .=  '<th>Fornecedor / CNPJ</th>';
        $html   .=  '<th>Elaborado por</th>';
        $html   .=  '<th>Última Etapa</th>';
        $html   .=  '<th>Loja Faturada</th>';
        $html   .=  '<th>Vencimento</th>';
        $html   .=  '<th>Valor</th>';
        $html   .=  '<th>Arquivos</th>';
        $html   .=  '<tr>';

        $html   .=  '<tbody>';      
        
        if(!empty($query->num_rows)>0){
                       
            foreach($query->result() as $row){
                                            
                                
                $row_stage = $this->M16->get_last_approval($row->T008_codigo)->row();
                
                $html   .=  '<tr>';
                
                $idRef  = json_encode(array(
                    'ap'=>$row->T008_codigo,
                    'etapa'=>$row->T060_codigo,
                    'tpnota'=>$row->T008_tp_nota,
                ));
                
                $html   .=  '<td class="idRef" style="display:none;">'.$row->T008_codigo.'</td>';
                $html   .=  '<td class="qtDias" style="display:none;">'.$row->QtDias.'</td>';
                $html   .=  '<td class="arrRef" style="display:none;">'.$idRef.'</td>';
                
                $html   .=  '<td>'.form_checkbox(array('class' => 'chkItm')).'</td>';                
                $html   .=  "<td>$row->T008_codigo</td>";
                $html   .=  "<td>$row->T008_nf_numero - $row->T026_nf_serie</td>";
                $html   .=  "<td>$row->T026_rms_razao_social - ".DV_format_field_vw($row, array('T026_rms_cgc_cpf'), 'cnpj')->T026_rms_cgc_cpf."</td>";
                $html   .=  "<td>$row->T004_nome ($row->T004_login)</td>";
                                
                $html   .=  "<td>$row_stage->GrupoCodigo - $row_stage->GrupoNome ($row_stage->Login)<p>$row_stage->DtAprovacao $row_stage->TimeAprovacao</p></td>";
                             
                $html   .=  '<td>'.DV_formata_codigo_nome($row->T006_codigo, $row->T006_nome).'</td>';
                $html   .=  '<td>'.DV_format_field_vw($row,array('T008_nf_dt_vencto'),'date')->T008_nf_dt_vencto.'</td>';
                $html   .=  '<td>'.DV_format_field_vw($row,array('T008_nf_valor_bruto'),'decimal')->T008_nf_valor_bruto.'</td>';
                
                $query_files    =   $this->M16->get_files($row->T008_codigo);                                
                
                $html_file  =   '';
                if($query_files->num_rows()>0){
                    $html_file  =   '<table>';
                    
                    foreach($query_files->result() as $row_file){
                        $html_file  .=  '<tr>';
                        
                        $html_file  .=  '<td style="display:none" class="file">'.$row_file->T055_codigo.'</td>';
                        $html_file  .=  '<td>'.DV_link_file($row_file->T055_codigo).'</td>';
                        $html_file  .=  '<td><span class="ui-icon ui-icon-close delete_file"></span></td>';
                        
                        $html_file  .=  '</tr>';
                    }
                    
                    $html_file  .=   '</table>';
                    
                    
                }
                
                $html   .=  '<td>'.$html_file.'</td>';    
                
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

        echo DV_form_open('C0016/novo');

        //Processo
        echo form_hidden('T061_codigo',1);
        //Código fornecedor preenchido após a executação do .buscaFornecedor (js)
        echo form_hidden('T026_codigo');
        
        $tab['Dados Fornecedor'] = array(
            DV_form_fields(array(
                array(4,'columns',DV_form_input('CNPJ (*)', array('name' => 'T026_rms_cgc_cpf', 'class' => 'buscaFornecedor cnpj'), NULL, set_value('T026_rms_cgc_cpf'))),
                array(3,'columns',DV_form_input('Código RMS (*)', array('name' => 'T026_rms_codigo', 'class' => 'buscaFornecedor'), NULL, set_value('T026_rms_codigo'))),
                
                array('row'),
                
                array(5,'columns',DV_form_input('Razão Social', array('name' => 'T026_rms_razao_social','readonly'=>'readonly'), NULL, set_value('T026_rms_razao_social'))),
                
                array(3,'columns',DV_form_input('Incrição Estadual', array('name' => 'T026_rms_insc_est_ident','readonly'=>'readonly'), NULL, set_value('T026_rms_insc_est_ident'))),
                array(3,'columns',DV_form_input('Inscrição Municipal', array('name' => 'T026_rms_insc_mun','readonly'=>'readonly'), NULL, set_value('T026_rms_insc_mun'))),

            )),
        );

        $arr_tp_nota = array(
            '' => 'Selecione...',
            '1' => '001 - Serviços',
            '2' => '002 - Despesas',
        );

        $arr_frm_pagto = array(
            '' => 'Selecione...',
            '1' => '001 - Boleto',
            '2' => '002 - Depósito em C/C',
            '3' => '003 - Outros',
        );

        $tab['Dados Nota Fiscal'] = array(
            DV_form_fields(array(

                array(2,'columns',DV_form_input('Nota Fiscal', array('name' => 'T008_nf_numero'), NULL, set_value('T008_nf_numero'))),
                array(2,'columns',DV_form_input('Série', array('name' => 'T026_nf_serie'), NULL, set_value('T026_nf_serie'))),
                array(2,'columns',DV_form_input('Fatura', array('name' => 'T008_ft_numero'), NULL, set_value('T008_ft_numero'))),
                array(4,'columns',DV_form_dropdown('Tipo da Nota', 'T008_tp_nota', $arr_tp_nota, array(), set_value('T008_tp_nota'))),

                array('row'),

                array(3,'columns',DV_form_input('Data Emissão (*)', array('name' => 'T008_nf_dt_emiss', 'class' => 'data customDate'), NULL, set_value('T008_nf_dt_emiss'))       ),
                array(3,'columns',DV_form_input('Data Recebimento (*)', array('name' => 'T008_nf_dt_receb', 'class' => 'data customDate'), NULL, set_value('T008_nf_dt_receb'))   ),
                array(3,'columns',DV_form_input('Data Vencimento (*)', array('name' => 'T008_nf_dt_vencto', 'class' => 'data customDate'), NULL, set_value('T008_nf_dt_vencto'))  ),

                array('row'),

                array(2,'columns',DV_form_input('Valor (*)', array('name' => 'T008_nf_valor_bruto', 'class' => 'valor'), NULL, set_value('T008_nf_valor_bruto'))),
                array(4,'columns',DV_form_dropdown('Forma de Pagamento', 'T008_forma_pagto', $arr_frm_pagto, array(), set_value('T008_forma_pagto'))),

                array(4,'columns',DV_form_dropdown_lojas(array('class' => 'cmb_loja'), set_value('T006_codigo'))),
                array(2,'columns',DV_form_input('Nº do Contrato', array('name' => 'T008_num_contrato'), NULL, set_value('T008_num_contrato'))),

                array('row'),

                array(6,'columns',DV_form_radio('Característica', array('name' => 'T008_tp_despesa', 'id' => 'radio'), array('Eventual', 'Por demanda', 'Regular'), array(1, 2, 3), set_value('T008_tp_despesa'))),
                array(4,'columns',DV_form_dropdown_categoria_fornecedor(array(), set_value('T120_codigo'))),

            ))
        );

        $tab['Grupo Workflow'] = array(
            DV_form_fields(array(
               array(6,'columns',DV_form_dropdown('Grupo Workflow (*)', 'T059_codigo')), 
               array(4,'columns',DV_botao_acao(FALSE, 'add_wkf botao-acao-form', 'plus', 'Adicionar Grupos', 'add_wkf')), 
            )),
        );

        $tab['Informações / Descrições'] = array(
            DV_form_fields(array(
                array(6,'',DV_form_textarea('Detalhes', array('name' => 'T008_desc'), NULL, set_value('T008_desc'), 'style="width:600px;"')), 

                array('row'),
               
                array(6,'',DV_form_textarea('Justificativas', array('name' => 'T008_justificativa'), NULL, set_value('T008_justificativa'), 'style="width:600px;"')),
               
                array('row'),
               
                array(6,'',DV_form_textarea('Instruções', array('name' => 'T008_inst_controladoria'), NULL, set_value('T008_inst_controladoria'), 'style="width:600px;"')),
               
                array('row'),
               
                array(6,'',DV_form_textarea('Controladoria', array('name' => 'T008_dados_controladoria'), NULL, set_value('T008_dados_controladoria'), 'style="width:600px;"'))
            )),
        );

        echo DV_tabs($tab);

        echo DV_form_close();

        break;

    case 'editar':
        
        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo DV_form_open('C0016/editar/' . $this->uri->segment(3));
       
        $tab['Dados Fornecedor'] = array(
            DV_form_fields(array(
                array(4,'columns',DV_form_input('CNPJ (*)', array('name' => 'T026_rms_cgc_cpf', 'class' => 'buscaFornecedor cnpj','readonly'=>'readonly'), NULL, set_value('T026_rms_cgc_cpf',$dados->T026_rms_cgc_cpf))),
                array(3,'columns',DV_form_input('Código RMS (*)', array('name' => 'T026_rms_codigo', 'class' => 'buscaFornecedor','readonly'=>'readonly'), NULL, set_value('T026_rms_codigo',$dados->T026_rms_codigo))),
                
                array('row'),
                
                array(5,'columns',DV_form_input('Razão Social', array('name' => 'T026_rms_razao_social','readonly'=>'readonly'), NULL, set_value('T026_rms_razao_social',$dados->T026_rms_razao_social))),
                
                array(4,'columns',DV_form_input('Incrição Estadual', array('name' => 'T026_rms_insc_est_ident','readonly'=>'readonly'), NULL, set_value('T026_rms_insc_est_ident',$dados->T026_rms_insc_est_ident))),
                array(4,'columns',DV_form_input('Inscrição Municipal', array('name' => 'T026_rms_insc_mun','readonly'=>'readonly'), NULL, set_value('T026_rms_insc_mun',$dados->T026_rms_insc_mun))),

            )),
        );

        $arr_tp_nota = array(
            '' => 'Selecione...',
            '1' => '001 - Serviços',
            '2' => '002 - Despesas',
        );

        $arr_frm_pagto = array(
            '' => 'Selecione...',
            '1' => '001 - Boleto',
            '2' => '002 - Depósito em C/C',
            '3' => '003 - Outros',
        );

        $tab['Dados Nota Fiscal'] = array(
            DV_form_fields(array(

                array(2,'columns',DV_form_input('Nota Fiscal', array('name' => 'T008_nf_numero'), NULL, set_value('T008_nf_numero',$dados->T008_nf_numero))),
                array(2,'columns',DV_form_input('Série', array('name' => 'T026_nf_serie'), NULL, set_value('T026_nf_serie',$dados->T026_nf_serie))),
                array(2,'columns',DV_form_input('Fatura', array('name' => 'T008_ft_numero'), NULL, set_value('T008_ft_numero',$dados->T008_ft_numero))),
                array(4,'columns',DV_form_dropdown('Tipo da Nota', 'T008_tp_nota', $arr_tp_nota, array(), set_value('T008_tp_nota',$dados->T008_tp_nota))),

                array('row'),

                array(3,'columns',DV_form_input('Data Emissão (*)', array('name' => 'T008_nf_dt_emiss', 'class' => 'data customDate'), NULL, set_value('T008_nf_dt_emiss',$dados->T008_nf_dt_emiss))       ),
                array(3,'columns',DV_form_input('Data Recebimento (*)', array('name' => 'T008_nf_dt_receb', 'class' => 'data customDate'), NULL, set_value('T008_nf_dt_receb',$dados->T008_nf_dt_receb))   ),
                array(3,'columns',DV_form_input('Data Vencimento (*)', array('name' => 'T008_nf_dt_vencto', 'class' => 'data customDate'), NULL, set_value('T008_nf_dt_vencto',$dados->T008_nf_dt_vencto))  ),

                array('row'),

                array(2,'columns',DV_form_input('Valor (*)', array('name' => 'T008_nf_valor_bruto', 'class' => 'valor'), NULL, set_value('T008_nf_valor_bruto',$dados->T008_nf_valor_bruto))),
                array(4,'columns',DV_form_dropdown('Forma de Pagamento', 'T008_forma_pagto', $arr_frm_pagto, array(), set_value('T008_forma_pagto',$dados->T008_forma_pagto))),

                array(4,'columns',DV_form_dropdown_lojas(array('class' => 'cmb_loja','disabled'=>'disabled'), set_value('T006_codigo',$dados->T006_codigo))),
                array(2,'columns',DV_form_input('Nº do Contrato', array('name' => 'T008_num_contrato'), NULL, set_value('T008_num_contrato',$dados->T008_num_contrato))),

                array('row'),

                array(6,'columns',DV_form_radio('Característica', array('name' => 'T008_tp_despesa', 'id' => 'radio'), array('Eventual', 'Por demanda', 'Regular'), array(1, 2, 3), set_value('T008_tp_despesa',$dados->T008_tp_despesa))),
                array(4,'columns',DV_form_dropdown_categoria_fornecedor(array(), set_value('T120_codigo',$dados->T120_codigo))),

            ))
        );
        
        $tab['Informações / Descrições'] = array(
            DV_form_fields(array(
                array(6,'',DV_form_textarea('Detalhes', array('name' => 'T008_desc'), NULL, set_value('T008_desc',$dados->T008_desc), 'style="width:600px;"')), 

                array('row'),
               
                array(6,'',DV_form_textarea('Justificativas', array('name' => 'T008_justificativa'), NULL, set_value('T008_justificativa',$dados->T008_justificativa), 'style="width:600px;"')),
               
                array('row'),
               
                array(6,'',DV_form_textarea('Instruções', array('name' => 'T008_inst_controladoria'), NULL, set_value('T008_inst_controladoria',$dados->T008_inst_controladoria), 'style="width:600px;"')),
               
                array('row'),
               
                array(6,'',DV_form_textarea('Controladoria', array('name' => 'T008_dados_controladoria'), NULL, set_value('T008_dados_controladoria',$dados->T008_dados_controladoria), 'style="width:600px;"'))
            )),
        );

        echo DV_tabs($tab);

        echo DV_form_close();
        
        break;

    case 'detalhes':

        echo DV_form_open('C0016/detalhes/' . $this->uri->segment(3));       
        
        $tab['Dados Fornecedor'] = array(
            DV_form_fields(array(
                array(4,'columns',DV_form_input('CNPJ (*)', array('name' => 'T026_rms_cgc_cpf', 'class' => 'buscaFornecedor cnpj','disabled'=>'disabled'), NULL, set_value('T026_rms_cgc_cpf',$dados->T026_rms_cgc_cpf))),
                array(3,'columns',DV_form_input('Código RMS (*)', array('name' => 'T026_rms_codigo', 'class' => 'buscaFornecedor','disabled'=>'disabled'), NULL, set_value('T026_rms_codigo',$dados->T026_rms_codigo))),
                
                array('row'),
                
                array(5,'columns',DV_form_input('Razão Social', array('name' => 'T026_rms_razao_social','disabled'=>'disabled'), NULL, set_value('T026_rms_razao_social',$dados->T026_rms_razao_social))),
                
                array(4,'columns',DV_form_input('Incrição Estadual', array('name' => 'T026_rms_insc_est_ident','disabled'=>'disabled'), NULL, set_value('T026_rms_insc_est_ident',$dados->T026_rms_insc_est_ident))),
                array(4,'columns',DV_form_input('Inscrição Municipal', array('name' => 'T026_rms_insc_mun','disabled'=>'disabled'), NULL, set_value('T026_rms_insc_mun',$dados->T026_rms_insc_mun))),

            )),
        );

        $arr_tp_nota = array(
            '' => 'Selecione...',
            '1' => '001 - Serviços',
            '2' => '002 - Despesas',
        );

        $arr_frm_pagto = array(
            '' => 'Selecione...',
            '1' => '001 - Boleto',
            '2' => '002 - Depósito em C/C',
            '3' => '003 - Outros',
        );

        $tab['Dados Nota Fiscal'] = array(
            DV_form_fields(array(

                array(2,'columns',DV_form_input('Nota Fiscal', array('name' => 'T008_nf_numero','disabled'=>'disabled'), NULL, set_value('T008_nf_numero',$dados->T008_nf_numero))),
                array(2,'columns',DV_form_input('Série', array('name' => 'T026_nf_serie','disabled'=>'disabled'), NULL, set_value('T026_nf_serie',$dados->T026_nf_serie))),
                array(2,'columns',DV_form_input('Fatura', array('name' => 'T008_ft_numero','disabled'=>'disabled'), NULL, set_value('T008_ft_numero',$dados->T008_ft_numero))),
                array(4,'columns',DV_form_dropdown('Tipo da Nota', 'T008_tp_nota', $arr_tp_nota, array('disabled' => 'disabled'), set_value('T008_tp_nota',$dados->T008_tp_nota))),

                array('row'),

                array(3,'columns',DV_form_input('Data Emissão (*)', array('name' => 'T008_nf_dt_emiss', 'class' => 'data customDate','disabled'=>'disabled'), NULL, set_value('T008_nf_dt_emiss',$dados->T008_nf_dt_emiss))       ),
                array(3,'columns',DV_form_input('Data Recebimento (*)', array('name' => 'T008_nf_dt_receb', 'class' => 'data customDate','disabled'=>'disabled'), NULL, set_value('T008_nf_dt_receb',$dados->T008_nf_dt_receb))   ),
                array(3,'columns',DV_form_input('Data Vencimento (*)', array('name' => 'T008_nf_dt_vencto', 'class' => 'data customDate','disabled'=>'disabled'), NULL, set_value('T008_nf_dt_vencto',$dados->T008_nf_dt_vencto))  ),

                array('row'),

                array(2,'columns',DV_form_input('Valor (*)', array('name' => 'T008_nf_valor_bruto', 'class' => 'valor'), NULL, set_value('T008_nf_valor_bruto',$dados->T008_nf_valor_bruto))),
                array(4,'columns',DV_form_dropdown('Forma de Pagamento', 'T008_forma_pagto', $arr_frm_pagto, array('disabled' => 'disabled'), set_value('T008_forma_pagto',$dados->T008_forma_pagto))),

                array(4,'columns',DV_form_dropdown_lojas(array('class' => 'cmb_loja','disabled'=>'disabled'), set_value('T006_codigo',$dados->T006_codigo))),
                array(2,'columns',DV_form_input('Nº do Contrato', array('name' => 'T008_num_contrato'), NULL, set_value('T008_num_contrato',$dados->T008_num_contrato))),

                array('row'),               
                
                array(6,'columns',DV_form_radio('Característica', array('name' => 'T008_tp_despesa', 'id' => 'radio', 'disabled'=>'disabled'), array('Eventual', 'Por demanda', 'Regular'), array(1, 2, 3), set_value('T008_tp_despesa',$dados->T008_tp_despesa))),
                array(4,'columns',DV_form_dropdown_categoria_fornecedor(array('disabled'=>'disabled'), set_value('T120_codigo',$dados->T120_codigo))),

            ))
        );                
        
        $tab['Grupo Workflow'] = array(
            DV_form_fields(array(
               array(6,'columns',  DV_form_dropdown_grp_workflow('T059_codigo', 'T059_nome', 'Grupo Workflow', 'T059_codigo',array('disabled' => 'disabled'),set_value('T059_codigo', $dados->T059_codigo))), 
            )),
        );        

        $tab['Informações / Descrições'] = array(
            DV_form_fields(array(
                array(6,'',DV_form_textarea('Detalhes', array('name' => 'T008_desc','disabled'=>'disabled'), NULL, set_value('T008_desc',$dados->T008_desc), 'style="width:600px;"')), 

                array('row'),
               
                array(6,'',DV_form_textarea('Justificativas', array('name' => 'T008_justificativa','disabled'=>'disabled'), NULL, set_value('T008_justificativa',$dados->T008_justificativa), 'style="width:600px;"')),
               
                array('row'),
               
                array(6,'',DV_form_textarea('Instruções', array('name' => 'T008_inst_controladoria','disabled'=>'disabled'), NULL, set_value('T008_inst_controladoria',$dados->T008_inst_controladoria), 'style="width:600px;"')),
               
                array('row'),
               
                array(6,'',DV_form_textarea('Controladoria', array('name' => 'T008_dados_controladoria','disabled'=>'disabled'), NULL, set_value('T008_dados_controladoria',$dados->T008_dados_controladoria), 'style="width:600px;"'))
            )),
        );

        echo DV_tabs($tab);

        echo DV_form_close();

        break;

    case 'cancelar':

        echo '<div>Tem certeza que deseja cancelar as Ap(s) selecionadas?</div>';

    break;

    case 'transferir':

        echo DV_form_open();
                
        echo DV_form_fields(array(
            array(10,'',DV_form_dropdown_grp_workflow('T059_codigo', 'T059_nome', 1, 'Grupo Workflow', 'T059_codigo',array(),array(),8))
        ));
                    
        echo DV_form_close();
        
        break;

    case 'excluir_arquivo':

        echo '<div>Tem certeza que deseja excluir o arquivo?</div>';
            
        break;

    case 'aprovar':

        echo '<div>Tem certeza que deseja aprovar as Ap(s) selecionadas?</div>';

        break;

    case 'fluxo':

        $query  =   $dados;
        
        //Consutrução da Tabela em HTML
        echo DV_construct_table_vw('T059_codigo', //Id de Referencia do Item na tabela
                //Cabeçalho da Tabela
                array(  'Sequência',
                        'Grupo',
                        'Aprovação',
                ),
                //Corpo da Tabela (campos da tabela)
                array(  'T008_T060_ordem',
                        array('DV_formata_codigo_nome'=>array('T059_codigo','T059_nome')),
                        array('<strong>Em: </strong>'                             
                             ,array('DV_format_field_vw'=>array(array('T008_T060_dt_aprovacao'),'datetime'))
                             ,'<strong> Por: </strong> '
                             ,'T004_nome'
                             ) 
                ),
                //Seleção de Dados
                $query
                ,FALSE
        );
        
        break;

    case 'upload':
        
        echo '<div class="row">';
        
        //Resgata Msgs
        echo DV_get_msg('msgok', TRUE);
        echo DV_get_msg('msgerro', TRUE);

        echo form_open_multipart('', array('class' => 'form_upload'));

        echo '<div class="small-8 large-8">';
        
        echo DV_form_dropdown_tp_arquivo(array(), array(), NULL, TRUE);

        echo form_upload(array('name' => 'arquivo'), set_value('arquivo'));

        echo form_submit('upload');

        echo '</div>';

        echo form_close();

        echo '<div class="small-5 large-5">';

        echo '<div class="progress">';
        echo '<div class="bar"></div>';
        echo '<div class="percent">0%</div >';
        echo '</div>';
        echo '</div>';

        break;

    case 'imprimir':

        //Variaveis
            
        switch ($dados->T008_forma_pagto){
            case 'BOLETO':
                $forma_pagto    =   'BOLETO';
            break;

            case 'DEPÓSITO':
                $forma_pagto    =   'DEPÓSITO';
            break;
            
            case 'OUTROS':
                $forma_pagto    =   'OUTROS';
            break;
            default:
                $forma_pagto    =   '';
            break;
            
        }
        
        switch ($dados->T008_tp_despesa){
            case '1':
                $tp_despesa    =   'EVENTUAL';
            break;

            case '2':
                $tp_despesa    =   'POR DEMANDA';
            break;
            
            case '3':
                $tp_despesa    =   'REGULAR';
            break;
            default:
                $tp_despesa    =   '';
            break;        
            
        }
        
        switch ($dados->T008_tp_nota){
            case '1':
                $tp_nota    =   'SERVIÇO';
            break;

            case '2':
                $tp_nota    =   'DESPESA';
            break;
            
        }  
        
        //Dados da Aprovação (Ordem 1)
        $query_approval =   $this->M16->get_approval_first($dados->T008_codigo);
        $user_approval  =   '';
        $date_approval  =   '';
        if($query_approval){
            $user_approval  =   $this->msis->get_name_user($query_approval->T004_login)->row()->T004_nome;
            $date_approval  =   DV_format_field_vw($query_approval,array('T008_T060_dt_aprovacao'),'date')->T008_T060_dt_aprovacao;
        }
            
        //Header
        $this->pdf->fontpath = 'font/';
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Image('images/logo_davo.jpg', 10, 5, 20);
        $this->pdf->SetFont('Arial', 'B', 20);
        $this->pdf->Cell(30);
        $this->pdf->Cell(120, 15, utf8_decode("APROVAÇÃO DE PAGAMENTO "), 0, 0, "L");
        $this->pdf->Cell(0, 15, utf8_decode("N° ".$dados->T008_codigo), 0, 1, "R");
        $this->pdf->Line(10, 32, 200, 32);
        $this->pdf->Ln(8);

        //Body
        $this->pdf->Ln(2);

        $this->pdf->SetFont('arial', 'B', 10);
        $this->pdf->Cell(135, 5, 'FORNECEDOR', "TLR", 0, "L");
        $this->pdf->Cell(55, 5, utf8_decode('CÓDIGO INTRANET / RMS'), "TLR", 1, "L");

        $this->pdf->SetFont('arial', '', 9);
        $this->pdf->Cell(135, 5, utf8_decode($dados->T026_rms_razao_social), "BRL", 0, "L");
        $this->pdf->Cell(55, 5, utf8_decode($dados->T026_codigo).' / '.utf8_decode($dados->T026_rms_codigo).'-'.utf8_decode($dados->T026_rms_digito), "BLR", 1, "L");

        $this->pdf->Ln(2);

        $this->pdf->SetFont('arial', 'B', 10);
        $this->pdf->Cell(64, 5, 'CNPJ / CPF', "TLR", 0, "L");
        $this->pdf->Cell(63, 5, 'I.E.', "TLR", 0, "L");
        $this->pdf->Cell(63, 5, 'I.M. / R.G', "TLR", 1, "L");

        $this->pdf->SetFont("arial", "", 9);
        $this->pdf->Cell(64, 5, $dados->T026_rms_cgc_cpf, "BLR", 0, "L");
        $this->pdf->Cell(63, 5, utf8_decode($dados->T026_rms_insc_est_ident), "BLR", 0, "L");
        $this->pdf->Cell(63, 5, utf8_decode($dados->T026_rms_insc_mun), "BLR", 1, "L");

        $this->pdf->Ln(2);

        $this->pdf->SetFont("arial", "B", 10);
        $this->pdf->Cell(100, 5, "NOTA FISCAL", "TLR", 0, "L");
        $this->pdf->Cell(20, 5, utf8_decode('SÉRIE'), "TLR", 0, "L");
        $this->pdf->Cell(70, 5, "FATURA", "TLR", 1, "L");

        $this->pdf->SetFont("arial", "", 9);
        $this->pdf->Cell(100, 5, utf8_decode($dados->T008_nf_numero), "BLR", 0, "L");
        $this->pdf->Cell(20, 5, utf8_decode($dados->T026_nf_serie), "BLR", 0, "L");
        $this->pdf->Cell(70, 5, utf8_decode($dados->T008_ft_numero), "BLR", 1, "L");

        $this->pdf->Ln(2);

        $this->pdf->SetFont("arial", "B", 10);
        $this->pdf->Cell(20, 5, 'DT EMISS', "TLR", 0, "L");
        $this->pdf->Cell(20, 5, "DT RECB", "TLR", 0, "L");
        $this->pdf->Cell(20, 5, "DT VENC", "TLR", 0, "L");
        $this->pdf->Cell(40, 5, 'VALOR:', "TLR", 0, "L");
        $this->pdf->Cell(50, 5, 'FORMA DE PAGAMENTO:', "TLR", 0, "L");
        $this->pdf->Cell(40, 5, "TIPO DA NOTA", "TLR", 1, "L");
        
        $this->pdf->SetFont("arial", "", 9);
        $this->pdf->Cell(20, 5, $dados->T008_nf_dt_emiss, "BLR", 0, "L");
        $this->pdf->Cell(20, 5, $dados->T008_nf_dt_receb, "BLR", 0, "L");
        $this->pdf->Cell(20, 5, $dados->T008_nf_dt_vencto, "BLR", 0, "L");
        $this->pdf->Cell(40, 5, $dados->T008_nf_valor_bruto, "BLR", 0, "L");
        $this->pdf->Cell(50, 5, utf8_decode($forma_pagto), "BLR", 0, "L");
        $this->pdf->Cell(40, 5, utf8_decode($tp_nota), "BLR", 1, "L");

        $this->pdf->Ln(2);

        $this->pdf->SetFont("arial", "B", 10);
        $this->pdf->Cell(80, 5, "LOJA FATURADA:", "TLR", 0, "L");
        $this->pdf->Cell(70, 5, utf8_decode('CARACTERÍSTICA DA DESPESA'), "TLR", 0, "L");
        $this->pdf->Cell(40, 5, "NUM. CONTRATO", "TLR", 1, "L");

        $this->pdf->SetFont("arial", "", 9);
        $this->pdf->Cell(80, 5, utf8_decode(DV_formata_codigo_nome($dados->T006_codigo, $dados->T006_nome)), "BLR", 0, "L");
        $this->pdf->Cell(70, 5, utf8_decode($tp_despesa), "BLR", 0, "L");
        $this->pdf->Cell(40, 5, utf8_decode($dados->T008_num_contrato), "BLR", 1, "L");

        $this->pdf->Ln(2);

        $this->pdf->SetFont("arial", "B", 10);
        $this->pdf->Cell(80, 5, 'CATEGORIA DA DESPESA', "TLR", 1, "L");

        $this->pdf->SetFont("arial", "", 9);
        $this->pdf->Cell(80, 5, utf8_decode(DV_formata_codigo_nome($dados->T120_codigo, $dados->T120_nome)), "BLR", 1, "L");

        $this->pdf->Ln(5);

        $this->pdf->SetFont("arial", "B", 8);
        $this->pdf->Write(5, utf8_decode('DETALHES (Detalhamento do serviço contratado, competência ou período de execução, mencionar anexos que seguem e demais conteúdos.):'));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "", 8);
        $this->pdf->Write(5, utf8_decode($dados->T008_desc));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "B", 8);
        $this->pdf->Write(5, utf8_decode('JUSTIFICATIVA/CONSIDERAÇÕES RELEVANTES A CONTRATAÇÃO'));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "", 8);
        $this->pdf->Write(5, utf8_decode($dados->T008_justificativa));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "B", 8);
        $this->pdf->Write(5, utf8_decode('INSTRUÇÕES P/ CONTROLADORIA/FINANCEIRO'));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "", 8);
        $this->pdf->Write(5, utf8_decode($dados->T008_inst_controladoria));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "B", 8);
        $this->pdf->Write(5, utf8_decode('ESPAÇO RESERVADO A CONTROLADORIA (AGENDA, NÚMERO, SÉRIE, DATA DE AGENDA, CONTA CONTABÍL, CONTROLES INTERNOS, ETC.):'));
        $this->pdf->Ln(8);

        $this->pdf->SetFont("arial", "", 8);
        $this->pdf->Write(5, utf8_decode($dados->T008_dados_controladoria));
        $this->pdf->Ln(10);

        //Footer
        $this->pdf->SetY(-71);
        
        $this->pdf->SetFont("arial", "B", 7);
        $this->pdf->Cell(47, 35, "", 1, 0, "L");
        $this->pdf->Cell(47, 35, "", 1, 0, "L");
        $this->pdf->Cell(47, 35, "", 1, 0, "L");
        $this->pdf->Cell(48, 35, "", 1, 1, "L");

        $this->pdf->SetFont("arial", "", 6);
        $this->pdf->Cell(47, 5, "Elaborada por: ".$this->msis->get_name_user($dados->T004_login)->row()->T004_nome, "TLR", 0, "C");
        $this->pdf->Cell(47, 5, utf8_decode("Aprovação"), "TLR", 0, "C");
        $this->pdf->Cell(47, 5, utf8_decode("Controladoria (Lançamento)"), "TLR", 0, "C");
        $this->pdf->Cell(48, 5, "Financeiro", "TLR", 1, "C");
        
        $this->pdf->SetFont("arial","",6);
        $this->pdf->Cell(47,5,"Conferida por: ".$user_approval,"LR",0,"C");
        $this->pdf->Cell(47,5,"","LR",0,"C");
        $this->pdf->Cell(47,5,"","LR",0,"C");
        $this->pdf->Cell(48,5,"","LR",1,"C");        
        
        $this->pdf->SetFont("arial", "", 6);
        $this->pdf->Cell(47, 5, "Em: ".$date_approval, "BLR", 0, "C");
        $this->pdf->Cell(47, 5, "", "BLR", 0, "C");
        $this->pdf->Cell(47, 5, "", "BLR", 0, "C");
        $this->pdf->Cell(48, 5, "", "BLR", 1, "C");

        $this->pdf->Output();
        
        break;

endswitch;