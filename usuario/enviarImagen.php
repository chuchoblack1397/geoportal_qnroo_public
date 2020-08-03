<?php
    session_start();
    $usuario_session = $_SESSION['usuarioSession'];

    include "../conexion.php";

    $ruta_carpeta = "imagenes/";
    $fecha = date("Ymd_His");
    $nombre_archivo =  "imagen_" . $usuario_session . "_" . $fecha . "." . pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $ruta_guardar_archivo = $ruta_carpeta . $nombre_archivo;
    
    $consulta_update_foto = "update usuarios set foto_perfil='".$nombre_archivo."' where usuario='".$usuario_session."'";
    $resultado_update_foto= pg_query($conexion,$consulta_update_foto);

    if(!$resultado_update_foto){
        echo "default.png";
    }
    else{
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $ruta_guardar_archivo)){
            echo $nombre_archivo;
        }
        else{
            echo "default.png";
        }
    }

    

?>