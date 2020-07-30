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
        this.svg = L.DomUtil.create('svg', iconClassName, this.container);
        this.legendContainer = L.DomUtil.create(
            'div',
            legendContainerClassName,
            this.container
        );

        L.DomEvent.on(this.container, 'click', this._click, this);

        return this.container;
    },
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);

        var style = window.getComputedStyle(this.svg);
        if (style.display === 'none') {
            this.container.classList.add(
                'leaflet-wms-legend-widget--collapsed'
            );
            this.svg.classList.add('d-block');
            this.containerTitle.classList.add('d-none');
            this.legendContainer.classList.add('d-none');
        } else {
            this.container.classList.remove(
                'leaflet-wms-legend-widget--collapsed'
            );
            this.svg.classList.remove('d-block');
            this.containerTitle.classList.remove('d-none');
            this.legendContainer.classList.remove('d-none');
        }
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
