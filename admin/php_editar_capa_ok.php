<?php
include "../conexion.php";
//echo "<script>console.log('Dentro de ajax update');</script>";

$idcapa = $_POST['idcapa'];
$titulo = $_POST['titulo'];
$url = $_POST['url'];
$layer = $_POST['layer'];
$estilo = $_POST['estilo'];
$version = $_POST['version'];
$formato = $_POST['formato'];
$transp = $_POST['transp'];
$leyenda = $_POST['leyenda'];
$activa_consulta = $_POST['activa_consulta'];
$consulta = $_POST['consulta'];

//-funcion para convertir las ACENTOS 
function agregarAcentosACUTE($cadena){
    //Codificamos la cadena en formato utf8 en caso de que nos de errores

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à','Á', 'À'),
        array('&aacute;', '&aacute;', '&Aacute;', '&Aacute;'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'É', 'È',),
        array('&eacute;', '&eacute;', '&Eacute;', '&Eacute;',),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'Í', 'Ì',),
        array('&iacute;', '&iacute;', '&Iacute;', '&Iacute;',),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'Ó', 'Ò',),
        array('&oacute;', '&oacute;', '&Oacute;', '&Oacute;',),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'Ú', 'Ù',),
        array('&uacute;', '&uacute;', '&Uacute;', '&Uacute;',),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ'),
        array('&ntilde;', '&Ntilde;'),
        $cadena
    );

    return $cadena;
}
//----fin funcion agregarComasACUTE

    $titulo_ok= agregarAcentosACUTE($titulo);//aqui manda llmar la funcion de acentos

    $consulta_update_capa = "update capas set urlcapa='".$url."', layer='".$layer."', estilo='".$estilo."', version='".$version."', formato='".$formato."', transparencia='".$transp."', leyenda='".$leyenda."', titulocapa='".$titulo_ok."', activo_consulta='".$activa_consulta."', campo_consulta='".$consulta."' where idcapa='".$idcapa."'";
    $resultado_update_capa= pg_query($conexion,$consulta_update_capa);

    if(!$resultado_update_capa){
        echo "<script>swal('Error', 'No se ha realizado el update', 'error');</script>";
    }//fin if
    else{
        echo "<script>swal('Perfecto', 'se han actualizado los datos', 'success');
        </script>
        ";
    }//fin else

    
?>