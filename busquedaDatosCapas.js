//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById('campoBuscar').onkeyup = function (event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById('btn_buscar').click();
    } //fin if
}; //fin funcion

var resultadoWMSlayer;
var resultadoWMSlayerOPACA;

//---- metodo de Click para buscar dato del input campoBuscar-------
//$("#btn_buscar").click(function(){
function buscarFiltro(){
    document.getElementById("contenedorResultado").style.display = "block";
    console.log("Buscando...");
    var variable_consulta_filtro = document.getElementById('campoBuscar').value;//asignacion de la variable
    console.log("Valor de Busqueda: "+variable_consulta_filtro);
    var valueRecibido = document.getElementById('selectTipo').value;//asignacion de la variable

    var valueRecibidoArreglo = valueRecibido.split("|");//una vez obtenido el valor del campo, lo secciono en 4 partes
    var selectTipo = valueRecibidoArreglo[0];//esta parte obtendra el tipo (osea la capa de donde se consultará)
    var url = valueRecibidoArreglo[1];//esta parte obtendra la url
    var layer = valueRecibidoArreglo[2];//esta parte obtendra la capa
    var campoFiltro = valueRecibidoArreglo[3];//esta parte obtiene el filtro 

    console.log("Tipo de Busqueda: "+selectTipo);
    console.log("URL de Busqueda: "+url);
    console.log("Capa de Busqueda: "+layer);
    console.log("Filtro de Busqueda: "+campoFiltro);

    
    if(variable_consulta_filtro !== '' && campoFiltro!='0'){//detecta si tiene datos el campo
        console.log("Hay datos en la variable de busqueda.");
        var ruta="variable_consulta_filtro="+variable_consulta_filtro+"&campo_filtro="+campoFiltro;
        $.ajax({
                url:'php_busquedaDatosCapas.php',
                type:'POST',
                data: ruta,
                beforeSend:function(){
                    document.getElementById("contenedorResultado").innerHTML="Buscando...";
                },
                success: function(res){
                $('#contenedorResultado').html(res);
            },
            error: function(){
                alert( "Error al realizar la busqueda" );
            } 
        });  
    }//fin if
    else{
        //alert('Asegurese que los parametros de busqueda sean correctos.');
        if(resultadoWMSlayer){//evaluando si existe la capa
            window.map.removeLayer(resultadoWMSlayer);//quitando la capa
            window.map.removeLayer(resultadoWMSlayerOPACA);//quitando la capa
        }
        document.getElementById("contenedorResultado").innerHTML="<b><span style='color:red'>Asegurese que los parametros de busqueda sean correctos</span></b>";
    }//fin else
}//fin metodo

function buscarUbicacionFiltro(latitud, longitud, variable_busqueda,centroideGeom,filtro,layer){

        var centroide = centroideGeom;
        
        if(resultadoWMSlayer){//evaluando si existe la capa
            console.log("Existe una capa, Borrando...");
            window.map.removeLayer(resultadoWMSlayer);//quitando la capa
            window.map.removeLayer(resultadoWMSlayerOPACA);//quitando la capa
        }

        if(centroide != ''){

            //---extrayendo las coordenadas en variables separadas----
            var centroSinPOINT = centroide.slice(6,-1);//quitando el texto POINT
            console.log("Centro sin texto POINT:" + centroSinPOINT);
            longitud = centroSinPOINT.split(' ')[0];
            console.log("Longitud: " + longitud);
            latitud = centroSinPOINT.split(' ')[1];
            console.log("Latitud: " + latitud);
            console.log("Filtro: " + filtro);
            console.log("Variable busqueda: " + variable_busqueda);
            console.log(filtro +" = "+ variable_busqueda);
            //---fin extraer-----
        }
            // capa de busqueda de predio
            resultadoWMSlayer= L.tileLayer.wms('http://144.91.126.153:8990/gs216/opb/wms',
            {
                layers: layer,
                format: 'image/png',
                transparent: true,
                zIndex:102,
                CQL_FILTER: filtro+"='"+variable_busqueda+"'"
            });//fin capa
            
            window.map.addLayer(resultadoWMSlayer);//agregando capa

            // capa de busqueda de predio OPACA
            resultadoWMSlayerOPACA= L.tileLayer.wms('http://144.91.126.153:8990/gs216/opb/wms',
            {
                layers: layer,
                format: 'image/png',
                transparent: true,
                zIndex:101,
                opacity: 0.2
            });//fin capa
            
            window.map.addLayer(resultadoWMSlayerOPACA);//agregando capa

            if(window.map.addLayer(resultadoWMSlayer)){
                console.log("Agregada");
            }
            else{
                console.log("Error.");
            }

            //var latitud = 17.5546;
            //var longitud = -99.4995;
            var zoom = 18;  
            map.setView({lat: latitud, lng: longitud},zoom);
            

            //map.setView({lat: latitud, lng: longitud}, zoom);//funcion para mover el mapa hasta el predio
            
            //map.panTo({lat: latitud, lng: longitud}); // otra funcion para mover el mapa hasta el predio
        
}//fin metodo

//CERRAR o ELIMINAR BUSQUEDA
var btn_borrarFiltro = document.getElementById("btn_borrarFiltro");
function borrarFiltro(){
    document.getElementById("contenedorResultado").innerHTML="";
    document.getElementById("contenedorResultado").style.display = "none";
    if(resultadoWMSlayer){//evaluando si existe la capa
        window.map.removeLayer(resultadoWMSlayer);//quitando la capa
        window.map.removeLayer(resultadoWMSlayerOPACA);//quitando la capa
    }

}
