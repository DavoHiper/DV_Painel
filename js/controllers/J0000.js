$(function(){
   $("#dialog-link").click(function(){
    $("#dialog").dialog({
                autoOpen: true,
                open:dialog.abrindo,
                close:dialog.fechando,
                modal: true,
                resizable:false,
                draggable:false,
                dialogClass:'dialogSystem',
                title: 'Titulo Teste',
                width: 400,
                buttons: [
                        {
                            text: 'Salvar',
                            click: function() {
                                var frm = $(dialog.atual).find('form');
                                $(dialog.atual).find('form').submit(function(event) {

                                  var form = $(this);

                                  $.ajax({
                                    type    : form.attr('method'),
                                    url     : form.attr('action'),
                                    data    : form.serializeArray(),
                                    success :dialog.retorno

                                  });
                                  event.preventDefault(); // Prevent the form from submitting via the browser.
                                }).trigger('submit');                                       

                            }                                        
                        },
                        {
                            text: "Cancelar",
                            click: function() {
                                    $( this ).dialog( "close" );
                            }
                        }
                ]
        });       
   });
  
    
    
});