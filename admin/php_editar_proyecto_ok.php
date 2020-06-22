<?php
include "../conexion.php";
ob_clean();
session_start();
$scripts = "<script>console.log('PHP guardar proyecto');</script>";
$result = new stdClass;

if (isset($_POST['data'])) {
    $proyecto = json_decode($_POST['data']);
    $scripts .= "<script>console.log('Se recibio la informacion');</script>";
    $result = new stdClass;
    $result->scripts = $scripts;
    $result->guardar = actualizarProyecto($proyecto->id_proyecto, $conexion, $proyecto->capas, $proyecto->usuarios);
    $json = json_encode($result);
    echo "$json";
} else {
    echo "<script>swal('Error', 'No se ha realizado el update', 'error');</script>";
}


function actualizarProyecto($id_proyecto, $conexion, $capas, $usuarios)
{
    
    $query_result_editar = pg_query($conexion, "SELECT EXISTS(SELECT 1 FROM proyectos WHERE id_proyecto = '$id_proyecto')");
    $existe_editar = pg_fetch_row($query_result_editar);
    if ($existe_editar[0] === 't') {

        //--esto se hace para limpiar el registro y volver a construirlo
        $query_eliminar_usuarios_proyecto = pg_query($conexion, "delete from relacion_proyecto_usuarios where id_proyecto='".$id_proyecto."'");
        $query_eliminar_capas_proyecto = pg_query($conexion, "delete from relacion_proyecto_capas where id_proyecto='".$id_proyecto."'");
        if((!$query_eliminar_usuarios_proyecto) || (!$query_eliminar_capas_proyecto)){
            //comprobando si se realizan las consultas de eliminacion
            //return false;
        }

        $values['usuarios'] = $values['capas'] = "";
        //Asignar usuarios
        foreach ($usuarios as $key => $value) {
            $values['usuarios'] .= "('$id_proyecto', '$value'),";
        }//fin foreach
        $values['usuarios'] = substr($values['usuarios'], 0, -1); //Quitar ultima coma de String
        if ($values) {
            $query_insert_usuarios = pg_query($conexion, "INSERT INTO relacion_proyecto_usuarios (id_proyecto, usuario) VALUES " . $values['usuarios']);
        }//fin if
        //Asignar capas
        foreach ($capas as $key => $value) {
            $values['capas'] .= "('$id_proyecto', '$value[0]', $value[1]),";
        }//fin foreach
        $values['capas'] = substr($values['capas'], 0, -1); //Quitar ultima coma de String
        if ($values) {
            $query_insert_usuarios = pg_query($conexion, "INSERT INTO relacion_proyecto_capas (id_proyecto, idcapa, zindex) VALUES " . $values['capas']);
        }//fin if

        return true;
    }//fin if 
    else {
        return false;
        }//fin else
}




/*
    $consulta_update_user = "update usuarios set nombreusuario='".$nombreUserR."', apellidopaternousuario='".$apUserR."', apellidomaternousuario='".$apUserR."', puesto='".$puestoUserR."', privilegio='".$privilegioUserR."', correo='".$correoUserR."' where usuario='".$usuarioR."'";
    $resultado_update_user= pg_query($conexion,$consulta_update_user);

    if(!$resultado_update_user){
        echo "<script>swal('Error', 'No se ha realizado el update', 'error');</script>";
    }//fin if
    else{
        echo "<script>swal('Perfecto', 'se han actualizado los datos', 'success');
        </script>
        ";
    }//fin else
    */
?>