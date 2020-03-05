<?php
session_start();
if(isset($_SESSION['usuarioSession']) && isset($_SESSION['usuarioPrivilegio'])){//verificando si existe una session iniciada
    if($_SESSION['usuarioPrivilegio'] == "administrador"){

    include '../conexion.php';
    
    if(isset($_GET['idPunto'])){
        $idPunto = $_GET['idPunto'];
        $pathPunto = $_GET['path'];
        $namePunto = $_GET['name'];
        $datePunto = $_GET['datetime'];
        $dirPunto = $_GET['direction'];
        
        $pathPuntoOriginal = $pathPunto;
        $namePuntoOriginal = $namePunto;
        $datePuntoOriginal = $datePunto;
        $dirPuntoOriginal = $dirPunto;
        
        $idPuntoSolo = str_replace("demo_bigs_ctm.", "", $idPunto);
        
    }//fin if
    else{
        $idPunto="Dato no recibido";
        $pathPunto ="Dato no recibido";
        $namePunto = "Dato no recibido";
        $datePunto = "Dato no recibido";
        $dirPunto = "Dato no recibido";
    }//fin else
?>
<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Geoportal - Edición</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../fonts/style.css">
        <link rel="stylesheet" href="css/tabla.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            
            <!--Libreria para ALERTAS sweetAlert-->
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    
    <body  style="background:#f5f5f5">
        <div class="container-fluid p-1 mb-2 bg-dark text-white">
        <h5><b>EDITANDO</b> - Id: <?php echo $idPuntoSolo; ?></h5>
        </div>
        
        <div class="container p-2">
            
            <div class="form-group">
                <label for="inputPath" class="small">Path</label>
                <input type="text" class="form-control" id="inputPath" placeholder="Escribe el path" value="<?php echo ($pathPunto);?>">
            </div>
            
            <div class="form-group">
                <label for="inputName" class="small">Name</label>
                <input type="text" class="form-control" id="inputName" placeholder="Escribe name" value="<?php echo ($namePunto);?>">
            </div>
            
            <div class="form-group">
                <label for="inputDate" class="small">Datetime</label>
                <input type="text" class="form-control" id="inputDate" placeholder="Escribe datetime" value="<?php echo ($datePunto);?>">
            </div>
            
            <div class="form-group">
                <label for="inputDir" class="small">Direction</label>
                <input type="text" class="form-control" id="inputDir" placeholder="Escribe direction" value="<?php echo ($dirPunto);?>">
            </div>

            <button type="button" class="btn btn-success mr-3" onclick="opcionesButtons('editar')" title="Editar punto">Editar</button>
            <button type="button" class="btn btn-secondary" onclick="opcionesButtons('cancelar')" title="Cancelar edición">Cancelar</button>
        </div>
        
        
    <!--fin Panel superior-->
    <!--fin codigo de la ventana emergente-->
    
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-input-spinner.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    

    <script src="editarPunto.js"></script><!--Archivo js para editar el punto-->
   
    <script>
    
        function opcionesButtons(opcion){
            switch(opcion){
                case 'editar':
                    
                    swal("¿Estás seguro de modificar este punto?", {
                      title: "Confirmar",
                      icon: "warning",
                      buttons: {
                          cancel: "Cancelar",
                          defeat: "OK",
                      }//fin buttons
                      })//fin swal inicial
                      .then((value) => {
                        if(value) {
                            
                            var pathOriginal = '<?php echo base64_encode($pathPuntoOriginal);?>';//encriptado para poder evaluar con modificado
                            var nameOriginal = '<?php echo $namePuntoOriginal;?>';
                            var dateOriginal = '<?php echo $datePuntoOriginal;?>';
                            var dirOriginal = '<?php echo $dirPuntoOriginal;?>';
                            
                            var idPunto = <?php echo $idPuntoSolo;?>;
                            var pathPunto = btoa(document.getElementById('inputPath').value);//encriptado para poder evaluar con original
                            var namePunto = document.getElementById('inputName').value;
                            var datePunto = document.getElementById('inputDate').value;
                            var dirPunto = document.getElementById('inputDir').value;
                            
                            console.log("Path Original: "+pathOriginal+" = Path Modificado: "+pathPunto);
                            console.log("Name Original: "+nameOriginal+" = Name Modificado: "+namePunto);
                            console.log("Date Original: "+dateOriginal+" = Date Modificado: "+datePunto);
                            console.log("Dir Original: "+dirOriginal+" = Dir Modificado: "+dirPunto);
                            
                            if((pathPunto == pathOriginal) && (namePunto == nameOriginal) && (datePunto == dateOriginal) && (dirPunto == dirPunto)){
                                swal("¿?", "No se han modificado datos del punto", "info");
                                
                                console.log("Path original: "+atob(pathOriginal)+" = Path modificado: "+atob(pathPunto));//desencriptando!
                                
                            }//fin if
                            else
                            {
                                var ruta = "idPunto="+idPunto+"&path="+atob(pathPunto)+"&name="+namePunto+"&datetime="+datePunto+"&direction="+dirPunto;
                                //--ajax
                                 $.ajax({
                                            url:'editarPuntoEdit.php',
                                            type:'POST',
                                            data: ruta,
                                            success: function(res){
                                              //$('#respuesta').html(res);
                                              if(res=="ok"){
                                                    swal({
                                                         title:"¡Perfecto!",
                                                         text:"El punto ha sido modificado con éxito",
                                                             icon: "success", 
                                                         })
                                                        .then((value) => {
                                                           window.close();
                                                    });//fin swal
                                              }
                                              else{
                                                  swal("¡Ups!", "Error: "+res, "error");
                                              }
                                            }
                                        });
                                //--fin ajax
                                
                            }//fin else
                            
                             
                        }//fin if
                    });//fin then
                    break;
                case 'cancelar':
                    swal("¿Deseas cancelar la edición?", {
                      icon: "info",
                      buttons: {
                          cancel: "Regresar",
                          defeat: "OK",
                      }//fin buttons
                      })//fin swal inicial
                      .then((value) => {
                        if(value) {
                             window.close();
                        }//fin if
                    });//fin then
                    break;
                default:
                    console.log("No hay opciones seleccionada");
                    break;
            }
           
        }
        
    
        </script> 
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