<?php
include "../conexion.php";
$consultaUsuarioVER = "SELECT * FROM usuarios ORDER BY usuario ASC "; //consulta general
$resultadoUsuarioVER = pg_query($conexion, $consultaUsuarioVER);

$i = 1;

while ($filaUserVer = pg_fetch_assoc($resultadoUsuarioVER)) { //obteniendo capas de BD
?>
  <tr>
    <th scope="row">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="<?php echo $filaUserVer['usuario']; ?>" name="inputEditarUsuario[]" value="<?php echo $filaUserVer['usuario']; ?>">
        <label class="custom-control-label" for="<?php echo $filaUserVer['usuario']; ?>"><?php echo $i; ?></label>
      </div>
    </th>
    <td><button id="btn_<?php echo $filaUserVer['usuario']; ?>" type="button" class="btn btn-light botonEditarCapas" onClick="editarCapa(this)"><span class="icon-pencil2 text-info"></span></button></td>
    <td><?php echo $filaUserVer['usuario']; ?></td>
    <td><?php echo $filaUserVer['nombreusuario']; ?></td>
    <td><?php echo $filaUserVer['apellidopaternousuario']; ?></td>
    <td><?php echo $filaUserVer['apellidomaternousuario']; ?></td>
    <td><?php echo $filaUserVer['puesto']; ?></td>
    <td><?php echo $filaUserVer['privilegio']; ?></td>
  </tr>
<?php
  $i = $i + 1;
} //fin while
?>