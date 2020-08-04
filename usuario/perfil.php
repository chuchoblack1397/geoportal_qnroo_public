<?php
session_start();
include '../conexion.php';
if (isset($_SESSION['usuarioSession']) && isset($_SESSION['usuarioPrivilegio'])) { //verificando si existe una session iniciada
  if ($_SESSION['usuarioPrivilegio'] != "") {

?>

    <!DOCTYPE html>
    <html lang="es" class="h-100">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Geoportal - Perfil de usuario</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../fonts/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        
    </head>

    <body class="d-flex flex-column h-100">
    <div id="errores">
    </div>
        <!--Panel superior-->
        <div class="container-fluid p-3 mb-2 bg-dark text-white">
            <h5>
                <span class="icon-profile mr-2"></span>Perfil de usuario <button class="btn btn-success ml-5" onclick="location.href='../ymagomundi.php'"><span class="icon-location mr-2"></span>VER MAPA</button>
                <a href="../cerrarSesion.php" class="text-danger ml-5"><span class="icon-switch"></span> Cerrar sesión</a>
            </h5>
        </div>
        <!--fin Panel superior-->

        <!--MODALS-->
        <?php include "modals.php"; ?>

        <div class="container bg-white p-2"><!--datos usuarios-->
            <div class="card" >
                <div class="row no-gutters">
                    <div class="col-md-2">
                        <img src="imagenes/default.png" class="card-img p-4" alt="Foto de perfil" id="foto_perfil">
                        <br>
                        <center>
                            <label for="cargaImagen" class="btn btn-link btn-sm text-danger" onMouseOver="this.style.cursor='pointer'">
                                <span class="icon-pencil"></span> Cambiar imagen
                            </label>
                            <input type="file" class="custom-file-input" id="cargaImagen" style="display:none" name="file" accept="image/png, image/jpeg">
                        </center>
                    </div><!--fin col-->
                    <div class="col-md-7">
                        <div class="card-body" id="datos_usuario">
                            
                        </div><!--fin card-body-->
                    </div><!--fin col-->
                    <div class="col-md-3">
                        <div class="card-body text-right pr-4">
                            <ul class="list-unstyled mt-4">
                                <li title="Editar perfil">
                                    <a href="#" class="card-link" data-toggle="modal" data-target="#modal_editar_usuario" onclick="cargar_modal_usuario()">Editar perfil<span class="icon-pencil ml-2"></span></a>
                                </li>
                                <li title="Cambiar contraseña">
                                    <a href="#" class="card-link" data-toggle="modal" data-target="#modal_cambiar_password">Cambiar contraseña<span class="icon-key ml-2"></span></a>
                                </li>
                            </ul><!--fin ul-->
                        </div><!--fin card-body-->
                    </div><!--fin col-->
                </div><!--fin row-->
            </div><!--fin card-->
    </div><!--fin datos usuario-->
    <div class="container">
        <div class="card text-justify" style="width: 19rem;">
            <h5 class="card-header">Imagen georreferenciada</h5>
            <div class="card-body">
            <p class="card-text ">Esta herramienta sube y geolocaliza en el mapa una imagen que haya sido tomada con georreferencia activada.</p>
            <center><button type="button" class="btn btn-success text-white" title="Ver mapa" data-toggle="modal" data-target="#modal_subir_fotoGeo"><span class="icon-images mr-2"></span>Subir imagen</button></center>
        </div>
</div>
    </div>
    <div class="container bg-white p-3 pb-5"><!--mapa-->
        <div class="row"><!--row-->
            <div class="col-md-8">
                <h4>Información</h4>
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="icon-books"></span> Proyectos asignados
                            <br>
                            <ol class="list" id="proyectos_usuario">
                                
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <span class="icon-pushpin"></span> Mis marcadores
                            <br>
                            <ol class="list" id="marcadores_usuario">
                            </ol>
                        </div>
                    </div>
                    
                </div>
            </div><!--fin col-->
            <div class="col-md-4 text-center">
               
            </div><!--fin col-->
        </div><!--fin row-->
    </div><!--fin mapa-->
    <!--pie de pagina-->
    <footer class="footer mt-auto p-3 bg-dark text-light">
        <div class="container">
        <center><span class="text-center">Este sitio es para fines de seguridad personal. Toda información y datos proporcionados serán utilizados por las autoridades pertinentes de acuerdo a los <a href="#" class="text-warning">Términos y condiciones</a>, en caso de algún factor que atiente contra la integridad del usuario propietario.</span></center>
            <hr>
            <div class="row"><!--row-->
                <div class="col-md-8">
                <div class="row"><!--row-->
                    <div class="col">
                    <h6>Menú</h6>
                    <ul class="list-unstyled ml-1">
                        <li><a href="../ymagomundi.php" class="text-light">Ver mapa</a></li>
                        <li><a href="#" class="text-light">Acerca de</a></li>
                        <li><a href="../cerrarSesion.php" class="text-light">Cerrar sesión</a></li>
                    </ul><!--fin ul-->
                    </div><!--fin col-->
                    <div class="col">
                    <h6>Perfil</h6>
                    <ul class="list-unstyled ml-1">
                        <li title="Editar perfil"><a href="#" class="text-light"  data-toggle="modal" data-target="#modal_editar_usuario">Editar perfil</a></li>
                        <li title="Cambiar contraseña"><a href="#" class="text-light"  data-toggle="modal" data-target="#modal_cambiar_password">Cambiar contraseña</a></li>
                    </ul><!--fin ul-->
                    </div><!--fin col-->
                </div><!--fin row-->
                </div><!--fin col-->
                <div class="col-md-4 text-center">
                    <!--<img src="img/logo_solo_blanco.png" width="130px">-->
                </div><!--fin col-->
            </div><!--fin row-->
            <p class="text-secondary">&#174; <small>Todos los derechos reservados</small></p>
        </div>
    </footer>

        <!--fin codigo de la ventana emergente-->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap-input-spinner.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    
        <script src="js_cargar_informacion.js"></script>
        <script src="js_ediciones.js"></script>

        <script>
        
        
        const imagen = document.getElementById("cargaImagen");
        imagen.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const formData = new FormData();
            formData.append('file',file);

            if(imagen != ''){
                $.ajax({
                url: 'enviarImagen.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function(){
                    document.getElementById('foto_perfil').src="../img/loading.gif";
                },
                success: function(data){
                    document.getElementById('foto_perfil').src="imagenes/"+data;
                }
            });
            }else{
                console.log("cancelando cambiar imagen");
                return;
            }

            
        });
        
        </script>

    </body>
    </html>
<?php
  } //fin if
  else {
    header("Location: ../index.php");
  } //fin else
} //fin if
else {
  header("Location: ../index.php");
} //fin else
?>