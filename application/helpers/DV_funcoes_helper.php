<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//Carrega um módulo do sistema devolvendo a tela solicitada
function DV_load_modulo($modulo = NULL, $tela = NULL, $dados = NULL, $js = TRUE, $diretorio = 'painel') {
    $CI = & get_instance();

    if ($modulo != NULL):
        return $CI->load->view("$diretorio/$modulo", array('tela' => $tela, 'dados' => $dados), $js);
    else:
        return FALSE;
    endif;
}

//Seta valores ao array $tema da classe sistema
function DV_set_tema($prop, $valor, $replace = TRUE) {
    $CI = & get_instance();
    $CI->load->library('sistema');
    if ($replace):
        $CI->sistema->tema[$prop] = $valor;
    else:
        if (!isset($CI->sistema->tema[$prop]))
            $CI->sistema->tema[$prop] = '';
        $CI->sistema->tema[$prop] .= $valor;
    endif;
}

//Retorna os valores do array $tema da classe sistema
function DV_get_tema() {
    $CI = & get_instance();
    $CI->load->library('sistema');
    return $CI->sistema->tema;
}

//Inicializa o painel adm carregando os recursos necessários
function DV_init_painel($controller = NULL) {

    $CI = & get_instance();

    //Carrega o módulo caso exista carrega automaticamente
    $jsController = NULL;
    if (isset($controller)):

        $modelName = 'M' . substr($controller, 1);
        $modelFile = 'M' . substr($controller, 1) . '.php';
        $modelNick = 'M' . (int) substr($controller, 1);

        if (file_exists(APPPATH . "models/$modelFile")):
            $CI->load->model($modelName, $modelNick);
        endif;

        $jsFile = 'J' . substr($controller, 1);

        if (file_exists("js/controllers/$jsFile.js")):
            $jsController = "controllers/$jsFile";
        endif;

    endif;

    DV_set_tema('titulo_padrao', 'Intranet Davó');                                                          //Titulo Padrao da Página
    DV_set_tema('rodape', '<p>&copy; 2013 | Todos os direitos reservados para D´avó Supermercados</p>');    //Rodapé padrão da Página
    DV_set_tema('template', 'painel_view');                                                                 //View Padrao
    //Inclusão .css na variavel headerinc    
    DV_set_tema('headerinc', DV_load_css(array( 
          'jquery/jquery-ui-1.10.3.custom'  //Css jQuery-ui     v1.10.3     
        , 'jquery/jquery.pnotify.default'
        , 'jquery/jquery.pnotify.default.icons'
        , 'jquery/jquery-ui-timepicker'
        , 'foundation/normalize'            //Css Foundation    v4
        , 'foundation/foundation.min'       //Css Foundation    v4          
        , 'style'                           //Css Custom        v1.0                
            )), FALSE);

    //Inclusão .js na variável headerinc
    DV_set_tema('headerinc', DV_load_js(array(
        'jquery/jquery-1.9.1'                 //jQuery v.1.9.1
        , 'jquery/jquery-ui-1.10.3.custom.min'  //jQuery-ui Customizada v1.10.3                                 
        , 'jquery/jquery.maskedinput.min'       //jQuery Mask
        , 'jquery/jquery.maskMoney'             //jQuery MaskMoney
        , 'jquery/jquery-ui-timepicker'         //jQuery Timepicker
        , 'jquery/jquery.form'                  //jQuery Form (para upload/file input)
        , 'jquery/jquery.pnotify'               //pnotify v1.2        
        , 'calculation'                         //Funções para Calculo      
        , 'DV_funcoesGerais'                    //Classes Principais/Gerais sistema
        , $jsController                         //.js do Controller Atual (caso exista)    
            )), FALSE);

    //Monta Menu
    DV_set_tema('titulo_programa', DV_titulo_programa());

    //Monta Menu
    DV_set_tema('menu', DV_monta_menu());

    //Breadcrumb
    DV_set_tema('breadcrumb', DV_breadcrumb());


    //Inclusão .js na variavel footerinc
    DV_set_tema('footerinc', DV_load_js(array('foundation/foundation.min'    //Foundation
            )), FALSE);

    //Debugger
    switch (ENVIRONMENT) {
        case 'development':

            $CI->output->enable_profiler(FALSE);

            break;

        default:

            $CI->output->enable_profiler(FALSE);

            break;
    }
}

