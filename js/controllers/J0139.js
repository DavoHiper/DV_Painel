$(function(){
    
    //Botão Novo            
    $(".pagamentos").click(function(event) {
        event.preventDefault();

        var url = new DV_url();
        var diag_pagto = new DV_dialog();

        url.controller = 'C0139';
        url.method = 'pagamentos';
        
        diag_pagto.controller    =   url.controller;

//        diag_pagto.width = '400';
        
        $.post(url.create(), function(dados) {
            diag_pagto.title_dialog = 'Pagamentos';
            diag_pagto.buttons.unshift
                    ({text: 'Salvar'
                     ,click: function() {
                            
                     }});
            diag_pagto.open(dados);
        });
    });
    
    
});