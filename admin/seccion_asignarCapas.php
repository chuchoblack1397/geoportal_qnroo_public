<?php
include "../conexion.php";
?>
<form id="formAsignarUsuario">
  <div class="form-group row">
        <label for="listAsignarUsuario" class="col-sm-2 col-form-label">Asignar a</label>
        <div class="col-sm-10" id="contenidoUsuariosAsignar">
          <select class="custom-select" id="listAsignarUsuario">
          </select>
        </div>
    </div>
</form>

<input type="text" class="form-control" id="buscadorAsignarCapas" placeholder="Buscar capa">
<br>

<form id="formAsignarTodasCapas">
  <div class="custom-control custom-checkbox ml-1">
    <input type="checkbox" class="custom-control-input" id="chk_vistaTotalAsignada">
    <label class="custom-control-label font-weight-bold" for="chk_vistaTotalAsignada">Vista Total</label>
    <span id="info_capaCapa" class="text-info ml-2">(Tendrá acceso a ver todas las capas actuales y futuras).</span>
  </div>
</form>

<div class="table-responsive">
<div style="position: relative; height: 500px; overflow: auto; display: block;">
<form id="formAsignarCapas">
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">T&iacute;tulo</th>
      <th scope="col">Layer</th>
      <th scope="col">Formato</th>
      <th scope="col">Consulta</th>
      <th scope="col">zindex</th>
    </tr>
  </thead>
  <tbody id="cuerpoTablaAsignacion">
  </tbody>
</table>
</form>
</div>
</div>
<div class="form-group row mt-2">
  <div class="col-sm-10">
      <button type="button" class="btn btn-success" id="btn_asignarCapas_Usuario"><span class="icon-checkmark mr-2"></span>Guardar</button>
      <button type="Reset" class="btn btn-secondary" onclick="limpiarFormulario()">Limpiar</button>
    </div>
  </div>
<script>

//$(document).ready(ajax_ver_capas());
//window.onload = ajax_asignar_capas();

    function ajax_asignar_capas(){
        console.log('Dentro de AJAX ver asignarcion de usuarios y capas');

        $.ajax({
              url:'php_asignar_capas_usuarios.php',
              beforeSend:function(){
                document.getElementById("listAsignarUsuario").innerHTML="<option selected value=''>Cargando...</option>";
              },
              success: function(res){
                seccionVer=document.getElementById("listAsignarUsuario");
                seccionVer.innerHTML=res;
            },
            error: function(){
              alert( "Error con el servidor" );
          } 
        });

        $.ajax({
              url:'php_asignar_capas.php',
              beforeSend:function(){
                document.getElementById("cuerpoTablaAsignacion").innerHTML="<p>Cargando...</p>";
              },
              success: function(res){
                seccionVer=document.getElementById("cuerpoTablaAsignacion");
                seccionVer.innerHTML=res;
            },
            error: function(){
              alert( "Error con el servidor" );
          } 
        });
    }

    //funcion para el buscador
     $(document).ready(function(){
        $("#buscadorAsignarCapas").on("keyup",function(){
          var value=$(this).val().toLowerCase();
          $("#cuerpoTablaAsignacion tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
          });
        });
     });
     //fin funcion buscador
     

     //funcion limpiar el formulario
     function limpiarFormulario(){listAsignarUsuario
        document.getElementById("formAsignarCapas").reset();
        document.getElementById("formAsignarTodasCapas").reset();
        document.getElementById("formAsignarUsuario").reset();
     }

    //funnciones para habilitar y deshabilitar checkbox
    $("#chk_vistaTotalAsignada").click(function() {
    $("input[type=checkbox][name='inputAsignarCapas[]']").prop("checked", $(this).prop("checked"));

    $("input[type=checkbox][name='inputAsignarCapas[]']").click(function() {
    if (!$(this).prop("checked")) {
        $("#chk_vistaTotalAsignada").prop("checked", false);
    }
});
});
</script>
