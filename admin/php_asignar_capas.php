<?php
session_start();
include "../conexion.php";
$consultaCapasAsignar = "SELECT capas.*, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY idcapa ASC "; //consulta general
$resultadoCapasAsignar = pg_query($conexion, $consultaCapasAsignar);

$i = 1;

while ($filaCapaAsignar = pg_fetch_assoc($resultadoCapasAsignar)) { //obteniendo capas de BD
?>
  <tr>
    <th scope="row">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="asignar_<?php echo $filaCapaAsignar['idcapa']; ?>" name="inputAsignarCapas[]" value="<?php echo $filaCapaAsignar['idcapa']; ?>">
        <label class="custom-control-label" for="asignar_<?php echo $filaCapaAsignar['idcapa']; ?>"><?php echo $i; ?></label>
      </div>
    </th>
    <td><?php echo $filaCapaAsignar['titulocapa']; ?></td>
    <td name='zindex' id="<?= $filaCapaAsignar['zindex'] ?>"><?php echo $filaCapaAsignar['zindex']; ?></td>
  </tr>
<?php
  $i = $i + 1;
} //fin while
?>