<?php
include '../conexion.php';
?>
<form>
  <h3>
    Ordenar capas
  </h3>
  <div class="form-group row">
      <label for="select_proyecto_orden_capas" class="col-sm-2 col-form-label">Selecciona el Proyecto</label>
      <div class="col-sm-10">
        <select name="select_proyecto_orden_capas" id="select_proyecto_orden_capas" class="custom-select my-1 mr-sm-2" onchange="select_proyecto_ordenar()">
          
        </select>
      </div>
    </div>
   
            <span class="text-info">Ordena las capas arrastrandolas con el mouse</span><br>
            <span class="text-info"><b>Nota: Número mayor = nivel superior, número menos = nivel inferior</b></span>
            
            <br>
            <br>
            <button style="display:none;" type="button" class="btn btn-success" id="btn_guardarOrdenCapas" onclick="guardarOrdenCapas()"><span class="icon-checkmark mr-2"></span>Guardar</button>

    <div class="form-group row mt-2">
      <div id="contenidoCapas" class="container">
          <ul class="list-group" id="listaCapa_orden">
            <center><span class="text-danger"><b>Selecciona un proyecto para ver el orden de sus capas</b></span></center>
          </ul><!--fin ul capaz-->
      </div><!--fin div capaz-->
    </div> 
<!--LOADER-->
<div style='display:none; width:100%' id="loader_orden_capas" class="mb-4">
    <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
</div>
<!--fin LOADER-->                 
</form>



<script>

function cargar_lista_proyectos_ordenar(){
  $.ajax({
        url:'php_mostrar_lista_proyectos_orden.php',
        beforeSend: function(){
          document.getElementById("select_proyecto_orden_capas").innerHTML="<option>Cargando...</option>";//vaciar la tabla
        },
        success: function(res){
          $('#select_proyecto_orden_capas').html(res);
      },
      error: function(){
        alert( "Error con el servidor" );
      }//fin error
    });//fin ajax
};

  function select_proyecto_ordenar(){
  var value_select_proyecto_orden = document.getElementById('select_proyecto_orden_capas').value;
  if( value_select_proyecto_orden == "NA" || value_select_proyecto_orden == '' || value_select_proyecto_orden == null){
    document.getElementById('listaCapa_orden').innerHTML = "<center><span class='text-danger'><b>Selecciona un proyecto para ver el orden de sus capas</b></span></center>";
    $('#loader_orden_capas').hide();//ocultar LOADER
    $('#btn_guardarOrdenCapas').hide();//mostrar LOADER
  }//fin if
  else{
    var ruta = "proyecto="+value_select_proyecto_orden;
    $.ajax({
        url:'php_mostrar_lista_orden.php',
        type:'POST',
        data: ruta,
        beforeSend: function(){
          document.getElementById("listaCapa_orden").innerHTML="";//vaciar la tabla
          $('#loader_orden_capas').show();//mostrar LOADER
          $('#btn_guardarOrdenCapas').hide();//mostrar LOADER
        },
        success: function(res){
          if(res != ''){
            $('#listaCapa_orden').html(res);
            $('#loader_orden_capas').hide();//ocultar LOADER
            $('#btn_guardarOrdenCapas').show();//mostrar LOADER
            nuevoOrden = [];//esta variable esta ligada en el archivo 'listaCapaDinamica.js' sirve para reinicar el orden de capas a 0
          }//fin if
          else{
            $('#listaCapa_orden').html("<center><span class='text-danger'><b>Selecciona un proyecto para ver el orden de sus capas</b></span></center>");
            $('#btn_guardarOrdenCapas').hide();//mostrar LOADER
            $('#loader_orden_capas').hide();//ocultar LOADER
          }//fin else
          
      },
      error: function(){
        alert( "Error con el servidor" );
      }//fin error
    });//fin ajax
  }//fin else
};
</script>