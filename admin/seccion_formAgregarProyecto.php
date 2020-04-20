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

    <div class="form-group row">
        <div class="col mr-1">
            <h6>Selecciona las capas que pertenecerán a este proyecto:</h6>
            <button type="Reset" class="btn btn-secondary mb-2">Seleccionar todas</button>
            <button type="" class="btn btn-secondary mb-2">Limpiar selección</button>
            <div class="table-responsive">
                <div style="position: relative; height: 450px; overflow: auto; display: block;">
                    <form id="formAsignarCapas">
                        <table class="table table-condensed table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">zindex</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaAsignacionProyecto">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--fin col-->
        <div class="col ml-1">
            <h6>Selecciona a los usuarios que tendrán acceso a este proyecto:</h6>
            <button type="Reset" class="btn btn-secondary mb-2">Seleccionar todos</button>
            <button type="" class="btn btn-secondary mb-2">Limpiar selección</button>
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

<script>
    function ajax_asignar_capas_proyecto() {
        console.log('Dentro de AJAX ver asignarcion de usuarios y capas');

        $.ajax({
            url: 'php_asignar_capas.php',
            beforeSend: function() {
                document.getElementById("cuerpoTablaAsignacionProyecto").innerHTML = "<p>Cargando...</p>";
            },
            success: function(res) {
                seccionVer = document.getElementById("cuerpoTablaAsignacionProyecto");
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
                seccionVer = document.getElementById("cuerpoTablaAsignacionUsuarioProyecto");
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
    //   document.getElementById("formAsignarCapas").reset();
    //   document.getElementById("formAsignarTodasCapas").reset();
    //   document.getElementById("formAsignarUsuario").reset();
    // }

    // //funnciones para habilitar y deshabilitar checkbox
    // $("#chk_vistaTotalAsignada").click(function() {
    //   $("input[type=checkbox][name='inputAsignarProyectos[]']").prop("checked", $(this).prop("checked"));

    //   $("input[type=checkbox][name='inputAsignarProyectos[]']").click(function() {
    //     if (!$(this).prop("checked")) {
    //       $("#chk_vistaTotalAsignada").prop("checked", false);
    //     }
    //   });
    // });

    //
    $(document).ready(function() {
        //console.log('documento listo')
        //asignarCapasUsuarios_proyecto();
    });

    //funcion para asignar capas seleccionadas
    function asignarCapasUsuarios_proyecto() {
        var capasAsiganadas, usuariosAsiganados;
        $("#btn_guardarProyecto").click(function() {
            capasAsiganadas = new Array();
            usuariosAsiganados = new Array();
            //get capas seleccionadas
            console.log($("#cuerpoTablaAsignacionProyecto tr"));

            $("#cuerpoTablaAsignacionProyecto tr").each(function(index, value) {
                let capasCheckbox = $(this).find("input[type=checkbox][name='inputAsignarProyectos[]']");
                let idcapa = '';
                if (!capasCheckbox.is(":checked"))
                    return;
                else {
                    idcapa = $(this).find("input[type=checkbox][name='inputAsignarProyectos[]']").val();
                    console.log(idcapa);
                    capasAsiganadas.push(
                        idcapa
                    );
                }
            });
            //send to php and save to db
            if (capasAsiganadas.length > 0) {
                console.log(capasAsiganadas);

                /* $.ajax({
                    url: 'php_asignar_capas.php',
                    beforeSend: function() {
                        document.getElementById("cuerpoTablaAsignacion").innerHTML = "<p>Cargando...</p>";
                    },
                    success: function(res) {
                        seccionVer = document.getElementById("cuerpoTablaAsignacion");
                        seccionVer.innerHTML = res;
                    },
                    error: function() {
                        alert("Error con el servidor");
                    }
                }); */
            } else {
                console.log("No se ha seleccionado alguna capa");
            }
        });
        //get usuarios seleccionados
        console.log($("#cuerpoTablaAsignacionProyecto tr"));
        $("#cuerpoTablaAsignacionProyecto tr").each(function(index, value) {
            let dataArray = [];
            if (!$(this).find("input[type=checkbox][name='inputAsignarProyectos[]']").is(":checked"))
                return;
            $(this).find('td').each(function(index2, td) {
                //console.log("Index: " + index + " Data: " + $(td).text());
                if (index2 == 0) dataArray["titulocapa"] = $(td).text();
                if (index2 == 1) dataArray["layer"] = $(td).text();
                if (index2 == 2) dataArray["formato"] = $(td).text();
                if (index2 == 3) dataArray["campo_consulta"] = $(td).text();
                if (index2 == 4) dataArray["zindex"] = $(td).text();
                if (index2 == 5) dataArray["titulocapa"] = $(td).text();
            });
            usuariosAsiganados.push(
                dataArray
            );
            //console.log(dataArray);
        });
        //send to php and save to db
        if (usuariosAsiganados.length > 0) {
            console.log(usuariosAsiganados);

            /* $.ajax({
                url: 'php_asignar_capas.php',
                beforeSend: function() {
                    document.getElementById("cuerpoTablaAsignacion").innerHTML = "<p>Cargando...</p>";
                },
                success: function(res) {
                    seccionVer = document.getElementById("cuerpoTablaAsignacion");
                    seccionVer.innerHTML = res;
                },
                error: function() {
                    alert("Error con el servidor");
                }
            }); */
        } else {
            console.log("No se ha seleccionado alguna capa");
        }

    };

    let base_url = "<?= "http://" . $_SERVER['SERVER_NAME']; ?>";
</script>