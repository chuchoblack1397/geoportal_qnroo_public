<?php
    session_start();
    
        if(isset($_POST['campUsuario']) && isset($_POST['campoContra'])){//asignando los valores obtenidos del login para las variables de session
            echo "<script>console.log('Recibiendo datos de POST');</script>";
            
            $_SESSION['usuarioSession'] = $_POST['campUsuario'];
            $_SESSION['usuarioPass'] = $_POST['campoContra'];
            echo "<script>console.log('Asignando datos a SESSION');</script>";
        }
        
         if(isset($_SESSION['usuarioSession']) && isset($_SESSION['usuarioPass'])){//verificando si existe una session iniciada
            echo "<script>console.log('Validando SESSION');</script>";
            
            include 'conexion.php';
            
            $miUsuario = $_SESSION['usuarioSession'];
            $miContra = $_SESSION['usuarioPass'];

            
            $consulta = "SELECT * FROM usuarios WHERE user='$miUsuario' AND pass='$miContra'";
			$resultado = mysqli_query($conexion,$consulta);

					if($row=mysqli_num_rows($resultado) > 0){//comprueba si existe el usuario
					    echo "<script>console.log('Se encontro Usuario');</script>";
					    
					    while($datoUsuarioPrivilegio = $resultado->fetch_assoc()){//obteniendo el dato del privilegio
					        echo "<script>console.log('DENTRO DEL WHILE');</script>";
					        $privilegio = $datoUsuarioPrivilegio['privilegio'];//asigna el valor del campo 'privilegio' a una variable normal
					        $nombre = $datoUsuarioPrivilegio['nombreUsuario'];
					        $aPaterno = $datoUsuarioPrivilegio['apellidoPaternoUsuario'];
					        $aMaterno = $datoUsuarioPrivilegio['apellidoMaternoUsuario'];
					        
					        $nombreCompleto = $nombre.' '.$aPaterno.' '.$aMaterno;
					        
					        $_SESSION['usuarioPrivilegio'] = $privilegio;//asignando el privilegio a la variable de session
					        
					        echo "<script>console.log('".$privilegio."');</script>";
					        
					    }//fin while
                        
 
 //--ARREGLO PARA LOS DATOS DE LAS CAPAS
 /*
 # Este metodo que se emplea aquí solamente sirve para 
 # realizar una sola vez la consulta a la base de datos
 # de los datos completos de las capas, ya que en este
 # codigo constantemente se estan rellenando etiquetas y
 # variables de JS con dichos datos, así evitamos llamar
 # muchas veces la conexion y dejamos todo dentro de un
 # ARREGLO el cual se reutiliza.
 */
 $consultaCapas = "SELECT capas.*, ordencapas.zIndex FROM capas INNER JOIN ordencapas WHERE capas.idCapa = ordencapas.idCapa ORDER BY ordencapas.zIndex DESC ";//consulta general
 $resultadoCapas = mysqli_query($conexion,$consultaCapas);
	    while($filaCapa = $resultadoCapas->fetch_assoc()){//obteniendo capas de BD
	     $arregloCapas[]=$filaCapa;//agregando los valores de la BD al arreglo
	    }//fin while
/*
# Una vez que se obtienen los datos de la BD en el ARREGLO
# se utiliza la siguiente sentencia -

    foreach ($arregloCapas as $clave => $campo) {
        echo $campo['idCapa'];
    }//fin foreach
    
# en donde $campo[''] es donde se pone el nombre del 
# campo a obtener los valores de BD ahora en el ARREGLO
*/	    
	    
//----fin ARREGLO PARA LOS DATOS DE LAS CAPAS
?>
<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Geoportal</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="Leaflet.PolylineMeasure.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="Leaflet.PolylineMeasure.js"></script>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="miestilo.css">
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="estiloPopup.css">
        <link rel="stylesheet" href="css/search.css">
        
        <!--links editBar-->
        <link rel="stylesheet" href="css/leaflet-geoman.css" />
        <script src="js/leaflet-geoman.min.js"></script>
        
        <!--draw-->
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.4.10/leaflet.draw.css' rel='stylesheet' />
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-draw/v0.4.10/leaflet.draw.js'></script>
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-geodesy/v0.1.0/leaflet-geodesy.js'></script>
        
    
        
          <!--links estilo leyendas wms-->
        <link rel="stylesheet" href="estiloLeyendas.css" />
        
         <!--links estilo barra Acciones-->
        <link rel="stylesheet" href="estiloBarraAcciones.css" />
        
        <style>
            body {padding: 0; margin: 0;}
            html, body, #map {height: 100%;}
        </style>
    </head>
    
    <body>

<!------ENCABEZADO DE LA PAGINA-->

<div id="controlMenuPanel">
    <!--btnAdmin-->
    <?php
        if($privilegio == "administrador"){
    ?>
    <button id="btnEntrarAdmin" onclick="location.href='admin/admin.php'">
        <span class="icon-cog"></span>
    </button>
    <?php
        }//fin if privilegio
    ?>
    <!--fin btnAdmin-->
<button id="btnCerrarMenu">
<span class="icon-cross"></span>
</button>
  <input type="checkbox" name="" id="botonCerrarControl" checked>
  <label for="botonCerrarControl" id="botonCerrarControl_label"><</label>
  <div id="avatar" class="baseControlPanel">
    <img src="https://cdn2.iconfinder.com/data/icons/website-icons/512/User_Avatar-512.png" alt="">
    <p><?php echo $nombreCompleto;?></p>
    <a href="cerrarSesion.php">Cerrar Sesión</a>
  </div><!--fin div avatar-->
  <hr><!--linea-->
  <div id="contenedorZoom" class="baseControlPanel">
    <label for="zoom">Zoom</label>
    <div class="divZoom">
      <button id="zoomOut" class="btnZoom"><span class="icon-minus"></span></button>
    </div>
    <div class="divZoom">
      <input type="range" class="custom-range" min="5" max="20" id="zoom">
    </div>
    <div class="divZoom">
      <button id="zoomIn" class="btnZoom"><span class="icon-plus"></span></button>
    </div>
  </div><!--fin div contenedorZoom-->
  <hr><!--linea-->
  <div id="contendorControles" >

    <button class="accordion">Mapas de Referencia</button>

      <div id="contenidoRadios" class="panel">
        <ul class="list-unstyled">
          <!--<li>
            <div class="custom-control custom-radio">
              <input type="radio" id="radio_ninguno" class="custom-control-input" name="radioGrupo" value="ninguno" checked>
              <label for="radio_ninguno" class="custom-control-label">Ninguno</label>
            </div>
          </li>
          -->
          <li>
            <div class="custom-control custom-radio">
              <input type="radio" id="radio_csm" class="custom-control-input" name="radioGrupo" value="csm" checked>
              <label for="radio_csm" class="custom-control-label">OSM</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-radio">
              <input type="radio" id="radio_calles" class="custom-control-input" name="radioGrupo" value="calles">
              <label for="radio_calles" class="custom-control-label">OSM Topo</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-radio">
              <input type="radio" id="radio_grises" class="custom-control-input" name="radioGrupo" value="grises">
              <label for="radio_grises" class="custom-control-label">OSM Grises</label>
            </div>
          </li>
          <li>
            <div class="custom-control custom-radio">
              <input type="radio" id="radio_google" class="custom-control-input" name="radioGrupo" value="googleSat">
              <label for="radio_google" class="custom-control-label">Google Sat</label>
            </div>
          </li>
        </ul>
      </div><!--fin div contenidoRadios-->

      <!--contenidoCapaz-->
      <button class="accordion">Capas</button>
        <div id="contenidoCapas" class="panel">
          <ul class="list-unstyled" id="listaCapa">
              <?php 
					    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
					       ?>
					        <li id="<?php echo $campo['idCapa'];?>">
    					       <div class="form-row">
    					           <div class="form-group col-md-11">
                                      <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="chk_<?php echo $campo['idCapa'];?>" class="custom-control-input" name="chkGrupo" value="<?php echo $campo['idCapa'];?>">
                                        <label for="chk_<?php echo $campo['idCapa'];?>" class="custom-control-label"><?php echo $campo['tituloCapa'];?></label>
                                      </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                            <input type="checkbox" id="chk_leyenda_<?php echo $campo['idCapa'];?>" style="display:none">
                                            <label class="form-check-label icon-eye" for="chk_leyenda_<?php echo $campo['idCapa'];?>" style="color:#888"></label>
                                    </div>
                                </div>
                            </li>
                            
					       <?php
					    }//fin foreach
              ?>
          </ul><!--fin ul capaz-->
      </div><!--fin div capaz-->

  </div><!--fin div contendorControles-->
  <hr><!--linea-->
   <div class="baseControlPanel">
   <div class="custom-control custom-switch">
       <input type="checkbox" id="chkBotonLeyenda" class="custom-control-input">
        <label for="chkBotonLeyenda" class="custom-control-label">Leyenda de capa</label>
    </div>
   </div>
  <hr><!--linea-->
  <div id="contenidoMedir" class="baseControlPanel">
    <div class="custom-control custom-switch">
       <input type="checkbox" id="chkBoton" class="custom-control-input">
        <label for="chkBoton" class="custom-control-label">Control de Medici&oacute;n y &Aacute;rea</label>
    </div>
        <span class="text-muted text-left">
          <ul>
          <li>Haga clic y arrastre para <b>mover el punto</b></li>
          <li>Presione la tecla MAYÚS y haga clic para <b>eliminar el punto</b><br></li>
          <li>Haga clic y arrastre para presionar la tecla CTRL y haga clic para <b>reanudar el punto</b> de movimiento de línea.<br></li>
          <li>Presione la tecla CTRL y haga clic para <b>agregar un punto</b></li>
          </ul>
        </span>
     <div id="contenedorBotonesAcciones">
         <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalAgregar"><span class="icon-plus text-secondary"></span><br><small class="text-secondary">Agregar</small></button>
              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalConsulta"><span class="icon-search text-secondary"></span><br><small class="text-secondary">Consultar</small></button>
              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalEliminar"><span class="icon-bin text-secondary"></span><br><small class="text-secondary">Eliminar</small></button>
        </div>
     </div>  
  </div><!--fin div contendorMedir-->
</div><!--fin div controlMenuPanel-->

<!--BARRA BUSCADOR--> 

      <div class="bg-light" id="contenedorBuscador" style="width:40%">
          <div class="input-group mt-2" id="buscador">
                <input id="campoBuscar" type="search" placeholder="Escribe tu búsqueda" aria-describedby="button-addon5" class="form-control">
            <div class="input-group-append">
                <select class="custom-select btn" id="selectTipo">
                    <option selected value="nombre">Nombre</option>
                    <option value="partido">Partido</option>
                    <option value="metodo">Método</option>
                </select>
               <button id="btn_buscar" class="btn btn-primary"><i class="icon-search"></i></button>
            </div>
          </div>
       
      </div>

<!--fin BARRA BUSCADOR-->

<!--contenedor iframes LEYENDAS -->
 <div id="contenedorIframeLeyendas">
           <p>No hay contenido</p>
 </div>
<!--fin contenedor iframes LEYENDAS -->

<!-- fin ENCABEZADO DE LA PAGINA-->

<!--boton para CERRAR MENU-->
<button id="btnAbrirMenu">
<span class="icon-menu"></span>
</button>
<!--fin boton para CERRAR MENU-->
       
<?php
include "modals_Acciones.php";//INSERCION DE CODIGO PARA MODALES Y BARRA DE ACCIONES
?>

        <div id='contenedorIframe' style="display:none"></div>
        <div id="map"></div>
        
        
        
        

    <!--fin codigo de la ventana emergente-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-input-spinner.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  
<script>

	var atribuciones = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
  	var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';


//-----------------CAPAS
    //----Mapas de referencia----
	var grayscale   = L.tileLayer(mbUrl, {
        id: 'mapbox.light', 
        attribution: atribuciones
    });
    var	streets  = L.tileLayer(mbUrl, {
        id: 'mapbox.streets',   
        attribution: atribuciones
    });
    
    var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
    });

    var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {//NOTA: OSM = Open Street Map
      minZoom: 1,
      maxZoom: 22,
      attribution: osmAttrib
      });
    //----fin Mapas de referencia----
    
    //---MAPA---
    
	var map = new L.Map('map', {
		center: [17.882479, -99.585289],
        zoom: 8,
        minZoom : 5,
        zoomControl: false,
    	layers: [osm]
	});
	
