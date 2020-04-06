<?php

include '../conexion.php';

$cadenaPrivilegio = $_POST['cadenaPrivilegio'];

$sql_eliminarPrivilegio = "delete from cat_privilegios where privilegio in(".$cadenaPrivilegio.")";
$resultado_eliminarProvolegio = pg_query($conexion,$sql_eliminarPrivilegio);

if ($resultado_eliminarProvolegio) {
        echo "<script>swal('COMPLETADO!', 'Privilegio(s) se han sido Eliminado con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La(s) capas(s) se han sido <strong>Eliminado</strong> con éxito', class:'success'});</script>";
        echo "<script>ajax_ver_privilegios();</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', ' al Eliminar Privilegio(s)', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> al Eliminar La(s) capas(s)', class:'danger'});</script>";
    }//fin else
?>