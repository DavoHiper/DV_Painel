<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

switch ($tela):

    case 'listar':
    
        //Barra de Botões
        echo DV_barra_botoes(array(
            DV_botao_acao(FALSE, 'atribuir', 'plus', 'Atribuir Valor', 'atribuir'),
        ));        

        echo '<div class="row" style="margin-bottom:20px;">';
        
        echo '<div class="small-4 large-4 columns">';
        
        echo form_label('<strong>Período de Carência Atual:</strong> 7 dias');
        
        echo '</div>';

        echo '<div class="small-3 large-3 left columns">';
        
        echo form_label('<strong>Valor Km Atual:</strong> R$ 0,42');
        
        echo '</div>';        
                
        echo '</div>';        
        
        //Cria formulário de Filtros               
        echo DV_form_open('C0141/salvar_dias');
                       
        echo DV_form_fields(array(
            array(2,'columns',DV_form_input('Período de Carencia', array('name' => ''), NULL, DV_set_value(''))),
            array(1,'columns',DV_form_submit('Salvar', array('name' => 'salvar_dias'))),
        ));
        
        echo DV_form_close();
        
        echo DV_form_open('C0141/salvar_km');
                       
        echo DV_form_fields(array(
            array(2,'columns',DV_form_input('Valor Atual Km', array('name' => 'T089_valor','class'=>'valor'), NULL, DV_set_value(''))),
            array(2,'columns',DV_form_input('Data Inicio', array('name' => 'T089_dt_inicio','class'=>'customDatetime'), NULL, DV_set_value(''))),
            array(2,'columns',DV_form_input('Data Fim', array('name' => 'T089_dt_fim','class'=>'customDatetime'), NULL, DV_set_value(''))),
            array(1,'columns',DV_form_submit('Salvar', array('name' => 'salvar_km','style'=>'margin-top:10px;'))),
        ));
    
        echo DV_form_close();
        
        $html    =   '<div id="tableFilter" class="small-12 large-12 columns">';

        $html   .=   '<table class="small-12 large-12 data-table">';

        $html   .=  '<thead>';
        $html   .=  '<tr>';
            $html   .=  '<th>Loja</th>';
            $html   .=  '<th>Data Início</th>';
            $html   .=  '<th>Data Final</th>';
            $html   .=  '<th>Valor</th>';
        $html   .=  '<tr>';

        $html   .=  '<tbody>';      
        
        if(!empty($dados->num_rows)>0){
                       
            foreach($dados->result() as $row){
                            
                $html   .=  '<tr>';
                
                $html   .=  "<td>$row->T006_codigo - $row->T006_nome</td>";
                $html   .=  "<td>$row->T089_dt_inicio</td>";
                $html   .=  "<td>$row->T089_dt_fim</td>";
                $html   .=  "<td>$row->T089_valor</td>";
                
                $html   .=  '</tr>';
                                
            }                                    
        }else{
            $html   .=  '<tr><td colspan="4" style="text-align:center;">Nenhum dado encontrado  </td</tr>';
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


endswitch;