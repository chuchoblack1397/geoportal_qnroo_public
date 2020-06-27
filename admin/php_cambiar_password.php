<?php
$usuario = $_POST['usuario'];
$passNueva = $_POST['passNueva'];

include "../conexion.php";

$validarPass="select pass from usuarios where usuario='".$usuario."'";
$resultadoPass= pg_query($conexion,$validarPass);

if(!$resultadoPass) {
    echo 'error';
    exit();
}//fin if

if($row=pg_num_rows($resultadoPass) > 0){//comprueba si existe el usuario
    while ($UserPass = pg_fetch_assoc($resultadoPass))
    {
        $pass = $UserPass['pass'];           
    }//fin while
}//fin if
else{
    echo 'error';
    exit();
}

if (password_verify($passNueva, $pass)) {
    echo "repetida";
    exit();
}//fin if
else{
    $hash= password_hash($passNueva, PASSWORD_DEFAULT);
    $sql_actualizarPass = "update usuarios set pass ='".$hash."' where usuario='".$usuario."'";
    $resultado_updatePass = pg_query($conexion,$sql_actualizarPass);
    if(!$resultado_updatePass) {
        echo 'error';
        exit();
    }//fin if
    echo "ok";
}//fin else


?>