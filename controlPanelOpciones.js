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

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

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
                optionElement.innerHTML = value['nombre_proyecto'];
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

const wmsUrl = 'http://opb.geoportal.mx:8990/gs216/opb/wms';
const wmsOptions = {
    transparent: true,
    format: 'image/png',
    maxZoom: 22,
    info_format: 'application/json',
};
let source = L.WMS.source(wmsUrl, wmsOptions);
let layersObj = {};
let layersOrder = [];

const wmsLegendWidget = L.wmsLegendWidget();

function toggleLayer() {
    if (
        Object.keys(layersObj).length !== 0 &&
        layersObj.constructor === Object
    ) {
        const layer = layersObj[this.id];

        if (this.checked === true && !map.hasLayer(layer)) {
            layer.addTo(map);
            wmsLegendWidget.addLegend(layer);
        } else if (this.checked !== true && map.hasLayer(layer)) {
            layer.remove();
            wmsLegendWidget.removeLegend(layer);
        }
    }
}
const listaCapasFromProyecto = document.getElementById(
    'listaCapasFromProyecto'
);
if (!listaCapasFromProyecto.length) {
    const spanElement = document.createElement('span');
    const textElement = document.createTextNode(
        'Por favor selecciona un proyecto.'
    );
    spanElement.appendChild(textElement);
    spanElement.classList.add('text-info');
    listaCapasFromProyecto.appendChild(spanElement);
}
function loadCapasFromProyecto() {
    const valueProyecto =
        selectProyecto.options[selectProyecto.selectedIndex].value;
    const proyecto = 'proyecto=' + valueProyecto;

    while (listaCapasFromProyecto.firstChild) {
        listaCapasFromProyecto.removeChild(listaCapasFromProyecto.firstChild);
    }

    while (wmsLegendWidget.legendContainer.firstChild) {
        wmsLegendWidget.legendContainer.removeChild(
            wmsLegendWidget.legendContainer.firstChild
        );
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
        const spanElement = document.createElement('span');
        const textElement = document.createTextNode(
            'Por favor selecciona un proyecto.'
        );
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

                listItemElement.id = 'li_' + value['idcapa'];
                listItemElement.classList.add('mb-3');
                listItemElement.appendChild(divElement);

                divElement.classList.add('custom-control'); //agregue clase a div
                divElement.classList.add('custom-checkbox'); //agregue clase a div

                divElement.appendChild(inputElement);
                divElement.appendChild(labelElement);

                inputElement.type = 'checkbox';
                inputElement.id = value['idcapa']; //agregue chk
                inputElement.classList.add('custom-control-input');
                inputElement.name = 'chkGrupo';
                inputElement.value = value['idcapa'];

                labelElement.htmlFor = value['idcapa'];
                labelElement.classList.add('custom-control-label');
                labelElement.innerHTML = value['titulocapa'];

                listaCapasFromProyecto.appendChild(listItemElement);

                inputElement.addEventListener('change', toggleLayer);

                const legendURL = new URL(wmsUrl);
                const params = new URLSearchParams({
                    service: 'WMS',
                    version: '1.3',
                    request: 'GetLegendGraphic',
                    format: 'image/png',
                    layer: value['layer'],
                    transparent: true,
                    sld_version: '1.1.0',
                    style: '',
                });
                legendURL.search = params.toString();

                layersObj[value['idcapa']] = source.getLayer(value['layer']);
                const titulo = new DOMParser().parseFromString(
                    value['titulocapa'],
                    'text/html'
                ).body.textContent;
                layersObj[value['idcapa']].tituloCapa = titulo;
                layersObj[value['idcapa']].zIndex = parseInt(value['zindex']);
                layersObj[value['idcapa']].leyenda = legendURL.href;
                layersObj[value['idcapa']].idcapa = value['idcapa'];
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
