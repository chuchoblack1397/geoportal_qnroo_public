<?php
include "../conexion.php";
?>
<h3 class="mb-3">Lista de proyectos</h3>
<div class="form-group row">
  <label class="mx-3 col-form-label icon-search" for="buscadorProyectos"></label>
  <input type="text" class="col-sm-11 form-control" id="buscadorProyectos" placeholder="Buscar nombre del proyecto">
</div>
<?php
if ($_SESSION['rol_mapa_d'] == 'true') {
?>
<?php
}
?>
<div class="table-responsive">
  <form id="formid">
    <table class="table table-condensed table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <?php
          if ($_SESSION['rol_mapa_u'] == 'true') {
          ?>
            <th scope="col"></th>
          <?php
          }
          ?>
        </tr>
      </thead>
      <tbody id="cuerpoTablaVerProyectos">
      </tbody>
    </table>
  </form>
</div>
<!-- <?php
      if ($_SESSION['rol_mapa_d'] == 'true') {
      ?>
  <div>
    <button type="button" class="btn btn-light botonEliminarCapas" onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar</strong></button>
  </div>
<?php
      }
?> -->
<script>
  // //$(document).ready(ajax_ver_capas());
  // window.onload = ajax_ver_capas();
  // ajax_ver_capas();

  // function ajax_ver_capas() {
  //   console.log('Dentro de AJAX ver capas');
  //   $.ajax({
  //     url: 'php_ver_capas.php',

  //     success: function(res) {
  //       seccionVer = document.getElementById("cuerpoTablaVerProyectos");
  //       seccionVer.innerHTML = res;
  //     },
  //     error: function() {
  //       alert("Error con el servidor");
  //     }
  //   });
  // }

  // //funcion para el buscador
  // $(document).ready(function() {
  //   $("#buscadorCapas").on("keyup", function() {
  //     var value = $(this).val().toLowerCase();
  //     $("#cuerpoTabla tr").filter(function() {
  //       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  //     });
  //   });
  // });
  //fin funcion buscador


  //click boton EDITAR
</script>