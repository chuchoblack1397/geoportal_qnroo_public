<?php
//include "../conexion.php";
echo "<script>console.log('Dentro de ajax update');</script>";

$usuarioR = $_POST['usuario'];
echo "<script>console.log('".$usuarioR."');</script>";
/*$nombreUserR = $_POST['nombre'];
$apUserR = $_POST['ap'];
$amUserR = $_POST['am'];
$puestoUserR = $_POST['puesto'];
$privilegioUserR = $_POST['privilegio'];

    $consulta_update_user = "UPDATE usuarios SET nombreusuario='"$nombreUserR"', apellidopaternousuario='"$apUserR"', apellidomaternousuario='"$apUserR"', puesto='"$puestoUserR"', privilegio='"$privilegioUserR"' WHERE usuario='"$usuarioR"'";
    $resultado_update_user= pg_query($conexion,$consulta_update_user);

    if(!$resultado_update_user){
        echo "<script>swal('Error', 'No se ha realizado el update', 'error');</script>";
    }//fin if
    else{
        echo "<script>swal('Perfecto', 'se han actualizado los datos', 'success');</script>";
    }//fin else
    */
?>