//Inicializa o painel adm carregando os recursos necessários
function DV_init_dialog() {

    $CI = & get_instance();

    $CI->sistema->tema = array();

    DV_set_tema('template', 'js_view');

    //Debugger
    switch (ENVIRONMENT) {
        case 'development':

            $CI->output->enable_profiler(FALSE);

            break;

        default:

            $CI->output->enable_profiler(FALSE);

            break;
    }
}

//Carerga um template passando o array $tema como parametro
function DV_load_template() {
    $CI = & get_instance();
    $CI->load->library('sistema');
    $CI->parser->parse($CI->sistema->tema['template'], DV_get_tema());
}

//Carrega um ou vários arquivos .css de uma pasta
function DV_load_css($arquivo = NULL, $pasta = 'css', $media = 'all') {
    if ($arquivo != NULL):
        $CI = & get_instance();
        $CI->load->helper('url');
        $retorno = '';

        if (is_array($arquivo)):
            foreach ($arquivo as $css):
                $retorno .= '<link rel="stylesheet" type="text/css" href="' . base_url("$pasta/$css.css") . '" media="' . $media . '" />';
            endforeach;
        else:
            $retorno = '<link rel="stylesheet" type="text/css" href="' . base_url("$pasta/$arquivo.css") . '" media="' . $media . '" />';
        endif;

    endif;

    return $retorno;
}

//Carrega um ou vários arquivos .js de uma pasta ou servidor remoto
function DV_load_js($arquivo = NULL, $pasta = 'js', $remoto = FALSE) {

    if ($arquivo != NULL):
        $CI = & get_instance();
        $CI->load->helper('url');
        $retorno = '';

        if (is_array($arquivo)):
            foreach ($arquivo as $js):
                if (!is_null($js)){                                   
                    if ($remoto):
                        $retorno .= '<script type="text/javascript" src="' . $js . '"></script>';
                    else:
                        $retorno .= '<script type="text/javascript" src="' . base_url("$pasta/$js.js") . '"></script>';
                    endif;
                }
            endforeach;
        else:
            if ($remoto):
                $retorno .= '<script type="text/javascript" src="' . $arquivo . '"></script>';
            else:
                $retorno .= '<script type="text/javascript" src="' . base_url("$pasta/$arquivo.js") . '"></script>';
            endif;
        endif;
        
        return $retorno;
        
    else:
        return FALSE;
    endif;

    
}

//Mostra erros de validação em forms
function DV_erros_validacao() {
    if (validation_errors())
        echo '<div class="messageError alert-box alert">' . validation_errors('<p>', '</p>') . '</div>';
}

//Verifica se o usuario está logado no sistema
function DV_esta_logado($redir = TRUE) {

    $CI = & get_instance();
    $CI->load->library('sistema');

    $user_status = $CI->session->userdata('user_logado');

    if (!isset($user_status) || $user_status != TRUE):
        $CI->session->sess_destroy();
        $CI->session->sess_create();

        if ($redir):
            $CI->session->userdata(array('redir_para' => current_url()));
            DV_set_msg('msgerro', 'Acesso restrito, faça login antes de prosseguir!', 'erro');
            redirect('Clogin/login');
        else:
            return FALSE;
        endif;
    else:
        return TRUE;
    endif;
}

//define uma mensagem para ser exibida na proxima tela carregada
function DV_msg($msg = NULL, $tipo = 'erro') {

    switch ($tipo) {
        case 'erro':
            return  '<div class="ui-widget messageError" >
                        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                            <p>
                                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                <strong>Alert:</strong>' . $msg . '
                            </p>
                        </div>
                      </div>';
            
            
            break;
        case 'sucesso':
            return '<div class="ui-widget messageAlert" >
                        <div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
                            <p>
                                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                <strong>Alert:</strong>' . $msg . '
                            </p>
                        </div>
                      </div>';
            break;
        default:
            return '<div class="messageError alert-box radius small"><p>' . $msg . '</p></div>';
            break;
    }
}

