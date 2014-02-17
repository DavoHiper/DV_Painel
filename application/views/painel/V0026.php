<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

switch ($tela):

    case 'listar':
               
        //Query do filtro guardada em uma seção (session[filtro])
        $filter = $this->session->userdata('filtroDespesa');
        $qtLine = 11;
        $status = $filter['status'];

        ($this->uri->segment(3) != '') ? $init = $this->uri->segment(3) : $init = 0;
        $query  =   NULL;
        $qtRecords = NULL;
        switch ($status) {
            case 1:

                $query =  $this->M26->get_awaiting_approval(0, 0, $filter); 
                
                if($query->num_rows>0)
                    $qtRecords = $query->num_rows;                                                
                else
                    $qtRecords  =   0;
                
                $query = $this->M26->get_awaiting_approval($qtLine, $init, $filter);
                
                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
                    DV_botao_acao(FALSE, 'aprovar           no-multiple ', 'check', 'Aprovar', 'aprovar'),
                ));
                
                break;
            case 2:

                $query =  $this->M26->get_my_typed(0, 0, $filter); 
                
                if($query->num_rows>0)
                    $qtRecords = $query->num_rows;                                                
                else
                    $qtRecords  =   0;
                
                $query = $this->M26->get_my_typed($qtLine, $init, $filter);
                
                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                    DV_botao_acao(FALSE, 'editar            no-multiple ', 'pencil', 'Editar', 'editar'),
                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                    DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                    DV_botao_acao(FALSE, 'upload            no-multiple ', 'pin-s', 'Anexar', 'upload'),
                    DV_botao_acao(FALSE, 'imprimir          no-multiple ', 'print', 'Imprimir', 'imprimir', '_blank'),
                    DV_botao_acao(FALSE, 'aprovar           no-multiple    ', 'check', 'Aprovar', 'aprovar'),
                ));                
                
                break;                
            case 3:

                $query =  $this->M26->get_previous(0, 0, $filter); 
                
                if($query->num_rows>0)
                    $qtRecords = $query->num_rows;                                                
                else
                    $qtRecords  =   0;
                
                $query = $this->M26->get_previous($qtLine, $init, $filter);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                    ', 'triangle-2-n-s' , 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                              ', 'plusthick'      , 'Novo'            , 'novo'),
                    DV_botao_acao(FALSE, 'detalhes              no-multiple ', 'search'         , 'Detalhes'        , 'detalhes'),
                    DV_botao_acao(FALSE, 'revisar               no-multiple ', 'flag'           , 'Revisar'         , 'revisar'),
                    DV_botao_acao(FALSE, 'cancelar          multiple    ', 'cancel', 'Cancelar', 'cancelar'),
                ));                
                
                break;
            case 4:

                $query =  $this->M26->get_later(0, 0, $filter); 
                
                if($query->num_rows>0)
                    $qtRecords = $query->num_rows;                                                
                else
                    $qtRecords  =   0;
                
                $query = $this->M26->get_later($qtLine, $init, $filter);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                        DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                        DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                        DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                ));                 
                
                break;
            case 5:

                $query =  $this->M26->get_finalized(0, 0, $filter); 
                
                if($query->num_rows>0)
                    $qtRecords = $query->num_rows;                                                
                else
                    $qtRecords  =   0;
                
                $query = $this->M26->get_finalized($qtLine, $init, $filter);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                        DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                        DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                        DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                ));                  
                
                break;
            case 6:

                $query =  $this->M26->get_canceled(0, 0, $filter); 
                
                if($query->num_rows>0)
                    $qtRecords = $query->num_rows;                                                
                else
                    $qtRecords  =   0;
                
                $query = $this->M26->get_canceled($qtLine, $init, $filter);

                //Cria Barar de Botões
                echo DV_barra_botoes(array(
                        DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                        DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                        DV_botao_acao(FALSE, 'detalhes          no-multiple ', 'search', 'Detalhes', 'detalhes'),
                ));                  
                
                break;
            default:
                
                $qtRecords  =   0;
                
                echo DV_barra_botoes(array(
                    DV_botao_acao(FALSE, 'ocultarFiltros                ', 'triangle-2-n-s', 'Ocultar Filtros'),
                    DV_botao_acao(FALSE, 'novo                          ', 'plusthick', 'Novo', 'novo'),
                ));   
                
                break;                
        }

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');

        echo DV_paginacao($qtRecords, $qtLine);

        $arr_status = array(
            '' => 'Selecione...',
            '1' => 'Aguardando minha aprovação',
            '2' => 'Minhas Digitadas',
            '3' => 'Anteriores à mim',
            '4' => 'Posteriores à mim',
            '5' => 'Finalizadas',
            '6' => 'Canceladas',
        );

        //Cria formulário de Filtros               
        echo DV_form_open('','','id="filters"');
                
        echo DV_form_fields(array(
            array(3,'columns',DV_form_dropdown('Status', 'status', $arr_status, array(), DV_set_value('status', $filter))),
            array(1,'columns',DV_form_input('Despesa', array('name' => 'T016_codigo'), NULL, DV_set_value('T016_codigo', $filter))),
            array(2,'columns',DV_form_input('Data Lançamento', array('name' => 'T016_dt_lancamento', 'class'=>'customDate'), NULL, DV_set_value('T016_dt_lancamento', $filter))),
            array(2,'columns',DV_form_input('Elaborador', array('name' => 'T004_login'), NULL, DV_set_value('T004_login', $filter))),
            array(1,'columns',DV_form_submit('Filtrar', array('name' => 'filtrar'))),
        ));
        
        echo DV_form_close();

        ($this->uri->segment(3) != '') ? $init = $this->uri->segment(3) : $init = 0;

        $html    =   '<div id="tableFilter" class="small-12 large-12 columns">';

        $html   .=   '<table class="small-12 large-12 data-table">';

        $html   .=  '<thead>';
        $html   .=  '<tr>';
        $html   .=  '<th>'.form_checkbox(array('id' => 'chkAll')).'</th>'; 
        $html   .=  '<th>Despesa Nº</th>';
        $html   .=  '<th></th>';
        $html   .=  '<th>Elaborado Por</th>';
        $html   .=  '<th>Data Lançamento</th>';
        $html   .=  '<th>Última Etapa</th>';
        $html   .=  '<th>Valor</th>';
        $html   .=  '<th>Arquivos</th>';
        $html   .=  '<tr>';

        $html   .=  '<tbody>';      
        
        if(!empty($query->num_rows)>0){
                       
            foreach($query->result() as $row){
                            
                $html   .=  '<tr>';
                
                if(isset($row->T060_codigo)){
                    $T060_codigo   =  '<td>'.$row->T060_codigo.'</td>';
                    $stage  =   $row->T060_codigo;
                }else
                {
                    $T060_codigo   =  '<td>000 - Digitada</td>';
                    $stage  =   0;
                }                
                
                $idRef  = json_encode(array(
                    'expense'=>$row->T016_codigo,
                    'stage'=>$stage,
                ));
                   
                if($this->M26->check_status_km($row->T016_codigo,2)->num_rows>0 || $this->M26->check_status_div($row->T016_codigo,2)->num_rows>0){
                    $icon   =   DV_button_icon(array('flag red'), array(''), array('Revisar'));
                }else{
                    $icon   =   '';
                }                
                
                $html   .=  '<td class="idRef" style="display:none;">'.$row->T016_codigo.'</td>';
                $html   .=  '<td class="arrRef" style="display:none;">'.$idRef.'</td>';
                
                $html   .=  '<td>'.form_checkbox(array('class' => 'chkItm')).'</td>';                
                $html   .=  "<td>$row->T016_codigo</td>";
                $html   .=  "<td>$icon</td>";
                $html   .=  "<td>".$this->msis->get_name_user($row->T004_login)->row()->T004_nome." (".$row->T004_login.")"."</td>";
                $html   .=  "<td>$row->T016_dt_lancamento</td>";
                $html   .=  $T060_codigo;
                $html   .=  "<td>$row->T016_vl_total_geral</td>";
                                
                $query_files    =   $this->M26->get_files($row->T016_codigo);                                
                
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
        
        echo '<div class="row">';

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');        
        
        if($this->M26->get_awaiting_approval(0, 0)->num_rows>0){            
            echo DV_msg('Aviso: Você tem aprovaçõe(s) pendente(s)');
        }
                
        echo DV_form_open('C0026/novo');
        
        $user   =   $this->session->userdata('user');  
        $parameter  =   $this->msis->get_parameter_present(0,7,  DV_format_datetime(date('d/m/Y')))->T089_valor;
        
        echo form_hidden('T004_login', $user);
        echo form_hidden('T016_status', 0);
        
        echo DV_form_fields(array(
            array(2,'columns',  DV_form_input('CPF', array('name'=>'T016_cpf','class'=>'cpf'), NULL, set_value('T016_cpf'))),
            array(5,'columns',  DV_form_input('Nome Colaborador', array('name'=>'nome','class'=>'nome','readonly'=>'readonly'), NULL, set_value('nome'))),
            array(2,'columns',  DV_form_input('Valor Km', array('name'=>'valor_km','readonly'=>'readonly','class'=>'valor'), NULL, set_value('valor_km',$parameter))),
        ));
        
        echo '<div id="botoes" style="display:none;">';

        echo DV_form_fields(array(
            array('large-3 small-3 columns',  DV_form_input('Data Ocorrência', array('name'=>'T016_dt_lancamento','class'=>'customDate'), NULL, set_value('T016_dt_lancamento'))),            
            array('small-3 large-3 columns left',  DV_botao_acao(FALSE, 'add_depesa_km', 'plus', 'Adicionar Despesa', 'add_despesa_km'),'margin-top:24px;'),
            array('small-4 large-4 columns left',  DV_botao_acao(FALSE, 'add_depesa_div', 'plus', 'Adicionar Despesa Diversa', 'add_despesa_div'),'margin-top:24px;'),

        ));  
        
        echo '</div>';

        echo '<div id="dadosKm" style="display:none;">';
        
        echo '<label style="margin-left:10px;">Despesas com Km</label>';

        echo    '   <table id="table_desp_km" style="margin-left: 5px;margin-right: 15px;">
                        <thead>
                            <tr>
                                <th>Loja Origem</th>
                                <th>Data/Hora Saída</th>
                                <th>Loja Destino</th>
                                <th>Data/Hora Chegada</th>                                                
                                <th style="width:300px;">Histórico</th>
                                <th>Distância (Km)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="despesaKm">
                        </tbody>
                    </table>';  

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Despesa Km', array('name'=>'T016_vl_total_km','class'=>'valor total_km'))),

        ));
        
        echo '</div>';
        echo '<div id="dadosDiv" style="display:none;">';

        echo '<label style="margin-left:10px;">Despesas Diversas</label>';

        echo    '   <table id="table_desp_div" style="margin-left: 5px;margin-right: 15px;">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th style="width:270px;">Conta</th>
                                <th style="width:270px;">Histórico</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="despesaDiv">
                        </tbody>
                    </table>';        

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Despesas Diversas', array('name'=>'T016_vl_total_diversos','class'=>'valor total_div'))),

        ));     
        
        echo '</div>';

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Geral', array('name'=>'T016_vl_total_geral','class'=>'valor'),NULL,  set_value('T016_vl_total_geral'))),

        ));         
                                
        echo DV_form_close();
        
        echo '</div>';
        
        break;
    
    case 'despesa_km':

        echo DV_form_open('C0026/despesa_km');
        
        if(set_value('T006_codigo_origem')==999)
            $selectOrigem  =   '<div id="externoOrig">'.DV_form_input('Externo Origem (*)', array('name'=>'T015_T016_origem'), NULL, set_value('T015_T016_origem')).'</div>';
        else
            $selectOrigem  =   '';
            
        if(set_value('T006_codigo_destino')==999)
            $selectDestino  =   '<div id="externoDest">'.DV_form_input('Externo Destino (*)', array('name'=>'T015_T016_destino'), NULL, set_value('T015_T016_destino')).'</div>';
        else
            $selectDestino  =   '';
            
        
        echo DV_form_fields(array(
            
            array(6,'columns',DV_form_dropdown_lojas(array('class'=>''), set_value('T006_codigo_origem'),NULL,TRUE,'T006_codigo_origem','Origem').$selectOrigem),
            array(4,'columns',DV_form_input('Data/Hora Saída (*)', array('name' => 'T015_T016_saida', 'class' => 'customDatetime_limit'), NULL, set_value('T015_T016_saida'))),

            array('row'),
            
            array(6,'columns',DV_form_dropdown_lojas(array(), set_value('T006_codigo_destino'),NULL,TRUE,'T006_codigo_destino','Destino').$selectDestino),
            array(4,'columns',DV_form_input('Data/Hora Chegada (*)', array('name'=>'T015_T016_chegada','class'=>'customDatetime_limit'), NULL, set_value('T015_T016_chegada'))),
            
            array('row'),

            array(5,'columns',DV_form_textarea('Histórico (*)', array('name' => 'T015_T016_desc'), NULL, set_value('T015_T016_desc'))),

            array('row'),

            array(3,'columns',DV_form_input('Distância (*)', array('name'=>'T015_T016_km'), NULL, set_value('T015_T016_km'))),                

        ));    
        
        echo DV_form_close();
        
        
    break;
    
    case 'despesa_div':

        echo DV_form_open('C0026/despesa_div');
        
        echo DV_form_fields(array( 

            array(4,'columns',DV_form_input('Data (*)', array('name' => 'T017_data', 'class' => 'customDatetime_limit'), NULL, set_value('T017_data'))),
            array(8,'columns',DV_form_dropdown_contas_rms(array('class'=>''), set_value('T014_codigo'))),

            array('row'),

            array(5,'columns',DV_form_textarea('Histórico (*)', array('name' => 'T017_desc'), NULL, set_value('T017_desc'))),

            array('row'),

            array(3,'columns',DV_form_input('Valor (*)', array('name'=>'T017_valor','class'=>'valor'), NULL, set_value('T017_valor'))),                

        ));    
        
        echo DV_form_close();
        
        
    break;

    case 'editar':

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');
        
        echo '<div class="row">';
        
        echo DV_form_open('C0026/editar/' . $this->uri->segment(3));
        
        $user       =   $this->session->userdata('user');  
        $parameter  =   $this->msis->get_parameter_present(0,7,  $dados['cabec']->T016_dt_lancamento)->T089_valor;
        
        echo form_hidden('T004_login', $user);
        echo form_hidden('T016_status', 0);
        
        echo DV_form_fields(array(
            array(2,'columns',  DV_form_input('CPF', array('name'=>'T016_cpf','class'=>'cpf','disabled'=>'disabled'), NULL, set_value('T016_cpf',$dados['cabec']->T016_cpf))),
            array(5,'columns',  DV_form_input('Nome Colaborador', array('name'=>'nome','class'=>'nome','disabled'=>'disabled'), NULL, set_value('nome',$this->msis->get_name_user($dados['cabec']->T004_login)->row()->T004_nome))),
            array(2,'columns',  DV_form_input('Valor Km', array('name'=>'valor_km','disabled'=>'disabled','class'=>'valor'), NULL, set_value('valor_km',$parameter))),
        ));
        
        echo DV_form_fields(array(
            array('large-3 small-3 columns',  DV_form_input('Data Ocorrência', array('name'=>'T016_dt_lancamento','class'=>'customDate'), NULL, set_value('T016_dt_lancamento',$dados['cabec']->T016_dt_lancamento))),            
            array('small-3 large-3 columns left',  DV_botao_acao(FALSE, 'add_depesa_km', 'plus', 'Adicionar Despesa', 'add_despesa_km'),'margin-top:24px;'),
            array('small-4 large-4 columns left',  DV_botao_acao(FALSE, 'add_depesa_div', 'plus', 'Adicionar Despesa Diversa', 'add_despesa_div'),'margin-top:24px;'),

        ));  
        
        echo '<div id="dadosKm">';
        
        echo '<label style="margin-left:10px;">Deslocamentos</label>';

        echo    '   <table id="table_desp_km" style="margin-left: 5px;margin-right: 15px;">
                        <thead>
                            <tr>
                                <th>Loja Origem</th>
                                <th>Data/Hora Saída</th>
                                <th>Loja Destino</th>
                                <th>Data/Hora Chegada</th>                                                
                                <th style="width:300px;">Histórico</th>
                                <th>Distância (Km)</th>
                                <th>Observação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="despesaKm">';
        
        
       
        
        $i=0;
        if($dados['km']->num_rows()>0){
            foreach($dados['km']->result() as $row){
                
                if($row->T015_T016_status==1){
                    $cor    =   '#a1f99e';
                }elseif($row->T015_T016_status==2){
                    $cor    =   '#eca2a0';
                }else{
                    $cor    =   '';
                }                   
                
                echo '<tr style="background:'.$cor.'">';    

                    $saida      = DV_format_datetime_vw($row->T015_T016_saida);
                    $chegada    = DV_format_datetime_vw($row->T015_T016_chegada);
                
                    echo '<td style="display:none;" class="idRef">'.$row->T015_T016_seq          .'</td>';
                    echo '<input type="hidden" name="T015_T016_status[]"     value="'.$row->T015_T016_status.'"/>';
                    
                    echo '<td>'.$row->T006_codigo_origem    .'</td><input type="hidden" name="T006_codigo_origem[]"     value="'.$row->T006_codigo_origem.'"/>';
                    echo '<td>'.$saida                      .'</td><input type="hidden" name="T015_T016_saida[]"        value="'.$saida.'"/>';
                    echo '<td>'.$row->T006_codigo_destino   .'</td><input type="hidden" name="T006_codigo_destino[]"    value="'.$row->T006_codigo_destino.'"/>';
                    echo '<td>'.$chegada                    .'</td><input type="hidden" name="T015_T016_chegada[]"      value="'.$chegada.'"/>';
                    echo '<td>'.$row->T015_T016_desc        .'</td><input type="hidden" name="T015_T016_desc[]"         value="'.$row->T015_T016_desc.'"/>';
                    echo '<td>'.$row->T015_T016_km          .'</td><input type="hidden" name="T015_T016_km[]"           value="'.$row->T015_T016_km.'"/>';
                    echo '<td>'.$row->T015_T016_obs_status  .'</td><input type="hidden" name="T015_T016_obs_status[]"   value="'.$row->T015_T016_obs_status.'"/>';
                    echo '<td style="width:110px;">';
                    echo DV_button_icon(array('pencil'      ,'minus'  ,'flag green'   )
                                      , array('edit_line'   ,'remove' ,'revisado_km' )
                                      , array('Editar'      ,'Remover','Revisar'      ));
                    echo '</td>';

                echo '</tr>';
                $i++;
            }
        }
        
        
        echo '</tbody></table>';  

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Despesa Km', array('name'=>'T016_vl_total_km','class'=>'valor total_km total'),NULL,  set_value('T016_vl_total_km',  DV_format_decimal_vw($dados['cabec']->T016_vl_total_km)))),

        ));
        
        echo '</div>';
        echo '<div id="dadosDiv">';

        echo '<label style="margin-left:10px;">Despesas Diversas</label>';

        echo    '   <table id="table_desp_div" style="margin-left: 5px;margin-right: 15px;">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th style="width:270px;">Conta</th>
                                <th style="width:270px;">Histórico</th>
                                <th>Valor</th>
                                <th>Observação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="despesaDiv">';
                         
        $i = 0;
        if($dados['div']->num_rows()>0){
            foreach($dados['div']->result() as $row){

                if($row->T017_status==1){
                    $cor    =   '#a1f99e';
                }elseif($row->T017_status==2){
                    $cor    =   '#eca2a0';
                }else{
                    $cor    =   '';
                }                  
                
                echo '<tr style="background:'.$cor.'">';

                    $data   = DV_format_datetime_vw($row->T017_data);
                    $valor  = DV_format_decimal_vw($row->T017_valor);
                    
                    echo '<td style="display:none;" class="idRef">'.$row->T017_seq       .'</td>';
                    echo '<input type="hidden" name="T017_status[]"     value="'.$row->T017_status.'"/>';
                    echo '<td>'.$data.'</td><input type="hidden" name="T017_data[]"     value="'.$data.'"/>';
                    echo '<td>'.$row->T014_codigo.'</td><input type="hidden" name="T014_codigo[]"     value="'.$row->T014_codigo.'"/>';
                    echo '<td>'.$row->T017_desc.'</td><input type="hidden" name="T017_desc[]"     value="'.$row->T017_desc.'"/>';
                    echo '<td>'.$valor.'</td><input class="valor" type="hidden" name="T017_valor[]"     value="'.$valor.'"/>';                    
                    echo '<td>'.$row->T017_obs_status.'</td><input type="hidden" name="T017_obs_status[]"     value="'.$row->T017_obs_status.'"/>';
                    echo '<td style="width:110px;">';
                    echo DV_button_icon(array('pencil'          ,'minus'    ,'flag green'   )
                                      , array('edit_line_div'   ,'remove'   ,'revisado_div' )
                                      , array('Editar'          ,'Remover'  ,'Revisar'      ));
                    echo '</td>';

                echo '</tr>';            

                $i++;

            }
        }
                
        echo '</tbody></table>';        

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Despesas Diversas', array('name'=>'T016_vl_total_diversos','class'=>'valor total_div total'),NULL,  set_value('T016_vl_total_diversos',DV_format_decimal_vw($dados['cabec']->T016_vl_total_diversos)))),

        ));     
        
        echo '</div>';

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Geral', array('name'=>'T016_vl_total_geral','class'=>'valor'),NULL,  set_value('T016_vl_total_geral',DV_format_decimal_vw($dados['cabec']->T016_vl_total_geral)))),

        ));        
                                
        echo DV_form_close();
        
        echo '</div>';
        
        break;

    case 'detalhes':

        //Resgata Msgs
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');
        
        echo '<div class="row">';
        
        echo DV_form_open('C0026/detalhes/' . $this->uri->segment(3));
        
        $user       =   $this->session->userdata('user');  
        $parameter  =   $this->msis->get_parameter_present(0,7,  $dados['cabec']->T016_dt_lancamento)->T089_valor;
        
        echo form_hidden('T004_login', $user);
        echo form_hidden('T016_status', 0);
        
        echo DV_form_fields(array(
            array(2,'columns',  DV_form_input('CPF', array('name'=>'T016_cpf','class'=>'cpf','disabled'=>'disabled'), NULL, set_value('T016_cpf',$dados['cabec']->T016_cpf))),
            array(5,'columns',  DV_form_input('Nome Colaborador', array('name'=>'nome','class'=>'nome','disabled'=>'disabled'), NULL, set_value('nome',$this->msis->get_name_user($dados['cabec']->T004_login)->row()->T004_nome))),
            array(2,'columns',  DV_form_input('Valor Km', array('name'=>'valor_km','disabled'=>'disabled','class'=>'valor'), NULL, set_value('valor_km',$parameter))),
        ));
        
        echo DV_form_fields(array(
            array('large-3 small-3 columns',  DV_form_input('Data Lançamento (*)', array('name'=>'T016_dt_lancamento','class'=>'customDate','disabled'=>'disabled'), NULL, set_value('T016_dt_lancamento',$dados['cabec']->T016_dt_lancamento))),            
        ));  
        
        echo '<div id="dadosKm">';
        
        echo '<label style="margin-left:10px;">Despesas com Km</label>';

        echo    '   <table id="table_desp_km" style="margin-left: 5px;margin-right: 15px;">
                        <thead>
                            <tr>
                                <th>Loja Origem</th>
                                <th>Data/Hora Saída</th>
                                <th>Loja Destino</th>
                                <th>Data/Hora Chegada</th>                                                
                                <th style="width:300px;">Histórico</th>
                                <th>Distância (Km)</th>
                            </tr>
                        </thead>
                        <tbody id="despesaKm">';
        
        $i=0;
        if($dados['km']->num_rows()>0){
            foreach($dados['km']->result() as $row){
                echo '<tr>';

                    $saida      = DV_format_datetime_vw($row->T015_T016_saida);
                    $chegada    = DV_format_datetime_vw($row->T015_T016_chegada);
                
                    echo '<td>'.$row->T006_codigo_origem    .'</td><input type="hidden" name="T006_codigo_origem[]"     value="'.$row->T006_codigo_origem.'"/>';
                    echo '<td>'.$saida                      .'</td><input type="hidden" name="T015_T016_saida[]"        value="'.$saida.'"/>';
                    echo '<td>'.$row->T006_codigo_destino   .'</td><input type="hidden" name="T006_codigo_destino[]"    value="'.$row->T006_codigo_destino.'"/>';
                    echo '<td>'.$chegada                    .'</td><input type="hidden" name="T015_T016_chegada[]"      value="'.$chegada.'"/>';
                    echo '<td>'.$row->T015_T016_desc        .'</td><input type="hidden" name="T015_T016_desc[]"         value="'.$row->T015_T016_desc.'"/>';
                    echo '<td>'.$row->T015_T016_km          .'</td><input type="hidden" name="T015_T016_km[]"           value="'.$row->T015_T016_km.'"/>';

                echo '</tr>';
                $i++;
            }
        }
        
        
        echo '</tbody></table>';  

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Despesa Km', array('name'=>'T016_vl_total_km','class'=>'valor total_km total','disabled'=>'disabled'),NULL,  set_value('T016_vl_total_km',  DV_format_decimal_vw($dados['cabec']->T016_vl_total_km)))),

        ));
        
        echo '</div>';
        echo '<div id="dadosDiv">';

        echo '<label style="margin-left:10px;">Despesas Diversas</label>';

        echo    '   <table id="table_desp_div" style="margin-left: 5px;margin-right: 15px;">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th style="width:270px;">Conta</th>
                                <th style="width:270px;">Histórico</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody id="despesaDiv">';
        
        $i = 0;
        if($dados['div']->num_rows()>0){
            foreach($dados['div']->result() as $row){

                echo '<tr>';

                    $data   = DV_format_datetime_vw($row->T017_data);
                    $valor  = DV_format_decimal_vw($row->T017_valor);
                    
                    echo '<td>'.$data.'</td><input type="hidden" name="T017_data[]"     value="'.$data.'"/>';
                    echo '<td>'.$row->T014_codigo.'</td><input type="hidden" name="T014_codigo[]"     value="'.$row->T014_codigo.'"/>';
                    echo '<td>'.$row->T017_desc.'</td><input type="hidden" name="T017_desc[]"     value="'.$row->T017_desc.'"/>';
                    echo '<td>'.$valor.'</td><input class="valor" type="hidden" name="T017_valor[]"     value="'.$valor.'"/>';

                echo '</tr>';            

                $i++;

            }
        }
                
        echo '</tbody></table>';        

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Despesas Diversas', array('name'=>'T016_vl_total_diversos','class'=>'valor total_div total','disabled'=>'disabled'),NULL,  set_value('T016_vl_total_diversos',DV_format_decimal_vw($dados['cabec']->T016_vl_total_diversos)))),

        ));     
        
        echo '</div>';

        echo DV_form_fields(array(
            array('small-3 large-3 columns right', DV_form_input('Total Geral', array('name'=>'T016_vl_total_geral','class'=>'valor','disabled'=>'disabled'),NULL,  set_value('T016_vl_total_geral',DV_format_decimal_vw($dados['cabec']->T016_vl_total_geral)))),

        ));        
                                
        echo DV_form_close();
        
        echo '</div>';

        break;

    case 'cancelar':

        echo '<div>Tem certeza que deseja cancelar as Despesa(s) selecionadas?</div>';

    break;

    case 'excluir_arquivo':

        echo '<div>Tem certeza que deseja excluir o arquivo?</div>';
            
        break;

    case 'aprovar':

        echo '<div>Tem certeza que deseja aprovar a Despesa selecionada?</div>';

        break;

    case 'confirm_cpf':

        echo '<p>O CPF: '.$dados['cpf'].' pertence à: '.$dados['nome'].'?</p>';

        break;

    case 'revisar':

        echo '<div class="row">';
        
        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');
        
        echo DV_form_open('C0026/revisar');
               
        $html   =   '';
        
        
        $i = 0;
        foreach($dados['km']->result() as $row){            
            
            if($i==0){                                
                
                $html .=    '<label style="margin-left:10px;">Deslocamentos</label>';  
                
                $html .=   '    <table id="table_desp_km">
                                     <thead>
                                         <tr>
                                             <th>Loja Origem</th>
                                             <th>Data/Hora Saída</th>
                                             <th>Loja Destino</th>
                                             <th>Data/Hora Chegada</th>                                                
                                             <th style="width:300px;">Histórico</th>
                                             <th>Distância</th>
                                             <th style="width:300px;">Observação</th>
                                             <th>Ações</th>
                                         </tr>
                                     </thead>
                                     <tbody id="despesaKm">';                                                
            }
                 
            if($row->T015_T016_status==1){
                $cor    =   '#a1f99e';
            }elseif($row->T015_T016_status==2){
                $cor    =   '#eca2a0';
            }else{
                $cor    =   '';
            }                
                                       
            $html   .=  '<tr style="background:'.$cor.'">';

            $saida  =   DV_format_field_vw($row,array('T015_T016_saida'),'datetime');
            $chegada=   DV_format_field_vw($row,array('T015_T016_chegada'),'datetime');
                    
            $html   .=  '<td style="display:none;" class="idRef">'.$row->T015_T016_seq          .'</td>';
            $html   .=  '<td>'.$row->T006_codigo_origem     .'</td>';
            $html   .=  '<td>'.$saida                       .'</td>';
            $html   .=  '<td>'.$row->T006_codigo_destino    .'</td>';
            $html   .=  '<td>'.$chegada                     .'</td>';
            $html   .=  '<td>'.$row->T015_T016_desc         .'</td>';
            $html   .=  '<td>'.$row->T015_T016_km           .'</td>';
            $html   .=  '<td>'.DV_form_input('', array('name'=>'T015_T016_obs_status'), NULL, set_value('T015_T016_obs_status',$row->T015_T016_obs_status)).'</td>';
            $html   .=  '<td width="110px">';
            
            $html   .= DV_button_icon(array('flag red'), array('vetado_km'), array('Vetar')).'</td>';
            
            $html   .=  '</tr>';                     
            
            $i++;
            
        }
        
        $html  .=   '</tbody></table>';  
                                                      
        $i = 0;                
        foreach($dados['div']->result() as $row){            
            
            if($i==0){
                
                $html .=    '<label style="margin-left:10px;">Despesas</label>';  
                
                $html .=   '    <table id="table_desp_div">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Conta</th>
                                            <th style="width:300px;">Histórico</th>
                                            <th>Valor</th>                                                
                                            <th style="width:300px;">Observação</th>                                                
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="despesaDiv">';                
            }                        
            
            if($row->T017_status==1){
                $cor    =   '#a1f99e';
            }elseif($row->T017_status==2){
                $cor    =   '#eca2a0';
            }else{
                $cor    =   '';
            }    
            
            $html   .=  '<tr style="background:'.$cor.'">';            
            
            $html   .=  '<td style="display:none;" class="idRef">'.$row->T017_seq       .'</td>';
            $html   .=  '<td>'.$row->T017_data       .'</td>  ';
            $html   .=  '<td>'.$row->T014_codigo       .'</td>';
            $html   .=  '<td>'.$row->T017_desc       .'</td>  ';
            $html   .=  '<td>'.$row->T017_valor       .'</td> ';
            $html   .=  '<td>'.DV_form_input('', array('name'=>'T017_obs_status'), NULL, set_value('T017_obs_status',$row->T017_obs_status)).'</td>';
            $html   .=  '<td width="90px">';
            
            $html   .= DV_button_icon(array('flag red'), array('vetado_div'), array('Vetar')).'</td>';
            
            $html   .=  '</tr>';           
            
            $i++;
            
        }   
        
        $html  .=   '</tbody></table>';      
                        
        echo $html;                        
        
        echo DV_form_close();
        
        echo '</div>';
        
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
        
        
            //Resgata Msgs
            echo DV_get_msg('msgok', TRUE);
            echo DV_get_msg('msgerro', TRUE);

            echo form_open_multipart('', array('class' => 'form_upload'));

            echo '<div class="small-7 large-7">';

                echo DV_form_dropdown_tp_arquivo(array(), array(), NULL, TRUE);

            echo '</div>';

            echo '<div class="small-12 large-12">';

                echo form_upload(array('name' => 'arquivo'), set_value('arquivo'));

                echo form_submit('upload');

            echo '</div>';

            echo form_close();

        
    break;

    case 'imprimir':

        //Logo Davó
        $this->pdf->fontpath = 'font/';
        $this->pdf->AddPage();        
        $this->pdf->Image('images/logo_davo.jpg',10,5,20);

        // Arial Negrito 20
        $this->pdf->SetFont('Arial','B',20);

        $this->pdf->Cell(30);

        //Título
        $this->pdf->Cell(120, 15, utf8_decode("REEMBOLSO DE DESPESAS "), 0, 0, "L");
        $this->pdf->Cell(0  , 15, utf8_decode("N° ".$dados['cabec']->T016_codigo) , 0, 1, "R");

        //Line
        $this->pdf->Line(10, 32, 200, 32);
        //Line break
        $this->pdf->Ln(10);  
        
            
        // Primeira Linha
        $this->pdf->SetFont('arial','B',8);    

        $this->pdf->Cell(20,5,utf8_decode("NOME")  ,"TL",0,"L"); 

        $this->pdf->SetFont('arial','',7);
        $this->pdf->Cell(70,5,utf8_decode($this->msis->get_name_user($dados['cabec']->T004_login)->row()->T004_nome)  ,"T" ,0,"L"); 

        $this->pdf->SetFont('arial','B',8);
        $this->pdf->Cell(30,5,utf8_decode("CONTRATADO")  ,"T",0,"L"); 

        $this->pdf->SetFont('arial','',7);
        $this->pdf->Cell(70,5,utf8_decode($this->msis->get_name_user($dados['cabec']->T004_login)->row()->T004_matricula),"TR",1,"L");

        // Segunda Linha
        $this->pdf->SetFont('arial','B',8);
        $this->pdf->Cell(20,5,utf8_decode("PERÍODO")  ,"BL",0,"L"); 

        $this->pdf->SetFont('arial','',7);
        $this->pdf->Cell(70,5,utf8_decode($dados['cabec']->T016_dt_lancamento)  ,"B",0,"L"); 

        $this->pdf->SetFont('arial','B',8);
        $this->pdf->Cell(30,5,utf8_decode("C. CUSTO")  ,"B",0,"L"); 

        $this->pdf->SetFont('arial','',7);
        $this->pdf->Cell(70,5,utf8_decode($dados['cabec']->T016_centro_custo_RMS),"RB",1,"L"); 

        $this->pdf->Ln(2);   
        
        
        
        $this->pdf->SetFont('arial', 'B', 8);
        $this->pdf->SetFillColor(210, 210, 210);        
        $this->pdf->Cell(190,5,  utf8_decode("DESLOCAMENTO(S)"),0,1,"C",true);

        $this->pdf->SetFillColor(245, 245, 245);
        $this->pdf->SetFont('arial', 'B', 8);
        $this->pdf->Cell(30,5,utf8_decode("DATA/HORA SAÍDA")     ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("ORIGEM")              ,0   ,0,"L",true);
        $this->pdf->Cell(34,5,utf8_decode("DATA/HORA CHEGADA")   ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("DESTINO")             ,0   ,0,"L",true);
        $this->pdf->Cell(6 ,5,utf8_decode("KM")                  ,0   ,1,"L",true);

        $this->pdf->SetFont('arial', '', 8);              
        $this->pdf->Cell(30,5,utf8_decode("20/12/2013 23:00")     ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("999 - LOJA DE GUAIANASES"),0   ,0,"L",true);
        $this->pdf->Cell(34,5,utf8_decode("20/12/2013 00:00")   ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("027 - LOJA DE ORATÓRIO")             ,0   ,0,"L",true);
        $this->pdf->Cell(6 ,5,utf8_decode("999")                  ,0   ,1,"L",true);
        
        $this->pdf->SetFont('arial', 'b', 8);
        $this->pdf->Cell(18,5,utf8_decode("HISTÓRICO: ")     ,0   ,0,"L",true);
        $this->pdf->SetFont('arial', '', 8);
        $this->pdf->Cell(172,5,utf8_decode('campo histórico')     ,0   ,1,"L",true);

        $this->pdf->SetFillColor(245, 245, 245);
        $this->pdf->SetFont('arial', 'B', 8);
        $this->pdf->Cell(30,5,utf8_decode("DATA/HORA SAÍDA")     ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("ORIGEM")              ,0   ,0,"L",true);
        $this->pdf->Cell(34,5,utf8_decode("DATA/HORA CHEGADA")   ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("DESTINO")             ,0   ,0,"L",true);
        $this->pdf->Cell(6 ,5,utf8_decode("KM")                  ,0   ,1,"L",true);

        $this->pdf->SetFont('arial', '', 8);              
        $this->pdf->Cell(30,5,utf8_decode("20/12/2013 23:00")     ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("999 - LOJA DE GUAIANASES"),0   ,0,"L",true);
        $this->pdf->Cell(34,5,utf8_decode("20/12/2013 00:00")   ,0   ,0,"L",true);
        $this->pdf->Cell(60,5,utf8_decode("027 - LOJA DE ORATÓRIO")             ,0   ,0,"L",true);
        $this->pdf->Cell(6 ,5,utf8_decode("999")                  ,0   ,1,"L",true);
        
        $this->pdf->SetFont('arial', 'b', 8);
        $this->pdf->Cell(18,5,utf8_decode("HISTÓRICO: ")     ,0   ,0,"L",true);
        $this->pdf->SetFont('arial', '', 8);
        $this->pdf->Cell(172,5,utf8_decode('campo histórico')     ,0   ,1,"L",true);

        
        $this->pdf->Ln(1);            
        $this->pdf->SetFillColor(210, 210, 210); 

        $this->pdf->SetFont('arial', 'B', 7);    
        $this->pdf->Cell(20,5,utf8_decode("VALOR DO KM:")            ,0  ,0 ,"L",true);

        $this->pdf->SetFont('arial', '', 7);    
        $this->pdf->Cell(20,5,utf8_decode('0,42')                  ,0  ,0 ,"L",true);    

        $this->pdf->SetFont('arial', 'B', 7);    
        $this->pdf->Cell(45,5,utf8_decode("TOTAL DA QUILOMETRAGEM:") ,0  ,0 ,"R",true); 

        $this->pdf->SetFont('arial', '', 7);    
        $this->pdf->Cell(30,5,utf8_decode("R$ ")            ,0  ,0 ,"L",true); 

        $this->pdf->SetFont('arial', 'B', 7);       
        $this->pdf->Cell(67,5,utf8_decode("TOTAL DE KM:")            ,0  ,0 ,"R",true);

        $this->pdf->SetFont('arial', '', 7);
        $this->pdf->Cell(8,5,utf8_decode('10')                    ,0  ,1 ,"L",true);    

        $this->pdf->Ln(2);        
            
            
        $this->pdf->Output();
        
        break;

endswitch;