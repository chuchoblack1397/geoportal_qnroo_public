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

function buscarCoordenada(){
    var latitud = document.getElementById('campoLatitud').value;
    var longitud = document.getElementById('campoLongitud').value;

    if(latitud == '' ||longitud == ''){
        alert("Ingresa los campos de coordenadas");
        return;
    }

    if (isNaN(latitud) || isNaN(longitud)) {
        alert("No puedes buscar texto en coordenadas");
        return;
    }
    
    var zoom = 18;  
    map.setView({lat: latitud, lng: longitud},zoom);

        marcador_coordenadas = L.marker([latitud, longitud], {
        title: "Latitud: "+latitud+" - Longitud: "+longitud,
        draggable:true,
        opacity: 1
        }).bindPopup("<i>Latitud: "+latitud+"<br>Longitud: "+longitud+"</i>")
        .addTo(map);

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