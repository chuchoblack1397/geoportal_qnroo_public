var c = new L.Control.Coordinates();
c.addTo(map);


map.on('click', function(e) {
   
    console.log("rrrrrrrrrrrrrrrrr")
    c.setCoordinates(e);
    
    L.marker([c.setCoordinates(e)])
	.bindLabel('A sweet static label!', { noHide: true })
	.addTo(map);
});