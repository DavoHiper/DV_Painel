$(function() {

    //Botão Novo            
    $(".novo").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_novo = new DV_dialog();

        url.controller = 'C0004';
        url.method = 'novo';
        
        diag_novo.controller    =   url.controller;

        diag_novo.opening   =   function(){
            
        };


        diag_novo.width = '400';

        $.post(url.create(), function(dados) {
            diag_novo.title_dialog = 'Novo';
            diag_novo.buttons.unshift
                    ({text: 'Salvar'
                     ,click: function() {
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
        var obj_checked =   $('.chkItm:checked').parents('tr');

        url.controller = 'C0004';
        url.method = 'editar';
        url.segment = obj_checked.find('.idRef').text();
        
        diag_editar.controller    =   url.controller;

        diag_editar.width = '400';
        

        $.post(url.create(), function(dados) {
            
            diag_editar.title_dialog = 'Editar';
            
            diag_editar.buttons.unshift
                    ({text: 'Salvar'
                     ,click: function() {
                            diag_editar.send_form();
                     }});
                 
            diag_editar.open(dados);
        });
    });
    
    //Botão Excluir            
    $(".excluir").click(function( event ) {
        event.preventDefault();
        
        var url = new DV_url();
        var diag_excluir = new DV_dialog();
        var arr_data = new Array();
        var table   =   new DV_table();
        
        url.controller = 'C0004';
        url.method = 'excluir';
        
        diag_excluir.controller =   url.controller;
        diag_excluir.method =   url.method;
        
        arr_data    =   table.get_checkeds();        
        
        $.post(url.create(), function(data) {            
            diag_excluir.title_dialog = 'Excluir';
            
            diag_excluir.buttons.unshift
                    ({text: 'Excluir'
                     ,click: function() {
                         $.post(url.create(),{arr_data:arr_data},function(){
                             diag_excluir.redirect();
                         });

                     }});
                 
            diag_excluir.open(data);
        });        
                      
     });      
    
});