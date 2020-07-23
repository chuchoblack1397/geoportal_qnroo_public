//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById('campoLatitud').onkeyup = function (event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById('btn_buscar').click();
    } //fin if
}; //fin funcion

//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById('campoLongitud').onkeyup = function (event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById('btn_buscar_coordenada').click();
    } //fin if
}; //fin funcion

var marcador_coordenadas="";
var coor_lat="";
var coor_lon="";

function buscarCoordenada(){
    coor_lat="";
    coor_lon="";
    var latitud = document.getElementById('campoLatitud').value;
    var longitud = document.getElementById('campoLongitud').value;
    if(marcador_coordenadas!=""){
        map.removeLayer(marcador_coordenadas);
    }

    if(latitud == '' ||longitud == ''){
        alert("Ingresa los campos de coordenadas");
        return;
    }

    if (isNaN(latitud) || isNaN(longitud)) {
        alert("No puedes buscar texto en coordenadas");
        return;
    }

    coor_lat = latitud;
    coor_lon = longitud;

    var zoom = 18;  
    map.setView({lat: coor_lat, lng: coor_lon},zoom);

        marcador_coordenadas = L.marker([coor_lat, coor_lon], {
        //title: "Latitud: "+latitud+" - Longitud: "+longitud,
        draggable:true,
        opacity: 1
        }).bindPopup("<i>Latitud: "+coor_lat+"<br>Longitud: "+coor_lon+"</i>")
        .addTo(map);
        marcador_coordenadas.dragging.disable();

};

function borrarCoordenada(){
    var latitud = document.getElementById('campoLatitud');
    var longitud = document.getElementById('campoLongitud');
    latitud.value = "";
    longitud.value = "";
    var zoom = 13;
    map.setView({lat: 18.5276, lng: -88.2963},zoom);
    map.removeLayer(this.marcador_coordenadas);
    marcador_coordenadas="";
};

function guardarCoordenadas(usuario){
    var accion = 'guardar';
    var latitud = document.getElementById('campoLatitud_guardar').value;
    var longitud = document.getElementById('campoLongitud_guardar').value;
    var markador = document.getElementById('campoMarcador').value;

    if(marcador_coordenadas!=""){
        map.removeLayer(marcador_coordenadas);
    }


    if(latitud == "" || longitud =="" || markador==""){
        swal('¿?', 'Completa los datos', 'info');
        return;
    }

    if (isNaN(latitud) || isNaN(longitud)) {
        swal('¿?', 'No puedes buscar texto en coordenadas', 'info');
        return;
    }

    markador = markador.trim();


    marcador_coordenadas = L.marker([latitud, longitud], {
        draggable:true,
        opacity: 1
        }).addTo(map);

    marcador_coordenadas.bindPopup("<center><b style='text-transform: uppercase;'>"+markador+"</b> <br> "+"<i>Latitud: </i>"+latitud+"<br><i>Longitud: </i>"+longitud+"</center>"); 
    marcador_coordenadas.dragging.disable();
    console.log("GUARDANDO "+markador+" Latitud: "+latitud+" - Longitud: "+longitud);


    var ruta = "accion="+accion+"&titulo="+markador+"&latitud="+latitud+"&longitud="+longitud+"&usuario="+usuario;
    console.log(ruta);

    $.ajax({
        url:"./php_crud_marcadores.php",
        type:"POST",
        data: ruta,
        success: function(respuesta){
            if(respuesta == "ok"){
                swal('Perfecto', 'Se han guardado tus coordenadas', 'success');
                borrarCoordenada_guardar();
            }//fin if
            if(respuesta == "error"){
                swal('Error', 'No se pudo guardar', 'error');
            }//fin if
            if(respuesta == "existe"){
                swal('¿?', 'Ya existe un marcador con ese nombre', 'warning');
            }//fin if
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });//fin ajax

};

//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById('campoMarcador').onkeyup = function (event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById('btn_buscar_coordenada_guardar').click();
    } //fin if
}; //fin funcion

//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById('campoLatitud_guardar').onkeyup = function (event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById('btn_buscar_coordenada_guardar').click();
    } //fin if
}; //fin funcion

//------- metodo para detectar tecla ENTER en el input campoBuscar----------------
document.getElementById('campoLongitud_guardar').onkeyup = function (event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById('btn_buscar_coordenada_guardar').click();
    } //fin if
}; //fin funcion

