<?php
include "../conexion.php";
?>
<input type="text" class="form-control" id="buscadorCapas" placeholder="Buscar capa">
<br>
<?php
        if($_SESSION['rol_mapa_d']=='true') {
                        ?>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas mb-2" onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar mapa(s)</strong></button>
</div>
<?php
        }
  ?>
<div class="table-responsive">
<form id="formid">
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <?php
        if($_SESSION['rol_mapa_u']=='true') {
                        ?>
      <th scope="col"></th>
             <?php
                      }
              ?>         
      <th scope="col">T&iacute;tulo</th>
      <th scope="col">URL</th>
      <th scope="col">Layer</th>
      <th scope="col">Est&iacute;lo</th>
      <th scope="col">Versi&oacute;n</th>
      <th scope="col">Transparencia</th>
      <th scope="col">Formato</th>
      <th scope="col">zindex</th>
    </tr>
  </thead>
  <tbody id="cuerpoTabla">
  </tbody>
</table>
</form>
</div>
<?php
                      if($_SESSION['rol_mapa_d']=='true') {
                        ?>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas"  onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar mapa(s)</strong></button>
</div>
<?php
                      }
?>
<script>

//$(document).ready(ajax_ver_capas());
window.onload = ajax_ver_capas();
ajax_ver_capas();

    function ajax_ver_capas(){
        console.log('Dentro de AJAX ver capas');
        $.ajax({
              url:'php_ver_capas.php',
              
              success: function(res){
                seccionVer=document.getElementById("cuerpoTabla");
                seccionVer.innerHTML=res;
            },
            error: function(){
              alert( "Error con el servidor" );
          } 
        });
    }

    //funcion para el buscador
     $(document).ready(function(){
        $("#buscadorCapas").on("keyup",function(){
          var value=$(this).val().toLowerCase();
          $("#cuerpoTabla tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
          });
        });
     });
     //fin funcion buscador
     
     
     //click boton EDITAR

</script>
