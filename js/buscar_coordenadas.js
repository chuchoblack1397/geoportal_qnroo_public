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
        .addTo(map)
        .on('dragend', function() {
			var coord = marcador_coordenadas.getLatLng();
            coor_lat = coord.lat.toFixed(6);
            coor_lon = coord.lng.toFixed(6);
            marcador_coordenadas.bindPopup("<i>Latitud: "+coor_lat+"<br>Longitud: "+coor_lon+"</i>");
            console.log("Latitud: "+coor_lat+" - Longitud: "+coor_lon);
            document.getElementById('campoLatitud').value = coor_lat;
            document.getElementById('campoLongitud').value = coor_lon;
            map.setView({lat: coor_lat, lng: coor_lon},zoom);
		});

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

function guardarCoordenadas(){
    //var latitud = document.getElementById('campoLatitud').value;
    //var longitud = document.getElementById('campoLongitud').value;
    if(coor_lat == "" || coor_lon ==""){
        alert("Debe escribir coordenadas para guardar");
        return;
    }

    var markador = prompt("Marcador:", "");
    marcador_coordenadas.bindPopup("<center><b style='text-transform: uppercase;'>"+markador+"</b> <br> "+"<i>Latitud: </i>"+coor_lat+"<br><i>Longitud: </i>"+coor_lon+"</center>"); 
    marcador_coordenadas.dragging.disable();
    console.log("GUARDANDO "+markador+" Latitud: "+coor_lat+" - Longitud: "+coor_lon);
}