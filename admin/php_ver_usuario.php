<?php
session_start();
include "../conexion.php";
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
          $correoUser=$filaUserVer['correo'];
  
?>
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $usuario;?>" name="inputEditarUsuario[]" value="<?php echo $usuario;?>">
            <label class="custom-control-label" for="<?php echo $usuario;?>"><?php echo $i;?></label>
          </div>
      </th>

      <?php
       if($_SESSION['rol_usuario_u'] =='true' ){
         ?>

      <td><button data-toggle="modal" data-target="#modalEditarUsuario" id="btn_user_<?php echo $usuario;?>" type="button" class="btn btn-light botonEditarCapas" onClick="modalUsuario('<?php echo $usuario;?>','<?php echo $nombreUser;?>','<?php echo $apUser;?>','<?php echo $amUser;?>','<?php echo $puestoUser;?>','<?php echo $privilegioUser;?>','<?php echo $correoUser;?>')"><span class="icon-pencil2 text-info"></span></button></td>
      <?php
       }
      ?>
      <td><?php echo $usuario;?></td>
      <td><?php echo $nombreUser;?></td>
      <td><?php echo $apUser;?></td>
      <td><?php echo $amUser;?></td>
      <td><?php echo $puestoUser;?></td>
      <td><?php echo $privilegioUser;?></td>
      <td><?php echo $correoUser;?></td>
</tr>
<?php
    $i=$i+1;
    }//fin while
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
       <!--LOADER-->
       <div style='display:none, width:100%' id="loader_usuarios_modal" class="mb-4">
            <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
        </div>
        <!--fin LOADER-->
      <div class="modal-footer">
        <button id="btn_cerrarModalUsuario" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btn_actualizarUsuario" type="button" class="btn btn-primary" onClick="editarUsuario()">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal  editar password usuario-->
<div class="modal fade" id="modal_cambiar_password" tabindex="-1" role="dialog" aria-labelledby="modal_cambiar_passwordTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cambiar_passwordTitle">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cuerpoModal_cambiar_password">
            </div>
             <!--LOADER-->
              <div style='display:none, width:100%' id="loader_pass_modal" class="mb-4">
                    <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
                </div>
                
              <!--fin LOADER-->
            <div class="modal-footer">
                <button id="btn_cerrarModalPassoword" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- fin Modal  editar password usuario-->