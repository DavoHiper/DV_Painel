<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* Criado em: 05/09/2013
 * Por: Rodrigo Alfieri
 * ***********************
 * Helper de Funções, retornando
 * $html para view
 */

//Função retorna titulo do programa
function DV_titulo_programa() {

    $CI = & get_instance();

    $user = $CI->session->userdata('user');

    $controller = $CI->router->class;

    $nroPrograma = preg_replace("/[^0-9\s]/", "", $controller);

    $query = $CI->msis->retornaTituloPrograma(array('T007_codigo' => $nroPrograma));

    if ($controller == 'Clogin'):
        $tituloPrograma = 'Faça seu Login';
    else:
        if ($query->num_rows() > 0):
            $row = $query->row();

            $tituloPrograma = $row->T007_titulo;

            if (empty($tituloPrograma)):
                $tituloPrograma = 'Programa SEM TITULO';
            endif;

        else:
            $tituloPrograma = 'sem titulo';
        endif;

    endif;

    $server = (SERVIDOR == 'QAS') ? '<strong style="color:red;">(QAS)</strong>' : '';

    return "<h4><strong>$tituloPrograma </strong> $server</h4>";
}

//Função para montar o menu principal
function DV_monta_menu() {

    $CI = & get_instance();                //Instacia Classes CI    
    $user = $CI->session->userdata('user');

    $html = '<nav class="top-bar" style="">';
    $html .= '<ul class="title-area">';
    $html .= '<li class="name">';
    $html .= '</li>';
    $html .= '<li class="toggle-topbar menu-icon left"><a href=""><span>Menu</span></a></li>';
    $html .= '</ul>';
    $html .= '<section class="top-bar-section">';
    $html .= '<ul class="left">';

    function criaLink($codigoMenu = NULL) {
        return $strLnk = 'C' . str_pad($codigoMenu, 4, '0', STR_PAD_LEFT);
    }

    function tem_filhos($user = NULL, $pai = NULL) {
        $CI = & get_instance();                //Instacia Classes CI        
        $queryFilho = $CI->msis->DV_menu($user, $pai);

        $htmlFilho = '';

        foreach ($queryFilho->result() as $rowFilho):

            if ($CI->msis->DV_menu($user, $rowFilho->T007_codigo)->num_rows() > 0):

                $htmlFilho .= '<li class="divider"></li>';
                $htmlFilho .= '<li class="has-dropdown not-click">' . anchor('#', $rowFilho->T007_nome, array('class' => 'not-click'));
                $htmlFilho .= '<ul class="dropdown">';
//                $htmlFilho  .=  '<li class="title back js-generated"><h5><a href="#">« Voltar</a></h5></li>';
//                $htmlFilho  .=    '<li class=""><label>Descrição Subnível</label></li>';                                                   
                $htmlFilho .= tem_filhos($user, $rowFilho->T007_codigo);
                $htmlFilho .= '</ul></li>';

            else:

                $htmlFilho .= '<li class="divider"></li>';
                $htmlFilho .= '<li class="">' . anchor(criaLink($rowFilho->T007_codigo), $rowFilho->T007_nome) . '</li>';

            endif;

        endforeach;

        return $htmlFilho;
    }

    if ($query = $CI->msis->DV_menu($user)):

        if ($query->num_rows() > 0):

            foreach ($query->result() as $row):

                $queryPai = $CI->msis->DV_menu($user, $row->T007_codigo);

                if ($queryPai->num_rows() > 0):

                    $html .= '<li class="has-dropdown not-click">' . anchor('#', $row->T007_nome, array('class' => 'not-click'));
                    $html .= '<ul class="dropdown">';
                    //                $html   .=  '<li class="title back js-generated"><h5><a href="#">« Voltar</a></h5></li>';
                    //                $html   .='<li class=""><label>Descrição Subnível</label></li>';                   
                    $html .= tem_filhos($user, $row->T007_codigo);
                    $html .= '</ul></li>';
                    $html .= '<li class="divider"></li>';

                else:

                    $html .= '<li class="">' . anchor(criaLink($row->T007_codigo), $row->T007_nome) . '</li>';
                    $html .= '<li class="divider"></li>';

                endif;

            endforeach;

        endif;

    endif;

    $html .= '</section></nav>';
    return $html;
}

