<?php

include '../conexion.php';

$cadenaCapa = $_POST['cadenaCapa'];

$sql_eliminarCapaIndez = "delete from ordencapas where idCapa in(".$cadenaCapa.")";
$resultado_eliminarCapaIndex = mysqli_query($conexion,$sql_eliminarCapaIndez);
$sql_eliminarCapa = "delete from capas where idCapa in(".$cadenaCapa.")";
$resultado_eliminarCapa = mysqli_query($conexion,$sql_eliminarCapa);

if ($resultado_eliminarCapa) {
        echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La(s) capas(s) se han sido <strong>Eliminado</strong> con éxito', class:'success'});</script>";
    }//fin if
    else {
        echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> al Eliminar La(s) capas(s)', class:'danger'});</script>";
    }//fin else
?>