<?php
include "../conexion.php";
echo "<script>console.log('PHP guardar capa');</script>";

password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
$userNickname = $_POST['userNickname'];
//$userPass =  $_POST['userPass'];
$userCorreo = $_POST['userCorreo'];
$userPass =  password_hash($_POST['userPass'], PASSWORD_DEFAULT);
$userNombre = $_POST['userNombre'];
$userAPaterno = $_POST['userAPaterno'];
$userAMaterno = $_POST['userAMaterno'];
$userPrivilegio = $_POST['userPrivilegio'];
$userPuesto = $_POST['userPuesto'];

//consulta para existencia de Titulo
$existenciaTitulo = "SELECT * FROM usuarios WHERE usuario='$userNickname'";
$resultado_existencia = pg_query($conexion,$existenciaTitulo);

if(pg_num_rows($resultado_existencia) > 0){
    //revisa si existe la clave principal Titulo
    echo "<script>swal('ATENCIÓN!', 'El usuario ".$userNickname." ya existe', 'warning');</script>";
    //echo "<script>mostrarAlertas({message: '<strong>ATENCIÓN!</strong> La capa <strong>".utf8_decode($userPass)."</strong> ya existe. Intenta de nuevo', class:'warning'});</script>";
}//fin if
else{
    //Si no existe el titulo entonces la inserta 
    $sql_InsertarUsuario = "insert into usuarios(usuario, pass, nombreusuario, apellidopaternousuario, apellidomaternousuario, puesto, privilegio,correo) values ('".$userNickname."','".$userPass."','".$userNombre."','".$userAPaterno."','".$userAMaterno."','".$userPuesto."','".$userPrivilegio."','".$userCorreo."')";
    $resultado_InsertarUsuario = pg_query($conexion,$sql_InsertarUsuario);
    
    
    if ($resultado_InsertarUsuario) {
        echo "<script>swal('Excelente!', 'El usuario ".$userNickname." ha sido agregada con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La capa <strong>".$userPass."</strong> ha sido agregada con éxito', class:'success'});</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', 'El usuario ".$userNickname." no pudo ser agregada', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> La capa <strong>".utf8_decode($userPass)."</strong> no pudo ser agregada', class:'danger'});</script>";
    }//fin else
}//fin else




//mysqli_close($conexion);//cerrando conexion

?>