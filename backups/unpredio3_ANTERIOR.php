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
    <head>
        <meta charset="UTF-8">
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
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="chk_<?php echo $campo['idCapa'];?>" class="custom-control-input" name="chkGrupo" value="<?php echo $campo['idCapa'];?>">
                                <label for="chk_<?php echo $campo['idCapa'];?>" class="custom-control-label"><?php echo $campo['tituloCapa'];?></label>
                              </div>
                            </li>
					       <?php
					    }//fin foreach
              ?>
              <!--
            <li id="capa_Ortofoto_de_muy_alta_resolución_(5_cm)">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="chk_fotoChilpo" class="custom-control-input" name="chkGrupo" value="fotoChilpo">
                <label for="chk_fotoChilpo" class="custom-control-label">Ortofoto de muy alta resoluci&oacute;n (5 cm)</label>
              </div>
            </li>
           <li id="capa_Calles">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="chk_callesChilpo" class="custom-control-input" name="chkGrupo" value="callesChilpo">
                <label for="chk_callesChilpo" class="custom-control-label">Calles</label>
              </div>
            </li>
            <li id="capa_Predios">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="chk_prediosChilpo" class="custom-control-input" name="chkGrupo" value="prediosChilpo">
                <label for="chk_prediosChilpo" class="custom-control-label">Predios</label>
              </div>
            </li>
            <li id="capa_Colonias">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="chk_colonias" class="custom-control-input" name="chkGrupo" value="colonias">
                <label for="chk_colonias" class="custom-control-label">Colonias</label>
              </div>
            </li>
            <li id="capa_Manzanas">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="chk_manzanas" class="custom-control-input" name="chkGrupo" value="manzanas">
                <label for="chk_manzanas" class="custom-control-label">Manzanas</label>
              </div>
            </li>
            <li id="capa_Regazo">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="chk_rezago" class="custom-control-input" name="chkGrupo" value="rezago">
                <label for="chk_rezago" class="custom-control-label">Rezago en el pago</label>
              </div>
            </li>
            -->
          </ul><!--fin ul capaz-->
      </div><!--fin div capaz-->

  </div><!--fin div contendorControles-->
  <hr><!--linea-->
  <div id="contenidoMedir" class="baseControlPanel">
    <div class="custom-control custom-switch">
       <input type="checkbox" id="chkBoton" class="custom-control-input">
        <label for="chkBoton" class="custom-control-label">Control de Medici&oacute;n</label>
    </div>
        <span class="text-muted text-left">
          <ul>
          <li>Haga clic y arrastre para <b>mover el punto</b></li>
          <li>Presione la tecla MAYÚS y haga clic para <b>eliminar el punto</b><br></li>
          <li>Haga clic y arrastre para presionar la tecla CTRL y haga clic para <b>reanudar el punto</b> de movimiento de línea.<br></li>
          <li>Presione la tecla CTRL y haga clic para <b>agregar un punto</b></li>
          </ul>
        </span>
  </div><!--fin div contendorMedir-->
</div><!--fin div controlMenuPanel-->
 

<!-- fin ENCABEZADO DE LA PAGINA-->

