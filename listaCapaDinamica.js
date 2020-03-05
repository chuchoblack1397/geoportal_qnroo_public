$('#listaCapa').sortable({ 
     start: function(event, ui) 
     { 
         var start_pos = ui.item.index(); 
         ui.item.data('start_pos', start_pos); 
         
     }, 
     change: function(event, ui) 
     { 
         var start_pos = ui.item.data('start_pos'); 
         var index = ui.placeholder.index(); 
         if (start_pos < index) 
         { 
             $('#listaCapa li:nth-child(' + index + ')').addClass('highlights'); 
         } 
         else 
         { 
             $('#listaCapa li:eq(' + (index + 1) + ')').addClass('highlights'); 
             
         } 
         
     }, 
     update: function(event, ui) 
     {
         $('#listaCapa li').removeClass('highlights'); 

       
   
        var ordenElementos = $(this).sortable("toArray");
        var numCapa = 100;
        
        for(i=0; i < ordenElementos.length; i++){
             numCapa = 100+i;
             
            
                    if(ordenElementos[i] == 'capa_Ortofoto_de_muy_alta_resolución_(5_cm)'){
                         console.log('zIndex capa_Ortofoto_de_muy_alta_resolución_(5_cm): '+ numCapa);
                     }
                     
                    if(ordenElementos[i] == 'capa_Calles'){
                         console.log('zIndex capa_calles: '+ numCapa);
                     }
                     
                     if(ordenElementos[i] == 'capa_Predios'){
                         console.log('zIndex capa_predios: '+ numCapa);
                     }
                     
                     if(ordenElementos[i] == 'capa_Colonias'){
                         console.log('zIndex capa_colonias: '+ numCapa);
                     }
                     
                     if(ordenElementos[i] == 'capa_Canzanas'){
                         console.log('zIndex capa_manzanas: '+ numCapa);
                     }
                     
                     if(ordenElementos[i] == 'capa_Rezago'){
                         console.log('zIndex capa_rezago: '+ numCapa);
                     }

        }//fin for
        
     } 
 });
 
 function zIndexCapas(){
     
 }
