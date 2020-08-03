<?php
session_start();
include '../conexion.php';
if (isset($_SESSION['usuarioSession']) && isset($_SESSION['usuarioPrivilegio'])) { //verificando si existe una session iniciada
  if ($_SESSION['usuarioPrivilegio'] == "administrador" || $_SESSION['rol_capa_r'] == "true" || $_SESSION['rol_mapa_r'] == "true" || $_SESSION['rol_usuario_r'] == "true" || $_SESSION['rol_rol_r'] == "true") {

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
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
      <script src="sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
      <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>


      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>

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

      <!--Menu de administradcion-->

      <nav class="m-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-estadisticas-tab" data-toggle="tab" href="#nav-estadisticas" role="tab" aria-controls="nav-estadisticas" aria-selected="false"></a>
          <?php if ($_SESSION['rol_capa_c'] == 'false' && $_SESSION['rol_capa_r'] == 'false' && $_SESSION['rol_capa_u'] == 'false' && $_SESSION['rol_capa_d'] == 'false') {
          } else { ?>
            <a class="nav-item nav-link" id="nav-capas-tab" data-toggle="tab" href="#nav-capas" role="tab" aria-controls="nav-capas" aria-selected="false">Capas</a>
          <?php
          } //fin if
          ?>
          <?php if ($_SESSION['rol_mapa_c'] == 'false' && $_SESSION['rol_mapa_r'] == 'false' && $_SESSION['rol_mapa_u'] == 'false' && $_SESSION['rol_mapa_d'] == 'false') {
          } else { ?>
            <a class="nav-item nav-link" id="nav-mapas_referencia-tab" data-toggle="tab" href="#nav-mapas_referencia" role="tab" aria-controls="nav-mapas_referencia" aria-selected="false" onclick="ajax_asignar_capas_proyecto();">Proyectos</a>
          <?php
          }
          ?>

          <?php if ($_SESSION['rol_usuario_c'] == 'false' && $_SESSION['rol_usuario_r'] == 'false' && $_SESSION['rol_usuario_u'] == 'false' && $_SESSION['rol_usuario_d'] == 'false') {
          } else { ?>
            <a class="nav-item nav-link" id="nav-usuarios-tab" data-toggle="tab" href="#nav-usuarios" role="tab" aria-controls="nav-usuarios" aria-selected="false">Usuarios</a>

          <?php
          }
          ?>
          <?php if ($_SESSION['rol_rol_c'] == 'false' && $_SESSION['rol_rol_r'] == 'false' && $_SESSION['rol_rol_u'] == 'false' && $_SESSION['rol_rol_d'] == 'false') {
          } else {
          ?>
            <a class="nav-item nav-link" id="nav-roles-tab" data-toggle="tab" href="#nav-roles" role="tab" aria-controls="nav-roles" aria-selected="false">Privilegios/Roles</a>

          <?php
          }
          ?>
        </div>
      </nav>
      <!--fin menu de administracion-->
      <!--Opciones de menu-->
      <div class="tab-content m-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-estadisticas" role="tabpanel" aria-labelledby="nav-estadisticas-tab">
          <h2 class="h2"></h2>
          <?php include 'seccion_formEstadisticas.php'; ?>
        </div>
        <!--Opcion CAPAS-->
        <?php if ($_SESSION['rol_capa_c'] == 'false' && $_SESSION['rol_capa_r'] == 'false' && $_SESSION['rol_capa_u'] == 'false' && $_SESSION['rol_capa_d'] == 'false') {
        } else { ?>
          <div class="tab-pane fade" id="nav-capas" role="tabpanel" aria-labelledby="nav-capas-tab">
            <h2 class="h2">Capas</h2>
            <!--FORMULARIO-->
            <div class="row p-2">
              <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <?php
                  if ($_SESSION['rol_capa_c'] == 'true') {
                  ?>
                    <a class="nav-link active" id="opcion_agregarCapa" data-toggle="pill" href="#AgregarCapa" role="tab" aria-controls="AgregarCapa" aria-selected="true"><span class="icon-plus mr-3"></span>Agregar Capa</a>
                  <?php
                  }
                  ?>
                  <?php
                  if ($_SESSION['rol_capa_r'] == 'true') {
                  ?>
                    <a class="nav-link" id="opcion_verCapa" data-toggle="pill" href="#verCapa" role="tab" aria-controls="verCapa" aria-selected="false" onclick="ajax_ver_capas();"><span class="icon-list2 mr-3"></span>Ver Capas</a>
                  <?php
                  }
                  ?>
                  <?php
                  if ($_SESSION['rol_capa_u'] == 'true') {
                  ?>
                    <a class="nav-link" id="opcion_ordenarCapa" data-toggle="pill" href="#ordenarCapa" role="tab" aria-controls="ordenarCapa" aria-selected="false" onclick="cargar_lista_proyectos_ordenar();select_proyecto_ordenar();"><span class="icon-menu2 mr-3"></span>Ordenar Capas</a>
                  <?php
                  }
                  ?>
                  <?php
                  if ($_SESSION['rol_capa_c'] == 'true') {
                  ?>
                  <a class="nav-link" id="opcion_subir_archivo" data-toggle="pill" href="#subir_archivo" role="tab" aria-controls="subir_archivo" aria-selected="false"><span class="icon-upload3 mr-3"></span>Subir archivo</a>
                  <?php
                  }
                  ?>
                  <!--<a class="nav-link" id="opcion_papeleraCapa" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><span class="icon-bin mr-3 text-danger"></span>Papelera</a>-->
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-3-->
              <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                  <div id="AgregarCapa" class="tab-pane fade show active ml-2 p-3" role="tabpanel" aria-labelledby="opcionAgregarCapa">
                    <?php
                    if ($_SESSION['rol_capa_c'] == 'true') {
                      include 'seccion_formAgregarCapa.php';
                    } ?>
                  </div>
                  <!--fin div opcionAgregarCapa-->
                  <div id="verCapa" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionVerCapa">
                    <?php include 'seccion_verCapas.php'; ?>
                  </div>
                  <!--fin div verCapas-->
                  <div id="ordenarCapa" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionOrdenarCapa">
                    <?php include 'seccion_ordenarCapas.php'; ?>
                  </div>
                  <!--fin div verCapas-->
                  <div id="subir_archivo" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcion_subir_archivo">
                    <?php include 'seccion_subir_archivo.php'; ?>
                  </div>
                  <!--fin div verCapas-->
                  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-9-->
            </div>
            <!--fin div row-->
            <div id="respuesta">
            </div>
            <!--fin FORMULARIO-->
          </div>
          <!--fin opcion CAPAS-->
        <?php
        } //fin if
        ?>
        <?php if ($_SESSION['rol_mapa_c'] == 'false' && $_SESSION['rol_mapa_r'] == 'false' && $_SESSION['rol_mapa_u'] == 'false' && $_SESSION['rol_mapa_d'] == 'false') {
        } else { ?>
          <div class=" container-fluid tab-pane fade" id="nav-mapas_referencia" role="tabpanel" aria-labelledby="nav-mapas_referencia-tab">
            <h2 class="h2">Proyectos</h2>
            <!--FORMULARIO-->
            <div class="row p-2">
              <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <?php
                  if ($_SESSION['rol_mapa_c'] == 'true') {
                  ?>
                    <a class="nav-link active" id="opcion_agregarProyecto" data-toggle="pill" href="#agregarProyecto" role="tab" aria-controls="agregarProyecto" aria-selected="true" onclick="ajax_asignar_capas_proyecto();"><span class="icon-plus mr-3"></span>Crear proyecto</a>
                  <?php
                  }

                  ?>
                  <?php
                  if ($_SESSION['rol_mapa_r'] == 'true') {
                  ?>
                    <a class="nav-link" id="opcion_verProyecto" data-toggle="pill" href="#verProyecto" role="tab" aria-controls="verProyecto" aria-selected="false" onclick="ajax_ver_proyectos();"><span class="icon-list2 mr-3"></span>Ver proyectos</a>

                  <?php
                  }
                  ?>

                  <!--<a class="nav-link" id="opcion_papeleraMapa" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><span class="icon-bin mr-3 text-danger"></span>Papelera</a>-->
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-3-->
              <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                  <div id="agregarProyecto" class="tab-pane fade show active ml-2 p-3" role="tabpanel" aria-labelledby="opcion_agregarProyecto">
                    <?php
                    if ($_SESSION['rol_mapa_c'] == 'true') {
                      include 'seccion_formAgregarProyecto.php';
                    } ?>
                  </div>
                  <!--fin div opcionAgregarCapa-->
                  <div id="verProyecto" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionVerProyectos">
                    <?php include 'seccion_verProyectos.php'; ?>
                  </div>
                  <!--fin div verCapas-->
                  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-9-->
            </div>
            <!--fin div row-->
            <div id="respuesta">
            </div>
            <!--fin FORMULARIO-->
          </div>
        <?php
        }
        ?>
        <?php if ($_SESSION['rol_usuario_c'] == 'false' && $_SESSION['rol_usuario_r'] == 'false' && $_SESSION['rol_usuario_u'] == 'false' && $_SESSION['rol_usuario_d'] == 'false') {
        } else { ?>
          <div class="tab-pane fade" id="nav-usuarios" role="tabpanel" aria-labelledby="nav-usuarios-tab">
            <h2 class="h2">Usuarios</h2>
            <!--FORMULARIO-->
            <div class="row p-2">
              <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <?php
                  if ($_SESSION['rol_usuario_c'] == 'true') {
                  ?>
                    <a class="nav-link active" id="opcion_agregarUsuario" data-toggle="pill" href="#AgregarUsuario" role="tab" aria-controls="AgregarUsuario" aria-selected="true"><span class="icon-plus mr-3"></span>Agregar Usuario</a>

                  <?php
                  }
                  ?>
                  <?php
                  if ($_SESSION['rol_usuario_r'] == 'true') {
                  ?>
                    <a class="nav-link" id="opcion_verUsuario" data-toggle="pill" href="#verUsuario" role="tab" aria-controls="verUsuario" aria-selected="false" onclick="ajax_ver_usuarios();"><span class="icon-list2 mr-3"></span>Listar Usuarios</a>
                  <?php
                  }

                  ?>
                  <!--<a class="nav-link" id="opcion_papeleraCapa" data-toggle="pill" href="#papeleraUsuario" role="tab" aria-controls="papeleraUsuario" aria-selected="false"><span class="icon-bin mr-3 text-danger"></span>Papelera</a>-->
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-3-->
              <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                  <div id="AgregarUsuario" class="tab-pane fade show active ml-2 p-3" role="tabpanel" aria-labelledby="opcionAgregarUsuario">
                    <?php
                    if ($_SESSION['rol_usuario_c'] == 'true') {
                      include 'seccion_formAgregarUsuario.php';
                    } ?>
                  </div>
                  <!--fin div opcionAgregarUsuario-->
                  <div id="verUsuario" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionVerUsuario">
                    <?php include 'seccion_verUsuario.php'; ?>
                  </div>
                  <!--fin div verUsuario-->
                  <div id="papeleraUsuario" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-settings-tab">Papelera de usuarios eliminados</div>
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-9-->
            </div>
            <!--fin div row-->
            <div id="respuestaUsuario">
            </div>
            <!--fin FORMULARIO-->
          </div>
        <?php
        }
        ?>

        <?php if ($_SESSION['rol_rol_c'] == 'false' && $_SESSION['rol_rol_r'] == 'false' && $_SESSION['rol_rol_u'] == 'false' && $_SESSION['rol_rol_d'] == 'false') {
        } else { ?>

          <div class="tab-pane fade" id="nav-roles" role="tabpanel" aria-labelledby="nav-roles-tab">
            <h2 class="h2">Privilegios/Roles</h2>
            <!--FORMULARIO-->
            <div class="row p-2">
              <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <?php
                  if ($_SESSION['rol_rol_c'] == 'true') {
                  ?>
                    <a class="nav-link active" id="opcion_agregarRol" data-toggle="pill" href="#AgregarRol" role="tab" aria-controls="AgregarRol" aria-selected="true"><span class="icon-plus mr-3"></span>Agregar Privilegio/Rol</a>
                  <?php
                  }
                  ?>
                  <?php
                  if ($_SESSION['rol_rol_r'] == 'true') {
                  ?>
                    <a class="nav-link" id="opcion_verRol" data-toggle="pill" href="#verRol" role="tab" aria-controls="verRol" aria-selected="false" onclick="ajax_ver_privilegios();"><span class="icon-list2 mr-3"></span>Ver Privilegios/Roles</a>
                  <?php
                  }
                  ?>
                  <!--<a class="nav-link" id="opcion_papeleraRol" data-toggle="pill" href="#papeleraRol" role="tab" aria-controls="papeleraRol" aria-selected="false"><span class="icon-bin mr-3 text-danger"></span>Papelera de Privilegios/Roles</a>-->
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-3-->
              <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                  <div id="AgregarRol" class="tab-pane fade show active ml-2 p-3" role="tabpanel" aria-labelledby="opcionAgregarRol">
                    <?php
                    if ($_SESSION['rol_rol_c'] == 'true') {
                      include 'seccion_formAgregarPrivilegio.php';
                    } ?>
                  </div>
                  <!--fin div opcionAgregarRol-->
                  <div id="verRol" class="tab-pane fade ml-2 p-3" role="tabpanel" aria-labelledby="opcionVerRol">
                    <?php include 'seccion_verPrivilegios.php'; ?>
                  </div>
                  <!--fin div verRol-->
                  <!--<div id="papeleraRol" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-settings-tab">Papelera de Privilegios/Roles</div>-->
                </div>
                <!--fin div tab-content-->
              </div>
              <!--fin div col-9-->
            </div>
            <!--fin div row-->
            <div id="respuestaRoles">
            </div>
            <!--fin FORMULARIO-->
          </div>
      </div>
    <?php
        }
    ?>
    <!--fin Opciones de menu-->



    <!--fin codigo de la ventana emergente-->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-input-spinner.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="js/listaCapaDinamica.js"></script>
    <!--Archivo js para ordenar las capas-->

    <script src="js_guardarCapa.js"></script>
    <!--Archivo js para guardar la capa en bd-->
    <script src="js_eliminarCapa.js"></script>
    <!--Archivo js para eliminar la capa en bd-->
    <script src="js_editarCapa.js"></script>
    <!--Archivo js para editar la capa en bd-->
    <script src="js_editarProyecto.js"></script>
    <!--Archivo js para editar el proyecto en bd-->
    <script src="js_guardarUsuario.js"></script>
    <!--Archivo js para guardar la capa en bd-->
    <script src="js_eliminarUsuario.js"></script>
    <!--Archivo js para eliminar la capa en bd-->
    <script src="js_editarUsuario.js"></script>
    <!--Archivo js para editar la capa en bd-->
    <script src="js_guardarPrivilegio.js"></script>
    <!--Archivo js para editar la capa en bd-->
    <script src="js_eliminarPrivilegio.js"></script>
    <!--Archivo js para eliminar la capa en bd-->
    <!--<script src="js_guardarAsignacionCapaProyecto.js"></script>-->
    <!--Archivo js para eliminar la capa en bd-->
    <script src="js_eliminarProyecto.js"></script>

    </body>

    </html>

    <script>
      //document.getElementById("verCapa").onclick = function() {myFunction()};
      $(document).ready(function () {
        bsCustomFileInput.init()
      });
    </script>
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