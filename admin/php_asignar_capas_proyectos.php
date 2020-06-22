<?php
session_start();
include "../conexion.php";
$consultaCapasAsignarProyecto = "SELECT idcapa, titulocapa FROM capas"; //consulta general
$resultadoCapasAsignarProyecto = pg_query($conexion, $consultaCapasAsignarProyecto);
?>
<option selected hidden value="">Selecciona...</option>
<?php
while ($filaCapaAsignarProyecto = pg_fetch_assoc($resultadoCapasAsignarProyecto)) { //obteniendo capas de BD
?>
        <option value="<?php echo $filaCapaAsignarProyecto['idcapa']; ?>"><?php echo $filaCapaAsignarProyecto['titulocapa']; ?></option>
<?php
} //fin while
?>