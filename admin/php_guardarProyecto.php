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
    $result->guardar = guardarProyecto($proyecto->nombre, $conexion, $proyecto->capas, $proyecto->usuarios);
    $json = json_encode($result);
    echo "$json";
} else {
    echo "<script>console.log('Ocurrio un error en el servidor');</script>";
}

function guardarProyecto($nombre, $conexion, $capas, $usuarios)
{
    $query_result = pg_query($conexion, "SELECT EXISTS(SELECT 1 FROM proyectos WHERE id_proyecto = '$nombre')");
    $existe = pg_fetch_row($query_result);
    if ($existe[0] === 'f') {
        $query_insert = pg_query($conexion, "INSERT INTO proyectos (id_proyecto, nombre_proyecto) VALUES ('$nombre', '$nombre')");
        $values['usuarios'] = $values['capas'] = "";
        //Asignar usuarios
        foreach ($usuarios as $key => $value) {
            $values['usuarios'] .= "('$nombre', '$value'),";
        }
        $values['usuarios'] = substr($values['usuarios'], 0, -1); //Quitar ultima coma de String
        if ($values) {
            $query_insert_usuarios = pg_query($conexion, "INSERT INTO relacion_proyectos_usuarios (id_proyecto, usuario) VALUES " . $values['usuarios']);
        }
        //Asignar capas
        foreach ($capas as $key => $value) {
            $values['capas'] .= "('$nombre', '$value[0]', $value[1]),";
        }
        $values['capas'] = substr($values['capas'], 0, -1); //Quitar ultima coma de String
        if ($values) {
            $query_insert_usuarios = pg_query($conexion, "INSERT INTO relacion_proyectos_capas (id_proyecto, idcapa, zindex) VALUES " . $values['capas']);
        }

        return true;
    } else {
        return false;
    }
}