//---fin MAPA---



//---cambiar el cursor en el mapa
document.getElementById('map').style.cursor = 'default'; // auto | crosshair | default | pointer | move | e-resize | ne-resize | nw-resize | n-resize | se-resize | sw-resize | s-resize | w-resize | text | wait | help | progress 

map.on('mousedown', function (e) {
    document.getElementById('map').style.cursor = 'move';
});
map.on('mouseup', function (e) {
    document.getElementById('map').style.cursor = 'default';
});
//---fin cambiar el cursor en el mapa


    
    //----Capaz----
    /*var wmsLayer= L.tileLayer.wms("http://sdg2112.softether.net:8080/geoserver/mxcatastro/wms", {
        layers: 'mxcatastro:chp_pred_raw_00',
        format: 'image/png',
        transparent: true
    });

    var predioWMSlayer= L.tileLayer.wms("http://sdg2112.softether.net:8080/geoserver/opengeo/wms", 
    {
        layers: 'opengeo:chp_pred_data00',
        format: 'image/png',
        transparent: true//,
        //CQL_FILTER:'j_ctacat=2901001001001'
    });
    */
    <?php
    
     ///////////////////////////////////////////////////////////////////////////
     
    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
	?>
	       
	       var <?php echo $campo['idCapa'];?>= L.tileLayer.wms("<?php echo $campo['urlCapa'];?>", {
            layers: '<?php echo $campo['layer'];?>',
            format: '<?php echo $campo['formato'];?>',
            transparent: <?php echo $campo['transparencia'];?>,
            maxZoom: 22,
            <?php
            if($campo['version'] != null){
            ?>
            version: '<?php echo $campo['version'];?>', 
            <?php
	            }//fin if
            ?>
            <?php
            if($campo['estilo'] != null){
            ?>
            style: '<?php echo $campo['estilo'];?>', 
            <?php
	            }//fin if
            ?>
            zIndex: <?php echo $campo['zIndex'];?> // orden de la capa ((mayor numero mas arriba)
	       });
	       
	      
          
    <?php
    }//fin foreach

        	    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    	   ?>
    	   var chkBoxControl_<?php echo $campo['idCapa'];?> = document.getElementById('chk_<?php echo $campo['idCapa'];?>');
    	   chkBoxControl_<?php echo $campo['idCapa'];?>.addEventListener("change", validaChkBoxControl, false);
    	   <?php
        	        }//fin foreach
    	   ?>
    	   
    	 
    	   
	       
	       function validaChkBoxControl(){//funcion para evaluar el boton chkbox
    	        <?php
        	        foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    	        ?>
    	            var checked_chkBoxControl_<?php echo $campo['idCapa'];?> = chkBoxControl_<?php echo $campo['idCapa'];?>.checked;
    	        <?php
    	            }//fin foreach
    	       ?>
    	       
    	     
    	       
    	       <?php
    	       foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    	       ?>
    	              if(checked_chkBoxControl_<?php echo $campo['idCapa'];?>){
                        console.log("<?php echo $campo['idCapa'];?>");
                        map.addLayer(<?php echo $campo['idCapa'];?>);
                        }//fin if
                        else{
                            console.log("No-<?php echo $campo['idCapa'];?>");
                            map.removeLayer(<?php echo $campo['idCapa'];?>);
                        }//fin else
                        <?php
    	       }//fin foreach
    	        ?>
    	        
    	      
    	        
	        }//fin funcion validaChkBoxControl
    
    window.onload = validaChkBoxControl(); //al cargar la pagina va a validar el boton chekbox
    
    //----fin Capaz----
