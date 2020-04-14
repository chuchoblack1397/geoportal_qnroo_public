<?php
include "../conexion.php";
echo "<script>console.log('PHP guardar asignacion capa y usuario');</script>";

$usuario = $_POST['usuario'];
$vista_total = $_POST['vista_total'];

if($vista_total == 'false'){
    echo "<script>console.log('Vista total FALSE');</script>";
    $checksCapas = $_POST['checksCapas'];
    
        foreach ($checksCapas as $key ) {
            echo "<script>console.log('".$key."');</script>";
        }
}




/*

//consulta para existencia de Titulo
$existenciaAsignacion = "SELECT * FROM relacion_usuario_capas WHERE usuario='$usuario'";
$resultado_existenciaAsignacion = pg_query($conexion,$existenciaAsignacion);

if(pg_num_rows($resultado_existenciaAsignacion) > 0){
    //revisa si existe la clave principal Titulo
    echo "<script>swal('ATENCIÓN!', 'Este usuario ya tiene capas asignadas', 'warning');</script>";
    //echo "<script>mostrarAlertas({message: '<strong>ATENCIÓN!</strong> La capa <strong>".utf8_decode($tituloCapaOK)."</strong> ya existe. Intenta de nuevo', class:'warning'});</script>";
}//fin if
else{
    //Si no existe el titulo entonces la inserta 
    $sql_Insertar = "insert into capas(campo_consulta) values ('".$idCapa."','".$tituloCapaACUTE."')";
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
*/
?>