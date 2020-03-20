<?php
include "../conexion.php";
<<<<<<< HEAD
$consultaUsuarioVER = "SELECT * FROM usuarios ORDER BY usuario ASC "; //consulta general
$resultadoUsuarioVER = pg_query($conexion, $consultaUsuarioVER);

$i = 1;

while ($filaUserVer = pg_fetch_assoc($resultadoUsuarioVER)) { //obteniendo capas de BD
  $usuario = $filaUserVer['usuario'];
  $nombreUser = $filaUserVer['nombreusuario'];
  $apUser = $filaUserVer['apellidopaternousuario'];
  $amUser = $filaUserVer['apellidomaternousuario'];
  $puestoUser = $filaUserVer['puesto'];
  $privilegioUser = $filaUserVer['privilegio'];
?>
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
<?php
  $i = $i + 1;
} //fin while
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
=======
        $consultaUsuarioVER = "SELECT * FROM usuarios ORDER BY usuario ASC ";//consulta general
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
?>
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $usuario;?>" name="inputEditarUsuario[]" value="<?php echo $usuario;?>">
            <label class="custom-control-label" for="<?php echo $usuario;?>"><?php echo $i;?></label>
          </div>
      </th>
      <td><button data-toggle="modal" data-target="#modalEditarUsuario" id="btn_user_<?php echo $usuario;?>" type="button" class="btn btn-light botonEditarCapas" onClick="modalUsuario('<?php echo $usuario;?>','<?php echo $nombreUser;?>','<?php echo $apUser;?>','<?php echo $amUser;?>','<?php echo $puestoUser;?>','<?php echo $privilegioUser;?>')"><span class="icon-pencil2 text-info"></span></button></td>
      <td><?php echo $usuario;?></td>
      <td><?php echo $nombreUser;?></td>
      <td><?php echo $apUser;?></td>
      <td><?php echo $amUser;?></td>
      <td><?php echo $puestoUser;?></td>
      <td><?php echo $privilegioUser;?></td>
</tr>
<?php
    $i=$i+1;
    }//fin while
?>
<<<<<<< HEAD

>>>>>>> Admin Usuario
=======
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
>>>>>>> Admin Privilegios/Roles