function buscarCoordenada_guardar(){
    coor_lat="";
    coor_lon="";
    var latitud = document.getElementById('campoLatitud_guardar').value;
    var longitud = document.getElementById('campoLongitud_guardar').value;
    if(marcador_coordenadas!=""){
        map.removeLayer(marcador_coordenadas);
    }

    if(latitud == '' ||longitud == ''){
        //alert("Ingresa los campos de coordenadas");
        swal('¿?', 'Ingresa los campos de coordenadas', 'info');
        return;
    }

    if (isNaN(latitud) || isNaN(longitud)) {
        //alert("No puedes buscar texto en coordenadas");
        swal('¿?', 'No puedes buscar texto en coordenadas', 'info');
        return;
    }

    
    var zoom = 18;  
    map.setView({lat: latitud, lng: longitud},zoom);

        marcador_coordenadas = L.marker([latitud, longitud], {
        //title: "Latitud: "+latitud+" - Longitud: "+longitud,
        draggable:true,
        opacity: 1
        }).bindPopup("<i>Latitud: "+latitud+"<br>Longitud: "+longitud+"</i>")
        .addTo(map)
        .on('dragend', function() {
			var coord = marcador_coordenadas.getLatLng();
            latitud = coord.lat.toFixed(6);
            longitud = coord.lng.toFixed(6);
            marcador_coordenadas.bindPopup("<i>Latitud: "+latitud+"<br>Longitud: "+longitud+"</i>");
            console.log("Latitud: "+latitud+" - Longitud: "+longitud);
            document.getElementById('campoLatitud_guardar').value = latitud;
            document.getElementById('campoLongitud_guardar').value = longitud;
            map.setView({lat: latitud, lng: longitud},zoom);
		});

};

function borrarCoordenada_guardar(){
    var marcador = document.getElementById('campoMarcador');
    var latitud = document.getElementById('campoLatitud_guardar');
    var longitud = document.getElementById('campoLongitud_guardar');
    marcador.value = "";
    latitud.value = "";
    longitud.value = "";
    var zoom = 13;
    map.setView({lat: 18.5276, lng: -88.2963},zoom);
    map.removeLayer(marcador_coordenadas);
    //marcador_coordenadas="";
};

function ver_marcadores(){
    console.log("Viendo");
    var accion = 'ver';
    ruta="accion="+accion;

    $.ajax({
        url:"./php_crud_marcadores.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            document.getElementById("contenedor_lista_marcadores").innerHTML="<center><span>Cargando...</span></center>";//vaciar la tabla
        },
        success: function(res){
            seccionVerUser=document.getElementById("contenedor_lista_marcadores");
            seccionVerUser.innerHTML=res;
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });//fin ajax

};

function buscar_coordenada_lista(titulo,latitud, longitud){
    
    if(marcador_coordenadas!=""){
        map.removeLayer(marcador_coordenadas);
    }

    var zoom = 18;  
    map.setView({lat: latitud, lng: longitud},zoom);

        marcador_coordenadas = L.marker([latitud, longitud], {
        title: titulo,
        draggable:true,
        opacity: 1
        }).bindPopup("<b>"+titulo+"</b><br><i>Latitud: "+latitud+"<br>Longitud: "+longitud+"</i>")
        .addTo(map);
        marcador_coordenadas.dragging.disable();
};

function cerrar_marcadores(){
    if(marcador_coordenadas!=""){
        map.removeLayer(marcador_coordenadas);
        var zoom = 13;
        map.setView({lat: 18.5276, lng: -88.2963},zoom);
        map.removeLayer(marcador_coordenadas);
    }
    
};

function borrar_coordenada_lista(marcador){
        console.log('Borrando: '+marcador);
        var accion = "eliminar";
        var ruta="accion="+accion+"&marcador="+marcador;

        swal({
            title: "Espera!",
            text: "¿Deseas eliminar el marcador: "+marcador+"?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:'php_crud_marcadores.php',
                        type:'POST',
                        data: ruta,
                        beforeSend:function(){
                            document.getElementById("contenedor_lista_marcadores").innerHTML="<center><span>Eliminando...</span></center>";//vaciar la tabla
                        },
                        success: function(respuesta){
                            if(respuesta == "ok"){
                                swal('Perfecto', 'Se ha eliminado el marcador: '+marcador, 'success');
                                ver_marcadores();
                            }//fin if
                            if(respuesta == "error"){
                                swal('Error', 'No se pudo eliminar', 'error');
                            }//fin if
                        
                    }
                    });
                } 
                
            });
};