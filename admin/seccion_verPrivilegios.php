
<input type="text" class="form-control" id="buscadorUser" placeholder="Buscar capa">
<br>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas mb-2" onclick="eliminarPrivilegio()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar privilegios/roles(s)</strong></button>
</div>
<div class="table-responsive">
<form id="formid_privilegios">
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width:5%;">#</th>
      <th scope="col" style="width:5%;"></th>
      <th scope="col" style="width:15%;">Privilegio / Rol</th>
      <th scope="col" style="width:75%;"></th>
    </tr>
  </thead>
  <tbody id="cuerpoTablaPrivilegio">
  </tbody>
</table>
</form>
</div>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas"  onclick="eliminarPrivilegio()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar privilegios/roles(s)</strong></button>
</div>

<script>

//$(document).ready(ajax_ver_usuarios());
window.onload = ajax_ver_privilegios();
ajax_ver_privilegios();

    function ajax_ver_privilegios(){
        console.log('Dentro de AJAX ver Privilegios');
        $.ajax({
              url:'php_ver_privilegio.php',
              
              success: function(res){
                seccionVerPrivilegio=document.getElementById("cuerpoTablaPrivilegio");
                seccionVerPrivilegio.innerHTML=res;
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
