<?php
include "../conexion.php";
echo "<script>console.log('PHP guardar privilegio');</script>";


$campo_privilegio = $_POST['campo_privilegio'];

$usuario_crear = $_POST['usuario_crear'];
$usuario_ver = $_POST['usuario_ver'];
$usuario_editar = $_POST['usuario_editar'];
$usuario_eliminar = $_POST['usuario_eliminar'];

$capas_crear = $_POST['capas_crear'];
$capas_ver = $_POST['capas_ver'];
$capas_editar = $_POST['capas_editar'];
$capas_eliminar = $_POST['capas_eliminar'];

$mapas_crear = $_POST['mapas_crear'];
$mapas_ver = $_POST['mapas_ver'];
$mapas_editar = $_POST['mapas_editar'];
$mapas_eliminar = $_POST['mapas_eliminar'];

$roles_crear = $_POST['roles_crear'];
$roles_ver = $_POST['roles_ver'];
$roles_editar = $_POST['roles_editar'];
$roles_eliminar = $_POST['roles_eliminar'];


//echo "<script>console.log('Datos recibidos: '+".$idCapa $tituloCapaOK $UrlCapaOK $capaCapaOK $estiloCapaOK $versionCapaOK $formatoCapa $transparenciaCapa.");</script>";


//consulta para existencia de Titulo
$existenciaTitulo = "SELECT * FROM cat_privilegios WHERE privilegio='$campo_privilegio'";
$resultado_existencia = pg_query($conexion,$existenciaTitulo);

if(pg_num_rows($resultado_existencia) > 0){
    //revisa si existe la clave principal Titulo
    echo "<script>swal('ATENCIÓN!', 'Ya existe ".$campo_privilegio."', 'warning');</script>";
    //echo "<script>mostrarAlertas({message: '<strong>ATENCIÓN!</strong> La capa <strong>".utf8_decode($tituloCapaOK)."</strong> ya existe. Intenta de nuevo', class:'warning'});</script>";
}//fin if
else{
    //Si no existe el titulo entonces la inserta 
    $sql_Insertar = "insert into cat_privilegios(privilegio,usuario_crear,usuario_ver,usuario_editar,usuario_eliminar,capa_crear,capa_ver,capa_editar,capa_eliminar,mapa_crear,mapa_ver,mapa_editar,mapa_eliminar,rol_crear,rol_ver,rol_editar,rol_eliminar) 
    values ('".$campo_privilegio."','".$usuario_crear."','".$usuario_ver."','".$usuario_editar."','".$usuario_eliminar."','".$capas_crear."','".$capas_ver."','".$capas_editar."','".$capas_eliminar."','".$mapas_crear."','".$mapas_ver."','".$mapas_editar."','".$mapas_eliminar."','".$roles_crear."','".$roles_ver."','".$roles_editar."','".$roles_eliminar."')";
    $resultado_Insertar = pg_query($conexion,$sql_Insertar);
    
    if ($resultado_Insertar) {
        echo "<script>swal('Excelente!', 'El privilegio ".$campo_privilegio." ha sido agregado con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La capa <strong>".$tituloCapaOK."</strong> ha sido agregada con éxito', class:'success'});</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', 'El privilegio ".$campo_privilegio." no pudo ser agregado', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> La capa <strong>".utf8_decode($tituloCapaOK)."</strong> no pudo ser agregada', class:'danger'});</script>";
    }//fin else
}//fin else




//mysqli_close($conexion);//cerrando conexion

?>