
<input type="text" class="form-control" id="buscadorUser" placeholder="Buscar capa">
<br>
<?php
 if($_SESSION['rol_usuario_d'] =='true' ){
   ?>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas mb-2" onclick="eliminarUsuario()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar usuario(s)</strong></button>
</div>
<?php
 }
 ?>
<div class="table-responsive">
<form id="formid_users">
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <?php
       if($_SESSION['rol_usuario_d'] =='true' ){
       ?>
       
      <th scope="col"></th>
      <?php
       }
      ?>
      <th scope="col">Usuario</th>
      <th scope="col">Nombre(s)</th>
      <th scope="col">Apellido Paterno</th>
      <th scope="col">Apellido Materno</th>
      <th scope="col">Puesto</th>
      <th scope="col">Privilegio/Rol</th>
    </tr>
  </thead>
  <tbody id="cuerpoTablaUser">
  </tbody>
</table>
</form>
</div>
<?php
 if($_SESSION['rol_usuario_d'] =='true' ){
   ?>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas"  onclick="eliminarUsuario()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar usuario(s)</strong></button>
</div>
<?php
 }
 ?>
<script>

//$(document).ready(ajax_ver_usuarios());
window.onload = ajax_ver_usuarios();
ajax_ver_usuarios();

    function ajax_ver_usuarios(){
        console.log('Dentro de AJAX ver Usuarios');
        $.ajax({
              url:'php_ver_usuario.php',
              
              success: function(res){
                seccionVerUser=document.getElementById("cuerpoTablaUser");
                seccionVerUser.innerHTML=res;
            },
            error: function(){
              alert( "Error con el servidor" );
          } 
        });
    }

    //funcion para el buscador
     $(document).ready(function(){
        $("#buscadorUser").on("keyup",function(){
          var value=$(this).val().toLowerCase();
          $("#cuerpoTablaUser tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
          });
        });
     });
     //fin funcion buscador
     
     
     //click boton EDITAR

</script>
