// Get the user's w3w API key via prompt


var key = "HVMXTN3Q"

var endpoint = 'https://api.what3words.com/v2';
var lang = 'es';
var defaultCoords = [45.21433, 5.80749];
var dragging = false;

L.Marker.prototype.animateDragging = function() {
  var iconMargin, shadowMargin;
  this.on('dragstart', function() {
    dragging = true;
    if (!iconMargin) {
      iconMargin = parseInt(L.DomUtil.getStyle(this._icon, 'marginTop'));
      shadowMargin = parseInt(L.DomUtil.getStyle(this._shadow, 'marginLeft'));
    }
    this._icon.style.marginTop = (iconMargin - 15) + 'px';
    this._shadow.style.marginLeft = (shadowMargin + 8) + 'px';
  });
  return this.on('dragend', function() {
    dragging = false;
    this._icon.style.marginTop = iconMargin + 'px';
    this._shadow.style.marginLeft = shadowMargin + 'px';
  });
};

// what3words Marker
var myIcon = L.icon({
  iconUrl: './img/marker-border.png',
  iconSize: [90, 90],
  iconAnchor: [45, 90],
  shadowUrl: './img/marker-shadow.png',
  shadowSize: [68, 95],
  shadowAnchor: [22, 94],
  popupAnchor: [0, -75]
});

/*var map = L.map('map').setView(defaultCoords, 15);*/

/*L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);*/

var w3wmarker = L.marker(defaultCoords, {
    icon: myIcon,
    draggable: true
  })
  .on('dragend', updateOnDragEnd)
  .on('move', update3wordaddress)
  .animateDragging()
  .addTo(map);

var w3wgrid = L.geoJson(null, {
  style: function() {
    return {
      weight: 1,
      opacity: 0.5,
      color: '#777',
      fill: false,
      clickable: false
    };
  }
});

map.addLayer(w3wgrid);

function onMapMoveEnd(evt) {
  w3wgrid.clearLayers();
  if( map.getZoom() >= 19) {
    var bounds = map.getBounds();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    var data = {
      'key': key,
      'format': 'geojson',
      'bbox': ne.lat + ',' + ne.lng + ',' + sw.lat + ',' + sw.lng
    };
    $.getJSON(endpoint + '/grid', data, function(response) {
      w3wgrid.addData(response);
    });
  }
}

function onMapClick(evt) {
  var latlon = evt.latlng;
  var lat = latlon.lat;
  var lon = latlon.lng;
  w3wmarker.setLatLng(L.latLng(lat, lon));
}

function getLangs() {
  var data = {
    'key': key
  };
  var langs = $('#lang');
  jQuery.get(endpoint + '/languages', data, function(response) {
    console.log(response);
    $.each(response.languages, function() {
      /*jshint -W106 */
      var display = this.native_name + ' (' + this.name + ')';
      /*jshint +W106 */
      if (this.code === 'es') {
        langs.append($('<option />').val(this.code).text(display).prop('selected', true));
      } else {
        langs.append($('<option />').val(this.code).text(display));
      }
    });
  });
}

function updateLang() {
  lang = $('#lang').val();
  update3wordaddress();
}

function updateOnDragEnd(e) {
  dragging = false;
  update3wordaddress(e);
}

function update3wordaddress(e) {
  var position;
  if (dragging) {
    return;
  }
  if (e === undefined || e.latlng === undefined) {
    position = L.latLng(w3wmarker.getLatLng().lat, w3wmarker.getLatLng().lng).wrap();
  } else {
    position = L.latLng(e.latlng).wrap();
  }
  var data = {
    'key': key,
    'lang': lang,
    'coords': position.lat + ',' + position.lng
  };

  $.get(endpoint + '/reverse', data, function(response) {
    console.log(response);
    $('#w3w').text(response.words);
  });
}

$(function() {
  getLangs();
  update3wordaddress();

  map.on('click', onMapClick);
  map.on('moveend', onMapMoveEnd);

  $('#lang').on('change', updateLang);
});
