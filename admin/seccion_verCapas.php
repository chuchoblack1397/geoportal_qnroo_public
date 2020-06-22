<?php
include "../conexion.php";
?>
<input type="text" class="form-control" id="buscadorCapas" placeholder="Buscar capa">
<br>
<?php
if($_SESSION['rol_capa_d'] =='true' ){
  ?>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas mb-2" onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar capa(s)</strong></button>
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
     <?php if($_SESSION['rol_capa_u'] =='true' ){
       ?>
      <th scope="col"></th>
    <?php
     }?>
      <th scope="col">T&iacute;tulo</th>
      <th scope="col">URL</th>
      <th scope="col">Layer</th>
      <th scope="col">Est&iacute;lo</th>
      <th scope="col">Versi&oacute;n</th>
      <th scope="col">Transparencia</th>
      <th scope="col">Formato</th>
      <th scope="col">Leyenda</th>
      <th scope="col">Consulta</th>
      <!--<th scope="col">zindex</th>-->
    </tr>
  </thead>
  <tbody id="cuerpoTabla">
  </tbody>
</table>

<!--LOADER-->
<div style='display:none, width:100%' id="loader_capas">
        <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
    </div>
<!--fin LOADER-->

</form>
</div>
<?php
if($_SESSION['rol_capa_d'] =='true' ){
  ?>

<div>
    <button type="button" class="btn btn-light botonEliminarCapas"  onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar capa(s)</strong></button>
</div>
<?php
}
?>
<script>



    function ajax_ver_capas(){
        console.log('Dentro de AJAX ver capas');
        $.ajax({
              url:'php_ver_capas.php',
              beforeSend:function(){
                document.getElementById("cuerpoTabla").innerHTML="";//vaciar la tabla
                $('#loader_capas').show();//mostrar LOADER
              },
              success: function(res){
                seccionVer=document.getElementById("cuerpoTabla");
                seccionVer.innerHTML=res;
                $('#loader_capas').hide();//ocultar LOADER
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
