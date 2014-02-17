<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="pt-br" > <!--<![endif]-->

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title><?php if (isset($titulo)): ?>{titulo_programa} | <?php endif; ?>{titulo_padrao}</title>  

        <!--Inclusão dos arquivos .css-->
        {headerinc}
 
    </head>

    <body <?php echo (SERVIDOR=='QAS')?'style="background:#93c1cc"':''; echo (SERVIDOR=='LOCALHOST')?'style="background:#999"':''?>>
        
        <?php if ($this->router->class=='Clogin'){?>
        <div id="">   
        <?php }  
                        
                $img_logo_prop = array( 'src' => 'images/logo.png',
                                        'alt' => '',
                                        'class' => '',
                                        'width' => '270',
                                        'height' => '65',
                                        'title' => '',                                      
                                       );
            
                 $img_icon_prop = array( 'src' => 'images/slot.png');?>

                <!--Cabeçalho-->
                <div id="header" class="row">
                    <div class="large-1 columns logo">                    
                        <?php echo anchor(WP_URL, img($img_logo_prop));?>
                    </div>                  
                    <div id="titleProgram" class="large-1 columns">{titulo_programa}</div>
                    <div id="icons">
                        <?php if (DV_esta_logado(FALSE)): ?><a target="_blank" href="https://www.adpweb.com.br/rhweb5/"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_01.png"></a><?php endif;?>
                        <a target="_blank" href="https://www.adpweb.com.br/rhweb5/"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_01.png"></a>
                        <a target="_blank" href="http://conhelp/conhelp"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_02.png"></a>
                        <a target="_blank" href="http://www.davo.com.br/Home.aspx"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_03.png"></a>
                        <a target="_blank" href="http://emporium"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_04.png"></a>
                        <a target="_blank" href="http://10.2.1.51:9090/vigilo/BamCentric.html"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_05.png"></a>
                        <a target="_blank" href="http://oraas007/tf.portal/"><img src="http://intranet.grupodavo.davo.com.br/wp-content/uploads/2014/02/icon_header_06.png"></a>
                    </div>                    
                    <div class="large-4 columns login">
                        <?php if (DV_esta_logado(FALSE)): ?><p class="text-right loginname"><?php echo anchor('Clogin/logoff', img($img_icon_prop))?><strong><?php echo $this->session->userdata('user_nome'); ?></strong></p><?php endif;?>
                    </div>
                    <!--FastPath-->
<!--                    <div id="fastPath"  class="large-3 columns">
                        <p class="text-right"><input type="text" placeholder="FastPath"></p>
                    </div>-->
                    
                </div>
                
            <!--Verifica se o usuario está logado e carrega o conteudo da página-->    
            <?php if (DV_esta_logado(FALSE)): ?>
            <!--Menu de navegação-->
            <div id="menu" class="row">                
                {menu} 
            </div>

            <!--Breadcrumb-->
<!--            <div id="breadcrumb" class="row">                
                {breadcrumb} 
            </div>-->
            <?php endif; ?>        

            <!-- Conteudo da Página -->
            <div id="content" class="row">
                <!--Somente para página de login cria um H1-->
                <?php if ($this->router->class=='Clogin'){?>
                <!--<h1>D´avó Supermercados</h1>-->   
                <?php }?> 
                {conteudo}   
                
            </div>

            <!--Rodapé da Página-->
<!--            <div id="footer" class="row">
                <div class="large-12 text-center">
                    {rodape}
                </div>
            </div>-->

            <!-- Inclusão dos arquivos .js -->
            {footerinc}
        <?php if ($this->router->class=='Clogin'){?>    
        </div>
        <?php }?>
    </body>

</html>
