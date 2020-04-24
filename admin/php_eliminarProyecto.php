<?php

include '../conexion.php';

$cadenaCapa = $_POST['cadenaProyecto'];

$sql_eliminarProyecto_capas = "delete from relacion_proyecto_capas where id_proyecto in(".$cadenaCapa.")";
$resultado_eliminarProyecto_capas = pg_query($conexion,$sql_eliminarProyecto_capas);

$sql_eliminarProyecto_usuarios = "delete from relacion_proyecto_usuarios where id_proyecto in(".$cadenaCapa.")";
$resultado_eliminarProyecto_usuarios = pg_query($conexion,$sql_eliminarProyecto_usuarios);

$sql_eliminarProyecto = "delete from proyectos where id_proyecto in(".$cadenaCapa.")";
$resultado_eliminarProyecto = pg_query($conexion,$sql_eliminarProyecto);

if ($resultado_eliminarProyecto_capas && $resultado_eliminarProyecto_usuarios && $resultado_eliminarProyecto) {
        echo "<script>swal('COMPLETADO!', 'Proyecto(s) se han sido Eliminado con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La(s) capas(s) se han sido <strong>Eliminado</strong> con éxito', class:'success'});</script>";
        echo "<script>ajax_ver_proyectos();</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', ' al Eliminar proyecto(s)', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> al Eliminar La(s) capas(s)', class:'danger'});</script>";
    }//fin else
?>