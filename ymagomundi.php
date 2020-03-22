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


            $consulta = "SELECT * FROM usuarios WHERE usuario='$miUsuario' AND pass='$miContra'";
            $resultado = pg_query($conexion,$consulta);
            if(!$resultado) {
                echo 'Consulta de usuario Fallida';
                exit();
               }
               else {
                  echo "<script>console.log('Consulta de usuario correcta');</script>";
               }//fin if error resultado

					if($row=pg_num_rows($resultado) > 0){//comprueba si existe el usuario
					    echo "<script>console.log('Se encontro Usuario');</script>";

                        while ($datoUsuarioPrivilegio = pg_fetch_assoc($resultado))
                        {//obteniendo el dato del privilegio
					        echo "<script>console.log('DENTRO DEL WHILE');</script>";
                            $privilegio = $datoUsuarioPrivilegio['privilegio'];//asigna el valor del campo 'privilegio' a una variable normal
					        $nombre = $datoUsuarioPrivilegio['nombreusuario'];
					        $aPaterno = $datoUsuarioPrivilegio['apellidopaternousuario'];
					        $aMaterno = $datoUsuarioPrivilegio['apellidopaternousuario'];

					        $nombreCompleto = $nombre.' '.$aPaterno.' '.$aMaterno;

					        $_SESSION['usuarioPrivilegio'] = $privilegio;//asignando el privilegio a la variable de session

					        echo "<script>console.log('Hola ".$nombre.", eres: ".$privilegio."');</script>";

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
$consultaCapas = "SELECT capas.*, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY ordencapas.zindex DESC";//consulta general
$resultadoCapas = pg_query($conexion,$consultaCapas);
if(!$resultadoCapas) {
   echo 'Consulta de resultadoCapas Fallida';
   exit();
  }
  else {
     echo "<script>console.log('Consulta de resultadoCapas correcta');</script>";
  }//fin if error resultadoCapas


       while ($filaCapa = pg_fetch_assoc($resultadoCapas))
       {//obteniendo capas de BD
         echo "<script>console.log('DENTRO DEL WHILE filaCapa');</script>";
        $arregloCapas[]=$filaCapa;//agregando los valores de la BD al arreglo
       }//fin while
/*
# Una vez que se obtienen los datos de la BD en el ARREGLO
# se utiliza la siguiente sentencia -

    foreach ($arregloCapas as $clave => $campo) {
        echo $campo['idcapa'];
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
        <script src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
        <script src="leaflet-plugins-1.9.3\layer\tile\Google.js"></script>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <link rel="stylesheet" href="miestilo.css">
        <link rel="stylesheet" href="fonts/style.css">
        <link rel="stylesheet" href="estiloPopup.css">
        <link rel="stylesheet" href="css/search.css">
        <link rel="stylesheet" href="css/css_controlDibujarPoligonos.css">
        <link rel="stylesheet" href="css/css_barraFiltro.css">


        <!--links editBar-->
        <link rel="stylesheet" href="css/leaflet-geoman.css" />
        <script src="js/leaflet-geoman.min.js"></script>

        <!--links Side para dividir pantalla-->
        <script src="js/side/leaflet-side-by-side.js"></script>

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

<div class="bg-light" id="controlMenuPanel">
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
    <a href="cerrarSesion.php">Cerrar sesión</a>
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

        <div id="contenedorBotonesAcciones">
                        <div class="btn-group" role="group">
                              <button type="button" class="btn btn-light" title="Informaci&oacute;n de capa" onclick="activarInformacion('informacion')" id="btnActivarInfo1"><span class="icon-info text-secondary small" id="btnActivarInfo2"></span></button>
                              <button type="button" class="btn btn-light" title="Activar barra de filtros" onclick="activarInformacion('busqueda')" id="btnActivarBusqueda1"><span class="icon-filter text-secondary small" id="btnActivarBusqueda2"></span></button>
                              <button type="button" class="btn btn-light" title="Activar swipe" onclick="activarInformacion('swipe')" id="btnActivarSwipe1"><span class="icon-images text-secondary small" id="btnActivarSwipe2"></span></button>
                        <span class="text-secondary mr-1 ml-1">|</span>
                              <button type="button" class="btn btn-light" title="Ver todas las leyendas" onclick="activarInformacion('leyenda')" id="btnActivarLeyenda1"><span class="icon-eye-plus text-secondary small" id="btnActivarLeyenda2"></span></button>
                              <button type="button" class="btn btn-light" title="Herramienta de medici&oacute;n" onclick="activarInformacion('medicion')" id="btnActivarMedi1"><span class="icon-wrench text-secondary small" id="btnActivarMedi2"></span></button>
                              <button type="button" class="btn btn-light" title="Herramienta de &aacute;reas y trazos" onclick="activarInformacion('areaTrazo')" id="btnActivarArea1"><span class="icon-paint-format text-secondary small" id="btnActivarArea2"></span></button>
                        </div>
                        <span class="text-secondary mr-1 ml-1">|</span>
                        <div class="btn-group" role="group">
                              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalAgregar" title="Agregar"><span class="icon-plus text-secondary small"></span></button>
                              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalConsulta" title="Consultar"><span class="icon-search text-secondary small"></span></button>
                              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalEliminar" title="Eliminar"><span class="icon-bin text-secondary small"></span></button>
                        </div>
        </div><!--fin contenedorBotonesAcciones-->

    <hr><!--linea-->

    <button class="accordion">Mapas de referencia: </button>

      <div id="contenidoRadios" class="panel">
        <ul class="list-unstyled">
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
      <button class="accordion">Capas de datos territoriales: </button>
        <div id="contenidoCapas" class="panel">
          <ul class="list-unstyled" id="listaCapa">
              <?php
					    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
					       ?>
					        <li id="<?php echo $campo['idcapa'];?>">
                                      <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="chk_<?php echo $campo['idcapa'];?>" class="custom-control-input" name="chkGrupo" value="<?php echo $campo['idcapa'];?>">
                                        <label for="chk_<?php echo $campo['idcapa'];?>" class="custom-control-label"><?php echo $campo['titulocapa'];?></label><br>
                                            <div id="div_btn_<?php echo $campo['idcapa'];?>" class="btn-group" role="group">
                                                <button id="btn_leyenda_<?php echo $campo['idcapa'];?>" type="button" class="btn btn-light"  title="Ver Leyenda" onclick="activarLeyendas('<?php echo $campo['idcapa'];?>')"><span id="icon_btn_leyenda_<?php echo $campo['idcapa'];?>" class="icon-eye text-secondary small"></span></button>
                                                <button type="button" class="btn btn-light"  title="Editar capa"><span class="icon-pencil2 text-secondary small"></span></button>
                                                <button type="button" class="btn btn-light"  title="Borrar capa"><span class="icon-bin text-secondary small"></span></button>

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

</div><!--fin div controlMenuPanel-->

<!--BARRA BUSCADOR-->

      <div class="bg-light" id="contenedorBuscador" style="width:35%; display:none">
          <div class="input-group mt-2" id="buscador">
                <input id="campoBuscar" type="search" placeholder="Escribe tu filtro" aria-describedby="button-addon5" class="form-control">
            <div class="input-group-append">
                <select class="custom-select btn" id="selectTipo">
                    <option selected value="ninguno">NINGUNO</option>
                    <?php
            		    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
            		?>
            		    <option value="<?php echo $campo['idcapa'];?>"><?php echo $campo['titulocapa'];?></option>
            		<?php
            		    }//fin foreach
            		?>
                </select>
               <button id="btn_buscar" class="btn btn-primary" title="Aplicar filtro"><i class="icon-filter"></i></button>
               <button id="btn_borrarFiltro" class="btn btn-danger ml-2" title="Borrar filtro"><i class="icon-bin2"></i></button>
            </div>
          </div>

      </div>

<!--fin BARRA BUSCADOR-->


<!--Inicio Selector de capas para el swipe -->

        <div class="bg-light" id="contenedorSwipe" style="width:35%; display:none">
          <div class="input-group mt-2" id="buscadorS">
          <select class="custom-select btn" id="selectTipoS" onchange="repetido()"> <!--Aqui voy a poner la comparacion de los mapas de referencia.-->
                    <option  value="ninguno">NINGUNO</option>
                    <option value="osm">OSM</option>
                    <option value="streets">OSM Topo</option>
                    <option value="grayscale">OSM Grises</option>
                    <option value="googleSat">Google Sat</option>
                    <?php
            		    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
            		?>
            		    <option value="<?php echo $campo['idcapa'];?>"><?php echo $campo['titulocapa'];?></option>
            		<?php
            		    }//fin foreach
                    ?>

                </select>
            <div class="input-group-append">
                <select class="custom-select btn" id="selectTipoS1" onchange="repetido()">
                    <option value="ninguno">NINGUNO</option>
                    <option value="osm">OSM</option>
                    <option value="streets">OSM Topo</option>
                    <option value="grayscale">OSM Grises</option>
                    <option value="googleSat">Google Sat</option>
                    <?php
            		    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
            		?>
            		    <option value="<?php echo $campo['idcapa'];?>"><?php echo $campo['titulocapa'];?></option>
            		<?php
            		    }//fin foreach
                    ?>


                </select>
               <button id="botonSwipeA" class="btn btn-primary" onClick="RecogerDatos()" title="Aplicar filtro"><i class="icon-filter"></i></button>
               <button id="btn_borrar" class="btn btn-danger ml-2" onClick ="RecogerDatos();"title="Borrar filtro"><i class="icon-bin2"></i></button>
            </div>
          </div>

        </div>



<!--Fin selector de capas para el swipe -->




<!--contenedor iframes LEYENDAS NUEVO-->
 <div id="contenedorIframeLeyendasNuevo">
        <?php
		    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
		?>
		    <div id="img_leyenda_<?php echo $campo['idcapa'];?>" class="contenedorImg" style="display:none">
                <img src="<?php echo $campo['leyenda'];?>">
            </div>
		<?php
		    }//fin foreach
		?>
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

    var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {//NOTA: OSM = Open Street Map
      minZoom: 1,
      maxZoom: 22,
      attribution: osmAttrib
      });


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







    //----fin Mapas de referencia----







    //---MAPA---

	var map = new L.Map('map', {
		center: [18.5276, -88.2963],
        zoom: 13,
        minZoom : 5,
        zoomControl: false,
    	layers: [osm]
        //layers: [osm,googleSat]
	});

    /*var control_side = L.control.sideBySide(osm,googleSat);
    control_side.addTo(map);*/

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

    <?php

     ///////////////////////////////////////////////////////////////////////////

    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    ?>
	       var <?php echo $campo['idcapa'];?>= L.tileLayer.wms("<?php echo $campo['urlcapa'];?>", {
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
            zIndex: <?php echo $campo['zindex'];?> // orden de la capa ((mayor numero mas arriba)
	       });

    <?php
    }//fin foreach

        	    foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    	   ?>
    	   var chkBoxControl_<?php echo $campo['idcapa'];?> = document.getElementById('chk_<?php echo $campo['idcapa'];?>');
    	   chkBoxControl_<?php echo $campo['idcapa'];?>.addEventListener("change", validaChkBoxControl, false);
    	   <?php
        	        }//fin foreach
    	   ?>

	       function validaChkBoxControl(){//funcion para evaluar el boton chkbox
    	        <?php
        	        foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    	        ?>
    	            var checked_chkBoxControl_<?php echo $campo['idcapa'];?> = chkBoxControl_<?php echo $campo['idcapa'];?>.checked;
    	        <?php
    	            }//fin foreach
    	       ?>

    	       <?php
    	       foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
    	       ?>
    	              if(checked_chkBoxControl_<?php echo $campo['idcapa'];?>){
                        console.log("<?php echo $campo['idcapa'];?>");
                        map.addLayer(<?php echo $campo['idcapa'];?>);
                        document.getElementById('btn_leyenda_<?php echo $campo['idcapa'];?>').disabled = false;
                        }//fin if
                        else{
                            console.log("No-<?php echo $campo['idcapa'];?>");
                            map.removeLayer(<?php echo $campo['idcapa'];?>);
                            document.getElementById('btn_leyenda_<?php echo $campo['idcapa'];?>').disabled = true;
                            document.getElementById('img_leyenda_<?php echo $campo['idcapa'];?>').style.display="none";
                            document.getElementById('icon_btn_leyenda_<?php echo $campo['idcapa'];?>').className = "icon-eye text-secondary small";

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
  position: 'topright',
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






//var control_side = L.control.sideBySide(osm,googleSat);






//document.getElementById("SwipeOcultar").style.display="none";
//document.getElementById("swipeOption").style.display="none";



//FUNCION VALIDAR CHECKBOX DE INFORMACION DE CAPA

var activoInformacion = false;//inicializando variable
var activoBusqueda = false;//inicializando variable
var activoLeyenda = false;//inicializando variable
var activoMedicion = false;//inicializando variable
var activoAreaTrazo= false;//inicializando variable
var activoSwipe=false;



function activarInformacion(opcionBtn){//funcion para evaluar el click del boton para el onMapClick
    switch(opcionBtn){

        case "informacion":
                if(activoInformacion == false){
                    activoInformacion = true;//cambiando el valor de la variable
                    document.getElementById("btnActivarInfo2").className = "icon-info text-light small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarInfo1").className = "btn btn-success";//alterando las propiedades del span dentro del boton
                    subFuncionactivarInformacion();
                }//fin if
                else{
                    activoInformacion = false;//cambiando el valor de la variable
                    document.getElementById("btnActivarInfo2").className = "icon-info text-secondary small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarInfo1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
                    subFuncionactivarInformacion();
                }//fin else
            break;
        case "busqueda":
                if(activoBusqueda == false){
                    activoBusqueda = true;//cambiando el valor de la variable
                    document.getElementById("btnActivarBusqueda2").className = "icon-filter text-light small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarBusqueda1").className = "btn btn-success";//alterando las propiedades del span dentro del boton
                    document.getElementById("contenedorBuscador").style.display="block";
                    console.log(mapa1);
                    console.log(mapa2);



                }//fin if
                else{
                    activoBusqueda = false;//cambiando el valor de la variable
                    document.getElementById("btnActivarBusqueda2").className = "icon-filter text-secondary small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarBusqueda1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
                    document.getElementById("contenedorBuscador").style.display="none";

                }//fin else
            break;


        case "swipe": //activamos y desactivamos swipe

                if(activoSwipe == false){

                    activoSwipe=true;
                    document.getElementById("btnActivarSwipe2").className = "icon-images text-light small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarSwipe1").className = "btn btn-success";//alterando las propiedades del span dentro del boton
                    //document.getElementById("SwipeOcultar").style.display="block";
                    //document.getElementById("swipeOption").style.display="block";
                    document.getElementById("contenedorSwipe").style.display="block";
                    //document.getElementById("radio_csm").disabled = true;
                    //document.getElementById("radio_grises").disabled = true;
                    //document.getElementById("radio_calles").disabled = true;
                    //document.getElementById("radio_google").disabled = true;
                    //document.getElementById("boton-fin").disabled=true;
                    repetido();




                }
                else{
                    activoSwipe = false;//cambiando el valor de la variable
                    document.getElementById("btnActivarSwipe2").className = "icon-images text-secondary small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarSwipe1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
                    //document.getElementById("SwipeOcultar").style.display="none";
                    //document.getElementById("swipeOption").style.display="none";
                    document.getElementById("contenedorSwipe").style.display="none";
                    //document.getElementById("radio_csm").disabled = false;
                    //document.getElementById("radio_grises").disabled = false;
                    //document.getElementById("radio_calles").disabled = false;
                    //document.getElementById("radio_google").disabled = false; //desactivamos radiobutton

                    removMapa();




                }
            break;
        case "leyenda":
                if(activoLeyenda == false){
                    activoLeyenda = true;//cambiando el valor de la variable
                    document.getElementById("btnActivarLeyenda2").className = "icon-eye-blocked text-light small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarLeyenda1").className = "btn btn-danger";//alterando las propiedades del span dentro del boton

                    //subFuncionactivarInformacion();
                }//fin if
                else{
                    activoLeyenda = false;//cambiando el valor de la variable
                    document.getElementById("btnActivarLeyenda2").className = "icon-eye-plus text-secondary small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarLeyenda1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
                    document.getElementById("contenedorIframeLeyendasNuevo").style.display="block";
                    //subFuncionactivarInformacion();
                }//fin else
            break;
        case "medicion":
                if(activoMedicion==false){
                    document.getElementById("btnActivarMedi2").className = "icon-wrench text-light small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarMedi1").className = "btn btn-success";//alterando las propiedades del span dentro del boton
                    myControl.addTo(map);//agregar control al mapa
                    activoMedicion=true;
                    subFuncionactivarInformacion();
                    document.getElementById("contenedorIframeLeyendasNuevo").style.right="50px";
                  }//fin if
                else{
                    document.getElementById("btnActivarMedi2").className = "icon-wrench text-secondary small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarMedi1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
                    map.removeControl(myControl);// quitar o eliminar control del mapa

                    //if para evaluar si las opciones estan activadas, realizar un espaciado en las leyendas
                    if(activoMedicion == false || activoAreaTrazo == false){
                        document.getElementById("contenedorIframeLeyendasNuevo").style.right="0px";
                    }else{
                        document.getElementById("contenedorIframeLeyendasNuevo").style.right="50px";
                    }//fin else

                    activoMedicion=false;
                    subFuncionactivarInformacion();

                  }//fin else
            break;
        case "areaTrazo":
                if(activoAreaTrazo==false){
                    document.getElementById("btnActivarArea2").className = "icon-paint-format text-light small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarArea1").className = "btn btn-success";//alterando las propiedades del span dentro del boton
                    drawControl.addTo(map);//agregar edit control figuras
                    map.addLayer(featureGroup);//agregar CAPA de figuras
                    activoAreaTrazo=true;
                    subFuncionactivarInformacion();
                    document.getElementById("contenedorIframeLeyendasNuevo").style.right="50px";
                  }//fin if
                else{
                    document.getElementById("btnActivarArea2").className = "icon-paint-format text-secondary small";//alterando las propiedades del span dentro del boton
                    document.getElementById("btnActivarArea1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
                    map.removeControl(drawControl);//quitar edit control figuras
                    map.removeLayer(featureGroup); //quitar CAPA de figuras

                    //if para evaluar si las opciones estan activadas, realizar un espaciado en las leyendas
                    if(activoMedicion == false || activoAreaTrazo == false){
                        document.getElementById("contenedorIframeLeyendasNuevo").style.right="0px";
                    }else{
                        document.getElementById("contenedorIframeLeyendasNuevo").style.right="50px";
                    }//fin else

                    activoAreaTrazo=false;
                    subFuncionactivarInformacion();

                  }//fin else
            break;
        default:
                console.log("Funcion nueva, aun no agregada");
            break;
    }//switch

}//fin funcion




