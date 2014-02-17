$(function(){

    function calcula_totais(){
        
        var distancia   =   $('input[name="T015_T016_km[]"]');
        var despesa     =   $('input[name="T017_valor[]"]');
        var km          =   $('input[name="valor_km"]');
                        
        var total_km    =   $('input[name="T016_vl_total_km"]');
        var total_div   =   $('input[name="T016_vl_total_diversos"]');
        
        var total_geral =   $('input[name="T016_vl_total_geral"]');

        //Calcula Total Distancia Percorrida
        total_km.calc(
                "distancia * km",
                {  
                        distancia: distancia.sum(),
                        km: km
                },
                function (s){return s.toFixed(2);}
        );
                             
        //Calcula Total de Despesas
        total_div.val(despesa.sum().toFixed(2));  
        
        $(".valor").maskMoney('mask');
        
        //Calcula Total Geral
        total_geral.val($('input[name="T016_vl_total_km"], input[name="T016_vl_total_diversos"]').sum().toFixed(2));
        
        //Mascara
        $(".valor").maskMoney('mask');
        
    }
    
    function dialog_km(inputs, obj){                            
              
        //Declaração de variável      
        var obj_dialog  =   new DV_dialog();
        var url         =   new DV_url();

        //Seta Controller e Method
        url.controller  =   'C0026';
        url.method  =   'despesa_km';     

        //Chama view php
        $.post(url.create(), function(data){

            //Titulo do Dialog
            obj_dialog.title_dialog  =   'Despesas com Km';

            //Botões do Dialog
            obj_dialog.buttons.unshift
                ({text: 'Salvar'
                , click: function(e) {
                    e.preventDefault();

                    var frm = $(obj_dialog.current).find('form');

                    frm.submit(function(event) {

                        var form    =   $(this);
                        var html    =   '';
                        var button  =   new DV_button();

                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            data: form.serializeArray(),
                            success: function(data) {
                                if(data!='1'){

                                    obj_dialog.close();
                                    obj_dialog.open(data);

                                }else{

                                    obj_dialog.close();

                                    html    +=  '<tr>';

                                    $.each(frm.serializeArray(),function(key,value){
                                        if((value.name=='T015_T016_origem') || (value.name=='T015_T016_destino')){
                                            html    +=  '<input type="hidden" name="'+value.name+'[]" value="'+value.value+'"/>';
                                        }else{
                                            html    +=  '<td>'+value.value+'</td><input type="hidden" name="'+value.name+'[]" value="'+value.value+'"/>';
                                        }
                                    });

                                    button.icon     =   new Array('pencil','refresh','minus');
                                    button.class    =   new Array('edit_line','inverse','remove');                                                
                                    button.title    =   new Array('Editar','Cópia Reversa','Remover');

                                    html    +=  '<td style="width:110px;">'+button.create()+'</td>';
                                    html    +=  '</tr>';

                                    $(obj).parents('tr').remove();

                                    $('#dadosKm').css('display','block');

                                    $('#despesaKm').append(html);

                                    calcula_totais();

                                }                                                                                        
                            }
                        });
                        event.preventDefault(); //Prevenir o formulario ser enviado via browse.
                    }).trigger('submit'); 
                }});                    

            //Ao abrir o dialog
            obj_dialog.opening    =   function(){

                //Limit 
                $('.customDatetime_limit').datetimepicker({                   
                    minDate: -7                    
                  , maxDate: "+0D" 
                  
                });  

                function get_km(origem, destino){

                    var input_km=   $('input[name=T015_T016_km]');

                    $.post(url.create(),{origem:origem.val(), destino:destino.val()}, function(data){
                        input_km.val(data);
                    });   

                };

                var origem  =   $('select[name=T006_codigo_origem]');
                var destino =   $('select[name=T006_codigo_destino]');

                origem.change(function(){

                    var $this   =   $(this);

                    if($this.val()==999){
                        $this.parent('div').append('<div id="externoOrig"><label>Externo Origem (*)</label><input name="T015_T016_origem" type="text"/></div>');
                    }else{
                        $("#externoOrig").remove();

                        url.method  =   'get_displacement';

                        if(destino.val()!=''){
                            get_km(origem, destino);
                        }


                    }                        
                });

                destino.change(function(){

                    var $this   =   $(this);

                    if($this.val()==999){
                        $this.parent('div').append('<div id="externoDest"><label>Externo Destino (*)</label><input name="T015_T016_destino" type="text"/></div>');
                    }else{
                        $("#externoDest").remove();

                        url.method  =   'get_displacement';

                        if(origem.val()!=''){
                            get_km(origem, destino);
                        }                                     
                    }                        
                });

                if($.type(inputs)!='undefined'){
                    $.each($("form:last :input").get(), function(key,value){
                        $.each(inputs, function(k, v){
                            if(value.name+'[]' == v.name){
                                value.value =   v.value;
                            }
                        });    
                    });   
                }


            };

            //Abre o dialog
            obj_dialog.open(data);

        });                      
     
                
    }
            
    function dialog_div(inputs, obj){

        var url             =   new DV_url();
        var diag_desp_div   =   new DV_dialog();

        url.controller  =   'C0026';
        url.method      =   'despesa_div';

        $.post(url.create(), function(data){                        

            diag_desp_div.title_dialog  =   'Despesas Diversas';

            diag_desp_div.buttons.unshift
                    ({text: 'Salvar'
                    , click: function(e) {
                        e.preventDefault();
                        var frm = $(diag_desp_div.current).find('form');

                        frm.find('input').removeAttr('disabled');
                        frm.find('select').removeAttr('disabled');

                        frm.submit(function(event) {

                            var form    =   $(this);
                            var html    =   '';
                            var conta   =   $("select[name=T014_codigo] option:selected").text();
                            var button  =   new DV_button();

                            $.ajax({
                                type: form.attr('method'),
                                url: form.attr('action'),
                                data: form.serializeArray(),
                                success: function(data) {
                                    if(data!='1'){
                                        diag_desp_div.close();
                                        diag_desp_div.open(data);

                                    }else{

                                        diag_desp_div.close();

                                        html    +=  '<tr>';

                                        $.each(frm.serializeArray(),function(key,value){
                                            if(value.name=='T017_valor'){     
                                                html    +=  '<td>'+value.value+'</td><input class="valor" type="hidden" name="'+value.name+'[]" value="'+value.value+'"/>';                                                
                                            }else if(value.name=='T014_codigo'){
                                                html    +=  '<td>'+conta+'</td><input type="hidden" name="'+value.name+'[]" value="'+value.value+'"/>';
                                            }else{
                                                html    +=  '<td>'+value.value+'</td><input type="hidden" name="'+value.name+'[]" value="'+value.value+'"/>';                                                
                                            }
                                        });
                                        
                                        button.icon     =   new Array('pencil','minus');
                                        button.class    =   new Array('edit_line_div','remove');                                                
                                        button.title    =   new Array('Editar','Remover');

                                        html    +=  '<td style="width:110px;">'+button.create()+'</td>';                                        

                                        html    +=  '</tr>';

                                        $(obj).parents('tr').remove();

                                        $('#dadosDiv').css('display','block');
                                        $('#despesaDiv').append(html);

                                        calcula_totais();

                                    }                                                                                        
                                }
                            });
                            event.preventDefault(); //Prevenir o formulario ser enviado via browse.
                        }).trigger('submit'); 
                    }});                    

            diag_desp_div.opening    =   function(){
                
                //Limit 
                $('.customDatetime_limit').datetimepicker({                   
                    minDate: -7                    
                  , maxDate: "+0D" 
                  
                });                  
                
                if($.type(inputs)!='undefined'){
                    $.each($("form:last :input").get(), function(key,value){
                        $.each(inputs, function(k, v){
                            if(value.name+'[]' == v.name){
                                value.value =   v.value;
                            }
                        });    
                    });   
                }                
                
            };

            diag_desp_div.open(data);

        });
                        
    }
    
    function remove_linha(obj){
        
        obj.parents('tr').remove();
        
        calcula_totais();
        
    }    
    
    function revisar_km(obj,despesa){
        
        var $this   =   obj;                  
        var idRef   =   $this.parents('tr').find('.idRef').text();
        var status  =   1; //Status Revisado
        var url     =   new DV_url();
        var obs     =   $this.parents('tr').find('input').val();
        
        url.controller  =   'C0026';
        url.method      =   'status_km';

        $.post(url.create(),{despesa:despesa,idRef:idRef, obs:obs,status:status},function(data){

            if(data=='1'){
                $this.parents('tr').css('background','#a1f99e');
                $this.parents('tr').find('input[name="T015_T016_status[]"]').val(status);
            }

        });  
        
    }
    
    function vetar_km(obj,despesa){
        
        var $this   =   obj;                  
        var idRef   =   $this.parents('tr').find('.idRef').text();
        var status  =   2; //Status Revisado
        var url     =   new DV_url();
        var obs     =   $this.parents('tr').find('input').val();        

        url.controller  =   'C0026';
        url.method  =   'status_km';

        $.post(url.create(),{despesa:despesa,idRef:idRef, obs:obs,status:status},function(data){

            if(data=='1'){
                $this.parents('tr').css('background','#eca2a0');
            }

        });  
        
    }
    
    function revisar_div(obj,despesa){
        
        var $this   =   obj;                  
        var idRef   =   $this.parents('tr').find('.idRef').text();
        var status  =   1; //Status Revisado
        var url     =   new DV_url();
        var obs     =   $this.parents('tr').find('input').val();

        url.controller  =   'C0026';
        url.method  =   'status_div';

        $.post(url.create(),{despesa:despesa,idRef:idRef, obs:obs,status:status},function(data){

            if(data=='1'){
                $this.parents('tr').css('background','#a1f99e');
                $this.parents('tr').find('input[name="T017_status[]"]').val(status);
            }

        });    
        
    }
    
    function vetar_div(obj,despesa){
        
        var $this   =   obj;                    
        var idRef   =   $this.parents('tr').find('.idRef').text();
        var status  =   2; //Status Revisado
        var url     =   new DV_url();
        var obs     =   $this.parents('tr').find('input').val();

        url.controller  =   'C0026';
        url.method  =   'status_div';

        $.post(url.create(),{despesa:despesa,idRef:idRef, obs:obs,status:status},function(data){

            if(data=='1'){
                $this.parents('tr').css('background','#eca2a0');
            }

        });   
        
    } 
    
    //Botão Novo
    $('.novo').click(function(e){
        e.preventDefault();
        var diag_novo   =   new DV_dialog();
        var url         =   new DV_url();
        
        url.controller          =   'C0026';
        url.method              =   'novo';
        diag_novo.controller    =   url.controller;
        
        $.post(url.create(),function(data){
                        
            diag_novo.title_dialog =   'Novo';
            
            diag_novo.width = '800';
            
            diag_novo.buttons.unshift
                    ({text: 'Salvar'
                    , click: function() {
                        diag_novo.send_form();
                    }});            

            diag_novo.opening   =   function(){                                                                                                      
                 
                $('.cpf').on('blur',function(){
                    var $this   =   $(this);   
                    var nome    =   $('input[name="nome"]');
                    var inputs  =   $('#botoes');
                    url.method  =   'get_cpf';

                    $.ajax({
                        type: 'post',
                        url: url.create(),
                        dataType: 'json',
                        data: {cpf:$this.val()},
                        success: function(data) {

                            var cpf =   data.cpf;

                            if(data.retorno == 1){

                                $('.error').remove();                                                                        
                                nome.val(data.nome);
                                inputs.css('display','block'); 

                            }else if(data.retorno   ==  0){

                                var diag_confirm_cpf    = new DV_dialog();

                                url.method  =   'confirm_cpf';

                                $.ajax({
                                    url : url.create(),
                                    type: 'post',
                                    data:{cpf:data.cpf,nome:data.nome},
                                    success : function(data){

                                        console.log(data);

                                        diag_confirm_cpf.title_program  =   'Confirmação de CPF';

                                        diag_confirm_cpf.buttons   =   [];

                                        diag_confirm_cpf.buttons.unshift
                                                ({text: 'Sim'
                                                , click: function() {                                                    
                                                    url.method  =   'save_cpf';                                                    
                                                    $.ajax({
                                                        url:        url.create(),
                                                        type:       'post',
                                                        dataType:   'json',
                                                        data:{cpf:cpf},
                                                        success:    function(data){
                                                            if(data.retorno == 1){                                                                

                                                                inputs.css('display','block');   

                                                                diag_confirm_cpf.close();

                                                                $('.error').remove();                                                                        

                                                                nome.val(data.nome);

                                                            }else{
                                                                alert('erro ao incluir');
                                                            }
                                                        }                                                        
                                                    });              



                                                }},
                                                {text: 'Não'
                                                , click: function() {
                                                    $(this).remove();

                                                    $('.error').remove();  
                                                    inputs.css('display','none');
                                                    $this.parent('div').append('<small class="error">Digite seu CPF</small>');
                                                    $this.val('');
                                                    nome.val('');
                                                    $this.focus();                                                        

                                                }}
                                                );                                           

                                        diag_confirm_cpf.open(data);
                                    }
                                });

                            }else if(data.retorno == 'erro'){

                                $('.error').remove();  
                                inputs.css('display','none');
                                $this.parent('div').append('<small class="error">CPF não encontrado no RMS</small>');
                                $this.val('');
                                nome.val('');
                                $this.focus();                               

                            }
                        }

                    });

                });

                $('.add_depesa_km').click(function(e){
                    e.preventDefault();

                    dialog_km();

                });

                $('.add_depesa_div').on('click',function(e){
                    e.preventDefault();

                    dialog_div();

                });    

            };            

            diag_novo.open(data);
                                                                                                         
        });
        
    });

    //Botão Editar
    $(".editar").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_editar = new DV_dialog();
        var obj_checked = $('.chkItm:checked').parents('tr');

        url.controller = 'C0026';
        url.method = 'editar';
        url.segment = obj_checked.find('.idRef').text();

        diag_editar.controller = url.controller;

        diag_editar.opening = function() {
                       
            $('.add_depesa_km').click(function(e){
                e.preventDefault();
                
                dialog_km();
                
            });
                        
            $('.add_depesa_div').on('click',function(e){
                e.preventDefault();

                dialog_div();

            });            
            
            $('.dialogSystem').on('click','.edit_line',function(){
                
                var inputs  =   $(this).parents('tr').find('input');
                
                dialog_km(inputs, $(this));
                
            });
                        
            $('.dialogSystem').on('click','.edit_line_div',function(){
                
                var inputs  =   $(this).parents('tr').find('input');
                
                dialog_div(inputs, $(this));
                
            });
            
            $('.dialogSystem').on('click','.remove',function(){
                
                remove_linha($(this));
                
            });
            
            $('.dialogSystem').on('click','.revisado_km',function(){
                
                revisar_km($(this),url.segment);

            });

            $('.dialogSystem').on('click','.revisado_div',function(){

                revisar_div($(this),url.segment);

            });            
                        
        };

        $.post(url.create(), function(dados) {

            diag_editar.title_program   = 'Editar ';
            diag_editar.title_dialog    = 'Reembolso de Despesa: #'+url.segment;
            diag_editar.buttons.unshift
                    ({text: 'Salvar'
                    , click: function() {
                        diag_editar.send_form();
                    }});

            diag_editar.open(dados);
            
        });

    });

    //Botão Detalhes
    $(".detalhes").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_detalhes = new DV_dialog();
        var obj_checked = $('.chkItm:checked').parents('tr');

        url.controller = 'C0026';
        url.method = 'detalhes';
        url.segment = obj_checked.find('.idRef').text();

        diag_detalhes.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_detalhes.title_dialog = 'Detalhes';
            diag_detalhes.buttons =
                    [
                        {
                            text: "Fechar",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    ];

            diag_detalhes.open(dados);
            
        });

    });

    //Botão Cancelar
    $('.cancelar').click(function() {

        var url = new DV_url();
        var diag_cancelar = new DV_dialog();
        var arr_data = new Array();
        var table = new DV_table();

        arr_data = table.get_checkeds();

        url.controller = 'C0026';
        url.method = 'cancelar';

        diag_cancelar.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_cancelar.title_dialog = 'Cancelar';
            
            diag_cancelar.buttons =
                    [
                        {
                            text: "Cancelar",
                            click: function() {
                                $.ajax({
                                    type: 'post',
                                    url: url.create(),
                                    data: {arr_data: arr_data},
                                    success: function(ret) {
                                        if (ret == '1') {
                                            diag_cancelar.close();
                                            diag_cancelar.redirect();
                                        } else {
                                        }
                                        diag_cancelar.redirect();
                                    }
                                });
                            }
                        },
                        {
                            text: "Fechar",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    ];            
            
            diag_cancelar.open(dados);
        });
    });
    
    //Botão Aprovar
    $('.aprovar').click(function() {

        var url = new DV_url();
        var diag_aprovar = new DV_dialog();
        var arr_data = new Array();
        var table = new DV_table();

        arr_data = table.get_checkeds_json();

        url.controller = 'C0026';
        url.method = 'aprovar';

        diag_aprovar.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_aprovar.title_dialog = 'Aprovar';

            diag_aprovar.buttons.unshift
                    ({text: 'Aprovar'
                                , click: function() {
                            $.ajax({
                                type: 'post',
//                                dataType: 'json',
                                url: url.create(),
                                data: {arr_data: arr_data},
                                success: function(data) {
                                    if(data!='1'){
                                        var diag_aprovar_pendencias = new DV_dialog();
                                        
                                        diag_aprovar_pendencias.opening =   function(){

                                            $('.aprovar_linha').on('click',function(){

                                                $(this).parents('tr').css('background','#a1f99e');

                                            });

                                            $('.reprovar_linha').on('click',function(){

                                                $(this).parents('tr').css('background','#eca2a0');

                                            });

                                        };                                        
                                        
                                        diag_aprovar_pendencias.title_dialog = 'Aprovar Pendências';
                                        
                                        diag_aprovar.close();
                                        diag_aprovar_pendencias.open(data);
                                        
                                    }else{
                                        diag_aprovar.close();
                                        diag_aprovar.redirect();
                                    }
                                }
                            });
                        }});

            diag_aprovar.open(dados);

        });
    });    
    
    $('.revisar').click(function(){
            
        var url = new DV_url();
        var diag_revisar = new DV_dialog();            
        var obj_checked = $('.chkItm:checked').parents('tr');

        url.controller = 'C0026';
        url.method = 'revisar';
        url.segment = obj_checked.find('.idRef').text();
            
        $.post(url.create(), function(dados) {

            diag_revisar.title_program   = 'Revisão ';
            diag_revisar.title_dialog    = 'Reembolso de Despesa: #'+url.segment;

            diag_revisar.opening =   function(){
                                            
                $('.dialogSystem').on('click','.vetado_km',function(){

                    vetar_km($(this),url.segment);
                
                });
                              
                $('.dialogSystem').on('click','.vetado_div',function(){

                    vetar_div($(this),url.segment);
                
                });
                
            };
            
            diag_revisar.buttons =
                    [
                        {
                            text: "Fechar",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    ];              

            diag_revisar.open(dados);

        });            
            
    });
    
    //Botão Upload
    $('.upload').click(function() {

        var url = new DV_url();
        var diag_upload = new DV_dialog();
        var obj_checked = $('.chkItm:checked').parents('tr');
//        var upload          =   new DV_upload();

        url.controller = 'C0026';
        url.method = 'upload';
        url.segment = obj_checked.find('.idRef').text();

        diag_upload.controller = url.controller;

        diag_upload.opening = function() {
            $('input[name=upload]').hide();
//            upload.init();
        };

        $.post(url.create(), function(dados) {

            diag_upload.title_dialog = 'Upload';
            diag_upload.buttons.unshift
                    ({text: 'Upload'
                                , type: 'submit'
                                , click: function() {

                            var options = {
                                beforeSend: function()
                                {
                                    $(".progress").show();
                                    //clear everything
                                    $(".bar").width('0%');
                                    $(".message").html("");
                                    $(".percent").html("0%");
                                },
                                uploadProgress: function(event, position, total, percentComplete)
                                {
                                    $(".bar").width(percentComplete + '%');
                                    $(".percent").html(percentComplete + '%');
                                },
                                success: function()
                                {
                                    $(".bar").width('100%');
                                    $(".percent").html('100%');
                                },
                                complete: function(response)
                                {
                                    diag_upload.close();
                                    diag_upload.open(response.responseText);
                                },
                                error: function()
                                {
                                    $(".message").html("<font color='red'> ERROR: unable to upload files</font>");
                                }

                            };

                            $('.form_upload').ajaxForm(options);
                            $('input[name=upload]:last').click();
                        }
                    });

            diag_upload.open(dados);

        });
    });  
    
    //Botão imprimir
    $('.imprimir').click(function() {

        var url = new DV_url();
        var table = new DV_table();

        url.controller = 'C0026';
        url.method = 'imprimir';
        url.segment = table.get_checkeds();

        $(this).attr('target', '_blank');
        $(this).attr('href', url.create());

    }); 
    
    //deletar arquivo
    $('.delete_file').on('click',function(event){
        event.preventDefault();
        var diag_file = new DV_dialog();
        var url = new DV_url();
        var $this   =   $(this);
        var arr_data =   $this.parents('tr:first').find('.file').text();
        
        url.controller = 'C0026';
        url.method = 'excluir_arquivo';
        
        diag_file.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_file.title_dialog = 'Excluir Arquivo';

            diag_file.buttons.unshift
                    ({text: 'Excluir'
                    , click: function() {
                            $.ajax({
                                type: 'post',
                                url: url.create(),
                                data: {arr_data: arr_data},
                                success: function(ret) {
                                    diag_file.close();
                                    if(ret=='1'){
                                        $this.parents('tr:first').remove(); 
                                    }
                                }
                            });
                        }});

            diag_file.open(dados);

        });       
        
        
    });       
    
});