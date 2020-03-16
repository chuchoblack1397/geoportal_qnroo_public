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
              mapa1=osm;
             validar=true;
              
             
              

              }//fin if
              else{
                  if(checked_calles){
                      console.log("Calle");
                      map.removeLayer(osm);
                      map.addLayer(streets);
                      map.removeLayer(grayscale);
                      map.removeLayer(googleSat);
                      mapa1=streets;
                      validar=true;
                     
                  }//fin if
                  else{
                        if(checked_grises){
                          console.log("Grises");

                      map.removeLayer(osm);
                      map.removeLayer(streets);
                      map.addLayer(grayscale);
                      map.removeLayer(googleSat);
                      mapa1=grayscale;
                      validar=true;
                         
                        }//fin if
                        else{
                             if(checked_google){
                                  console.log("GoogleSat");
                                  map.removeLayer(osm);
                                  map.removeLayer(streets);
                                  map.removeLayer(grayscale);
                                  map.addLayer(googleSat);  
                                  mapa1=osm;                               

                                  validar=false;
                                }//fin if
                                else{
                                    console.log("Nada");
                                }//fin else
                        }//fin else
                  }//fin else
              }//fin else














            /*if(checked_csm&& checked_csm1){
             

              mapa1=osm;
              mapa2=osm1;
            }
            else{
            if(checked_csm&& checked_calles1){
              
              
              map.removeLayer(grayscale);
              map.addLayer(osm);
              map.removeLayer(streets);
              map.removeLayer(googleSat);

              map.removeLayer(grayscale1);
            map.removeLayer(osm1);
            map.addLayer(streets1);
            map.removeLayer(googleSat1);
              mapa1=osm;
              mapa2=streets1;

            }
            else{
            if(checked_csm && checked_grises1){
             

              map.addLayer(grayscale1);
              map.removeLayer(osm1);
              map.removeLayer(streets1);
              map.removeLayer(googleSat1);

              mapa1=osm;
              mapa2=grayscale1;



            }else{
            if(checked_csm  && checked_google1){
              map.removeLayer(grayscale);
              map.addLayer(osm);
              map.removeLayer(streets);
              map.removeLayer(googleSat);

              map.addLayer(grayscale1);
              map.removeLayer(osm1);
              map.removeLayer(streets1);
              map.addLayer(googleSat1);
              mapa1=osm;
              mapa2=googleSat1;

            }
            else{
              if(checked_calles && checked_csm1)
              {
                map.removeLayer(grayscale);
                map.removeLayer(osm);
                map.addLayer(streets);
                map.removeLayer(googleSat);

                map.removeLayer(grayscale1);
              map.addLayer(osm1);
              map.removeLayer(streets1);
              map.removeLayer(googleSat1);
              mapa1=streets;
              mapa2=osm1;

              console.log("ffffffff");
              }
            if(checked_calles&& checked_calles1){
              map.removeLayer(grayscale);
              map.removeLayer(osm);
              map.addLayer(streets);
              map.removeLayer(googleSat);

              map.removeLayer(grayscale1);
              map.removeLayer(osm1);
              map.addLayer(streets1);
              map.removeLayer(googleSat1);

              mapa1=streets;
              mapa2=streets1;
            }
            else{
              if(checked_calles&& checked_grises1){
                map.removeLayer(grayscale);
                map.removeLayer(osm);
                map.addLayer(streets);
                map.removeLayer(googleSat);

                map.addLayer(grayscale1);
                map.removeLayer(osm1);
                map.removeLayer(streets1);
                map.removeLayer(googleSat1);
                mapa1=streets;
              mapa2=grayscale1;

              
              }
              else{
                if(checked_calles && checked_google1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                }
                else{
                  if(checked_grises && checked_csm1){
                    map.addLayer(grayscale);
                    map.removeLayer(osm);
                    map.removeLayer(streets);
                    map.removeLayer(googleSat);

                    map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                  }
                else
                if(checked_grises && checked_calles1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                }
              else{
                if(checked_grises&& checked_grises1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);

                } 
              else{
                if(checked_grises && checked_google1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                }
              else{
                if(checked_google && checked_csm1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                }
              else{
                if(checked_google && checked_calles1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                }
                else{
                if(checked_google && checked_grises1){
                  map.addLayer(grayscale);
                  map.removeLayer(osm);
                  map.removeLayer(streets);
                  map.removeLayer(googleSat);

                  map.addLayer(grayscale1);
                  map.removeLayer(osm1);
                  map.removeLayer(streets1);
                  map.removeLayer(googleSat1);
                }
                else{
                  if(checked_google && checked_google1){
                    map.addLayer(grayscale);
                    map.removeLayer(osm);
                    map.removeLayer(streets);
                    map.removeLayer(googleSat);

                    map.addLayer(grayscale1);
                    map.removeLayer(osm1);
                    map.removeLayer(streets1);
                    map.removeLayer(googleSat1);
                  }
                else{

                }
                }
                }
              }
              }
              }
              }

                }
              }
            }

            }
            }
          }
        }
              






           

            

           
          
               /* if(checked_csm){
                    console.log("OMS");
                    map.addLayer(osm);
                    mapa1=osm;
                  if(checked_csm1){
                    map.addLayer(osm);
                    map.removeLayer(streets);
                    map.removeLayer(grayscale);
                    map.removeLayer(googleSat);
                    
                    mapa2=osm;
                   
                    
                    
                  }else{

                  if(checked_calles1){
                    map.addLayer(streets);
                    map.removeLayer(grayscale);
                    map.removeLayer(googleSat);
                    mapa2=streets;
                    
                  }else {
                  if(checked_grises1){
                    map.addLayer(grayscale);
                    map.removeLayer(streets);
                    map.removeLayer(googleSat);
                    mapa2=grayscale;
                  }
                  else{
                    if(checked_google1){
                      map.addLayer(googleSat);
                      map.removeLayer(grayscale);
                      map.removeLayer(streets);
                      mapa2=googleSat;

                     
                    }
                    else{}
                  }
                  
                  }
                
              }
            
              // map.removeLayer(streets);
                    //map.removeLayer(grayscale);
                    //map.addLayer(googleSat);
                    }//fin if
                    else{
                      if(checked_calles){
                        console.log("OMS");
                        map.addLayer(streets);
                      if(checked_csm1){
                        map.addLayer(osm);

                      }else{
    
                      if(checked_calles1){
                        map.addLayer(streets);
                      }else {
                      if(checked_grises1){
                        map.addLayer(grayscale);
                      }
                      else{
                        if(checked_google1){
                          map.addLayer(googleSat);
                          
                        }
                        else{}
                      }
                      
                      }
                    
                  }
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



                  /* // map.removeLayer(streets);
                    //map.removeLayer(grayscale);
                    //map.addLayer(googleSat);
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
      */
            

        }//fin funcion validaRadioButtonControl
//fin radiobuttons

//--fin codigo ControlPanel



var mapa1, validar =true;

var mapa2 =googleSat ;
var control_side = L.control.sideBySide(mapa1,mapa2); // control de side, variable mapa1 y mapa 2 son los mapas a mostrarse



function mapas1(){ //aactiva el swipe
  
  if(mapa1== osm){
    map.addLayer(osm);  //validamos para osm
    map.addLayer(googleSat);
    control_side.addTo(map);
  }else{
  map.addLayer(googleSat);
  
  control_side.addTo(map);
  }

 
  

}



function removMapa(){ //funcion para desactivar el swipe
 
  if(validar == false){
    map.removeLayer(osm); //validamos para google sat
    
    control_side.remove(map);
  }else{
    
  map.removeLayer(googleSat);
  control_side.remove(map);
  }
 
}



