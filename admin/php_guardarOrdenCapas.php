<?php
include "../conexion.php";
ob_clean();
session_start();
$result = new stdClass;

if (isset($_POST['orden'])) {
    $ordenCapas = json_decode($_POST['orden']);
    $result->guardar = actualizarOrdenCapas($ordenCapas->proyecto, $conexion, $ordenCapas->capas);
    $json = json_encode($result);
    echo "$json";
    //echo "ok";
}//fin if isset
else{
    echo "<script>swal('Error', 'No se ha realizado el reordenamiento', 'error');</script>";
}//fin else isset

function actualizarOrdenCapas($id_proyecto, $conexion, $capas)
{
    $i=100;
    $update = false;
    foreach ($capas as $key => $value) {
        $query_insert_usuarios = pg_query($conexion, "update relacion_proyecto_capas set zindex='".$i."' where id_proyecto='".$id_proyecto."' and idcapa='".$value."'");
        $i = $i - 1;
        if($query_insert_usuarios){
            $update = true;
        }else{
            $update = false;
            break;
        }
    }//fin for
    return $update;
}//fin actualizarProyecto
?>