//-------------fin Capas-------------  

            //L.control.layers(baseLayers, overlays).addTo(map);//asginacion de control de capaz por defecto
            L.control.scale ({maxWidth:240, metric:true, imperial:false, position: 'bottomleft'}).addTo(map);

            //control para poliniea calculo de metrica de puntos
            var myControl= L.control.polylineMeasure ({position:'topright', unit:'metres', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: false});
            
            map.addEventListener('click', onMapClick);//llama al evento click dentro del MAPA




//-------capa de figuras y control de figuras-----------------
var featureGroup = L.featureGroup();//.addTo(map); //crendo la capa de figuras

var drawControl = new L.Control.Draw({ //creando el control de las figuras
  edit: {
    featureGroup: featureGroup,
    poly : {
                    allowIntersection : false
    }
  },
  position: 'bottomright',
  draw: {
    polygon : {
                    allowIntersection: false,
                    showArea:true
                },
    polyline: true,
    rectangle: true,
    circle: false,
    marker: true
  },
  metric: ['km', 'm']
});
//---MAS ABAJO ESTA EL METODO PARA EL AREA DE LAS FIGURAS ----------
//-----fin capa de figuras y control de figuras-------

//--variables para chekbox
var chkBotonControl = document.getElementById('chkBoton');
chkBotonControl.addEventListener("change", validaCheckbox, false);

