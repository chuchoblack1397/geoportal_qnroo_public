<?php

include '../conexion.php';

$cadenaCapa = $_POST['cadenaCapa'];

$sql_eliminarCapaIndez = "delete from ordencapas where idcapa in(".$cadenaCapa.")";
$resultado_eliminarCapaIndex = pg_query($conexion,$sql_eliminarCapaIndez);
$sql_eliminarCapa = "delete from capas where idcapa in(".$cadenaCapa.")";
$resultado_eliminarCapa = pg_query($conexion,$sql_eliminarCapa);

if ($resultado_eliminarCapa) {
        echo "<script>swal('COMPLETADO!', 'La(s) capas(s) se han sido Eliminado con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La(s) capas(s) se han sido <strong>Eliminado</strong> con éxito', class:'success'});</script>";
        echo "<script>ajax_ver_capas();</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', ' al Eliminar La(s) capas(s)', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> al Eliminar La(s) capas(s)', class:'danger'});</script>";
    }//fin else
?>