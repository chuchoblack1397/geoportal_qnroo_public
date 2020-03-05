//codigo para controlPanel
//-------zoom
    var zoomOut = document.getElementById('zoomOut');
    var zoomIn = document.getElementById('zoomIn');


    var zoom = document.getElementById('zoom');
    zoom.addEventListener("change", zoomzoom);
    
    var valorZoomMap = map.getZoom();//obtiene el valor del zoom al iniciar

    var currZoom = map.getZoom();
    map.on('moveend', function(e) {//funcion para detectar cambios en el zoom del mapa y agregarlos al input range
      var newZoom = map.getZoom();
      if (currZoom != newZoom) {
        currZoom = newZoom;
        zoom.value=newZoom;//se agrega el cambio al input
      }
    });

    window.onload = zoomActual();

    function zoomActual(){//funcion con el input Range
        zoom.value=valorZoomMap;
        }
    
    function zoomzoom(){//funcion con el input Range
    var nuevZoom = $(this).val();
    console.log(nuevZoom);
    map.setZoom(nuevZoom);
    }

    //--zoom con botones
    $("#zoomOut").click(function(){
       var zoomMenos = map.getZoom() - 1;
       map.setZoom(zoomMenos);
    });
    
    $("#zoomIn").click(function(){
        var zoomMas = map.getZoom() + 1;
        map.setZoom(zoomMas);
   });
   //-------------------
//---------fin zoom

//--Acordeon 
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
//---fin arcordeon

//radioButtons
       /* var radioButtonControl_ninguno = document.getElementById('radio_ninguno');
        radioButtonControl_ninguno.addEventListener("change", validaRadioButtonControl, false);*/

        var radioButtonControl_csm = document.getElementById('radio_csm');
        radioButtonControl_csm.addEventListener("change", validaRadioButtonControl, false);
        
        var radioButtonControl_calles = document.getElementById('radio_calles');
        radioButtonControl_calles.addEventListener("change", validaRadioButtonControl, false);
        
        var radioButtonControl_grises = document.getElementById('radio_grises');
        radioButtonControl_grises.addEventListener("change", validaRadioButtonControl, false);
        
        var radioButtonControl_google = document.getElementById('radio_google');
        radioButtonControl_google.addEventListener("change", validaRadioButtonControl, false);

        window.onload = validaRadioButtonControl(); //al cargar la pagina va a validar el boton chekbox

        function validaRadioButtonControl(){//funcion para evaluar el boton chkbox
           // var checked_ninguno = radioButtonControl_ninguno.checked;
            var checked_csm = radioButtonControl_csm.checked;
            var checked_calles = radioButtonControl_calles.checked;
            var checked_grises = radioButtonControl_grises.checked;
            var checked_google = radioButtonControl_google.checked;

          
                if(checked_csm){
                    console.log("OMS");
                    map.addLayer(osm);
                    map.removeLayer(streets);
                    map.removeLayer(grayscale);
                    map.removeLayer(googleSat);
                    }//fin if
                    else{
                        if(checked_calles){
                            console.log("Calle");
                            map.addLayer(streets);
                            map.removeLayer(osm); 
                            map.removeLayer(grayscale);
                            map.removeLayer(googleSat);
                        }//fin if
                        else{
                              if(checked_grises){
                                console.log("Grises");
                                map.addLayer(grayscale);
                                map.removeLayer(osm);
                                map.removeLayer(streets);
                                map.removeLayer(googleSat);
                              }//fin if
                              else{
                                   if(checked_google){
                                        console.log("GoogleSat");
                                        map.addLayer(googleSat);
                                        map.removeLayer(osm);
                                        map.removeLayer(streets);
                                        map.removeLayer(grayscale);
                                      }//fin if
                                      else{
                                          console.log("Nada");
                                      }//fin else
                              }//fin else
                        }//fin else
                    }//fin else
      
            

        }//fin funcion validaRadioButtonControl
//fin radiobuttons

//checkbox
       /* var chkBoxControl_fotoChilpo = document.getElementById('chk_fotoChilpo');//fotochilpo
        chkBoxControl_fotoChilpo.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_callesChilpo = document.getElementById('chk_callesChilpo');//calles
        chkBoxControl_callesChilpo.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_prediosChilpo = document.getElementById('chk_prediosChilpo');//predios
        chkBoxControl_prediosChilpo.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_colonias = document.getElementById('chk_colonias');//colonias
        chkBoxControl_colonias.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_manzanas = document.getElementById('chk_manzanas');//manzanas
        chkBoxControl_manzanas.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_rezago = document.getElementById('chk_rezago');//rezago
        chkBoxControl_rezago.addEventListener("change", validaChkBoxControl, false);
        

        window.onload = validaChkBoxControl(); //al cargar la pagina va a validar el boton chekbox

        function validaChkBoxControl(){//funcion para evaluar el boton chkbox
            var checked_chkBoxControl_fotoChilpo = chkBoxControl_fotoChilpo.checked;//fotochilpo
            var checked_chkBoxControl_callesChilpo = chkBoxControl_callesChilpo.checked;//calles
            var checked_chkBoxControl_prediosChilpo = chkBoxControl_prediosChilpo.checked;//predios
            var checked_chkBoxControl_colonias = chkBoxControl_colonias.checked;//colonias
            var checked_chkBoxControl_manzanas = chkBoxControl_manzanas.checked;//manzanas
            var checked_chkBoxControl_rezago = chkBoxControl_rezago.checked;//rezago



      
            if(checked_chkBoxControl_fotoChilpo){
                console.log("fotoChilpo");
                map.addLayer(capa_Ortofoto_de_muy_alta_resolucion_5_cm);
            }//fin if
            else{
                console.log("No-fotoChilpo");
                map.removeLayer(capa_Ortofoto_de_muy_alta_resolucion_5_cm);
            }//fin else
            
            if(checked_chkBoxControl_callesChilpo){
                console.log("Calles Chilpo");
                map.addLayer(capa_calles);
            }//fin if
            else{
                console.log("No-Calles Chilpo");
                map.removeLayer(capa_calles);
            }//fin else
            
            if(checked_chkBoxControl_prediosChilpo){
                console.log("Predios Chilpo");
                map.addLayer(capa_predios);
            }//fin if
            else{
                console.log("No-Predios Chilpo");
                map.removeLayer(capa_predios);
            }//fin else
            
            if(checked_chkBoxControl_colonias){
                console.log("Colonias");
                map.addLayer(capa_colonias);
            }//fin if
            else{
                console.log("No-Colonias");
                map.removeLayer(capa_colonias);
            }//fin else
            
            if(checked_chkBoxControl_manzanas){
                console.log("Manzanas");
                map.addLayer(capa_manzanas);
            }//fin if
            else{
                console.log("No-Manzanas");
                map.removeLayer(capa_manzanas);
            }//fin else
            
            if(checked_chkBoxControl_rezago){
                console.log("Rezago");
                map.addLayer(capa_rezago);
            }//fin if
            else{
                console.log("No-Rezago");
                map.removeLayer(capa_rezago);
            }//fin else

        }//fin funcion validaRadioButtonControl
//fin checkbox
*/
//--fin codigo ControlPanel