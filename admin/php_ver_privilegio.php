<?php
include "../conexion.php";
/*       $consultaUsuarioVER = "SELECT * FROM usuarios ORDER BY usuario ASC ";//consulta general
        $resultadoUsuarioVER = pg_query($conexion,$consultaUsuarioVER);
        
        $i=1;
    
        while ($filaUserVer = pg_fetch_assoc($resultadoUsuarioVER))
        {//obteniendo capas de BD
          $usuario=$filaUserVer['usuario'];
          $nombreUser=$filaUserVer['nombreusuario'];
          $apUser=$filaUserVer['apellidopaternousuario'];
          $amUser=$filaUserVer['apellidomaternousuario'];
          $puestoUser=$filaUserVer['puesto'];
          $privilegioUser=$filaUserVer['privilegio'];
          */
?>
<!--
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $usuario; ?>" name="inputEditarUsuario[]" value="<?php echo $usuario; ?>">
            <label class="custom-control-label" for="<?php echo $usuario; ?>"><?php echo $i; ?></label>
          </div>
      </th>
      <td><button data-toggle="modal" data-target="#modalEditarUsuario" id="btn_user_<?php echo $usuario; ?>" type="button" class="btn btn-light botonEditarCapas" onClick="modalUsuario('<?php echo $usuario; ?>','<?php echo $nombreUser; ?>','<?php echo $apUser; ?>','<?php echo $amUser; ?>','<?php echo $puestoUser; ?>','<?php echo $privilegioUser; ?>')"><span class="icon-pencil2 text-info"></span></button></td>
      <td><?php echo $usuario; ?></td>
      <td><?php echo $nombreUser; ?></td>
      <td><?php echo $apUser; ?></td>
      <td><?php echo $amUser; ?></td>
      <td><?php echo $puestoUser; ?></td>
      <td><?php echo $privilegioUser; ?></td>
</tr>
-->

<tr>
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="x" name="inputEditarUsuario[]" value="x">
      <label class="custom-control-label" for="x">1</label>
    </div>
  </th>
  <td><button data-toggle="modal" data-target="#modalEditarUsuario" id="y" type="button" class="btn btn-light botonEditarCapas"><span class="icon-pencil2 text-info"></span></button></td>
  <td>Administrador</td>
  <td>
    <div class="accordion" id="acordionCaracteristicasPrivilegios">
      <div>
        <div id="cabezaAcordion">
          <p><a href="#" class="text-info" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Ver características</a></p>
        </div>
        <div id="collapseOne" class="collapse" aria-labelledby="cabezaAcordion" data-parent="#acordionCaracteristicasPrivilegios">
          <div class="row">
            <div class="col">
              <span class="font-italic">Usuarios</span>
              <ul>
                <li>Agregar Usuarios</li>
                <li>Ver Usuarios</li>
                <li>Editar Usuarios</li>
                <li>Eliminar Usuarios</li>
              </ul>
            </div>
            <div class="col">
              <span class="font-italic">Capas</span>
              <ul>
                <li>Agregar Capas</li>
                <li>Ver Capas</li>
                <li>Editar Capas</li>
                <li>Eliminar Capas</li>
              </ul>
            </div>
            <div class="col">
              <span class="font-italic">Mapas de referencia</span>
              <ul>
                <li>Agregar Mapas</li>
                <li>Ver Mapas</li>
                <li>Editar Mapas</li>
                <li>Eliminar Mapas</li>
              </ul>
            </div>
            <div class="col">
              <span class="font-italic">Roles</span>
              <ul>
                <li>Agregar Roles</li>
                <li>Ver Roles</li>
                <li>Editar Roles</li>
                <li>Eliminar Roles</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </td>

</tr>

<?php
/* $i=$i+1;
    }//fin while*/
?>
<!-- Modal -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEditarUsuarioTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarUsuarioTitle">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="cuerpoModalEditarUsuario">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onClick="editarUsuario()">Guardar</button>
      </div>
    </div>
  </div>
</div>