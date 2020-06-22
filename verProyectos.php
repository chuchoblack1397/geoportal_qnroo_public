<?php
session_start();
include "conexion.php";
ob_clean();

if (isset($_POST['proyecto'])) {
    if (isset($_SESSION['usuarioSession'])) {
        $proyecto = $_POST['proyecto'];
        $idUsuario = $_SESSION['usuarioSession'];

        $queryVerProyectosFromUsuario = "SELECT * FROM relacion_proyecto_usuarios WHERE usuario = '$idUsuario' and id_proyecto = '$proyecto'";
        $resultProyectosUsuario = pg_query($conexion, $queryVerProyectosFromUsuario);

        if (pg_num_rows($resultProyectosUsuario) !== 0) {
            $queryGetCapasFromProyecto = "SELECT relacion_proyecto_capas.idcapa, capas.titulocapa, capas.urlcapa, capas.layer, capas.formato, capas.transparencia, capas.version, capas.estilo, relacion_proyecto_capas.zindex  FROM relacion_proyecto_capas LEFT JOIN capas ON relacion_proyecto_capas.idcapa = capas.idcapa WHERE id_proyecto = '$proyecto' ORDER BY relacion_proyecto_capas.zindex DESC";
            $resultGetCapasFromProyecto = pg_query($conexion, $queryGetCapasFromProyecto);
            $resultArrayCapas = pg_fetch_all($resultGetCapasFromProyecto);
            echo json_encode($resultArrayCapas);
        } else {
            echo json_encode('No se encontraron capas en este proyecto.');
        }
    }
} else {
    if (isset($_SESSION['usuarioSession'])) {
        $idUsuario = $_SESSION['usuarioSession'];

        $queryVerProyectosFromUsuario = "SELECT relacion_proyecto_usuarios.id_proyecto, proyectos.nombre_proyecto FROM relacion_proyecto_usuarios LEFT JOIN proyectos ON relacion_proyecto_usuarios.id_proyecto = proyectos.id_proyecto WHERE usuario = '$idUsuario' ORDER BY proyectos.nombre_proyecto ASC";
        $resultProyectosUsuario = pg_query($conexion, $queryVerProyectosFromUsuario);

        $resultArray = pg_fetch_all($resultProyectosUsuario);

        echo json_encode($resultArray);
    }
}