<button id="btnAbrirMenu">
<span class="icon-menu"></span>
</button>

        <div id="map"></div>

            <!-- Modal -->
    <div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Datos del punto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="formId">
                
               <!--Latitud y Longitud-->
              <div class="container">
                  <div class="row">
                      <div class="col">
                        <center>
                            <span id="textoLat" class="small">
                                Latitud
                              </span>
                        </center>
                      </div>
                      <div class="col">
                        <center>
                            <span id="textoLon" class="small">
                                Longitud
                              </span>
                        </center>
                      </div>
                   </div>
              </div>
              
                <!--fotografia-->
                <div class="container">
                    <img id="imgMapa" src="" alt="" style="width: 100%; margin-bottom: 10px;">
                </div>
                
             <!-- PREDIO -->
              <p class="h5">
                Tipo de Predio
              </p>
              <center>
              <div class="form-group py-2">
                <div class="row  justify-content-around">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoPredio" id="rb_baldio" value="baldio" onchange="javascript:mostrarContenido()" checked>
                        <label class="form-check-label" for="rb_baldio">Baldío</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="tipoPredio" id="rb_habitacional" value="habitacional" onchange="javascript:mostrarContenido()">
                          <label class="form-check-label" for="rb_habitacional">Habitacional</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="tipoPredio" id="rb_comercial" value="comercial" onchange="javascript:mostrarContenido()">
                          <label class="form-check-label" for="rb_comercial">Comercial</label>
                      </div>
                </div>
                
              </div>  
            </center> 
            <!-- FIN PREDIO -->

            <!-- # PLANTAS -->
            <p class="h5">
                Número de plantas
            </p>
            <center>
                <div class="form-group py-2" style="width: 60%">
                    <input placeholder="#" required type="number" value="" min="0" max="100" id="numeroPlantas"/>
                </div>
            </center>
            <!-- FIN # PLANTAS -->

            <!-- BANQUETA -->
            <div class="form-group py-2">
                <p class="h5">
                    Banqueta
                </p>
                <center>

                  <div class="row  justify-content-around" style="width: 60%">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="banqueta" id="si" value="SI" checked>
                        <label class="form-check-label" for="si">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="banqueta" id="no" value="NO">
                        <label class="form-check-label" for="no">No</label>
                    </div>
                </div>
              </center>
                
            </div>
              
              <!-- FIN BANQUETA -->

              <!-- DATOS -->
               <!-- DATOS PARA PREDIO COMERCIAL-->
               <div class="form-group py-2" id="comercial" style="display: none">
               <p class="h5">
                Datos
               </p>
               <div style="margin: 0px 30px">
                  <label class="form-check-label" for="tb_razonSocial">Razón Social</label>
                  <input class="form-control form-control" type="text" placeholder="Razón Social" id="tb_razonSocial" required>
                  <br>
                  <label class="form-check-label" for="tb_anuncio">Anuncio</label>
                  <input class="form-control form-control" type="text" placeholder="Anuncio" id="tb_anuncio" required>
               </div>
                 
              </div>
               <!-- FIN DATOS PARA PREDIO COMERCIAL-->

               <!-- DATOS PARA PREDIO HABITACIONAL-->
                <div class="form-group py-2" id="habitacional" style="display: none">
                <p class="h5">
                    Datos
                </p>
                    <div style="width: 60%; margin:0px 80px" class="options">
                        <div class="form-check py-1">
                            <input class="form-check-input" type="checkbox" name="type[]" value="alto/presidencial" id="cb_alto" required>
                            <label class="form-check-label" for="cb_alto">
                              Alto/Residencial
                            </label>
                        </div>
                        <div class="form-check py-1">
                            <input class="form-check-input" type="checkbox" name="type[]" value="popular" id="cb_popular" required>
                            <label class="form-check-label" for="cb_popular">
                              Popular
                            </label>
                        </div>
                        <div class="form-check py-1">
                            <input class="form-check-input" type="checkbox" name="type[]" value="rustico" id="cb_rustico" required>
                            <label class="form-check-label" for="cb_rustico">
                              Rústico
                            </label>
                        </div>
                    </div>
                    
                </div>
                <!-- FIN DATOS PARA PREDIO HABITACIONAL-->
               
                <p class="h5">
                      Frentes de Calle
                </p>
                <center>
                    <div class="form-group py-2" style="width: 60%">
                        <input placeholder="#" required type="number" value="" min="0" max="100" id="numeroFrentresCalle"/>
                    </div>
                </center>
                
              
              <!-- FIN DATOS -->

              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="enviar">Guardar</button>
        </div>
      </div>
    </div>
  </div>

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
      maxZoom: 19, 
      attribution: osmAttrib
      });
    //----fin Mapas de referencia----
    
    //---MAPA---
	var map = new L.Map('map', {
		center: [17.552242, -99.501295],
        zoom: 19,
        minZoom : 5,
        zoomControl: false,
    	//layers: [osm, wmsLayer,predioWMSlayer]
    	layers: [osm]
	});
