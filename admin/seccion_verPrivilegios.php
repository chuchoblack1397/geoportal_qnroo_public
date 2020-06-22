<?php
include "../conexion.php";
?>
<input type="text" class="form-control" id="buscadorPrivilegio" placeholder="Buscar capa">
<br>
<?php
if($_SESSION['rol_rol_d']=='true'){
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
if($_SESSION['rol_rol_u']=='true'){
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
    <!--LOADER-->
    <div style='display:none, width:100%' id="loader_privilegios">
        <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
    </div>
    <!--fin LOADER-->
</form>
</div>
<?php
if($_SESSION['rol_rol_d']=='true'){
  ?>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas"  onclick="eliminarPrivilegio()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar privilegios/roles(s)</strong></button>
</div>
<?php
}
?>
<script>


    function ajax_ver_privilegios(){
        console.log('Dentro de AJAX ver Privilegios');
        $.ajax({
              url:'php_ver_privilegio.php',
              
              beforeSend: function() {
                document.getElementById("cuerpoTablaPrivilegio").innerHTML="";
                $('#loader_privilegios').show();//mostrar LOADER
              },
              success: function(res){
                seccionVerPrivilegio=document.getElementById("cuerpoTablaPrivilegio");
                seccionVerPrivilegio.innerHTML=res;
                $('#loader_privilegios').hide();//ocultar LOADER
            },
            error: function(){
              alert( "Error con el servidor" );
          } 
        });
    }

    //funcion para el buscador
    $(document).ready(function(){
        $("#buscadorPrivilegio").on("keyup",function(){
          var value=$(this).val().toLowerCase();
          $("#cuerpoTablaPrivilegio tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
          });
        });
    });
     //fin funcion buscador

     //click boton EDITAR

</script>
