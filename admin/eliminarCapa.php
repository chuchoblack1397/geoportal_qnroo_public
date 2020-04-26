<?php

include '../conexion.php';

$cadenaCapa = $_POST['cadenaCapa'];

$sql_eliminarCapaIndez = "delete from ordencapas where idcapa in(".$cadenaCapa.")";
$resultado_eliminarCapaIndex = pg_query($conexion,$sql_eliminarCapaIndez);
$sql_eliminarCapa = "delete from capas where idcapa in(".$cadenaCapa.")";
$resultado_eliminarCapa = pg_query($conexion,$sql_eliminarCapa);

if ($resultado_eliminarCapa) {
        echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La(s) capas(s) se han sido <strong>Eliminado</strong> con éxito', class:'success'});</script>";
    }//fin if
    else {
        echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> al Eliminar La(s) capas(s)', class:'danger'});</script>";
    }//fin else
?>