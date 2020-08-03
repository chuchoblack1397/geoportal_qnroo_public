/*
 * L.Control.WMSLegendWidget is used to add multiple WMS Legends to the map
 */

L.Control.WMSLegendWidget = L.Control.extend({
    options: {
        position: 'topright',
    },
    onAdd: function () {
        const controlClassName = 'leaflet-wms-legend-widget',
            titleClassName = 'leaflet-wms-legend-widget__title',
            iconClassName = 'leaflet-wms-legend-widget__icon icon-list',
            legendContainerClassName = 'leaflet-wms-legend-widget__legends',
            stop = L.DomEvent.stopPropagation;
        this.container = L.DomUtil.create('div', controlClassName);
        this.containerTitle = L.DomUtil.create(
            'h6',
            titleClassName,
            this.container
        );
        this.containerTitle.textContent = 'Simbología';
        this.icon = L.DomUtil.create('span', iconClassName, this.container);
        this.legendContainer = L.DomUtil.create(
            'div',
            legendContainerClassName,
            this.container
        );

        L.DomEvent.on(this.container, 'click', this._click, this)
            .on(this.container, 'mousewheel', stop)
            .on(this.container, 'mousedown', stop)
            .on(this.container, 'dblclick', stop)
            .on(this.container, 'click', L.DomEvent.preventDefault)
            .on(this.container, 'click', stop);

        this.shrink();

        return this.container;
    },
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);

        var style = window.getComputedStyle(this.icon);
        if (style.display === 'none') {
            this.shrink();
        } else {
            this.expand();
        }
    },
    expand: function () {
        this.container.classList.remove('leaflet-wms-legend-widget--collapsed');
        this.icon.classList.remove('d-block');
        this.containerTitle.classList.remove('d-none');
        this.legendContainer.classList.remove('d-none');

        this.container.removeAttribute('data-toggle');
        this.container.removeAttribute('data-placement');
        this.container.removeAttribute('title');
        $('.leaflet-wms-legend-widget').tooltip('dispose');
    },
    shrink: function () {
        this.container.classList.add('leaflet-wms-legend-widget--collapsed');
        this.icon.classList.add('d-block');
        this.containerTitle.classList.add('d-none');
        this.legendContainer.classList.add('d-none');

        this.container.setAttribute('data-toggle', 'tooltip');
        this.container.setAttribute('data-placement', 'left');
        this.container.title = 'Simbología';
        $('.leaflet-wms-legend-widget').tooltip();
    },
    addLegend: function (layer) {
        const legendClassName = 'wms-legend';
        const legendContainerClassName =
            'leaflet-wms-legend-widget__legends-container';

        const legendImg = L.DomUtil.create(
            'img',
            legendClassName,
            this.container
        );
        const legendContainer = L.DomUtil.create(
            'div',
            legendContainerClassName
        );
        const legendLayerTitle = L.DomUtil.create('h6');

        legendLayerTitle.textContent = layer.tituloCapa;
        legendImg.src = layer.leyenda;
        legendContainer.id = layer.idcapa + '-legend';
        legendContainer.appendChild(legendLayerTitle);
        legendContainer.appendChild(legendImg);
        this.legendContainer.appendChild(legendContainer);
    },
    removeLegend: function (layer) {
        const legendContainer = document.getElementById(
            layer.idcapa + '-legend'
        );
        this.legendContainer.removeChild(legendContainer);
    },
});

L.wmsLegendWidget = function () {
    const wmsLegendWidget = new L.Control.WMSLegendWidget();
    map.addControl(wmsLegendWidget);
    return wmsLegendWidget;
};