//Gera um breadcrumb com base no controller atual
function DV_breadcrumb() {
    $CI = & get_instance();
    $CI->load->helper('url');

    $classe = ucfirst($CI->router->class);

    if ($classe == 'Painel'):
        $classe = anchor($CI->router->class, 'Início');
    else:
        $classe = anchor($CI->router->class, $classe);
    endif;

    $metodo = ucwords(str_replace('_', ' ', $CI->router->method));

    if ($metodo && $metodo != 'Index'):
        $metodo = anchor($CI->router->class . "/" . $CI->router->method, $metodo, array('class' => 'current'));
    else:
        $metodo = '';
    endif;

    $html = '<nav class="breadcrumbs">';

    $html .= anchor('painel', 'Home');
    $html .= $classe;
    $html .= $metodo;
    $html .= '</nav>';

    return $html;
}

//Gera Paginador
function DV_paginacao($num_row = 0, $por_pagina = QT_LINHA_PAGINADOR) {

    $CI = & get_instance();
    $CI->load->library('pagination');

    $classe = $CI->router->class;
    $metodo = $CI->router->method;

    $config['base_url'] = base_url($classe . '/' . $metodo);
    $config['total_rows'] = $num_row;
    $config['per_page'] = $por_pagina;
    $config['page_query_string'] = FALSE;

    //Tag abertura
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';

    //Primeiro Registro
    $config['first_link'] = '&laquo;';
    $config['first_tag_open'] = '<li class="arrow">';
    $config['first_tag_close'] = '</li>';

    //Ultimo Registro
    $config['last_link'] = '&raquo;';
    $config['last_tag_open'] = '<li class="arrow">';
    $config['last_tag_close'] = '</li>';

    //Próximo Registro
    $config['next_link'] = '&rsaquo;';
    $config['next_tag_open'] = '<li class="arrow">';
    $config['next_tag_close'] = '</li>';

    //Registro Anterior
    $config['prev_link'] = '&lsaquo;';
    $config['prev_tag_open'] = '<li class="arrow">';
    $config['prev_tag_close'] = '</li>';

    //Registro Atual
    $config['cur_tag_open'] = '<li class="current">';
    $config['cur_tag_close'] = '</li>';

    //Numeradores
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $CI->pagination->initialize($config);

    $html = '<div id="paginator" class="large-2">';
    $html .= '<div class="pagination-centered">';
    $html .= $CI->pagination->create_links();
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

//Cria botão de ação
function DV_botao_acao($anchor = TRUE, $class = NULL, $icon_jquery_ui = NULL, $name = NULL, $method = NULL, $target = '', $css = '', $title = '') {

    $CI = & get_instance();

    if ($anchor == TRUE) {
        $html = anchor($CI->router->class . '/' . $method
                , '<span style="' . $css . '" class="ui-icon ui-icon-' . $icon_jquery_ui . ' title="'.$title.'"></span>'
                . $name, array('id' => 'dialog-link', 'class' => "ui-state-default ui-corner-all 
                    botao-acao $class", 'target' => $target));
    } else {
        $html = '<a class="ui-state-default ui-corner-all botao-acao '.$class.'" title="'.$title.'" style="' . $css . '" id="dialog-link" href="#"><span class="ui-icon ui-icon-' . $icon_jquery_ui . '"></span>' . $name . '</a>';
    }

    return $html;
}

function DV_button_icon($icon = array(), $class = array(), $title = array()){
    
   $html    =   '<ul class="ui-widget ui-helper-clearfix" id="icons">';       
   $i = 0;
   foreach($icon as $row){
       
        $html   .=  '<li title="'.$title[$i].'" class="ui-state-default ui-corner-all '.$class[$i].'"><span class="ui-icon ui-icon-'.$row.'"></span></li>';       
        
        $i++;
   }
                    
   $html    .=  '</ul>'; 
   
   return $html;
    
}

//Cria Barra de botões
function DV_barra_botoes($botoes = NULL) {

    $html = '<div class="toolbar">';
//    $html   .=   '<div class="large-12 columns">';

    if (is_array($botoes)):
        foreach ($botoes as $valores):
            $html .= '<div class="large-2 columns left btIcon">';

            $html .= $valores;

            $html .= '</div>';
        endforeach;
    else:
        $html .= $botoes;
    endif;

//    $html   .=  '</div>';
    $html .= '</div>';

    return $html;
}

function DV_check_fields($row = NULL, $field = NULL) {

    $html = '';

    if (!is_array($field)) {
        if (property_exists($row, $field)) {
            $html .= $row->$field;
        } else {
            $html .= $field;
        }
    } else {
        foreach ($field as $key => $value) {

            if (function_exists($key)) {
                if (is_array($value)) {
                    $data = array();
                    foreach ($value as $k => $val) {
                        if (property_exists($row, $val)) {
                            array_push($data, $row->$val);
                        } else {
                            array_push($data, $val);
                        }
                    }
                    $html .= call_user_func_array($key, $data);
                } else {
                    $html .= $key($row->$value);
                }
            } elseif (is_array($value)) {
                $html .= DV_check_fields($row, $value);
            } elseif (property_exists($row, $value)) {
                $html .= $row->$value;
            } else {
                $html .= $value;
            }
        }
    }

    return $html;
}

function DV_construct_table_vw($id = NULL, $header = array(), $fields = array(), $query = NULL, $checkbox = TRUE, $extra = '') {

    $html = '<div id="tableFilter" class="small-12 large-12 columns " ' . $extra . '>';
    $html .= '<table class="large-12 data-table " ' . $extra . '>';
    $html .= '<thead>';
    $html .= '<tr>';
    if ($checkbox) {
        $html .= '<th>' . form_checkbox(array('id' => 'chkAll')) . '</th>';
    }

    if (is_array($header)) {
        foreach ($header as $row) {
            $html .= '<th>' . $row . '</th>';
        }
    } else {
        $html .= '';
    }

    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<div class="bodyTable">';
    $html .= '<tbody id="contentScroll">';

    if (!empty($query)) {

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {

                $html .= '<tr>';

                if (!empty($id)) {
                    $html .= '<td class="idRef" style="display:none;">' . $row->$id . '</td>';
                }

                if ($checkbox) {
                    $html .= '<td>' . form_checkbox(array('class' => 'chkItm')) . '</td>';
                }

                foreach ($fields as $field) {

                    $html .= '<td>';

                    $html .= DV_check_fields($row, $field);

                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }

    $html .= '</tbody>';
    $html .= '</div>';
    $html .= '</table>';
    $html .= '</div> ';

    return $html;
}

//Monta tabela em HTML
function DV_monta_tabela($idRef = NULL, $cabecalho = array(), $camposTabela = array(), $query = NULL, $botoes = NULL, $acoes = FALSE) {
    $html = '<div id="tableFilter" class="large-12 columns">';
    $html .= '<table class="large-12 data-table">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>' . form_checkbox(array('id' => 'chkAll')) . '</th>';

    if (is_array($cabecalho)):

        foreach ($cabecalho as $valores):

            $html .= '<th>' . $valores . '</th>';

        endforeach;

        if ($acoes):
            $html .= '<th class="text-center" style="width:100px;">Ações</th>';
        endif;

    else:

        $html .= '<th>' . $cabecalho . '</th>';

    endif;

    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<div class="bodyTable">';
    $html .= '<tbody id="contentScroll">';


    if (!empty($query)) {

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $linha):

                $html .= '<tr>';
                $html .= '<td class="idRef" style="display:none;">' . $linha->$idRef . '</td>';
                $html .= '<td>' . form_checkbox(array('class' => 'chkItm')) . '</td>';

                foreach ($camposTabela as $valores):
                    if (is_array($valores)):
                        foreach ($valores as $key => $value):
                            if (function_exists($key)):
                                $html .= '<td>' . $key($linha->$value) . '</td>';
                            else:
                                $str = DV_format_digits($linha->$key) . ' - ' . $linha->$value;
                                $html .= '<td>' . $str . '</td>';
                            endif;
                        endforeach;
                    else:
                        $html .= '<td>' . $linha->$valores . '</td>';
                    endif;
                endforeach;

                if ($acoes):

                    $html .= '<td align="center">
                                            <ul class="ui-widget ui-helper-clearfix" id="icons">
                                                <li title=".ui-icon-closethick" class="ui-state-default ui-corner-all">
                                                        <span class="ui-icon ui-icon-closethick"></span>
                                                </li>
                                            </ul>
                                        </td>';

                endif;

                $html .= '</tr>';

            endforeach;
        }
    }


    $html .= '</tbody>';
    $html .= '</div>';
    $html .= '</table>';
    $html .= '</div> ';

    return $html;
}

function DV_tabs($tab = array()) {

    $html = '<div class="tabs">';

    $html .= '<ul>';

    $count = 1;
    foreach ($tab as $key => $value) {
        $html .= '<li><a href="#tabs-' . $count . '">' . $key . '</a></li>';
        $count++;
    }

    $html .= '</ul>';

    $count = 1;
    foreach ($tab as $key => $value) {

        $html .= '<div id="tabs-' . $count . '">';

        $html .= '<div class="row">';

        foreach ($value as $row) {
            $html .= $row;
        }

        $html .= '</div>';

        $html .= '</div>';

        $count++;
    }

    return $html;
}