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
    $nombre = ltrim($nombre);
    $nombre = rtrim($nombre);
    $unwanted_array = array(
        'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', ' ' => '_'
    );
    $id_proyecto = strtr($nombre, $unwanted_array);
    $id_proyectoOK = 'proyecto_'.$id_proyecto;
    $query_result = pg_query($conexion, "SELECT EXISTS(SELECT 1 FROM proyectos WHERE id_proyecto = '$id_proyecto')");
    $existe = pg_fetch_row($query_result);
    if ($existe[0] === 'f') {
        $query_insert = pg_query($conexion, "INSERT INTO proyectos (id_proyecto, nombre_proyecto) VALUES ('$id_proyectoOK', '$nombre')");
        $values['usuarios'] = $values['capas'] = "";
        //Asignar usuarios
        foreach ($usuarios as $key => $value) {
            $values['usuarios'] .= "('$id_proyectoOK', '$value'),";
        }
        $values['usuarios'] = substr($values['usuarios'], 0, -1); //Quitar ultima coma de String
        if ($values) {
            $query_insert_usuarios = pg_query($conexion, "INSERT INTO relacion_proyecto_usuarios (id_proyecto, usuario) VALUES " . $values['usuarios']);
        }
        //Asignar capas
        foreach ($capas as $key => $value) {
            $values['capas'] .= "('$id_proyectoOK', '$value[0]', $value[1]),";
        }
        $values['capas'] = substr($values['capas'], 0, -1); //Quitar ultima coma de String
        if ($values) {
            $query_insert_usuarios = pg_query($conexion, "INSERT INTO relacion_proyecto_capas (id_proyecto, idcapa, zindex) VALUES " . $values['capas']);
        }

        return true;
    } else {
        return false;
    }
}
