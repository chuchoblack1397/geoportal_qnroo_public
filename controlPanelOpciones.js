//codigo para controlPanel
//-------zoom
var zoomOut = document.getElementById('zoomOut');
var zoomIn = document.getElementById('zoomIn');

var zoom = document.getElementById('zoom');
zoom.addEventListener('change', zoomzoom);

var valorZoomMap = map.getZoom(); //obtiene el valor del zoom al iniciar

var currZoom = map.getZoom();
map.on('moveend', function (e) {
    //funcion para detectar cambios en el zoom del mapa y agregarlos al input range
    var newZoom = map.getZoom();
    if (currZoom != newZoom) {
        currZoom = newZoom;
        zoom.value = newZoom; //se agrega el cambio al input
    }
});

window.onload = zoomActual();

function zoomActual() {
    //funcion con el input Range
    zoom.value = valorZoomMap;
}

function zoomzoom() {
    //funcion con el input Range
    var nuevZoom = $(this).val();
    console.log(nuevZoom);
    map.setZoom(nuevZoom);
}

//--zoom con botones
$('#zoomOut').click(function () {
    var zoomMenos = map.getZoom() - 1;
    map.setZoom(zoomMenos);
});

$('#zoomIn').click(function () {
    var zoomMas = map.getZoom() + 1;
    map.setZoom(zoomMas);
});
//-------------------
//---------fin zoom

//--Acordeon
var acc = document.getElementsByClassName('accordion');
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener('click', function () {
        this.classList.toggle('active');
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + 'px';
        }
    });
}
//---fin arcordeon

//radioButtons
/* var radioButtonControl_ninguno = document.getElementById('radio_ninguno');
        radioButtonControl_ninguno.addEventListener("change", validaRadioButtonControl, false);*/

var radioButtonControl_csm = document.getElementById('radio_csm');
radioButtonControl_csm.addEventListener(
    'change',
    validaRadioButtonControl,
    false
);

var radioButtonControl_calles = document.getElementById('radio_calles');
radioButtonControl_calles.addEventListener(
    'change',
    validaRadioButtonControl,
    false
);

var radioButtonControl_grises = document.getElementById('radio_grises');
radioButtonControl_grises.addEventListener(
    'change',
    validaRadioButtonControl,
    false
);

var radioButtonControl_google = document.getElementById('radio_google');
radioButtonControl_google.addEventListener(
    'change',
    validaRadioButtonControl,
    false
);

var selector = document.getElementById('selectTipoS');
var selector2 = document.getElementById('selectTipoS1');
var boton1 = document.getElementById('botonSwipeA');
var boton2 = document.getElementById('btn_borrar');

var selector = document.getElementById('selectTipoS');
var selector2 = document.getElementById('selectTipoS1');
var boton1 = document.getElementById('botonSwipeA');
var boton2 = document.getElementById('btn_borrar');

window.onload = validaRadioButtonControl(); //al cargar la pagina va a validar el boton chekbox

function validaRadioButtonControl() {
    //funcion para evaluar el boton chkbox
    // var checked_ninguno = radioButtonControl_ninguno.checked;
    var checked_csm = radioButtonControl_csm.checked;
    var checked_calles = radioButtonControl_calles.checked;
    var checked_grises = radioButtonControl_grises.checked;
    var checked_google = radioButtonControl_google.checked;

    //segunda lista
    //   var checked_csm1 = radioButtonControl_csm1.checked;
    //  var checked_calles1 = radioButtonControl_calles1.checked;
    // var checked_grises1 = radioButtonControl_grises1.checked;
    //var checked_google1 = radioButtonControl_google1.checked;

    if (checked_csm) {
        console.log('OMS');

        map.addLayer(osm);
        map.removeLayer(streets);
        map.removeLayer(grayscale);
        map.removeLayer(googleSat);
    } //fin if
    else {
        if (checked_calles) {
            console.log('Calle');
            map.removeLayer(osm);
            map.addLayer(streets);
            map.removeLayer(grayscale);
            map.removeLayer(googleSat);

            validar = true;
        } //fin if
        else {
            if (checked_grises) {
                console.log('Grises');

                map.removeLayer(osm);
                map.removeLayer(streets);
                map.addLayer(grayscale);
                map.removeLayer(googleSat);
                mapa1 = grayscale;
                validar = true;
            } //fin if
            else {
                if (checked_google) {
                    console.log('GoogleSat');
                    map.removeLayer(osm);
                    map.removeLayer(streets);
                    map.removeLayer(grayscale);
                    map.addLayer(googleSat);
                    mapa1 = osm;

                    validar = false;
                } //fin if
                else {
                    console.log('Nada');
                } //fin else
            } //fin else
        } //fin else
    } //fin else
}

var activo;
var control;

function RecogerDatos() {
    //activa el el swipe
    var capa1 = eval(selector.value);
    var capa2 = eval(selector2.value);
    var control_side = L.control.sideBySide(capa1, capa2);

    if (activo == true) {
        activo = false;
        map.removeLayer(capa1);
        map.removeLayer(capa2); //removemos el swipe
        control.remove(map);
        console.log('si estoy entrando');
        boton1.disabled = false;
        boton2.disabled = true;
    } else {
        map.addLayer(capa1);
        map.addLayer(capa2);
        control_side.addTo(map);
        activo = true;
        control = control_side; //agregamos el mapa anterior
        boton2.disabled = false;
        boton1.disabled = true;
    }

    console.log(activo);

    console.log(activo);
}

function repetido() {
    if (selector.value == selector2.value) {
        console.log('esta repetido ');
        boton1.disabled = true;
        boton2.disabled = true;
    } else {
        if (selector2.value == 'ninguno' || selector.value == 'ninguno') {
            boton1.disabled = true;
            boton2.disabled = true;
        } else {
            boton1.disabled = false;
            boton2.disabled = false;
        }
    }
}
