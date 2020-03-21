<?php

include '../conexion.php';

$cadenaCapa = $_POST['cadenaUsuario'];

$sql_eliminarUsuario = "delete from usuarios where usuario in(".$cadenaCapa.")";
$resultado_eliminarUsuario = pg_query($conexion,$sql_eliminarUsuario);

if ($resultado_eliminarUsuario) {
        echo "<script>swal('COMPLETADO!', 'Usuario(s) se han sido Eliminado con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La(s) capas(s) se han sido <strong>Eliminado</strong> con éxito', class:'success'});</script>";
        echo "<script>ajax_ver_usuarios();</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', ' al Eliminar usuario(s)', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> al Eliminar La(s) capas(s)', class:'danger'});</script>";
    }//fin else
?>