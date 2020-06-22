<?php
include "../conexion.php";
?>
<form id="formAsignarCapa">
  <div class="form-group row">
    <label for="listAsignarCapa" class="col-sm-2 col-form-label">Asignar capa</label>
    <div class="col-sm-10" id="contenidoCapasAsignar">
      <select class="custom-select" id="listAsignarCapa">
      </select>
    </div>
  </div>
</form>

<input type="text" class="form-control" id="buscadorAsignarCapas" placeholder="Buscar proyecto">
<br>

<form id="formAsignarTodasCapas">
  <div class="custom-control custom-checkbox ml-1">
    <input type="checkbox" class="custom-control-input" id="chk_vistaTotalAsignada">
    <label class="custom-control-label font-weight-bold" for="chk_vistaTotalAsignada">Vista Total</label>
    <!-- <span id="info_capaCapa" class="text-info ml-2">(Tendrá acceso a ver todas las capas actuales y futuras).</span> -->
  </div>
</form>

<div class="table-responsive">
  <div style="position: relative; height: 500px; overflow: auto; display: block;">
    <form id="formAsignarCapas">
      <table class="table table-condensed">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
          </tr>
        </thead>
        <tbody id="cuerpoTablaAsignacionProyecto">
        </tbody>
      </table>
    </form>
  </div>
</div>
<div class="form-group row mt-2">
  <div class="col-sm-10">
    <button type="button" class="btn btn-success" id="btn_asignarCapas_Proyecto"><span class="icon-checkmark mr-2"></span>Guardar</button>
    <button type="Reset" class="btn btn-secondary" onclick="limpiarFormulario()">Limpiar</button>
  </div>
</div>
<script>
  //$(document).ready(ajax_ver_capas());
  //window.onload = ajax_asignar_capas();

  function ajax_asignar_capas() {
    console.log('Dentro de AJAX ver asignarcion de usuarios y capas');

    $.ajax({
      url: 'php_asignar_capas_proyectos.php',
      beforeSend: function() {
        document.getElementById("listAsignarCapa").innerHTML = "<option selected value=''>Cargando...</option>";
      },
      success: function(res) {
        seccionVer = document.getElementById("listAsignarCapa");
        seccionVer.innerHTML = res;
      },
      error: function() {
        alert("Error con el servidor");
      }
    });

    $.ajax({
      url: 'php_ver_capa_proyectos.php',
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
  }

  //funcion para el buscador
  $(document).ready(function() {
    $("#buscadorAsignarCapas").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#cuerpoTablaAsignacionProyecto tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    actualizarProyectosCapas();
  });
  //fin funcion buscador


  //funcion limpiar el formulario
  function limpiarFormulario() {
    listAsignarCapa
    document.getElementById("formAsignarCapas").reset();
    document.getElementById("formAsignarTodasCapas").reset();
    document.getElementById("formAsignarCapa").reset();
  }

  //funnciones para habilitar y deshabilitar checkbox
  $("#chk_vistaTotalAsignada").click(function() {
    $("input[type=checkbox][name='inputAsignarProyectos[]']").prop("checked", $(this).prop("checked"));

    $("input[type=checkbox][name='inputAsignarProyectos[]']").click(function() {
      if (!$(this).prop("checked")) {
        $("#chk_vistaTotalAsignada").prop("checked", false);
      }
    });
  });

  //Actualizar proyectos que ya tienen la capa
  function actualizarProyectosCapas() {
    $("#listAsignarCapa").change(function() {
      console.log('Select value: ' + $("#listAsignarCapa").val());
      checkProyectos();
    });
  };

  function checkProyectos() {
    let capaSelect = $("#listAsignarCapa").val();
    $.ajax({
      url: 'php_ver_capa_proyectos.php',
      type: 'POST',
      data: {
        capa: capaSelect
      },
      beforeSend: function() {
        document.getElementById("cuerpoTablaAsignacionProyecto").innerHTML = "<p>Cargando...</p>";
      },
      success: function(proyectos) {
        if (proyectos) {
          seccionVer = document.getElementById("cuerpoTablaAsignacionProyecto");
          seccionVer.innerHTML = proyectos;
        } else {
          document.getElementById("cuerpoTablaAsignacionProyecto").innerHTML = "<p>Todos los proyectos ya tienen asignada la capa " + capaSelect + " ...</p>";
        }

      },
      error: function() {
        alert("Error con el servidor");
      }
    });
  }
</script>