<?php
session_start();
include "../conexion.php";
        $consultaProyectoVER = "SELECT * FROM proyectos ORDER BY nombre_proyecto ASC";//consulta general
        $resultadoProyectoVER = pg_query($conexion,$consultaProyectoVER);
        
        $i=1;
    
        while ($filaProyectoVER = pg_fetch_assoc($resultadoProyectoVER))
        {//obteniendo capas de BD
          $idProyecto =  $filaProyectoVER['id_proyecto'];
?>
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $idProyecto;?>" name="inputEditarProyectos[]" value="<?php echo $idProyecto;?>">
            <label class="custom-control-label" for="<?php echo $idProyecto;?>"><?php echo $i;?></label>
          </div>
      </th>
      <?php
      if($_SESSION['rol_capa_u']=='true') {
      ?>
      <td><button data-toggle="modal" data-target="#modalEditarProyecto" id="btn_proyecto_<?php echo $idProyecto;?>" type="button" class="btn btn-light botonEditarCapas" onClick="modalProyecto('<?php echo $idProyecto;?>')"><span class="icon-pencil2 text-info"></span></button></td>
      <?php
      }
      ?>
      <td><?php echo $idProyecto;?></td>
      <td><?php echo $filaProyectoVER['nombre_proyecto'];?></td>
      <td><!--lista de usuarios asignados-->
        <ul>
        <?php
          $arregloUsuariosVista = Array();
          $consultaProyectoUsuarioLista = "select usuarios.usuario, usuarios.nombreusuario, usuarios.apellidopaternousuario, usuarios.apellidomaternousuario from relacion_proyecto_usuarios inner join usuarios on id_proyecto = '$idProyecto' and usuarios.usuario = relacion_proyecto_usuarios.usuario order by usuarios.nombreusuario asc";//consulta general
          $resultadoProyectoUsuarioLista = pg_query($conexion,$consultaProyectoUsuarioLista);

          while ($filaProyectoUsuarioLista = pg_fetch_assoc($resultadoProyectoUsuarioLista))
          {//obteniendo capas de BD
        ?>
          <li>
            <?php
              echo "[".$filaProyectoUsuarioLista['usuario']."] - ".$filaProyectoUsuarioLista['nombreusuario']." ".$filaProyectoUsuarioLista['apellidopaternousuario']." ".$filaProyectoUsuarioLista['apellidomaternousuario'];
            ?>
          </li>
        <?php
          }//fin while
        ?>
        </ul>
      </td><!--fin lista de usuarios asignados-->
      <td><!--lista de capas asignadas-->
      <ul>
        <?php
          $consultaProyectoCapaLista = "select capas.idcapa, capas.titulocapa from relacion_proyecto_capas inner join capas on id_proyecto = '$idProyecto' and capas.idcapa = relacion_proyecto_capas.idcapa order by capas.titulocapa asc";//consulta general
          $resultadoProyectoCapaLista = pg_query($conexion,$consultaProyectoCapaLista);

          while ($filaProyectoCapaLista = pg_fetch_assoc($resultadoProyectoCapaLista))
          {//obteniendo capas de BD
        ?>
          <li>
            <?php
              echo "[".$filaProyectoCapaLista['idcapa']."] - ".$filaProyectoCapaLista['titulocapa'];
            ?>
          </li>
        <?php
          }//fin while
        ?>
        </ul>
      </td><!--fin lista de capas asignadas-->

</tr>
<?php
    $i=$i+1;
    }//fin while
?>
<!-- Modal -->
<div class="modal fade" id="modalEditarProyecto" tabindex="-1" role="dialog" aria-labelledby="modalEditarProyectoTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarProyectoTitle">Editar proyecto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cuerpoModalEditarProyecto">
      </div>
        <!--LOADER-->
        <div style='display:none, width:100%' id="loader_proyectos_modal" class="mb-4">
            <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
        </div>
        <!--fin LOADER-->
      <div class="modal-footer">
        <button id="btn_cerrarModalProyecto" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btn_actualizarProyecto" type="button" class="btn btn-success" onClick="editarProyecto()"><span class="icon-checkmark"></span> Guardar</button>
      </div>
    </div>
  </div>
</div>
