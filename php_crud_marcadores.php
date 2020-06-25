<?php
    include 'conexion.php';
    $titulo = $_POST['titulo'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $usuario = $_POST['usuario'];


    $existenciaMarcador = "SELECT * FROM marcadores WHERE titulo_marcador='$titulo'";
    $resultado_existencia_marcador = pg_query($conexion,$existenciaMarcador);

    if(pg_num_rows($resultado_existencia_marcador) > 0){
        //revisa si existe la clave principal Titulo
        echo "existe";
    }//fin if
    else{
        $sql_Insertar_marcador = "insert into marcadores(titulo_marcador, latitud, longitud, usuario) values ('".$titulo."',".$latitud.",".$longitud.",'".$usuario."')";
        $resultado_Insertar_marcador = pg_query($conexion,$sql_Insertar_marcador);

        if ($resultado_Insertar_marcador) {
        echo "ok";
        }//fin if
        else {
            echo "error";
        }//fin else
    }
?>