var chkBotonControlLeyenda = document.getElementById('chkBotonLeyenda');
chkBotonControlLeyenda.addEventListener("change", validaCheckboxLeyenda, false);

window.onload = validaCheckbox(); //al cargar la pagina va a validar el boton chekbox
window.onload = validaCheckboxLeyenda();
window.onload = mostrarLeyendas();

//------------VALIDAR CHEKBOX CONTROLES----
function validaCheckbox(){//funcion para evaluar el boton chkbox
  var checked = chkBotonControl.checked;
  if(checked){
    myControl.addTo(map);//agregar control al mapa
    drawControl.addTo(map);//agregar edit control figuras
    map.addLayer(featureGroup);//agregar CAPA de figuras
  }//fin if
  else{
    map.removeControl(myControl);// quitar o eliminar control del mapa
    map.removeControl(drawControl);//quitar edit control figuras
    map.removeLayer(featureGroup); //quitar CAPA de figuras 
  }
}//fin funcion validaCheckbox

//---creando funciones para los checkbox de las capas y mostrar la leyenda


function validaCheckboxLeyenda(){//funcion validaCheckboxLeyenda
    var checkedLeyenda = chkBotonControlLeyenda.checked;
    if(checkedLeyenda){
       document.getElementById("contenedorIframeLeyendas").style.display = "block";
       
    }//fin if
    else{
       document.getElementById("contenedorIframeLeyendas").style.display = "none";  
    }//fin else
}//fin funcion validaCheckboxLeyenda


