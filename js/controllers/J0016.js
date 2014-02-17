$(function() {
    
    $.each($('.qtDias'),function(key, value){
       if($(this).text()>1){
           $(this).parent('tr').find('td').css('color','red');
       }
    });
    
    $('.delete_file').on('click',function(event){
        event.preventDefault();
        var diag_file = new DV_dialog();
        var url = new DV_url();
        var $this   =   $(this);
        var arr_data =   $this.parents('tr:first').find('.file').text();
        
        url.controller = 'C0016';
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
              
    //Botão Novo            
    $(".novo").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_novo = new DV_dialog();
        var mask = new DV_mask();
        
        url.controller = 'C0016';
        url.method = 'novo';
        
        diag_novo.opening = function() {

            $('.cmb_loja').on('change', function() {
                var cnpj = $('.dialogSystem .cnpj').val();
                var loja = $(this).val();
                url.controller = 'C0016';
                url.method = 'combo_workflow';

                $.ajax({
                    type: 'post',
                    url: url.create(),
                    dataType: 'json',
                    data: {cnpj: cnpj, loja: loja},
                    success: function(ret) {

                        $('.dialogSystem select[name=T059_codigo] option').remove();
                        $.each(ret, function(key, value) {
                            $('.dialogSystem select[name=T059_codigo]').append('<option value="' + key + '">' + key + ' - ' + value + '</option>');
                        });

                    }
                });


            });

            diag_novo.diag_wkf();

        };

        diag_novo.controller = url.controller;

        $.post(url.create(), function(dados) {
            diag_novo.title_dialog = 'Novo';
            diag_novo.buttons.unshift
                    ({text: 'Salvar'
                    , click: function() {
                            diag_novo.send_form();
                        }});

            diag_novo.open(dados);
        });

    });

    //Botão Editar            
    $(".editar").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_editar = new DV_dialog();
        var mask = new DV_mask();
        var obj_checked = $('.chkItm:checked').parents('tr');

        url.controller = 'C0016';
        url.method = 'editar';
        url.segment = obj_checked.find('.idRef').text();

        diag_editar.controller = url.controller;

        diag_editar.opening = function() {
            mask.init();
        };

        $.post(url.create(), function(dados) {

            diag_editar.title_dialog = 'Editar';
            diag_editar.buttons.unshift
                    ({text: 'Salvar'
                                , click: function() {
                            diag_editar.send_form();
                        }});

            diag_editar.open(dados);

        });

    });

    //Botão Visualizar
    $(".detalhes").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_detalhes = new DV_dialog();
        var mask = new DV_mask();
        var obj_checked = $('.chkItm:checked').parents('tr');

        url.controller = 'C0016';
        url.method = 'detalhes';
        url.segment = obj_checked.find('.idRef').text();

        diag_detalhes.controller = url.controller;

        diag_detalhes.opening = function() {
            mask.init();
        };

        $.post(url.create(), function(dados) {

            diag_detalhes.title_dialog = 'Visualizar';

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

        url.controller = 'C0016';
        url.method = 'cancelar';

        diag_cancelar.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_cancelar.title_dialog = 'Cancelar';
            diag_cancelar.buttons.unshift
                    ({text: 'Cancelar'
                                , click: function() {
                            $.ajax({
                                type: 'post',
                                url: url.create(),
                                data: {arr_data: arr_data},
                                success: function(ret) {
                                    if (ret == '1') {
//                                    table.display('none');
                                        diag_cancelar.close();
                                        diag_cancelar.redirect();
                                    } else {
                                    }
                                    diag_cancelar.redirect();
                                }
                            });
                        }});
            diag_cancelar.open(dados);
        });
    });

    //Botão Transferir
    $('.transferir').click(function() {

        var url = new DV_url();
        var diag_transferir = new DV_dialog();
        var arr_data = new Array();
        var table = new DV_table();

        arr_data = table.get_checkeds();

        url.controller = 'C0016';
        url.method = 'transferir';

        diag_transferir.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_transferir.title_dialog = 'Transferir';

            diag_transferir.buttons.unshift
                    ({text: 'Transferir'
                                , click: function() {
                            $.ajax({
                                type: 'post',
                                url: url.create(),
                                data: {arr_data: arr_data, T059_codigo: $('select[name=T059_codigo]').val()},
                                success: function(ret) {
                                    diag_transferir.close();
                                    diag_transferir.redirect();
                                }
                            });
                        }});

            diag_transferir.open(dados);  

        });
    });

    //Botão Aprovar
    $('.aprovar').click(function() {

        var url = new DV_url();
        var diag_aprovar = new DV_dialog();
        var arr_data = new Array();
        var table = new DV_table();

        arr_data = table.get_checkeds_json();

        url.controller = 'C0016';
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
                                success: function(ret) {
                                    diag_aprovar.close();
                                    diag_aprovar.redirect();
                                }
                            });
                        }});

            diag_aprovar.open(dados);

        });
    });

    //Botão Fluxo
    $('.fluxo').click(function() {

        var url = new DV_url();
        var diag_fluxo = new DV_dialog();
        var table = new DV_table();

        data = table.get_checkeds();

        url.controller = 'C0016';
        url.method = 'fluxo';
        url.segment = data;

        diag_fluxo.controller = url.controller;

        $.post(url.create(), function(dados) {

            diag_fluxo.title_dialog = 'Fluxo AP: ' + data;

            diag_fluxo.buttons =
                    [
                        {
                            text: "Fechar",
                            click: function() {
                                diag_fluxo.close();
                            }
                        }
                    ];

            diag_fluxo.open(dados);

        });
    });

    //Botão Upload
    $('.upload').click(function() {

        var url = new DV_url();
        var diag_upload = new DV_dialog();
        var obj_checked = $('.chkItm:checked').parents('tr');
//        var upload          =   new DV_upload();

        url.controller = 'C0016';
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

        url.controller = 'C0016';
        url.method = 'imprimir';
        url.segment = table.get_checkeds();

        $(this).attr('target', '_blank');
        $(this).attr('href', url.create());

    });

});