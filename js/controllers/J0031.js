$(function() {
    
    //Botão Novo            
    $(".novo").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_novo = new DV_dialog();
        var mask = new DV_mask();
        
        url.controller = 'C0031';
        url.method = 'novo';

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

        var url         =   new DV_url();
        var diag_editar =   new DV_dialog();
        var mask        =   new DV_mask();
        var table       =   new DV_table();
        var arr_data    =   new Array();

        url.controller = 'C0031';
        url.method = 'editar';
        
        arr_data = table.get_checkeds_json();
        
        diag_editar.controller = url.controller;

        $.post(url.create(), {arr_data:arr_data},function(dados) {

            diag_editar.title_dialog = 'Editar';
            diag_editar.buttons.unshift
                    ({text: 'Salvar'
                                , click: function() {
                                    $.ajax({
                                        type: 'post',
                                        url: url.create(),
                                        data: {arr_data: arr_data},
                                        success: function(ret) {
                                            diag_file.close();
                                            if(ret=='1'){
                                                alert('aew');
                                            }
                                        }
                                    });
                        }});

            diag_editar.open(dados);

        });

    });

    //Botão Excluir
    $('.excluir').click(function() {

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


});