var algunaLeyendasChecked = false;
function mostrarLeyendas(){//funcion para leer los checkbox y mostrar las leyendas
if(algunaLeyendasChecked == false){
    var contadorLeyendas = 0;
    <?php
     foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    ?>
       var checkedLeyenda_<?php echo $campo['idCapa'];?> = chkBotonControlLeyenda_<?php echo $campo['idCapa'];?>.checked;
       if(checkedLeyenda_<?php echo $campo['idCapa'];?>){
           document.getElementById("contenedorIframeLeyendas").innerHTML = "<iframe src='<?php echo $campo['leyenda'];?>' id='iframeLeyendas' width='100%' height='290px' frameborder='0' scrolling='no'></iframe>";
           contadorLeyendas = contadorLeyendas + 1;
       }//fin if
    <?php
    }
    ?>
    if(contadorLeyendas == 0){
        document.getElementById("contenedorIframeLeyendas").innerHTML = "<p>Selecciona una capa</p>";
    }
}//fin if
else{
    document.getElementById("contenedorIframeLeyendas").innerHTML = "<p>Selecciona una capa</p>";
}//fin else
    
}

//-------------fin VALIDAR CHEKBOX CONTROLES----




var popup = L.popup({maxWidth: 1000,className:'popup'});//variable de popup de click sobre el mapa