//define uma mensagem para ser exibida na proxima tela carregada
function DV_set_msg($id = 'msgerro', $msg = NULL, $tipo = 'erro') {
    $CI = & get_instance();
    switch ($tipo) {
        case 'erro':
            $CI->session->set_flashdata($id, '<div class="ui-widget messageError" >
                                                <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                                                    <p>
                                                        <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                                        <strong>Alert:</strong>' . $msg . '
                                                    </p>
                                                </div>
                                              </div>'
            );
            
            break;
        case 'sucesso':
            $CI->session->set_flashdata($id, '<div class="ui-widget messageAlert" >
                                            <div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
                                                <p>
                                                    <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                                    <strong>Alert:</strong>' . $msg . '
                                                </p>
                                            </div>
                                          </div>'
            );
            break;
        default:
            $CI->session->set_flashdata($id, '<div class="messageError alert-box radius small"><p>' . $msg . '</p></div>');
            break;
    }
}

//verifica se existe uma mensagem para ser exibida na tela atual
function DV_get_msg($id, $printar = TRUE) {

    $CI = & get_instance();

    if ($CI->session->flashdata($id)):

        if ($printar):

            echo $CI->session->flashdata($id);

        else:

            return $CI->session->flashdata($id);

        endif;

    endif;
}

//Verifica se o usuário atual é administrador
function DV_is_admin($set_msg = FALSE) {
    $CI = & get_instance();
    $user_admin = $CI->session->userdata('user_admin');
    if (!isset($user_admin) || $user_admin != TRUE):
        if ($set_msg)
            DV_set_msg('msgerro', 'Seu usuário não tem permissão para executar essa operação', 'erro');
        return FALSE;
    else:
        return TRUE;
    endif;
}

//Faz autenticação do usuario
function DV_autentica_usuario($user = NULL, $pass = NULL) {
    $CI = & get_instance();                //Instacia Classes CI            
    //Verifica host
    if (SERVIDOR == 'PRD'):

        //Conecta AD
        $connAD = ldap_connect(HOST_AD);
        ldap_set_option($connAD, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($connAD, LDAP_OPT_REFERRALS, 0);

        if (!$connAD):
            set_msg('msgerro', 'Erro desconhecido, contate a equipe Web (AD Connection)', 'erro');
            redirect('Clogin/login');
        else:
            $bind = @ldap_bind($connAD, $user . "@" . DOMINIO_AD, $pass);

            if (!$bind):
                DV_set_msg('msgerro', 'Usuário ou senha incorreto(s)', 'erro');
                redirect('Clogin/login');
            else:
                $attributes = array('displayname', 'mail', 'departament', 'title');
                $filter = "(&(objectCategory=person)(sAMAccountName=$user))";
                $result = ldap_search($connAD, DN_AD, $filter, $attributes);

                if ($result):
                    $entries = ldap_get_entries($connAD, $result);


                    $nomeCompleto = $entries[0]['displayname'][0];
                    $email = $entries[0]['mail'][0];
//                    $departamento   = $entries[0]['department'][0];
//                    $titulo         = $entries[0]['title'][0]; 


                    $dadosUsuario = array('T004_login' => $user
                        , 'T004_nome' => $nomeCompleto
                        , 'T004_email' => $email);

                    $query = $CI->msis->get_usuario($dadosUsuario)->row();

                    if (empty($query)):
                        $tabela = 'T004_usuario';
                        $mensagem = 'Não foi possível gravar o usuário na Intranet';

                        $CI->msis->do_insert($tabela, $dadosUsuario, FALSE, $mensagem);
                    endif;

                    $dados = array(
                        'user' => $query->T004_login,
                        'user_nome' => $query->T004_nome,
                        'user_email' => $query->T004_email,
                        'user_adm' => $query->T004_adm,
                        'user_loja' => $query->T006_codigo,
                        'user_logado' => TRUE,
                    );

                    $CI->session->set_userdata($dados);

                    ldap_close($connAD);

                    redirect('painel');

                endif;

            endif;

        endif;

    else:

        $dadosUsuario = array('T004_login' => $user);

        $query = $CI->msis->get_usuario($dadosUsuario);

        if ($query->num_rows() > 0):

            foreach ($query->result() as $row):

                $dados = array(
                    'user' => $row->T004_login,
                    'user_nome' => $row->T004_nome,
                    'user_email' => $row->T004_email,
                    'user_adm' => $row->T004_adm,
                    'user_loja' => $row->T006_codigo,
                    'user_logado' => TRUE,
                );

            endforeach;

            $CI->session->set_userdata($dados);

            redirect('painel');

        else:

            $CI->session->sess_destroy();
            $CI->session->sess_create();

            DV_set_msg('msgerro', 'Usuário ou senha incorreto(s)');
            redirect('Clogin/login');

        endif;

    endif;
}

/* Constroi array associativo
 * ***************************
 * Input: array
 * Input Example: $array = "campo=>valor"
 * 
 */

function DV_array_associativo(&$arr) {
    $args = func_get_args();
    foreach ($args as $arg) {
        if (is_array($arg)) {
            foreach ($arg as $key => $value) {
                $arr[$key] = $value;
            }
        } else {
            $arr[$arg] = "";
        }
    }
}

function retornarParametroVigente($loja = NULL, $parametro = NULL, $dataInicio = NULL) {
    $CI = & get_instance();


    $query = $CI->msis->retornarParametroVigente($loja, $parametro, $dataInicio)->row();

    date_default_timezone_set('UTC');
    $now = time();

    if ($query->T089_dt_fim <= unix_to_human($now, 'us')):
        return 'sim';
    else:
        return 'nao';
    endif;
}

function DV_format_digits($data = NULL, $digit = '0', $amount = 3, $position = 'left') {

    if (!is_null($data)) {

        switch ($position) {

            case 'left':
                return str_pad($data, $amount, $digit, STR_PAD_LEFT);
                break;

            case 'right':
                return str_pad($data, $amount, $digit, STR_PAD_RIGHT);
                break;
        }
    }
    else
        return FALSE;
}

function DV_formata_codigo_nome($codigo = NULL, $nome = NULL) {

    if (!empty($codigo)):
        return str_pad($codigo, 3, '0', STR_PAD_LEFT) . ' - ' . $nome;
    else:
        return FALSE;
    endif;
}

function DV_format_datetime($date = ''){
    
    return $date = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2) . ' ' . substr($date, 11, 8);

}

