<?php
session_start();
include "../conexion.php";
       $consultaPrivilegioVER = "SELECT * FROM cat_privilegios ORDER BY privilegio ASC ";//consulta general
        $resultadoPrivilegioVER = pg_query($conexion,$consultaPrivilegioVER);
        
        $i=1;

        $mns_sin_permisos = 'TOTALMENTE DENEGADO';
    
        while ($filaPrivilegioVer = pg_fetch_assoc($resultadoPrivilegioVER))
        {//obteniendo capas de BD
          $privilegio=$filaPrivilegioVer['privilegio'];

          $usuario_c = $filaPrivilegioVer['usuario_crear'];
          $usuario_r = $filaPrivilegioVer['usuario_ver'];
          $usuario_u = $filaPrivilegioVer['usuario_editar'];
          $usuario_d = $filaPrivilegioVer['usuario_eliminar'];

          $capa_c = $filaPrivilegioVer['capa_crear'];
          $capa_r = $filaPrivilegioVer['capa_ver'];
          $capa_u = $filaPrivilegioVer['capa_editar'];
          $capa_d = $filaPrivilegioVer['capa_eliminar'];

          $mapa_c = $filaPrivilegioVer['mapa_crear'];
          $mapa_r = $filaPrivilegioVer['mapa_ver'];
          $mapa_u = $filaPrivilegioVer['mapa_editar'];
          $mapa_d = $filaPrivilegioVer['mapa_eliminar'];

          $rol_c = $filaPrivilegioVer['rol_crear'];
          $rol_r = $filaPrivilegioVer['rol_ver'];
          $rol_u = $filaPrivilegioVer['rol_editar'];
          $rol_d = $filaPrivilegioVer['rol_eliminar'];


?>

<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="btn_edit_<?php echo $privilegio?>" name="inputEditarUsuario[]" value="<?php echo $privilegio?>">
            <label class="custom-control-label" for="btn_edit_<?php echo $privilegio?>"><?php echo $i; ?></label>
          </div>
      </th>
      <td><button data-toggle="modal" data-target="#modalEditarPrivilegios" id="y" type="button" class="btn btn-light botonEditarCapas" ><span class="icon-pencil2 text-info"></span></button></td>
      <td><?php echo $privilegio; ?></td>
      <td>
              <div class="accordion" id="acordionCaracteristicasPrivilegios">
                  <div>
                    <div id="cabezaAcordion_<?php echo $privilegio;?>">
                        <p><a href="#" class="text-info" data-toggle="collapse" data-target="#collapseOne_<?php echo $privilegio;?>" aria-expanded="true" aria-controls="collapseOne">Ver características</a></p>
                    </div>
                    <div id="collapseOne_<?php echo $privilegio;?>" class="collapse" aria-labelledby="cabezaAcordion_<?php echo $privilegio;?>" data-parent="#acordionCaracteristicasPrivilegios">
                      <div class="row">
                        
                          <div class="col">
                            <span class="font-italic">Usuarios</span>
                            <?php if( $usuario_c == 'true' || $usuario_r == 'true' || $usuario_u == 'true' || $usuario_d == 'true') 
                            {
                            ?>
                              <ul>
                                <?php if($usuario_c == 'true') {?>
                                  <li>Agregar Usuarios</li>
                                <?php }//fin if 
                                if($usuario_r == 'true') {?>
                                  <li>Ver Usuarios</li>
                                <?php }//fin if 
                                if($usuario_u == 'true') {?>
                                  <li>Editar Usuarios</li>
                                <?php }//fin if 
                                if($usuario_d == 'true') {?>
                                  <li>Eliminar Usuarios</li>
                                <?php }//fin if ?>
                              </ul>
                            <?php 
                            }//fin if
                            else{
                              ?>
                                <br><span class="text-warning"><?php echo $mns_sin_permisos; ?></span>
                              <?php
                            }//fin else
                            ?>
                          </div>
                       
                          <div class="col">
                            <span class="font-italic">Capas</span>
                            <?php 
                            if( $capa_c == 'true' || $capa_r == 'true' || $capa_u == 'true' || $capa_d == 'true') 
                            {
                            ?>
                              <ul>
                                <?php if($capa_c == 'true') {?>
                                  <li>Agregar Capas</li>
                                <?php }//fin if 
                                if($capa_r == 'true') {?>
                                  <li>Ver Capas</li>
                                <?php }//fin if 
                                if($capa_u == 'true') {?>
                                  <li>Editar Capas</li>
                                <?php }//fin if 
                                if($capa_d == 'true') {?>
                                  <li>Eliminar Capas</li>
                                <?php }//fin if ?>
                              </ul>
                            <?php 
                            }//fin if
                            else{
                              ?>
                                <br><span class="text-warning"><?php echo $mns_sin_permisos; ?></span>
                              <?php
                            }//fin else
                            ?>
                          </div>
                        
                          <div class="col">
                            <span class="font-italic">Mapas de referencia</span>
                            <?php 
                            if( $mapa_c == 'true' || $mapa_r == 'true' || $mapa_u == 'true' || $mapa_d == 'true') 
                            {
                            ?>
                              <ul>
                                <?php if($mapa_c == 'true') {?>
                                  <li>Agregar Mapas</li>
                                <?php }//fin if 
                                if($mapa_r == 'true') {?>
                                  <li>Ver Mapas</li>
                                <?php }//fin if 
                                if($mapa_u == 'true') {?>
                                  <li>Editar Mapas</li>
                                <?php }//fin if 
                                if($mapa_d == 'true') {?>
                                  <li>Eliminar Mapas</li>
                                <?php }//fin if ?>
                              </ul>
                            <?php 
                            }//fin if
                            else{
                              ?>
                                <br><span class="text-warning"><?php echo $mns_sin_permisos; ?></span>
                              <?php
                            }//fin else
                            ?>
                          </div>
                        
                          <div class="col">
                            <span class="font-italic">Roles</span>
                            <?php 
                            if( $rol_c == 'true' || $rol_r == 'true' || $rol_u == 'true' || $rol_d == 'true') 
                            {
                            ?>
                              <ul>
                                <?php if($rol_c == 'true') {?>
                                  <li>Agregar Roles</li>
                                <?php }//fin if 
                                if($rol_r == 'true') {?>
                                  <li>Ver Roles</li>
                                <?php }//fin if 
                                if($rol_u == 'true') {?>
                                  <li>Editar Roles</li>
                                <?php }//fin if 
                                if($rol_d == 'true') {?>
                                  <li>Eliminar Roles</li>
                                <?php }//fin if ?>
                              </ul>
                            <?php 
                            }//fin if
                            else{
                              ?>
                                <br><span class="text-warning"><?php echo $mns_sin_permisos; ?></span>
                              <?php
                            }//fin else
                            ?>
                          </div>
                      </div>
                    </div>
                </div>
              </div>
      </td>

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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onClick="editarUsuario()">Guardar</button>
      </div>
    </div>
  </div>
</div>