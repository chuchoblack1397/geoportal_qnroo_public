(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['leaflet'], factory);
    } else if (typeof module !== 'undefined') {
        module.exports = factory(require('leaflet'));
    } else {
        if (typeof this.L === 'undefined')
            throw 'Leaflet must be loaded first!';
        this.L.WMS = this.L.wms = factory(this.L);
    }
})(function (L) {
    var wms = {};
    if (!('keys' in Object)) {
        Object.keys = function (obj) {
            var result = [];
            for (var i in obj) {
                if (obj.hasOwnProperty(i)) {
                    result.push(i);
                }
            }
            return result;
        };
    }
    wms.Source = L.Layer.extend({
        options: { untiled: true, identify: true },
        initialize: function (url, options) {
            L.setOptions(this, options);
            if (this.options.tiled) {
                this.options.untiled = false;
            }
            this._url = url;
            this._subLayers = {};
            this._overlay = this.createOverlay(this.options.untiled);
        },
        createOverlay: function (untiled) {
            var overlayOptions = {};
            for (var opt in this.options) {
                if (opt != 'untiled' && opt != 'identify') {
                    overlayOptions[opt] = this.options[opt];
                }
            }
            if (untiled) {
                return wms.overlay(this._url, overlayOptions);
            } else {
                return wms.tileLayer(this._url, overlayOptions);
            }
        },
        onAdd: function () {
            this.refreshOverlay();
        },
        getEvents: function () {
            if (this.options.identify) {
                return { click: this.identify };
            } else {
                return {};
            }
        },
        setOpacity: function (opacity) {
            this.options.opacity = opacity;
            if (this._overlay) {
                this._overlay.setOpacity(opacity);
            }
        },
        bringToBack: function () {
            this.options.isBack = true;
            if (this._overlay) {
                this._overlay.bringToBack();
            }
        },
        bringToFront: function () {
            this.options.isBack = false;
            if (this._overlay) {
                this._overlay.bringToFront();
            }
        },
        getLayer: function (name) {
            return wms.layer(this, name);
        },
        addSubLayer: function (name) {
            this._subLayers[name] = true;
            this.refreshOverlay();
        },
        removeSubLayer: function (name) {
            delete this._subLayers[name];
            this.refreshOverlay();
        },
        refreshOverlay: function () {
            let layers = [...Object.keys(this._subLayers)];
            layersOrder.length = 0;
            layers.forEach((value) => {
                Object.values(layersObj).some((val, ind) => {
                    if (val['_name'] === value) {
                        layersOrder.push(val);
                    }
                });
            });
            layersOrder.sort((a, b) => a.zIndex - b.zIndex);
            layers.length = 0;
            layersOrder.forEach((value) => {
                layers.push(value['_name']);
            });

            var subLayers = layers.join(',');
            if (!this._map) {
                return;
            }
            if (!subLayers) {
                this._overlay.remove();
            } else {
                this._overlay.setParams({ layers: subLayers });
                this._overlay.addTo(this._map);
            }
        },
        identify: function (evt) {
            var layers = this.getIdentifyLayers();
            if (!layers.length) {
                return;
            }
            if (infoToggler.classList.contains('activo')) {
                layersOrder.length = 0;
                layers.forEach((value) => {
                    Object.values(layersObj).some((val, ind) => {
                        if (val['_name'] === value) {
                            layersOrder.push(val);
                        }
                    });
                });
                layersOrder.sort((a, b) => a.zIndex - b.zIndex);
                layers.length = 0;
                layersOrder.forEach((value) => {
                    layers.push(value['_name']);
                });

                this.getFeatureInfo(
                    evt.containerPoint,
                    evt.latlng,
                    layers,
                    this.showFeatureInfo
                );
            }
        },
        getFeatureInfo: function (point, latlng, layers, callback) {
            var params = this.getFeatureInfoParams(point, layers),
                url = this._url + L.Util.getParamString(params, this._url);
            this.showWaiting();
            this.ajax(url, done);
            function done(result) {
                this.hideWaiting();
                var text = this.parseFeatureInfo(result, url, latlng);
                callback.call(this, latlng, text);
            }
        },
        ajax: function (url, callback) {
            ajax.call(this, url, callback);
        },
        getIdentifyLayers: function () {
            if (this.options.identifyLayers) return this.options.identifyLayers;
            return Object.keys(this._subLayers);
        },
        getFeatureInfoParams: function (point, layers) {
            var wmsParams, overlay;
            if (this.options.untiled) {
                wmsParams = this._overlay.wmsParams;
            } else {
                overlay = this.createOverlay(true);
                overlay.updateWmsParams(this._map);
                wmsParams = overlay.wmsParams;
                wmsParams.layers = layers.join(',');
            }
            var infoParams = {
                request: 'GetFeatureInfo',
                query_layers: layers.join(','),
                X: Math.round(point.x),
                Y: Math.round(point.y),
            };
            return L.extend({}, wmsParams, infoParams);
        },
        parseFeatureInfo: function (result, url, latlng) {
            if (result == 'error') {
                result =
                    "<iframe src='" +
                    url +
                    "' style='border:none;width:500px;height:200px'>";
                return result;
            }
            const data = JSON.parse(result);
            const divMain = document.createElement('div');
            divMain.classList.add('popup__container');

            if (Object.keys(data['features']).length === 0) {
                divMain.textContent =
                    'No se encontró información acerca de este punto.';
            } else {
                const divHeader = document.createElement('div');
                const coordsPopup = document.createElement('div');
                const coordLat = document.createElement('span');
                const coordLong = document.createElement('span');
                const titlePopup = document.createElement('div');
                const dataContainer = document.createElement('div');
                const footer = document.createElement('div');
                const zoomIn = document.createElement('div');

                coordsPopup.appendChild(coordLat);
                coordsPopup.appendChild(coordLong);
                divHeader.appendChild(titlePopup);
                divHeader.appendChild(coordsPopup);
                divMain.appendChild(divHeader);
                divMain.appendChild(dataContainer);
                footer.appendChild(zoomIn);

                divHeader.classList.add('popup__header');
                titlePopup.classList.add('tituloPopup');
                coordsPopup.classList.add('coordenadasPopup');
                dataContainer.classList.add('popup__data');
                footer.classList.add('popup__footer');

                titlePopup.textContent = 'Atributos descriptivos';
                coordLat.textContent = `Lat: ${latlng.lat.toFixed(6)}`;
                coordLong.textContent = `Long: ${latlng.lng.toFixed(6)}`;

                const featureCount = data['features'].length;

                data['features'].forEach((value, index) => {
                    const layerId = value['id'];
                    const [layerName, featureNo] = layerId.split(
                        /\.(?=[^\.]+$)/
                    );

                    const titleLayer = document.createElement('h6');
                    const table = document.createElement('table');
                    const tableBody = document.createElement('tbody');
                    const tableContainer = document.createElement('div');

                    table.appendChild(tableBody);
                    tableContainer.appendChild(titleLayer);
                    tableContainer.appendChild(table);
                    dataContainer.appendChild(tableContainer);

                    table.classList.add(
                        'table',
                        'table-striped',
                        'popup__table'
                    );

                    titleLayer.classList.add('popup__title');
                    tableContainer.classList.add('popup__feature');
                    tableContainer.id = 'popupData' + (index + 1).toString();

                    if (index > 0) {
                        tableContainer.classList.add('d-none');
                    }

                    Object.values(layersObj).some((val, ind) => {
                        if (val['_name'].includes(layerName)) {
                            titleLayer.textContent = val['tituloCapa'];
                            return val['_name'].includes(layerName);
                        }
                    });
                    Object.keys(value['properties']).forEach((val, ind) => {
                        const tableRow = document.createElement('tr');
                        const tableHeader = document.createElement('th');
                        const tableData = document.createElement('td');

                        tableHeader.textContent = val;
                        if (
                            typeof value['properties'][val] === 'string' &&
                            value['properties'][val].includes('http')
                        ) {
                            const link = document.createElement('a');
                            link.href = value['properties'][val];
                            link.textContent = value['properties'][val];
                            link.target = '_blank';
                            tableData.appendChild(link);
                        } else {
                            tableData.textContent = value['properties'][val];
                        }

                        tableRow.appendChild(tableHeader);
                        tableRow.appendChild(tableData);
                        tableBody.appendChild(tableRow);
                    });
                });

                if (featureCount > 1) {
                    const nextBtn = document.createElement('btn');
                    const nextBtnIcon = document.createElement('span');
                    const prevBtn = document.createElement('btn');
                    const prevBtnIcon = document.createElement('span');
                    const pagination = document.createElement('div');
                    const paginationLabel = document.createElement('div');
                    const currentPage = document.createElement('span');
                    const pageCount = document.createElement('span');

                    prevBtn.classList.add('btn', 'btn-light', 'disabled');
                    prevBtnIcon.classList.add('icon-arrow-left');
                    nextBtn.classList.add('btn', 'btn-light');
                    nextBtnIcon.classList.add('icon-arrow-right');
                    pagination.classList.add('popup__footer-pag');
                    paginationLabel.classList.add('popup__footer-pag-label');

                    prevBtn.addEventListener('click', this.prevFeature);
                    nextBtn.addEventListener('click', this.nextFeature);

                    prevBtn.id = 'popupPrevBtn';
                    nextBtn.id = 'popupNextBtn';
                    currentPage.id = 'currentPage';
                    pageCount.id = 'pageCount';

                    currentPage.setAttribute('data-currentpage', 1);
                    pageCount.setAttribute('data-pagecount', featureCount);

                    currentPage.textContent = '1';
                    pageCount.textContent = ' de ' + featureCount.toString();

                    prevBtn.appendChild(prevBtnIcon);
                    nextBtn.appendChild(nextBtnIcon);
                    paginationLabel.appendChild(currentPage);
                    paginationLabel.appendChild(pageCount);
                    pagination.appendChild(prevBtn);
                    pagination.appendChild(paginationLabel);
                    pagination.appendChild(nextBtn);
                    footer.appendChild(pagination);
                }

                divMain.appendChild(footer);
            }

            return divMain;
        },
        nextFeature: function () {
            const dataContainer = document.getElementsByClassName(
                'popup__data'
            )[0];
            const currentPage = document.getElementById('currentPage');
            const pageCount = document.getElementById('pageCount');
            const prevBtn = document.getElementById('popupPrevBtn');
            const nextBtn = document.getElementById('popupNextBtn');

            const currentPageValue = parseInt(
                currentPage.attributes['data-currentpage'].value
            );
            const pageCountValue = parseInt(
                pageCount.attributes['data-pagecount'].value
            );

            if (currentPageValue + 1 <= pageCountValue) {
                const query = `#popupData${currentPageValue}`;
                const nextQuery = `#popupData${currentPageValue + 1}`;
                const currentTable = dataContainer.querySelector(query);
                const nextTable = dataContainer.querySelector(nextQuery);

                if (prevBtn.classList.contains('disabled')) {
                    prevBtn.classList.remove('disabled');
                }

                currentTable.classList.add('d-none');
                nextTable.classList.remove('d-none');

                currentPage.attributes['data-currentpage'].value =
                    currentPageValue + 1;
                currentPage.textContent =
                    currentPage.attributes['data-currentpage'].value;

                if (currentPageValue + 1 === pageCountValue) {
                    nextBtn.classList.add('disabled');
                }
            }
        },
        prevFeature: function () {
            const dataContainer = document.getElementsByClassName(
                'popup__data'
            )[0];
            const currentPage = document.getElementById('currentPage');
            const pageCount = document.getElementById('pageCount');
            const prevBtn = document.getElementById('popupPrevBtn');
            const nextBtn = document.getElementById('popupNextBtn');

            const currentPageValue = parseInt(
                currentPage.attributes['data-currentpage'].value
            );
            const pageCountValue = parseInt(
                pageCount.attributes['data-pagecount'].value
            );

            if (currentPageValue - 1 > 0) {
                const query = `#popupData${currentPageValue}`;
                const prevQuery = `#popupData${currentPageValue - 1}`;
                const currentTable = dataContainer.querySelector(query);
                const prevTable = dataContainer.querySelector(prevQuery);

                if (nextBtn.classList.contains('disabled')) {
                    nextBtn.classList.remove('disabled');
                }

                currentTable.classList.add('d-none');
                prevTable.classList.remove('d-none');

                currentPage.attributes['data-currentpage'].value =
                    currentPageValue - 1;
                currentPage.textContent =
                    currentPage.attributes['data-currentpage'].value;

                if (currentPageValue - 1 === 1) {
                    prevBtn.classList.add('disabled');
                }
            }
        },
        showFeatureInfo: function (latlng, info) {
            if (!this._map) {
                return;
            }
            this._map.openPopup(info, latlng, {
                maxWidth: 400,
                minWidth: 400,
                maxHeight: 340,
            });
        },
        showWaiting: function () {
            if (!this._map) return;
            this._map._container.style.cursor = 'progress';
        },
        hideWaiting: function () {
            if (!this._map) return;
            this._map._container.style.cursor = 'default';
        },
    });
    wms.source = function (url, options) {
        return new wms.Source(url, options);
    };
    wms.Layer = L.Layer.extend({
        initialize: function (source, layerName, options) {
            L.setOptions(this, options);
            if (!source.addSubLayer) {
                source = wms.getSourceForUrl(source, options);
            }
            this._source = source;
            this._name = layerName;
        },
        onAdd: function () {
            if (!this._source._map) this._source.addTo(this._map);
            this._source.addSubLayer(this._name);
        },
        onRemove: function () {
            this._source.removeSubLayer(this._name);
        },
        setOpacity: function (opacity) {
            this._source.setOpacity(opacity);
        },
        bringToBack: function () {
            this._source.bringToBack();
        },
        bringToFront: function () {
            this._source.bringToFront();
        },
    });
    wms.layer = function (source, layerName, options = null) {
        return new wms.Layer(source, layerName, options);
    };
    var sources = {};
    wms.getSourceForUrl = function (url, options) {
        if (!sources[url]) {
            sources[url] = wms.source(url, options);
        }
        return sources[url];
    };
    wms.TileLayer = L.TileLayer.WMS;
    wms.tileLayer = L.tileLayer.wms;
    wms.Overlay = L.Layer.extend({
        defaultWmsParams: {
            service: 'WMS',
            request: 'GetMap',
            version: '1.1.0',
            layers: '',
            styles: '',
            format: 'image/jpeg',
            transparent: false,
            feature_count: 50,
        },
        options: {
            crs: null,
            uppercase: false,
            attribution: '',
            opacity: 1,
            isBack: false,
            minZoom: 0,
            maxZoom: 18,
        },
        initialize: function (url, options) {
            this._url = url;
            var params = {},
                opts = {};
            for (var opt in options) {
                if (opt in this.options) {
                    opts[opt] = options[opt];
                } else {
                    params[opt] = options[opt];
                }
            }
            L.setOptions(this, opts);
            this.wmsParams = L.extend({}, this.defaultWmsParams, params);
        },
        setParams: function (params) {
            L.extend(this.wmsParams, params);
            this.update();
        },
        getAttribution: function () {
            return this.options.attribution;
        },
        onAdd: function () {
            this.update();
        },
        onRemove: function (map) {
            if (this._currentOverlay) {
                map.removeLayer(this._currentOverlay);
                delete this._currentOverlay;
            }
            if (this._currentUrl) {
                delete this._currentUrl;
            }
        },
        getEvents: function () {
            return { moveend: this.update };
        },
        update: function () {
            if (!this._map) {
                return;
            }
            this.updateWmsParams();
            var url = this.getImageUrl();
            if (this._currentUrl == url) {
                return;
            }
            this._currentUrl = url;
            var bounds = this._map.getBounds();
            var overlay = L.imageOverlay(url, bounds, { opacity: 0 });
            overlay.addTo(this._map);
            overlay.once('load', _swap, this);
            function _swap() {
                if (!this._map) {
                    return;
                }
                if (overlay._url != this._currentUrl) {
                    this._map.removeLayer(overlay);
                    return;
                } else if (this._currentOverlay) {
                    this._map.removeLayer(this._currentOverlay);
                }
                this._currentOverlay = overlay;
                overlay.setOpacity(
                    this.options.opacity ? this.options.opacity : 1
                );
                if (this.options.isBack === true) {
                    overlay.bringToBack();
                }
                if (this.options.isBack === false) {
                    overlay.bringToFront();
                }
            }
            if (
                this._map.getZoom() < this.options.minZoom ||
                this._map.getZoom() > this.options.maxZoom
            ) {
                this._map.removeLayer(overlay);
            }
        },
        setOpacity: function (opacity) {
            this.options.opacity = opacity;
            if (this._currentOverlay) {
                this._currentOverlay.setOpacity(opacity);
            }
        },
        bringToBack: function () {
            this.options.isBack = true;
            if (this._currentOverlay) {
                this._currentOverlay.bringToBack();
            }
        },
        bringToFront: function () {
            this.options.isBack = false;
            if (this._currentOverlay) {
                this._currentOverlay.bringToFront();
            }
        },
        updateWmsParams: function (map) {
            if (!map) {
                map = this._map;
            }
            var bounds = map.getBounds();
            var size = map.getSize();
            var wmsVersion = parseFloat(this.wmsParams.version);
            var crs = this.options.crs || map.options.crs;
            var projectionKey = wmsVersion >= 1.3 ? 'crs' : 'srs';
            var nw = crs.project(bounds.getNorthWest());
            var se = crs.project(bounds.getSouthEast());
            var params = { width: size.x, height: size.y };
            params[projectionKey] = crs.code;
            params.bbox = (wmsVersion >= 1.3 && crs === L.CRS.EPSG4326
                ? [se.y, nw.x, nw.y, se.x]
                : [nw.x, se.y, se.x, nw.y]
            ).join(',');
            L.extend(this.wmsParams, params);
        },
        getImageUrl: function () {
            var uppercase = this.options.uppercase || false;
            var pstr = L.Util.getParamString(
                this.wmsParams,
                this._url,
                uppercase
            );
            return this._url + pstr;
        },
    });
    wms.overlay = function (url, options) {
        return new wms.Overlay(url, options);
    };
    function ajax(url, callback) {
        var context = this,
            request = new XMLHttpRequest();
        request.onreadystatechange = change;
        request.open('GET', url);
        request.send();
        function change() {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    callback.call(context, request.responseText);
                } else {
                    callback.call(context, 'error');
                }
            }
        }
    }
    return wms;
});
