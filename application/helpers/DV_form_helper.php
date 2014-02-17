<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Elemntos para Formulário com validação
function DV_form_input($label = NULL, $data = NULL, $value = NULL, $default = NULL, $extra = NULL) {

    if (array_key_exists('name', $data))
        $name = $data['name'];

    $input  = form_label($label);
    $input .= form_input($data, set_value($value, $default), $extra);
    $input .= form_error($name, '<small class="error">', '</small>');

    return $input;
}

function DV_form_input_login($label = NULL, $data = NULL, $value = NULL, $default = NULL, $extra = NULL) {

    if (array_key_exists('name', $data))
        $name = $data['name'];
    
    $input  = form_label($label);
    $input .= form_input(array('class'=>'inputLogin'), set_value($value, $default), $extra);
    $input .= form_hidden($name, set_value($value, $default));
    $input .= form_error($name, '<small class="error">', '</small>');

    return $input;
}

//Elemntos para Formulário com validação
function DV_form_submit($label = NULL, $data = NULL) {

    if (array_key_exists('name', $data))
        $name = $data['name'];

    $input  =   form_submit(array('name' => $name, 'class' => 'button prefix'), $label);
    
    return $input;
}
//Elemntos para Formulário com validação
function DV_form_textarea($label = NULL, $data = NULL, $value = NULL, $default = NULL, $extra = NULL) {

    if (array_key_exists('name', $data))
        $name = $data['name'];

    $input  = form_label($label);
    $input .= form_textarea($data, set_value($value, $default), $extra);
    $input .= form_error($name, '<small class="error">', '</small>');

    return $input;
}

function DV_form_password($label = NULL, $data = NULL,  $extra = NULL) {

    if (array_key_exists('name', $data))
        $name = $data['name'];

    $input  = form_label($label);
    $input .= form_password($data, set_value($name), $extra);
    $input .= form_error($name, '<small class="error">', '</small>');

    return $input;
}

function DV_form_checkbox($label = NULL, $data = NULL, $value = NULL, $checked = FALSE, $extra = '') {

    if (array_key_exists('name', $data))
        $name = $data['name'];

    $input  = form_label(form_checkbox($data, $value, $checked, $extra) . $label, $name);
    $input .= form_error($name, '<small class="error">', '</small>');

    return $input;
}

//Funcao para setar o valor de um campo do filtro, usada normalmente em telas de listagem de dados
function DV_set_value($name = NULL, $filtro = array()) {
    if (!empty($filtro)):
        $valor = set_value($name);
        if (!empty($valor)):
            return $valor;
        elseif (!empty($filtro[$name])):
            return $filtro[$name];
        endif;
    endif;
}

function DV_form_open($action = '', $attributes = '', $extra = '', $fieldset = ''){
    
    $CI = & get_instance(); 
    $html   =   '';
    
    $html  .=    '<div '.$extra.'class="row">';
      
    
    if(!empty($action))
        $html .=    form_open($action, $attributes);
    else
        $html .=    form_open(base_url().$CI->router->class, $attributes);
   
    if(!empty($fieldset))
    $html   .=  form_fieldset($fieldset);
           
    return $html;  
}

function DV_form_fields($inputs=array()){
    
    if(is_array($inputs)){
        
        $html   =   '';
        
        $i  =   0;
        
        $html   .=   '<div class="row">';
        
        foreach($inputs as $input){
            
            if($input[0]=='row'){
                $html   .=  '</div><div class="row">';
                $i++;                
            }else{                                            
                
                if(empty($input[3]) && $input[1]=='columns')
                    $input[3]   =   'left';
                elseif(empty($input[3])){
                    $input[3]   =   '';
                }
                
                if(is_integer($input[0])){
                    $html   .=  "<div class='large-$input[0] small-$input[0] $input[1] $input[3]'>";
                    $html   .=  $input[2];
                }else{                    
                    if(empty($input[2]))
                        $input[2]   =   '';
                    $html   .=  "<div class='$input[0]' style='$input[2]'>";
                    $html   .=  $input[1];
                }
                                                    
                $html   .=  '</div>';

            }      
        }
        
        $html   .=   '</div>';
        
    }else
        $html   .=  $inputs;
    
    return $html;  
}