function onMapClick(e) {

    if(document.getElementById('chkBoton').checked){//verifica solo si cuando se da click en el mapa esta activado el boton chkboton
    //
    }//fin if
    else{
    var latlngStr = '(' + e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4) + ')';
    var latitud = e.latlng.lat.toFixed(4);
    var longitud = e.latlng.lng.toFixed(4);
    var BBOX = map.getBounds()._southWest.lng+","+map.getBounds()._southWest.lat+","+map.getBounds()._northEast.lng+","+map.getBounds()._northEast.lat;
    var WIDTH= map.getSize().x;
    var HEIGHT = map.getSize().y;
    var X = map.layerPointToContainerPoint(e.layerPoint).x;
    var Y = map.layerPointToContainerPoint(e.layerPoint).y;
   // var URL = 'http://sdg2112.softether.net:8080/geoserver/mxassets/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS=mxassets:inventario_muestra_recorrido_v01&QUERY_LAYERS=mxassets:inventario_muestra_recorrido_v01&propertyName=imglnk&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
   // var URL = 'http://74.208.210.103:8990/geos/cat12mx/wms?service=WMS&version=1.1.0&request=GetFeatureInfo&layers=cat12mx:cmun_12029_ref_6369u_predio&QUERY_LAYERS=cat12mx:cmun_12029_ref_6369u_predio_sel&propertyName=clvcatact&STYLES=&bbox='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
  //  var URL = 'http://sdg2112.softether.net:8080/geoserver/mxassets/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS=mxassets:inventario_muestra_recorrido_v01&QUERY_LAYERS=mxassets:inventario_muestra_recorrido_v01&propertyName=imglnk&STYLES=&BBOX=-88.3494758605957,18.466746589854342,-88.26536178588867,18.573199162905585&FEATURE_COUNT=5&HEIGHT=654&WIDTH=490&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X=330&Y=256';
    //var URL = 'http://sdg2112.softether.net:8080/geoserver/opengeo/wms?service=WMS&version=1.1.0&request=GetFeatureInfo&layers=opengeo:chp_pred_rezago&propertyName=imglnk&STYLES=&bbox='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
    //var URL = 'http://sdg2112.softether.net:8080/geoserver/opengeo/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS=opengeo:chp_pred_rezago&QUERY_LAYERS=opengeo:chp_pred_rezago&propertyName=j_ctacat,j_ubimpag&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=application%2Fjson&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
    var URL = 'http://74.208.210.103:8990/geos/pievi/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS=pievi:vap_e12_sexo&QUERY_LAYERS=pievi:vap_e12_sexo&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=50&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
    //var URL = 'http://74.208.210.103:8990/geos/pievi/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS=pievi:vap_e12_sexo&QUERY_LAYERS=pievi:vap_e12_sexo&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;

//-----------FIN PRUEBAS---------------------------------------------------------    

    var htmlPopup = "<div class='tituloPopup'><b>Titulo</b></div><div class='coordenadasPopup'><span>Latitud:"+latitud+"</span><span>Longitud:"+longitud+"</span></div><div class='contenidoPopup'> <iframe src="+URL+" id='miFrame'width='500px' height='200px'></iframe> </div>";
    popup.setLatLng(e.latlng);
    popup.setContent(htmlPopup);
    map.openPopup(popup);

      }//fin else
    }//fin onMapClick
    
    