function subFuncionactivarInformacion(){//esta funcion cambia el icono dependiendo de su seleccion con los otros botones
    if(activoMedicion!=false || activoAreaTrazo!=false){

        document.getElementById("btnActivarInfo1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
        document.getElementById("btnActivarInfo2").className = "icon-info text-danger small";//alterando las propiedades del span dentro del boton
    }//fin if

    if(activoMedicion==false && activoAreaTrazo==false){
        if(activoInformacion==true){
            document.getElementById("btnActivarInfo1").className = "btn btn-success";//alterando las propiedades del span dentro del boton
            document.getElementById("btnActivarInfo2").className = "icon-info text-light small";//alterando las propiedades del span dentro del boton
        }//fin if
        else{
            document.getElementById("btnActivarInfo2").className = "icon-info text-secondary small";//alterando las propiedades del span dentro del boton
            document.getElementById("btnActivarInfo1").className = "btn btn-light";//alterando las propiedades del span dentro del boton
        }//fin else
    }//fin if








}//fin subfuncion
//fin FUNCION VALIDAR CHECKBOX DE INFORMACION DE CAPA

//FUNCION VER LEYENDA DE CAPA
    function activarLeyendas(idLeyenda){
        var divImg = document.getElementById('img_leyenda_'+idLeyenda);

        if(divImg.style.display == "block"){
            divImg.style.display="none";

            document.getElementById('icon_btn_leyenda_'+idLeyenda).className = "icon-eye text-secondary small";
        }
        else{
            divImg.style.display="block";
            document.getElementById('icon_btn_leyenda_'+idLeyenda).className = "icon-eye text-primary small";
        }

    }
//fin FUNCION VER LEYENDA DE CAPA

var popup = L.popup({maxWidth: 1000,className:'popup'});//variable de popup de click sobre el mapa

function onMapClick(e) {

    //if(document.getElementById('chkBoton').checked){//verifica solo si cuando se da click en el mapa esta activado el boton chkboton
    if(activoInformacion==true && activoMedicion==false && activoAreaTrazo==false){//verifica solo si cuando se da click en el mapa esta activado el boton btnActivarInfo

        var cadenaLayers=[];
        var i=0;
        var urlWMS="";
        <?php

        foreach ($arregloCapas as $clave => $campo) {//obteniendo datos de Arreglo con datos de BD
        ?>
            var ck_layer_<?php echo $campo['idcapa'];?> = document.getElementById('chk_<?php echo $campo['idcapa'];?>');
            if(ck_layer_<?php echo $campo['idcapa'];?>.checked == true)
            {
                cadenaLayers[i] = '<?php echo $campo['layer'];?>';
                urlWMS='<?php echo $campo['urlcapa'];?>';
                i=i+1;
            }
        <?php
        }//fin foreach
        ?>

        console.log('CADENA: '+cadenaLayers);

        var latlngStr = '(' + e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4) + ')';
        var latitud = e.latlng.lat.toFixed(4);
        var longitud = e.latlng.lng.toFixed(4);
        var BBOX = map.getBounds()._southWest.lng+","+map.getBounds()._southWest.lat+","+map.getBounds()._northEast.lng+","+map.getBounds()._northEast.lat;
        var WIDTH= map.getSize().x;
        var HEIGHT = map.getSize().y;
        var X = map.layerPointToContainerPoint(e.layerPoint).x;
        var Y = map.layerPointToContainerPoint(e.layerPoint).y;
        //var URL = 'http://74.208.210.103:8990/geos/bigsdemo/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS='+cadenaLayers+'&QUERY_LAYERS='+cadenaLayers+'&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=50&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
        var URL = urlWMS+'?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS='+cadenaLayers+'&QUERY_LAYERS='+cadenaLayers+'&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=50&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
        //var URL = 'http://74.208.210.103:8990/geos/pievi/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&LAYERS=pievi:vap_e12_sexo&QUERY_LAYERS=pievi:vap_e12_sexo&STYLES=&BBOX='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;

    //-----------FIN PRUEBAS---------------------------------------------------------
        if(cadenaLayers!=""){

        var htmlPopup = "<div class='tituloPopup'><b>Titulo</b></div><div class='coordenadasPopup'><span>Latitud:"+latitud+"</span><span>Longitud:"+longitud+"</span></div><div class='contenidoPopup'> <iframe class='mb-2' src="+URL+" id='miFrame'width='500px' height='200px'></iframe><br><b><a onclick='recargarPopup()' class='text-primary p-2' id='btnActualizar' onmouseover='hover()' onmouseout='nohover()' ><span class='icon-loop2 mr-1'></span>Actualizar</a></b></div>";
        popup.setLatLng(e.latlng);
        popup.setContent(htmlPopup);
        map.openPopup(popup);

        }//fin if cadena
    }//fin if
    }//fin onMapClick

//sub-funcion para recargar el popup cada 3 segundos.
function recargarPopup(){
    var iframeReload;
    if(iframeReload = document.getElementById('miFrame'))
    {
        iframeReload.src = iframeReload.src;
        console.log(iframeReload.src);
    }//fin if
    else{
        console.log("No hay popup");
    }
}//fin function

 //---cambiar el cursor en el link
             // auto | crosshair | default | pointer | move | e-resize | ne-resize | nw-resize | n-resize | se-resize | sw-resize | s-resize | w-resize | text | wait | help | progress

           function hover(){
                document.getElementById('btnActualizar').style.cursor = 'pointer';
            }
            function nohover(){
                document.getElementById('btnActualizar').style.cursor = 'default';
            }
//---fin cambiar el cursor en el link


//-fin sub-funcion

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
					pg_close($conexion);
        }//fin if
        else
        {
            header("Location: index.php");
        }//fin else
?>