function DV_form_close($fieldset=FALSE){
    
    $html   =   '';
    
    if($fieldset)
        $html   .=  form_fieldset_close();   
    
    $html .= form_close();

    $html .= '</div>';

    return $html;  
}

//Funçao para criar radiobutton
function DV_form_radio($label = NULL, $data = array(), $radioRotulo = array(), $value = array(), $checked = 1, $extra = '') {

    $html  = form_label($label);
    $html .= '<div class="radioset">';

    $i = 1;
    $id = $data['id'];
    foreach ($radioRotulo as $v):

        $data['id'] = $id . $i;

        if ($checked == $i):
            $ckd = TRUE;
        else:
            $ckd = FALSE;
        endif;

        $html .= form_radio($data, $value[$i-1], $ckd, $extra);
        $html .= '<label for="' . $data['id'] . '">' . $v . '</label>';

        $i++;

    endforeach;

    $html .= '</div>';

    return $html;
}

//Cria dropdown/combobox
function DV_form_dropdown_db($table = NULL, $valorRotulo = NULL, $campoRotulo = NULL, $where = NULL, $label = NULL, $name = '', $extra = array(), $selected = array()) {

    $CI = & get_instance();

    $query = $CI->msis->retornaDadosCombo($table, $valorRotulo, $campoRotulo, $where);
    
    if (key_exists('id', $extra)):
        $id = $extra['id'];
    else:
        $id = '';
    endif;

    $html = form_label($label, '', array('for' => $id));

    $dados = array();
    DV_array_associativo($dados, array(NULL => 'Selecione...'));
    foreach ($query->result() as $row):

        $rotuloOption = str_pad($row->$valorRotulo, 3, "0", STR_PAD_LEFT) . " - " . $row->$campoRotulo;

        DV_array_associativo($dados, array($row->$valorRotulo => $rotuloOption));

    endforeach;

    $atributos = "";
    foreach ($extra as $key => $row):
        $atributos .= $key . " = '" . $row . "' ";
    endforeach;

    $html .= form_dropdown($name, $dados, $selected, $atributos);
    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

//Cria dropdown/combobox
function DV_form_dropdown($label = NULL, $name = '', $dados = array(), $extra = array(), $selected = array()) {

    if (key_exists('id', $extra)):
        $id = $extra['id'];
    else:
        $id = '';
    endif;

    $html = form_label($label, '', array('for' => $id));

    $atributos = "";
    foreach ($extra as $key => $row):
        $atributos .= $key . " = '" . $row . "' ";
    endforeach;

    $html .= form_dropdown($name, $dados, $selected, $atributos);

    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

function DV_form_multiselect($label = '', $name = '', $options = array(), $selected = array(), $placeholder = '', $extra = '') {

    $html = '<div class="list">';

    $html .= '<div class="large-6 columns">';

    $html .= '<div class="row collapse ">';
    $html .= '<div class="small-10 columns">';

    $html .= DV_form_input($label, array('name' => 'inputList', 'class' => 'autocomplete', 'placeholder' => $placeholder));

    $html .= '</div>';

    $html .= '<div class="small-2 columns">';
    $html .= '<a href="#" class="buttonList button prefix"><span class="ui-icon ui-icon-plus"></span></a>';
    $html .= '</div>';

    $html .= '</div>';

    $html .= '</div>';

    $html .= form_multiselect($name, $options, $selected, $extra);
    $html .= form_error($name, '<small class="error">', '</small>');
    $html .= '</div>';

    return $html;
}

function DV_form_dropdown_lojas($extra = array(), $selected = array(), $where = NULL, $required = TRUE, $name = NULL, $label = '') {

    $table = 'T006_loja';
    $valorRotulo = 'T006_codigo';
    $campoRotulo = 'T006_nome';
    
    if(empty($name))
        $name = $valorRotulo;
    
    $label = 'Loja '.$label;

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);    

    return $html;
}

function DV_form_dropdown_contas_rms($extra = array(), $selected = array(), $where = NULL, $required = TRUE, $name = NULL, $label = '') {

    $table = 'T014_conta';
    $valorRotulo = 'T014_codigo';
    $campoRotulo = 'T014_nome';
    
    if(empty($name))
        $name = $valorRotulo;
    
    $label = 'Conta '.$label;

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);    

    return $html;
}

