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
            $queryGetCapasFromProyecto = "SELECT relacion_proyecto_capas.idcapa, capas.titulocapa FROM relacion_proyecto_capas LEFT JOIN capas ON relacion_proyecto_capas.idcapa = capas.idcapa WHERE id_proyecto = '$proyecto' ";
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

        $queryVerProyectosFromUsuario = "SELECT id_proyecto FROM relacion_proyecto_usuarios WHERE usuario = '$idUsuario'";
        $resultProyectosUsuario = pg_query($conexion, $queryVerProyectosFromUsuario);

        $resultArray = pg_fetch_all($resultProyectosUsuario);

        echo json_encode($resultArray);
    }
}
