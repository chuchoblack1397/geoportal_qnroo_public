<?php 
include '../conexion.php';
                $consultaCapasVER = "SELECT capas.*, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY idcapa ASC ";//consulta general
                $resultadoCapasVER = pg_query($conexion,$consultaCapasVER);
                ?>
             
<input type="text" class="form-control" id="buscadorCapas" placeholder="Buscar capa">
<br>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas mb-2" onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar capa(s)</strong></button>
</div>
<div class="table-responsive">
<form id="formid">
<table class="table table-condensed">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col"></th>
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
<?php
    $i=1;
    
    while ($filaCapaVER = pg_fetch_assoc($resultadoCapasVER))
    {//obteniendo capas de BD
?>
    <tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $filaCapaVER['idcapa'];?>" name="inputEditarCapas[]" value="<?php echo $filaCapaVER['idcapa'];?>">
            <label class="custom-control-label" for="<?php echo $filaCapaVER['idcapa'];?>"><?php echo $i;?></label>
          </div>
      </th>
      <td><button id="btn_<?php echo $filaCapaVER['idcapa'];?>" type="button" class="btn btn-light botonEditarCapas" onClick="editarCapa(this)"><span class="icon-pencil2 text-info"></span></button></td>
      <td><?php echo $filaCapaVER['titulocapa'];?></td>
      <td><?php echo $filaCapaVER['urlcapa'];?></td>
      <td><?php echo $filaCapaVER['layer'];?></td>
      <td><?php echo $filaCapaVER['estilo'];?></td>
      <td><?php echo $filaCapaVER['version'];?></td>
      <td><?php echo $filaCapaVER['formato'];?></td>
      <td><?php echo $filaCapaVER['transparencia'];?></td>
      <td><?php echo $filaCapaVER['zindex'];?></td>
    </tr>
<?php
    $i=$i+1;
    }//fin while
?>
  </tbody>
</table>
</form>
</div>
<div>
    <button type="button" class="btn btn-light botonEliminarCapas"  onclick="eliminarCapa()"><span class="icon-bin text-danger mr-2"></span><strong>Eliminar capa(s)</strong></button>
</div>

<script>
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