function DV_format_field_db($data = array(), $fields = array(),$format='') {

        switch ($format) {
            case 'date':

                foreach ($fields as $field) {

                    $date = substr($data[$field], 6, 4) . '-' . substr($data[$field], 3, 2) . '-' . substr($data[$field], 0, 2);

                    $data[$field] = $date;
                }

                return $data;    

            break;

            case 'datetime':
                
                foreach ($fields as $field) {

                    $date = substr($data[$field], 6, 4) . '-' . substr($data[$field], 3, 2) . '-' . substr($data[$field], 0, 2) . ' ' . substr($data[$field], 11, 8);

                    $data[$field] = $date;
                }

                return $data;    
                
            break;

            case 'money':
                
                foreach ($fields as $field) {

                    $data[$field]   = str_replace('R$ ', '', $data[$field]);
                    $data[$field]   = str_replace('.', '', $data[$field]);
                    $data[$field]   = str_replace(',', '.', $data[$field]);

                }
                
                return $data;
                
            break;

            case 'decimal':
                
                foreach ($fields as $field) {

                    $data[$field]   = str_replace('.', '', $data[$field]);
                    $data[$field]   = str_replace(',', '.', $data[$field]);

                }

                return $data;                  
                
            break;

            case 'cnpj':   
                
                foreach ($fields as $field) {
    
                    $data[$field] = str_replace('/', "", $data[$field]);
                    $data[$field] = str_replace('_', "", $data[$field]);
                    $data[$field] = str_replace('-', "", $data[$field]);
                    $data[$field] = str_replace('|', "", $data[$field]);
                    $data[$field] = str_replace('.', "", $data[$field]);
                    $data[$field] = str_replace(',', "", $data[$field]);
                    $data[$field] = str_replace(':', "", $data[$field]);
                    $data[$field] = str_replace(':', "", $data[$field]);
                    $data[$field] = trim($data[$field]);                
                
                }

                return $data;      
                
            break;
            
            case 'cpf':
                
                foreach ($fields as $field) {
    
                    $data[$field] = str_replace('/', "", $data[$field]);
                    $data[$field] = str_replace('_', "", $data[$field]);
                    $data[$field] = str_replace('-', "", $data[$field]);
                    $data[$field] = str_replace('|', "", $data[$field]);
                    $data[$field] = str_replace('.', "", $data[$field]);
                    $data[$field] = str_replace(',', "", $data[$field]);
                    $data[$field] = str_replace(':', "", $data[$field]);
                    $data[$field] = str_replace(':', "", $data[$field]);
                    $data[$field] = trim($data[$field]);                
                
                }

                return $data;   
                
            break;
        
            default:
            break;
        }

}

