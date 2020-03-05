//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById("campoBuscar").onkeyup = function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
    document.getElementById("btn_buscar").click();
    }//fin if
}//fin funcion

var resultadoWMSlayer;

//---- metodo de Click para buscar dato del input campoBuscar-------
$("#btn_buscar").click(function(){
    console.log("Buscando...");
    var variable_clave_catastral = document.getElementById('campoBuscar').value;//asignacion de la variable
    console.log("Valor de Busqueda: "+variable_clave_catastral);
    var selectTipo = document.getElementById('selectTipo').value;//asignacion de la variable
    console.log("Tipo de Busqueda: "+selectTipo);
    
    if(variable_clave_catastral !== ''){//detecta si tiene datos el campo
        console.log("Hay datos en la variable de busqueda.");
        
        if(resultadoWMSlayer){//evaluando si existe la capa
            console.log("Existe una capa, Borrando...");
            window.map.removeLayer(resultadoWMSlayer);//quitando la capa
        }
        
        
        
        if(selectTipo=='nombre'){
            // capa de busqueda de predio
            resultadoWMSlayer= L.tileLayer.wms("http://74.208.210.103:8990/geos/pievi/wms",
            {
                layers: 'pievi:vap_e12_partido',
                format: 'image/png',
                transparent: true,
                zIndex:101,
                CQL_FILTER:'nombre='+variable_clave_catastral
            });//fin capa
            
            window.map.addLayer(resultadoWMSlayer);//agregando capa
        }//fin if
        
        
        
        if(selectTipo=='partido'){// capa de busqueda de predio
            console.log("Dentro del tipo PARTIDO.");
            resultadoWMSlayer= L.tileLayer.wms("http://74.208.210.103:8990/geos/pievi/wms",
            {
                layers: 'pievi:vap_e12_partido',
                format: 'image/png',
                transparent: true,
                maxZoom: 22,
                zIndex:101,
                CQL_FILTER:'partido='+variable_clave_catastral
            });//fin capa
            
            window.map.addLayer(resultadoWMSlayer);
            
            if(window.map.addLayer(resultadoWMSlayer)){
                console.log("Agregada");
            }
            else{
                console.log("Error.");
            }
            //agregando capa
        }//fin if
        
        
        
        if(selectTipo=='metodo'){
            // capa de busqueda de predio
            resultadoWMSlayer= L.tileLayer.wms("http://74.208.210.103:8990/geos/pievi/wms",
            {
                layers: 'pievi:vap_e12_partido',
                format: 'image/png',
                transparent: true,
                zIndex:101,
                CQL_FILTER:'metodo='+variable_clave_catastral
            });//fin capa
            
            window.map.addLayer(resultadoWMSlayer);//agregando capa
        }//fin if
        
       
        
        
           /* 
            var latitud = 17.5546;
            var longitud = -99.4995;
            
            var zoom = 18;
            
            map.setView({lat: latitud, lng: longitud},zoom);
            */
            
            //map.setView({lat: latitud, lng: longitud}, zoom);//funcion para mover el mapa hasta el predio
            
            //map.panTo({lat: latitud, lng: longitud}); // otra funcion para mover el mapa hasta el predio
            
            //PROBAR PROBAR PROBAR PROBAR
        
    }//fin if
    else{
        if(predioWMSlayer){//evaluando si existe la capa
            window.map.removeLayer(predioWMSlayer);//quitando la capa
        }
    }//fin else
});//fin metodo