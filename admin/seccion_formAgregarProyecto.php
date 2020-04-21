<?php
include "../conexion.php";
?>
<form id="formAgregarProyecto">
    <h3>
        Crear nuevo proyecto
    </h3>
    <div class="form-group row">
        <label for="nombreProyecto" class="col-sm-2 col-form-label">Nombre del proyecto</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nombreProyecto" placeholder="Nombre del proyecto" required>
        </div>
    </div>
    <form></form>
    <div class="form-group row">
        <div class="col mr-1">
            <h6>Selecciona las capas que pertenecerán a este proyecto:</h6>
            <button type="button" id="seleccionar_capas" class="btn btn-secondary mb-2">Seleccionar todas</button>
            <button type="button" id="limpiar_Capas" class="btn btn-secondary mb-2">Limpiar selección</button>
            <div class="table-responsive">
                <div style="position: relative; height: 450px; overflow: auto; display: block;">
                    <form id="formAsignarCapasAProyecto" name="formAsignarCapasAProyecto">
                        <table class="table table-condensed table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">zindex</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaAsignacionCapaProyecto">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--fin col-->
        <div class="col ml-1">
            <h6>Selecciona a los usuarios que tendrán acceso a este proyecto:</h6>
            <button type="button" id="seleccionar_usuarios" class="btn btn-secondary mb-2">Seleccionar todos</button>
            <button type="button" id="limpiar_Usuarios" class="btn btn-secondary mb-2">Limpiar selección</button>
            <div class="table-responsive">
                <div style="position: relative; height: 450px; overflow: auto; display: block;">
                    <form id="formAsignarUsuariosAProyecto">
                        <table class="table table-condensed table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre Usuario</th>
                                    <th scope="col">Nombre Completo</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaAsignacionUsuarioProyecto">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--fin col-->
    </div>
    <!--fin row-->

    <div class="form-group row">
        <div class="col-sm-10">
            <button type="button" class="btn btn-primary" id="btn_guardarProyecto">Crear proyecto</button>
        </div>
    </div>
</form>
<div id="scripts"></div>

<script>
    function ajax_asignar_capas_proyecto() {
        console.log('Dentro de AJAX ver asignarcion de usuarios y capas');

        $.ajax({
            url: 'php_asignar_capas.php',
            beforeSend: function() {
                document.getElementById("cuerpoTablaAsignacionCapaProyecto").innerHTML = "<p>Cargando...</p>";
            },
            success: function(res) {
                let seccionVer = document.getElementById("cuerpoTablaAsignacionCapaProyecto");
                seccionVer.innerHTML = res;
            },
            error: function() {
                alert("Error con el servidor");
            }
        });

        $.ajax({
            url: 'php_asignar_capas_usuarios.php',
            beforeSend: function() {
                document.getElementById("cuerpoTablaAsignacionUsuarioProyecto").innerHTML = "<option selected value=''>Cargando...</option>";
            },
            success: function(res) {
                let seccionVer = document.getElementById("cuerpoTablaAsignacionUsuarioProyecto");
                seccionVer.innerHTML = res;
            },
            error: function() {
                alert("Error con el servidor");
            }
        });
    }

    //funcion para el buscador
    // $(document).ready(function() {
    //   $("#buscadorAsignarCapas").on("keyup", function() {
    //     var value = $(this).val().toLowerCase();
    //     $("#cuerpoTablaAsignacionProyecto tr").filter(function() {
    //       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    //     });
    //   });
    // });
    // //fin funcion buscador


    // //funcion limpiar el formulario
    // function limpiarFormulario() {
    //   listAsignarCapa
    //   document.getElementById("formAsignarCapasAProyecto").reset();
    //   document.getElementById("formAsignarTodasCapas").reset();
    //   document.getElementById("formAsignarUsuariosAProyecto").reset();
    // }

    function accionesFormularios() {
        //Quitar checkboxs
        $('#limpiar_Capas').click(function() {
            $('#formAsignarCapasAProyecto')[0].reset();
        });

        $('#limpiar_Usuarios').click(function() {
            $('#formAsignarUsuariosAProyecto')[0].reset();
        });

        //Seleccionar todos los checkboxs
        $('#seleccionar_capas').click(function() {
            //console.log($('#formAsignarCapasAProyecto input:checkbox').not(this));
            $('#formAsignarCapasAProyecto').find('input:checkbox').prop('checked', true);
        });

        $('#seleccionar_usuarios').click(function() {
            $('#formAsignarUsuariosAProyecto').find('input:checkbox').prop('checked', true);
        });
    }

    $(document).ready(function() {
        accionesFormularios();
    });

    // //funnciones para habilitar y deshabilitar checkbox
    // $("#chk_vistaTotalAsignada").click(function() {
    //   $("input[type=checkbox][name='inputAsignarProyectos[]']").prop("checked", $(this).prop("checked"));

    //   $("input[type=checkbox][name='inputAsignarProyectos[]']").click(function() {
    //     if (!$(this).prop("checked")) {
    //       $("#chk_vistaTotalAsignada").prop("checked", false);
    //     }
    //   });
    // });
    let base_url = "<?= "http://" . $_SERVER['SERVER_NAME']; ?>";
</script>
<script src="js_guardarProyecto.js" defer></script>