function DV_format_vw_datetime($data = array(), $fields = array()) {

    foreach ($fields as $field) {

        if (strlen($data->$field) > 10) {
            $date = substr($data->$field, 8, 2)
                    . '/' . substr($data->$field, 5, 2)
                    . '/' . substr($data->$field, 0, 4)
                    . ' ' . substr($data->$field, 11, 2)
                    . ':' . substr($data->$field, 14, 2)
                    . ':' . substr($data->$field, 17, 2);
        } else {
            $date = substr($data->$field, 8, 2)
                    . '/' . substr($data->$field, 5, 2)
                    . '/' . substr($data->$field, 0, 4);
        }

        $data->$field = $date;
    }

    return $data;
}

function DV_format_decimal_vw($data = NULL){
    if(!empty($data)){

        $data = number_format($data, 2, ',', '.'); // retorna 999.999,99

        return $data;

    }else
        return FALSE;


}

function DV_format_datetime_vw($data = NULL){
    if(!empty($data)){
        $data   = substr($data, 8, 2)
                . '/' . substr($data, 5, 2)
                . '/' . substr($data, 0, 4)
                . ' ' . substr($data, 11, 2)
                . ':' . substr($data, 14, 2)
                . ':' . substr($data, 17, 2); 

        return $data;

    }else
        return FALSE;


}

function DV_format_field_vw($data = array(), $fields = array(),$format='') {

    if (!empty($data)) {

        switch ($format) {
            
            case 'date':
                                                
                foreach ($fields as $field) {
                
                    if(property_exists($data, $field)){

                        $data->$field = substr($data->$field, 8, 2)
                                . '/' . substr($data->$field, 5, 2)
                                . '/' . substr($data->$field, 0, 4);
                                                                        
                        return $data;
                        
                    }else{    
                        
                        $data[$field] = substr($data[$field], 8, 2)
                                . '/' . substr($data[$field], 5, 2)
                                . '/' . substr($data[$field], 0, 4);
                        
                    }
                }

                return $data;

                break;

            case 'datetime':

                foreach ($fields as $field) {
                
                    if(property_exists($data, $field)){
                                               
                        $data->$field = substr($data->$field, 8, 2)
                                . '/' . substr($data->$field, 5, 2)
                                . '/' . substr($data->$field, 0, 4)
                                . ' ' . substr($data->$field, 11, 2)
                                . ':' . substr($data->$field, 14, 2)
                                . ':' . substr($data->$field, 17, 2);                          
                        
                    }else{                  

                        $data[$field] = substr($data[$field], 8, 2)
                                . '/' . substr($data[$field], 5, 2)
                                . '/' . substr($data[$field], 0, 4)
                                . ' ' . substr($data[$field], 11, 2)
                                . ':' . substr($data[$field], 14, 2)
                                . ':' . substr($data[$field], 17, 2);
                        
                    }
                }

                return $data;

                break;

            case 'money':

                foreach ($fields as $field) {

                    if(property_exists($data, $field)){

                        $data->$field = 'R$' . number_format($data->$field, 2, ',', '.'); // retorna R$100.000,50                     
                        
                    }else{  
                        
                        $data[$field] = 'R$' . number_format($data[$field], 2, ',', '.'); // retorna R$100.000,50
                        
                    }

                }
                
                return $data;

            case 'decimal':
                
                foreach ($fields as $field) {
                
                    if(property_exists($data, $field)){

                        $data->$field = number_format($data->$field, 2, ',', '.'); // retorna R$100.000,50                                                
                        
                    }else{ 
            
                        $data[$field] = number_format($data[$field], 2, ',', '.'); // retorna R$100.000,50
                        
                    }
                    
                    return $data;
                }

            case 'cnpj':

                foreach ($fields as $field) {
                
                    if(property_exists($data, $field)){

                        $data->$field = substr($data->$field, 0, 2)
                                . '.' . substr($data->$field, 2, 3)
                                . '.' . substr($data->$field, 5, 3)
                                . '/' . substr($data->$field, 8, 4)
                                . '-' . substr($data->$field, 12, 2); 
                        
                    }else{                 
                
                        $data[$field] = substr($data[$field], 0, 2)
                                . '.' . substr($data[$field], 2, 3)
                                . '.' . substr($data[$field], 5, 3)
                                . '/' . substr($data[$field], 8, 4)
                                . '-' . substr($data[$field], 12, 2); 
                    }
                }
                
                return $data;

            case 'cpf':

                foreach ($fields as $field) {
                
                    if(property_exists($data, $field)){

                        $data->$field = substr($data->$field, 0, 3)
                                . '.' . substr($data->$field, 3, 3)
                                . '.' . substr($data->$field, 6, 3)
                                . '-' . substr($data->$field, 9, 2);
                        
                    }else{                    
                
                        $data[$field] = substr($data[$field], 0, 3)
                                . '.' . substr($data[$field], 3, 3)
                                . '.' . substr($data[$field], 6, 3)
                                . '-' . substr($data[$field], 9, 2);
                    }
                }
                return $data;

                break;
        }
    }
    else
        return FALSE;
}

