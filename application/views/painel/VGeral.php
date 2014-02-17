<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

switch ($tela):

    case 'grupo_workflow':

        echo DV_get_msg('msgok');
        echo DV_get_msg('msgerro');        
        
        echo '<div class="">';
        
        echo form_open();
        
        echo '<div class="row">';
        
        //Processo
        echo form_hidden('T061_codigo');
        
        //Loja
        echo form_hidden('T006_codigo');
        
        //Fornecedor
        echo form_hidden('T026_codigo');
        
        echo '<p>Selecione um grupo de Workflow</p>';        
        
        echo DV_form_dropdown_grp_workflow('T059_codigo', 'T059_nome', 'Grupo Workflow', 'T059_codigo',array(),array(),12);
        
        echo '</div>';
        
        echo form_close();
        
        echo '</div>';
        
    break;

endswitch;