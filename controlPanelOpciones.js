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
        selector.disabled = false;
        selector2.disabled = false;
    } else {
        map.addLayer(capa1);
        map.addLayer(capa2);
        control_side.addTo(map);
        activo = true;
        control = control_side; //agregamos el mapa anterior
        boton2.disabled = false;
        boton1.disabled = true;
        selector.disabled = true;
        selector2.disabled = true;
    }

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

const selectProyecto = document.getElementById('selectProyecto');

function loadSelectProyectos() {
    let request = new XMLHttpRequest();
    request.open('GET', './verProyectos.php', true);

    request.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            const respuesta = JSON.parse(this.response);

            respuesta.forEach((value, index) => {
                const optionElement = document.createElement('option');
                optionElement.value = value['id_proyecto'];
                optionElement.text = value['nombre_proyecto'];
                selectProyecto.appendChild(optionElement);
            });
        } else {
            alert(
                'Hubo un error al intentar conectarse con el servidor: Conexión fallida.\n' +
                    this.statusText
            );
        }
    };

    request.onerror = function () {
        alert(
            'Hubo un error al intentar conectarse con el servidor: Conexión fallida.'
        );
    };

    request.send();
}

loadSelectProyectos();

let layersObj = {};

function toggleLayer() {
    if (
        Object.keys(layersObj).length !== 0 &&
        layersObj.constructor === Object
    ) {
        if (this.checked === true && !map.hasLayer(layersObj[this.id])) {
            layersObj[this.id].addTo(map);
        } else if (this.checked !== true && map.hasLayer(layersObj[this.id])) {
            layersObj[this.id].remove();
        }
    }
}

const listaCapasFromProyecto = document.getElementById(
    'listaCapasFromProyecto'
);
function loadCapasFromProyecto() {
    const valueProyecto =
        selectProyecto.options[selectProyecto.selectedIndex].value;
    const proyecto = 'proyecto=' + valueProyecto;

    while (listaCapasFromProyecto.firstChild) {
        listaCapasFromProyecto.removeChild(listaCapasFromProyecto.firstChild);
    }

    if (
        Object.keys(layersObj).length !== 0 &&
        layersObj.constructor === Object
    ) {
        for (const key of Object.keys(layersObj)) {
            map.removeLayer(layersObj[key]);
            delete layersObj[key];
        }
    }

    if (valueProyecto === '') {
        return;
    }

    let request = new XMLHttpRequest();
    request.open('POST', './verProyectos.php', true);

    request.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8'
    );

    request.onload = function () {
        if (this.status >= 200 && this.status < 400) {
            const respuesta = JSON.parse(this.response);

            respuesta.forEach((value, index) => {
                const listItemElement = document.createElement('li');
                const divElement = document.createElement('div');
                const inputElement = document.createElement('input');
                const labelElement = document.createElement('label');
                const breakElement = document.createElement('br');
                const divLeyendElement = document.createElement('div');
                const btnElement = document.createElement('button');
                const spanElement = document.createElement('span');

                listItemElement.classList.add('px-3');

                inputElement.id = value['idcapa'];
                inputElement.classList.add('form-check-input');
                inputElement.type = 'checkbox';
                inputElement.value = '';

                labelElement.classList.add('form-check-label');
                labelElement.htmlFor = value['idcapa'];
                labelElement.textContent = value['titulocapa'];

                listItemElement.appendChild(inputElement);
                listItemElement.appendChild(labelElement);

                listaCapasFromProyecto.appendChild(listItemElement);

                inputElement.addEventListener('change', toggleLayer);

                const layer = L.tileLayer.wms(value['urlcapa'], {
                    layers: value['layer'],
                    format: value['formato'],
                    transparent: value['transparencia'],
                    maxZoom: 22,
                    version: value['version'],
                    style: value['estilo'],
                    zIndex: value['zindex'],
                });

                layersObj[value['idcapa']] = layer;
            });

            delete layersObj.length;
        } else {
            alert(
                'Hubo un error al intentar conectarse con el servidor: Conexión fallida.\n' +
                    this.statusText
            );
        }
    };

    request.onerror = function () {
        alert(
            'Hubo un error al intentar conectarse con el servidor: Conexión fallida.'
        );
    };

    request.send(proyecto);
}

selectProyecto.addEventListener('change', loadCapasFromProyecto);