//---fin MAPA---
    
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
	 ?>
	       <?php
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
    
    /*
    //--capa de calles
    var capa_calles= L.tileLayer.wms("http://74.208.210.103:8990/geos/cat12mx/wms", {
        layers: 'cat12mx:cmun_12029_ref_6369u_calles',
        format: 'image/png',
        transparent: true,
        zIndex: 100 // orden de la capa ((mayor numero mas arriba)
    });
    
    //--capa de predios de chilpancingo
    var capa_predios= L.tileLayer.wms("http://74.208.210.103:8990/geos/cat12mx/wms", {
        layers: 'cat12mx:cmun_12029_ref_6369u_predio',
        format: 'image/png',
        transparent: true,
        zIndex: 99 // orden de la capa (mayor numero mas arriba)
    });
    
    //--capa de foto de chilpo HD
    var capa_fotoChilpo= L.tileLayer.wms("http://74.208.210.103:8990/geos/cat12mx/wms", {
        layers: 'cat12mx:c12029_z01_omgr_fiuagro',
        format: 'image/png',
        transparent: true,
        zIndex: 98 // orden de la capa (mayor numero mas arriba)
    });
    
    //--capa de colonias
    var capa_colonias= L.tileLayer.wms("http://74.208.210.103:8990/geos/cat12mx/wms", {
        layers: 'cat12mx:cmun_12029_ref_6369u_colonias',
        format: 'image/png',
        transparent: true,
        zIndex: 97 // orden de la capa (mayor numero mas arriba)
    });
    
    //--capa de manzanas
    var capa_manzanas= L.tileLayer.wms("http://74.208.210.103:8990/geos/cat12mx/wms", {
        layers: 'cat12mx:cmun_12029_ref_6369u_manzanas',
        format: 'image/png',
        transparent: true,
        zIndex: 96 // orden de la capa (mayor numero mas arriba)
    });
    
    //--capa de rezago
    var capa_rezago= L.tileLayer.wms("http://sdg2112.softether.net:8080/geoserver/opengeo/wms", {
        layers: 'opengeo:chp_pred_rezago',
        format: 'image/png',
        transparent: true,
        zIndex: 95 // orden de la capa (mayor numero mas arriba)
    });
    */
    //----fin Capaz----
//-------------fin Capas-------------  




/*	
    //variables con atributos para el control de capaz por defecto.
    
    var baseLayers = {//variable para CAPAS Base
		"Escala de Grises": grayscale,
        "Calles": streets,
        "OSM": osm,
        "Google Sat": googleSat
	};

	var overlays = {//variable para capas 
        "WMS": wmsLayer,
        "Predios": predioWMSlayer,
        "Calles" : capa_calles
	};
*/

            //L.control.layers(baseLayers, overlays).addTo(map);//asginacion de control de capaz por defecto
            L.control.scale ({maxWidth:240, metric:true, imperial:false, position: 'bottomleft'}).addTo(map);

            //control para poliniea calculo de metrica de puntos
            var myControl= L.control.polylineMeasure ({position:'topright', unit:'metres', showBearings:true, clearMeasurementsOnStop: false, showClearControl: true, showUnitControl: false});
            
            map.addEventListener('click', onMapClick);//llama al evento click dentro del MAPA

var chkBotonControl = document.getElementById('chkBoton');
chkBotonControl.addEventListener("change", validaCheckbox, false);

window.onload = validaCheckbox(); //al cargar la pagina va a validar el boton chekbox

function validaCheckbox(){//funcion para evaluar el boton chkbox
  var checked = chkBotonControl.checked;
  if(checked){
    myControl.addTo(map);//agregar control al mapa
  }//fin if
  else{
    map.removeControl(myControl);// quitar o eliminar control del mapa
  }
}//fin funcion validaCheckbox

