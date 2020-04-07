<?php
include "../conexion.php";
?>
<input type="text" class="form-control" id="buscadorUser" placeholder="Buscar capa">
<br>
<?php
if ($_SESSION['rol_rol_d'] == 'true') {
?>
  <div>
    <button type="button" class="btn btn-light botonEliminarCapas mb-2" onclick="eliminarPrivilegio()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar privilegios/roles(s)</strong></button>
  </div>
<?php

}
?>
<div class="table-responsive">
  <form id="formid_privilegios">
    <table class="table table-condensed">
      <thead class="thead-dark">
        <tr>

          <th scope="col" style="width:5%;">#</th>
          <?php
          if ($_SESSION['rol_rol_u'] == 'true') {
          ?>
            <th scope="col" style="width:5%;"></th>
          <?php
          }
          ?>
          <th scope="col" style="width:15%;">Privilegio / Rol</th>
          <th scope="col" style="width:75%;"></th>
        </tr>
      </thead>
      <tbody id="cuerpoTablaPrivilegio">
      </tbody>
    </table>
  </form>
</div>
<?php
if ($_SESSION['rol_rol_d'] == 'true') {
?>
  <div>
    <button type="button" class="btn btn-light botonEliminarCapas" onclick="eliminarPrivilegio()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar privilegios/roles(s)</strong></button>
  </div>
<?php
}
?>
<script>
  //$(document).ready(ajax_ver_usuarios());
  window.onload = ajax_ver_privilegios();
  ajax_ver_privilegios();

  function ajax_ver_privilegios() {
    console.log('Dentro de AJAX ver Usuarios');
    $.ajax({
      url: 'php_ver_privilegio.php',

      success: function(res) {
        seccionVerPrivilegio = document.getElementById("cuerpoTablaPrivilegio");
        seccionVerPrivilegio.innerHTML = res;
      },
      error: function() {
        alert("Error con el servidor");
      }
    });
  }

  function ajax_ver_privilegios() {
    console.log('Dentro de AJAX ver Privilegios');
    $.ajax({
      url: 'php_ver_privilegio.php',

      success: function(res) {
        seccionVerPrivilegio = document.getElementById("cuerpoTablaPrivilegio");
        seccionVerPrivilegio.innerHTML = res;
      },
      error: function() {
        alert("Error con el servidor");
      }
    });
  }


  //click boton EDITAR
</script>