//METODO PARA CONTROL DE FIGURAS Y SU AREA/////    
//-----------MAS ARRIBA ESTAN LOS OBJETOS DEL CONTROL Y LA CAPA DE FIGURAS -----------------

map.on('draw:created', showPolygonArea);
map.on('draw:edited', showPolygonAreaEdited);

function showPolygonAreaEdited(e) {
  e.layers.eachLayer(function(layer) {
    showPolygonArea({ layer: layer });
  });
}
function showPolygonArea(e) {
  //featureGroup.clearLayers();
  featureGroup.addLayer(e.layer);
  e.layer.bindPopup((LGeo.area(e.layer) / 1000000).toFixed(4) + ' km<sup>2</sup>');
  e.layer.openPopup();
}
// Truncate value based on number of decimals
        var _round = function(num, len) {
            return Math.round(num*(Math.pow(10, len)))/(Math.pow(10, len));
        };
        // Helper method to format LatLng object (x.xxxxxx, y.yyyyyy)
        var strLatLng = function(latlng) {
            return "("+_round(latlng.lat, 6)+", "+_round(latlng.lng, 6)+")";
        };

        // Generate popup content based on layer type
        // - Returns HTML string, or null if unknown object
        var getPopupContent = function(layer) {
            // Marker - add lat/long
            if (layer instanceof L.Marker || layer instanceof L.CircleMarker) {
                return strLatLng(layer.getLatLng());
            // Circle - lat/long, radius
            } else if (layer instanceof L.Circle) {
                var center = layer.getLatLng(),
                    radius = layer.getRadius();
                return "Center: "+strLatLng(center)+"<br />"
                      +"Radius: "+_round(radius, 2)+" m";
            // Rectangle/Polygon - area
            } else if (layer instanceof L.Polygon) {
                map.on('draw:created', showPolygonArea);
            // Polyline - distance
            } else if (layer instanceof L.Polyline) {
                var latlngs = layer._defaultShape ? layer._defaultShape() : layer.getLatLngs(),
                    distance = 0;
                if (latlngs.length < 2) {
                    return "Distance: N/A";
                } else {
                    for (var i = 0; i < latlngs.length-1; i++) {
                        distance += latlngs[i].distanceTo(latlngs[i+1]);
                    }
                    return "Distance: "+_round(distance, 2)+" m";
                }
            }
            return null;
        };

        // Object created - bind popup to layer, add to feature group
        map.on(L.Draw.Event.CREATED, function(event) {
            var layer = event.layer;
            var content = getPopupContent(layer);
            if (content !== null) {
                layer.bindPopup(content);
            }
            featureGroup.addLayer(layer);
        });

        // Object(s) edited - update popups
        map.on(L.Draw.Event.EDITED, function(event) {
            var layers = event.layers,
                content = null;
            layers.eachLayer(function(layer) {
                content = getPopupContent(layer);
                if (content !== null) {
                    layer.setPopupContent(content);
                }
            });
        });
  //FIN METODO PARA CONTROL DE FIGURAS Y SU AREA/////  
        </script> 
    
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="controlPanelOpciones.js"></script>  
        <script src="controlPanel.js"></script>
        <script src="busquedaDatosCapas.js"></script>
    </body>
</html>

<?php //AQUI TERMINA EL MAPA POR ESO SE VUELVE ABRIR PHP
					}//fin if usuario encontrado
					else{
                        //Si el usuario no existe me mandara un mensaje
						echo 'Este usuario no existe <br> <a href="cerrarSesion.php"> <-- Volver a intentar</a>';
						
					}//fin else
					mysqli_close($conexion);
        }//fin if
        else
        {
            header("Location: index.php");
        }//fin else
?>