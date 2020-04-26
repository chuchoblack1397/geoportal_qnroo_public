<?php
include "../conexion.php";
echo "<script>console.log('PHP guardar capa');</script>";


$idCapa = $_POST['idCapa'];
$tituloCapaOK =  $_POST['tituloCapaOK'];
$UrlCapaOK = $_POST['UrlCapaOK'];
$capaCapaOK = $_POST['capaCapaOK'];
$estiloCapaOK = $_POST['estiloCapaOK'];
$versionCapaOK = $_POST['versionCapaOK'];
$formatoCapa = $_POST['formatoCapa'];
$transparenciaCapa = $_POST['transparenciaCapa'];
$leyendaCapa = $_POST['leyenda'];
$chkConsultaCapa = $_POST['chkConsulta'];
$campoConsultaCapa = $_POST['campoConsulta'];

//echo "<script>console.log('Datos recibidos: '+".$idCapa $tituloCapaOK $UrlCapaOK $capaCapaOK $estiloCapaOK $versionCapaOK $formatoCapa $transparenciaCapa.");</script>";

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

$tituloCapaACUTE= agregarAcentosACUTE($tituloCapaOK);//aqui manda llmar la funcion de acentos

//consulta para existencia de Titulo
$existenciaTitulo = "SELECT * FROM capas WHERE idcapa='$idCapa'";
$resultado_existencia = pg_query($conexion,$existenciaTitulo);

if(pg_num_rows($resultado_existencia) > 0){
    //revisa si existe la clave principal Titulo
    echo "<script>swal('ATENCIÓN!', 'La capa ".$tituloCapaOK." ya existe', 'warning');</script>";
    //echo "<script>mostrarAlertas({message: '<strong>ATENCIÓN!</strong> La capa <strong>".utf8_decode($tituloCapaOK)."</strong> ya existe. Intenta de nuevo', class:'warning'});</script>";
}//fin if
else{
    //Si no existe el titulo entonces la inserta 
    $sql_Insertar = "insert into capas(idcapa, titulocapa, urlcapa, layer, estilo, version, formato, transparencia, leyenda, activo_consulta, campo_consulta) values ('".$idCapa."','".$tituloCapaACUTE."','".$UrlCapaOK."','".$capaCapaOK."','".$estiloCapaOK."','".$versionCapaOK."','".$formatoCapa."','".$transparenciaCapa."','".$leyendaCapa."','".$chkConsultaCapa."','".$campoConsultaCapa."')";
    $resultado_Insertar = pg_query($conexion,$sql_Insertar);
    
    //encontrando el valor de zIndex
    $sql_minValor = "SELECT min(zindex) FROM ordencapas";
    $resultado_minValor = pg_query($conexion,$sql_minValor);

    if(!$resultado_minValor){
        echo 'Consulta de usuario Fallida';
        exit();
    }
   
    
        while ($rowMin = pg_fetch_row($resultado_minValor)) {
            if($rowMin[0]==0)
            {
                $valorMinimoZIndex=99;
            }
            else
            {
                $valorMinimoZIndex = $rowMin[0]-1;
            }
          }
   
     //encontrando el valor de zIndex
     $sql_maxValor = "SELECT max(id_orden) FROM ordencapas";
     $resultado_maxValor = pg_query($conexion,$sql_maxValor);
 
     if(!$resultado_maxValor){
         echo 'Consulta de usuario Fallida';
         exit();
     }

     while ($rowMax = pg_fetch_row($resultado_maxValor)) {
        if($rowMax[0]==0 || $rowMax[0]==null)
        {
            $valorIdOrdeCapa=1;
        }
        else
        {
            $valorIdOrdeCapa = $rowMax[0]+1;
        }
      }


            
    $sql_InsertarZIndex = "insert into ordencapas(id_orden,idcapa, zindex) values('".$valorIdOrdeCapa."','".$idCapa."','".$valorMinimoZIndex."')";
    $resultado_InsertarZIndex = pg_query($conexion,$sql_InsertarZIndex);
    
    if ($resultado_Insertar && $resultado_InsertarZIndex) {
        echo "<script>swal('Excelente!', 'La capa ".$tituloCapaOK." ha sido agregada con éxito', 'success');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>COMPLETADO!</strong> La capa <strong>".$tituloCapaOK."</strong> ha sido agregada con éxito', class:'success'});</script>";
    }//fin if
    else {
        echo "<script>swal('ERROR!', 'La capa ".$tituloCapaOK." no pudo ser agregada', 'error');</script>";
        //echo "<script>mostrarAlertas({message: '<strong>ERROR!</strong> La capa <strong>".utf8_decode($tituloCapaOK)."</strong> no pudo ser agregada', class:'danger'});</script>";
    }//fin else
}//fin else




//mysqli_close($conexion);//cerrando conexion

?>