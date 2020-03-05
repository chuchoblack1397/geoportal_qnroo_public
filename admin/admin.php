<?php
session_start();
if(isset($_SESSION['usuarioSession']) && isset($_SESSION['usuarioPrivilegio'])){//verificando si existe una session iniciada
    if($_SESSION['usuarioPrivilegio'] == "administrador"){
        
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
       /*  $consultaCapasIndex = "SELECT capas.*, ordencapas.zIndex FROM capas INNER JOIN ordencapas WHERE capas.idCapa = ordencapas.idCapa ORDER BY ordencapas.zIndex DESC ";//consulta general
         $resultadoCapasIndex = mysqli_query($conexion,$consultaCapasIndex);
        	    while($filaCapaIndex = $resultadoCapasIndex->fetch_assoc()){//obteniendo capas de BD
        	     $arregloCapasIndex[]=$filaCapaIndex;//agregando los valores de la BD al arreglo
        	    }//fin while
        /*
        # Una vez que se obtienen los datos de la BD en el ARREGLO
        # se utiliza la siguiente sentencia -
        
            foreach ($arregloCapasIndex as $claveIndex => $campoIndex) {
                echo $campoIndex['idCapa'];
            }//fin foreach
            
        # en donde $campo[''] es donde se pone el nombre del 
        # campo a obtener los valores de BD ahora en el ARREGLO
        */	    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
  
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Geoportal - Administrador</title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <link rel="stylesheet" href="../fonts/style.css">
        <link rel="stylesheet" href="css/tabla.css">
        
           
            
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            
           
        
    </head>
    
    <body>
     <!--Panel superior-->
    <div class="container-fluid p-3 mb-2 bg-dark text-white">
    <h5>Administrador <button class="btn btn-success ml-5" onclick="location.href='../ymagomundi.php'"><span class="icon-location mr-2"></span>VER MAPA</button></h5>
    
    </div>
    <!--fin Panel superior-->

    <!--Alertas-->
    <div id="alert"></div>
    <!--fin alertas--> 
    
    <!--FORMULARIO-->
    <div class="row p-2">
        
      <div class="col-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="opcion_agregarCapa" data-toggle="pill" href="#AgregarCapa" role="tab" aria-controls="AgregarCapa" aria-selected="true"><span class="icon-plus mr-3"></span>Agregar Capa</a>
          <a class="nav-link" id="opcion_verCapa" data-toggle="pill" href="#verCapa" role="tab" aria-controls="verCapa" aria-selected="false"><span class="icon-list2 mr-3"></span>Ver Capas</a>
          <a class="nav-link" id="opcion_ordenarCapa" data-toggle="pill" href="#ordenarCapa" role="tab" aria-controls="ordenarCapa" aria-selected="false"><span class="icon-menu2 mr-3"></span>Ordenar Capas</a>
          <a class="nav-link" id="opcion_papeleraCapa" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><span class="icon-bin mr-3 text-danger"></span>Papelera</a>
        </div><!--fin div tab-content-->
      </div><!--fin div col-3-->
      <div class="col-9">
        <div class="tab-content" id="v-pills-tabContent">
          <div id="AgregarCapa" class="tab-pane fade show active ml-2 p-3" role="tabpanel" aria-labelledby="opcionAgregarCapa">
            <?php include 'formAgregarCapa.php';?>
          </div><!--fin div opcionAgregarCapa-->
          <div id="verCapa" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionVerCapa">
            <?php include 'verCapas.php';?>
          </div><!--fin div verCapas-->
          <div id="ordenarCapa" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionOrdenarCapa">
            <?php include 'ordenarCapas.php';?>
          </div><!--fin div verCapas-->
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
        </div><!--fin div tab-content-->
      </div><!--fin div col-9-->
      
</div><!--fin div row-->
    

    <div id="respuesta">
    </div>
    <!--fin FORMULARIO-->
    
    <!--fin codigo de la ventana emergente-->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-input-spinner.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    
    <script src="js/listaCapaDinamica.js"></script><!--Archivo js para ordenar las capas-->
    
    <script src="js_guardarCapa.js"></script><!--Archivo js para guardar la capa en bd-->
    <script src="js_eliminarCapa.js"></script><!--Archivo js para eliminar la capa en bd-->
    <script src="js_editarCapa.js"></script><!--Archivo js para editar la capa en bd-->
    
    </body>
    
</html>
<?php
    }//fin if
    else
        {
            header("Location: ../index.php");
        }//fin else
 }//fin if
        else
        {
            header("Location: ../index.php");
        }//fin else
?>