function DV_form_dropdown_categoria_fornecedor($extra = array(), $selected = array(), $where = NULL, $required = TRUE) {

    $table = 'T120_fornecedor_categoria';
    $valorRotulo = 'T120_codigo';
    $campoRotulo = 'T120_nome';
    $name = $valorRotulo;
    $label = 'Categoria Fornecedor';

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);    

    return $html;
}

function DV_form_dropdown_tp_arquivo($extra = array(), $selected = array(), $where = NULL, $required = TRUE) {

    $table = 'T056_categoria_arquivo';
    $valorRotulo = 'T056_codigo';
    $campoRotulo = 'T056_nome';
    $name = $valorRotulo;
    $label = 'Tipo Arquivo';

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);    

    return $html;
}

function DV_form_dropdown_grp_workflow($valorRotulo = NULL, $campoRotulo = NULL, $processo = NULL, $label = NULL, $name = '', $extra = array(), $selected = array()) {

    $CI = & get_instance();

    $query = $CI->msis->retornaDadosComboGrpWkf($valorRotulo, $campoRotulo, $processo);

    if (key_exists('id', $extra)):
        $id = $extra['id'];
    else:
        $id = '';
    endif;

    $html = form_label($label, '', array('for' => $id));

    $dados = array();
    DV_array_associativo($dados, array(NULL => 'Selecione...'));
    foreach ($query->result() as $row):

        $rotuloOption = str_pad($row->$valorRotulo, 3, "0", STR_PAD_LEFT) . " - " . $row->$campoRotulo;

        DV_array_associativo($dados, array($row->$valorRotulo => $rotuloOption));

    endforeach;

    $atributos = "";
    foreach ($extra as $key => $row):
        $atributos .= $key . " = '" . $row . "' ";
    endforeach;

    $html .= form_dropdown($name, $dados, $selected, $atributos);
    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

function DV_form_dropdown_menu($extra = array(), $selected = array(), $where = NULL, $required = TRUE) {

    $table = 'T007_estrutura';
    $valorRotulo = 'T007_codigo';
    $campoRotulo = 'T007_nome';
    $name = $valorRotulo;
    $label = 'Menu Pai';

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);
    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

function DV_form_dropdown_departamento($extra = array(), $selected = array(), $where = NULL, $required = TRUE) {

    $table = 'T077_departamento';
    $valorRotulo = 'T077_codigo';
    $campoRotulo = 'T077_nome';
    $name = $valorRotulo;
    $label = 'Departamento';

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);
    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

function DV_form_dropdown_datatype($extra = array(), $selected = array(), $where = NULL, $required = TRUE) {

    $table = 'T002_datatype';
    $valorRotulo = 'T002_codigo';
    $campoRotulo = 'T002_valor';
    $name = $valorRotulo;
    $label = 'Datatype';

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);
    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

function DV_form_dropdown_perfis($extra = array(), $selected = array(), $where = NULL, $required = TRUE) {

    $table = 'T009_perfil';
    $valorRotulo = 'T009_codigo';
    $campoRotulo = 'T009_nome';
    $name = $valorRotulo;
    $label = 'Perfil';

    if ($required) {
        $label .= ' (*)';
    }

    $html = DV_form_dropdown_db($table, $valorRotulo, $campoRotulo, $where, $label, $name, $extra, $selected);
    $html .= form_error($name, '<small class="error">', '</small>');

    return $html;
}

/* End of file DV_form_helper.php */
/* Location: ./application/helpers/DV_form_helper.php */