var popup = L.popup({maxWidth: 1000,className:'popup'});


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
    var URL = 'http://74.208.210.103:8990/geos/cat12mx/wms?service=WMS&version=1.1.0&request=GetFeatureInfo&layers=cat12mx:cmun_12029_ref_6369u_predio&QUERY_LAYERS=cat12mx:cmun_12029_ref_6369u_predio_sel&propertyName=clvcatact&STYLES=&bbox='+BBOX+'&FEATURE_COUNT=5&HEIGHT='+HEIGHT+'&WIDTH='+WIDTH+'&FORMAT=image%2Fpng&INFO_FORMAT=text%2fhtml&SRS=EPSG%3A4326&X='+X+'&Y='+Y;
    /*$("#ventanaModal").modal();
    document.getElementById("imgMapa").src = "https://www.tony.com.mx/image/cache/catalog/00560003-500x500.jpg";
    document.getElementById("textoLat").textContent="Latitud: "+latitud;
    document.getElementById("textoLon").textContent="Longitud: "+longitud;*/
    var htmlPopup = "<div class='tituloPopup'><b>Titulo</b></div><div class='coordenadasPopup'><span>Latitud:"+latitud+"</span><span>Longitud:"+longitud+"</span></div><div class='contenidoPopup'></div>";
    popup.setLatLng(e.latlng);
    popup.setContent(htmlPopup);
    map.openPopup(popup);
      }//fin else
    }//fin onMapClick
    
    
    
    /*
    
    //--Funcion de AJAX para enviar los datos del formulario---
    $('#enviar').click(function(){

      //adquieriendo el valor de los campos
      var tipoPredio = "Ninguno";
      var tipoPredioName = document.getElementsByName('tipoPredio');
      

      //ciclo para obtener el valor del radioButton
      for(var i=0;i<tipoPredioName.length;i++)
        {
            if(tipoPredioName[i].checked)
            tipoPredio=tipoPredioName[i].value;
        }
        //fin ciclo

      var numPlantas = document.getElementById('numeroPlantas').value;

      var banquetas = "Ninguna";
      var banquetasName = document.getElementsByName('banqueta');
      //ciclo para obtener el valor del radioButton
      for(var i=0;i<banquetasName.length;i++)
        {
            if(banquetasName[i].checked)
            banquetas=banquetasName[i].value;
        }
        //fin ciclo
      
      var frentes = document.getElementById('numeroFrentresCalle').value;

      var razonSocial = document.getElementById('tb_razonSocial').value;
      console.log(razonSocial);

      var anuncio = document.getElementById('tb_anuncio').value;

      //var datoHabi = document.getElementsByName('type[]').value;//checkbox del predio Habitacional

      var selected = ''; //checkbox del predio Habitacional   
          $('#formId input[type=checkbox]').each(function(){
              if (this.checked) {
                  selected += $(this).val()+', ';
              }
          }); 
          
      
      
      var Ruta = "tipoPredio="+tipoPredio+"&numPlantas="+numPlantas+"&banquetas="+banquetas+
      "&frentes="+frentes+"&razonSocial="+razonSocial+"&anuncio="+anuncio+
      "&datoHabitacional="+selected;
      

      $.ajax({
        url:'datos.php',
        type:'POST',
        data: Ruta,
        success: function(res){
          $('#respuesta').html(res);
      }
      });
    });
    // ------ fin funcion de AJAX -----


//funciones para la ventana emergente
 //funcion para mostrar y ocultar las secciones de "habitacional" y "comercial"
    function mostrarContenido(){
      elementoHabitacional = document.getElementById("habitacional");
      elementoComercial = document.getElementById("comercial");

      rbHabitacional = document.getElementById("rb_habitacional");
      rbComercial = document.getElementById("rb_comercial");

      rbBaldio = document.getElementById("rb_baldio");

        if (rbHabitacional.checked) {
          elementoHabitacional.style.display='block';
        }
        else {
          elementoHabitacional.style.display='none';
        }

        if (rbComercial.checked) {
          elementoComercial.style.display='block';
        }
        else {
          elementoComercial.style.display='none';
        }

        if(rbBaldio.checked){
          elementoHabitacional.style.display='none';
          elementoComercial.style.display='none';
        }
    };
    //------fin funcion ---------

    // Funcion para revisar cada uno de los checkbox de la seccion "Habitacional"
    $(function(){
        var requiredCheckboxes = $('.options :checkbox[required]');
        requiredCheckboxes.change(function(){
            if(requiredCheckboxes.is(':checked')) {
                requiredCheckboxes.removeAttr('required');
            } else {
                requiredCheckboxes.attr('required', 'required');
            }
      });
      //--------fin funcion ----------
});
//---fin de funciones de ventana emergente

*/
        </script> 

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="controlPanelOpciones.js"></script>  
<script src="controlPanel.js"></script>
    </body>
</html>

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