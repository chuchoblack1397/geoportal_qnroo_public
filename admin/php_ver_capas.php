<?php
session_start();
include "../conexion.php";
        //$consultaCapasVER = "SELECT capas.*, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY idcapa ASC ";//consulta general
        $consultaCapasVER = "SELECT capas.* FROM capas ORDER BY idcapa ASC ";//consulta general
        $resultadoCapasVER = pg_query($conexion,$consultaCapasVER);
        
        $i=1;
    
        while ($filaCapaVER = pg_fetch_assoc($resultadoCapasVER))
        {//obteniendo capas de BD
          $id_capa = $filaCapaVER['idcapa'];
          $titulocapa = $filaCapaVER['titulocapa'];
          $urlcapa = $filaCapaVER['urlcapa'];
          $layer = $filaCapaVER['layer'];
          $estilo = $filaCapaVER['estilo'];
          $version = $filaCapaVER['version'];
          $transparencia = $filaCapaVER['transparencia'];
          $formato = $filaCapaVER['formato'];
          $leyenda = $filaCapaVER['leyenda'];
          $activo_consulta = $filaCapaVER['activo_consulta'];
          $campo_consulta = $filaCapaVER['campo_consulta'];
          //$zindex = $filaCapaVER['zindex'];

?>
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $id_capa;?>" name="inputEditarCapas[]" value="<?php echo $id_capa;?>">
            <label class="custom-control-label" for="<?php echo $id_capa;?>"><?php echo $i;?></label>
          </div>
      </th>
      <?php
       if($_SESSION['rol_capa_u']=='true') {
                        ?>
      <td><button data-toggle="modal" data-target="#modalEditarCapa" id="btn_<?php echo $id_capa;?>" type="button" class="btn btn-light botonEditarCapas" onClick="editarCapa('<?php echo $id_capa;?>','<?php echo $titulocapa;?>','<?php echo $urlcapa;?>','<?php echo $layer;?>','<?php echo $estilo;?>','<?php echo $version;?>','<?php echo $transparencia;?>','<?php echo $formato;?>','<?php echo $leyenda;?>','<?php echo $activo_consulta;?>','<?php echo $campo_consulta;?>')"><span class="icon-pencil2 text-info"></span></button></td>
      <?php
      }
      ?>
      <td><?php echo $titulocapa;?></td>
      <td><?php echo $urlcapa;?></td>
      <td><?php echo $layer;?></td>
      <td><?php echo $estilo;?></td>
      <td><?php echo $version;?></td>
      <td><?php echo $transparencia;?></td>
      <td><?php echo $formato;?></td>
      <td><?php echo $leyenda;?></td>
      <td><?php echo $campo_consulta;?></td>
      <!--<td><?php //echo $zindex;?></td>-->
</tr>
<?php
    $i=$i+1;
    }//fin while
?>
<!-- Modal -->
<div class="modal fade" id="modalEditarCapa" tabindex="-1" role="dialog" aria-labelledby="modalEditarCapaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarCapaTitle">Editar Capa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cuerpoModalEditarCapa">
      </div>
       <!--LOADER-->
       <div style='display:none, width:100%' id="loader_capas_modal" class="mb-4">
            <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
        </div>
        <!--fin LOADER-->
      <div class="modal-footer">
        <button id="btn_cerrarModalCapa" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btn_actualizarCapa" type="button" class="btn btn-primary" onclick="actualizar_capa()">Actualizar</button>
      </div>
    </div>
  </div>
</div>
