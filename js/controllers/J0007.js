$(function(){
	
//    Botão Novo            
     $( ".novo" ).click(function( event ) {
         event.preventDefault();
         
         $.post(DV_createURL('C0007','novo'),function(dados){
             
             dialog.titleDialog =   'Novo';
             dialog.textoBotao  =   'Salvar';            
             dialog.retorno = function(data){                 
                 dialog.fechar();
                 if(data!=='1'){
                    dialog.abrir(data);
                 }else{
                    $(location).attr('href', DV_createURL('C0007','index'));
                 }                                  
             };
             dialog.abrindo = function(){                 
                 $( ".radioset" ).buttonset();
             };
             dialog.fechando = function(){
                 $( ".radioset").buttonset('destroy');
                 $( ".radioset").remove();
             };
             dialog.abrir(dados);
         });
              
     });  
	
//    Botão Editar            
     $( ".editar" ).click(function( event ) {
         event.preventDefault();
         
         var segment    =   $( "input:checked" ).parent('td').parent('tr').find('.idRef').text();
          
         $.post(DV_createURL('C0007','editar',segment),function(dados){
             
             dialog.textoBotao = 'Editar';
             dialog.retorno = function(data){
                 if(data!=='1'){
                    dialog.abrir(data);
                 }else{
                    $(location).attr('href', DV_createURL('C0007','index'));
                 }
                 dialog.fechar();
             };
             dialog.abrindo = function(){
                 $( ".radioset" ).buttonset();
             };
             dialog.fechando = function(){
                 $( ".radioset").buttonset('destroy');
                 $( ".radioset").remove();
             };
             dialog.abrir(dados);
         });
              
     });  
	
//    Botão Excluir            
    $( ".excluir" ).click(function( event ) {
        event.preventDefault();
        var arrIdRef = new Array();
        
        $.each($(".chkItm:checked"),function(){
            arrIdRef.push($(this).parent('td').parent('tr').find('.idRef').text());
        });

        $.post(DV_createURL('C0007','excluir'),function(dados){
            
            dialogExcluir.arrIdRef      =   arrIdRef;
            dialogExcluir.controller    =   'C0007';
            dialogExcluir.method        =   'excluir';
            dialogExcluir.abrir(dados);
            
        });
                      
     });  
	            	  
});