function DV_retira_mascara($str = NULL) {

    $str = str_replace('/', "", $str);
    $str = str_replace('_', "", $str);
    $str = str_replace('-', "", $str);
    $str = str_replace('|', "", $str);
    $str = str_replace('.', "", $str);
    $str = str_replace(',', "", $str);
    $str = str_replace(':', "", $str);
    $str = str_replace(':', "", $str);
    $str = trim($str);

    return $str;
}

function DV_retira_digito($str = NULL) {

    $str = substr($str, -1);

    return $str;
}

function DV_cria_workflow($grupo_workflow = NULL, $table = NULL, $data = array(), $id = NULL) {

    $CI = & get_instance();

    //Retorna Etapa do Grupo
    $etapa = $CI->msis->retornaEtapaGrpWkf($grupo_workflow);

    $user = $CI->session->userdata('user');

    DV_array_associativo($data, array('T060_codigo' => $etapa->T060_codigo));
    DV_array_associativo($data, array('T004_login' => $user));

    function cria_fluxo($table, $data = array(), $id = NULL, $proxima_etapa = NULL, $ordem = 2) {

        $CI = & get_instance();
        if (!is_null($proxima_etapa)) {

            $proxima_etapa = $CI->msis->retornaProximasEtapas($proxima_etapa);

            $data['T060_codigo'] = $proxima_etapa->T060_codigo;
            $data[$table . "_ordem"] = $ordem;

            $CI->msis->do_insert($table, $data, FALSE);

            cria_fluxo($table, $data, $id, $proxima_etapa->T060_proxima_etapa, $ordem + 1);
        }

        return TRUE;
    }

    $CI->msis->do_insert($table, $data, FALSE);

    cria_fluxo($table, $data, $id, $etapa->T060_proxima_etapa);
}

