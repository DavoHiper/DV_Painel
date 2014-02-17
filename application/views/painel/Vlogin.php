<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

switch ($tela):
    
    case    'login':
        
        echo DV_form_open('Clogin/login', array('id'=>'frmLogin','class'=>'loginform custom'),'id="boxLogin" class="small-4 large-centered columns"','Identifique-se');
        
        DV_get_msg('msgerro');
        
        echo DV_form_fields(array(
            array(12,'columns',DV_form_input('Usuário', array('id'=>'usuario','name'=>'usuario'), 'usuario', NULL, NULL, TRUE,'autofocus')),
            array('row'),
            array(12,'columns',DV_form_password('Senha', array('id'=>'senha', 'name'=>'senha'))),
            array('row'),
            array(1,'columns',form_submit(array('id'=>'login','name'=>'logar', 'class'=>'button radius right small'),'Login'),'right'),
        ));        
        
        echo DV_form_close(TRUE);
        
        break;    
        
    default:
        
        echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
        
        break;
    
endswitch;