function DV_upload($campo = NULL, $table = NULL, $nick = '', $idRef = NULL, $processo = NULL) {

    $CI = & get_instance();

    function set_config($categoria = '', $id_arquivo = '') {
        $CI = & get_instance();

        //Captura Extensoes Disponíveis
        $extensoes = '';

        foreach ($CI->msis->retornaExtensoes()->result() as $row) {
            $extensoes .= trim($row->T057_nome) . '|';
        }

        $query = $CI->msis->retornaCategoria($categoria);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $str_path = FOLDER_UPLOAD . 'CAT' . str_pad($row->T056_codigo, 4, '0', STR_PAD_LEFT);
        } else {
            DV_set_msg('msgerro', 'Categoria inexistente!');
        }

        //Configurações Upload
        $config['upload_path'] = $str_path;
        $config['allowed_types'] = $extensoes;
        $config['overwrite'] = TRUE;
        $config['file_name'] = $id_arquivo;

        $CI->upload->initialize($config);
    }

    function insert_tables($campo = '', $processo = '', $nick = '', $table = '', $idRef = '', $categoria = '') {

        $CI = & get_instance();

        //Captura extensão arquivo
        $query = $CI->msis->retornaExtensoes($CI->upload->get_extension($_FILES[$campo]['name']));

        if ($query->num_rows() > 0) {
            $extensao = $query->row();
        } else {
            DV_set_msg('msgerro', 'Extensão inexistente');
            return FALSE;
        }

        $user = $CI->session->userdata('user');

        $arquivo_data = array(
            'T055_nome' => '[Automático] - Intranet',
            'T055_desc' => '[Automático] - Intranet',
            'T055_dt_upload' => date('Y-m-d H:i:s'),
            'T004_login' => $user,
            'T057_codigo' => $extensao->T057_codigo,
            'T056_codigo' => $categoria,
            'T061_codigo' => $processo,
        );

        $CI->msis->db->trans_begin();

        $CI->msis->do_insert('T055_arquivos', $arquivo_data, FALSE, 'Arquivo inserido com sucesso', TRUE);

        $id_arquivo = $CI->db->insert_id();

        $assoc_data = array(
            $nick . '_codigo' => $idRef,
            'T055_codigo' => $id_arquivo
        );

        $CI->msis->do_insert($table, $assoc_data, FALSE, 'Associação feita com sucesso', TRUE);
                
        //caso houver algum erro durante as transações do db
        if ($CI->msis->db->trans_status() === FALSE):
            $CI->db->trans_rollback();
            return FALSE;
        else: //senao
            move_file($campo, $categoria,$id_arquivo);
        endif;
    }

    function move_file($campo = '', $categoria = '', $id_arquivo = '') {
        $CI = & get_instance();

        set_config($categoria, $id_arquivo);

        if ($CI->upload->do_upload($campo)) {
            DV_set_msg('msgok', 'Upload reliazado com sucesso!', 'sucesso');
            $CI->db->trans_commit();
            return TRUE;
        } else {
            DV_set_msg('msgerro', $CI->upload->display_errors(), 'erro');
            $CI->db->trans_rollback();
            return FALSE;
        }
    }

    $files = $_FILES;
    $categoria = element('T056_codigo', $CI->input->post());

    if (is_array($files[$campo]['name'])) {
        $count = count($files[$campo]['name']) - 1;

        for ($i = 0; $i <= $count; $i++) {

            $_FILES = array();

            foreach ($files[$campo] as $key => $value) {

                $_FILES[$campo][$key] = $value[$i];
            }

            if (insert_tables($campo, $processo, $nick, $table, $idRef, $categoria)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    } else {
        if (insert_tables($campo, $processo, $nick, $table, $idRef, $categoria)) {
            if (move_file($campo, $categoria)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}

function DV_clear_filter($data = array(), $extra=array()){
    
    if(!empty($data)){
        foreach($data as $key => $value){
            if(strlen($value)){
                unset($data[$key]);
            }
            
            foreach($extra as $val){
                unset($data[$val]);
            }
            
        }
    }
    
    return $data;
    
}

function DV_link_file($file=NULL, $target='_blank'){
    
    $CI = & get_instance();
    
    if(!empty($file)){
        
        $row  =   $CI->msis->get_file($file);
        
        if($row){
            
            $file   =   $row->T055_codigo.'.'.$row->T057_nome;
            
            $str_path = FOLDER_UPLOAD . 'CAT' . str_pad($row->T056_codigo, 4, '0', STR_PAD_LEFT);
            
            return anchor($str_path.'/'.$file, $row->T055_codigo.' - '.$row->T056_nome, array('target'=>$target));
            
        }
                
    }
    
}

function DV_get_path_file($file=NULL){
    
    $CI = & get_instance();
    
    if(!is_null($file)){
        
        $row  =   $CI->msis->get_file($file);
        
        if($row){
            
            $str_path = FOLDER_UPLOAD . 'CAT' . str_pad($row->T056_codigo, 4, '0', STR_PAD_LEFT).'/'.$row->T055_codigo.'.'.$row->T057_nome;
            
            return $str_path;
            
        }else
            return FALSE;
                
    }
    
}

function DV_check_values_array($array=NULL){
    
    if(!is_null($array)){
        
        if(is_array($array)){
            foreach ($array as $key => $value){
                if(!empty($value)){
                    return TRUE;
                }
            }
        }
        
        return FALSE;
        
    }
}

//Função para conversão de dados do DB para View 
//
//parametro 1: array/object 
//parametro 2: campos 
//parametro 3: formato
//Exemplo: DV_format_vw($object, array('campoData1','campoData2'),'date');
function DV_format_vw(&$data = array()){
    
    $args = func_get_args();
    
    switch ($args[2]){
        
        //Formato para Data sem Hora (DATE)
        case 'date': //entrada: AAAA-MM-DD saida: DD/MM/AAAA
            
            foreach($args[1] as $arg){
            
                if(is_object($args[0])){
                    
                    $data[0]->$arg =    substr($data[0]->$arg, 8, 2)
                                . '/' . substr($data[0]->$arg, 5, 2)
                                . '/' . substr($data[0]->$arg, 0, 4);                    
                    
                }else if(is_array($args[0])){

                     $data[0][$arg] =   substr( $data[0][$arg], 8, 2)
                                . '/' . substr( $data[0][$arg], 5, 2)
                                . '/' . substr( $data[0][$arg], 0, 4);                    
                    
                }                     
            }
            
        break;   
        
        //Formato para data/hora (DATETIME)
        case 'datetime': //entrada: AAAA-MM-DD HH:MM:SS saida: DD/MM/AAAA HH:MM:SS
            
            foreach($args[1] as $arg){
            
                if(is_object($args[0])){
                    
                    $data[0]->$arg =    substr($data[0]->$arg, 8, 2)
                                . '/' . substr($data[0]->$arg, 5, 2)
                                . '/' . substr($data[0]->$arg, 0, 4)
                                . ' ' . substr($data[0]->$arg, 11, 2)
                                . ':' . substr($data[0]->$arg, 14, 2)
                                . ':' . substr($data[0]->$arg, 17, 2);                      
                    
                }else if(is_array($args[0])){

                    $data[0][$arg] =    substr($data[0][$arg], 8, 2)
                                . '/' . substr($data[0][$arg], 5, 2)
                                . '/' . substr($data[0][$arg], 0, 4)
                                . ' ' . substr($data[0][$arg], 11, 2)
                                . ':' . substr($data[0][$arg], 14, 2)
                                . ':' . substr($data[0][$arg], 17, 2);                     
                    
                }                     
            }
            
        break;    
         
        //Formato R$
        case 'money': //entrada: 9999999.99 saida: R$ 9.999.999,99

            foreach($args[1] as $arg){
            
                if(is_object($args[0])){
                    
                    $data[0]->$arg = 'R$' . number_format($data[0]->$arg, 2, ',', '.');                                
                    
                }else if(is_array($args[0])){

                    $data[0][$arg] = 'R$' . number_format($data[0][$arg], 2, ',', '.');                           
                    
                }                     
            }            
            
        break;        
        
        //Formato
        case 'decimal': //entrada: 9999999.99 saida: 9.999.999,99

            foreach($args[1] as $arg){
            
                if(is_object($args[0])){
                    
                    $data[0]->$arg = number_format($data[0]->$arg, 2, ',', '.');                                
                    
                }else if(is_array($args[0])){

                    $data[0][$arg] = number_format($data[0][$arg], 2, ',', '.');                           
                    
                }                     
            }            
            
        break;  

        //Formata CPF
        case 'cpf': //entrada: 99999999999 saida: 999.999.999-99
            
            foreach($args[1] as $arg){
            
                if(is_object($args[0])){
                    
                    $data[0]->$arg =    substr($data[0]->$arg, 0, 3)
                                . '.' . substr($data[0]->$arg, 3, 3)
                                . '.' . substr($data[0]->$arg, 6, 3)
                                . '-' . substr($data[0]->$arg, 9, 2);                      
                    
                }else if(is_array($args[0])){

                    $data[0][$arg] =    substr($data[0][$arg], 0, 3)
                                . '.' . substr($data[0][$arg], 3, 3)
                                . '.' . substr($data[0][$arg], 6, 3)
                                . '-' . substr($data[0][$arg], 9, 2);                   
                    
                }                     
            }
            
        break;       

        //Formata CNPJ
        case 'cnpj': //entrada:99999999999999 saida:99.999.999/9999-99
            
            foreach($args[1] as $arg){
            
                if(is_object($args[0])){
                    
                    $data[0]->$arg =    substr($data[0]->$arg, 0, 2)
                                . '.' . substr($data[0]->$arg, 2, 3)
                                . '.' . substr($data[0]->$arg, 5, 3)
                                . '/' . substr($data[0]->$arg, 8, 4)
                                . '-' . substr($data[0]->$arg, 12, 2);                                         
                    
                }else if(is_array($args[0])){

                    $data[0][$arg] =    substr($data[0][$arg], 0, 2)
                                . '.' . substr($data[0][$arg], 2, 3)
                                . '.' . substr($data[0][$arg], 5, 3)
                                . '/' . substr($data[0][$arg], 8, 4)
                                . '-' . substr($data[0][$arg], 12, 2);                 
                    
                }                     
            }
            
        break;   
        
        //Formata código       
        case 'codigo': //entrada: 9 saida: 999
            
        break;
        
    }
    
}


/* Final do Arquivo DV_funcoes_helper.php
 * Localização: ./application/helpers/DV_funcoes_helper.php 
 * Data Criação: 12/08/2013 
 */