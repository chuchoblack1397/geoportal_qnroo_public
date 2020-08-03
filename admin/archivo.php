<?php
// En versiones de PHP anteriores a la 4.1.0, debería utilizarse $HTTP_POST_FILES en lugar
// de $_FILES.
include '../conexion.php';
$tblname = $_POST['capa-nombre'];
$SRID =$_POST['srid'];

//echo $tblname;
//echo $SRID;

$dir_subida = '/var/tmp/uploads';
$fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);

//echo '<pre>';
if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
    echo "El fichero es válido y se subió con éxito.\n";
} else {
    echo "¡Posible ataque de subida de ficheros!\n";
}

//echo 'Más información de depuración:';
//print_r($_FILES);

//print "</pre>";

//echo $fichero_subido;


$zip = new ZipArchive;
if ($zip->open($fichero_subido) === TRUE) {
    $zip->extractTo('/var/tmp/uploads');
    $zip->close();
    echo 'ok';
    ?>

        <script type="text/javascript">
                    parent.resultadoExtraccionCorrecta();
                 </script>
    <?php
    
    
    
} else {
    ?>

<script type="text/javascript">
                    parent.resultadoErrorExtraccion();
                 </script>
    
    <?php

    echo 'failed';
}


unlink($fichero_subido);
/*
$nombre_fichero = '/path/to/*.txt';

if (file_exists($nombre_fichero)) {
    echo "El fichero $nombre_fichero existe";
} else {
    echo "El fichero $nombre_fichero no existe";
}*/


$directorio_base = '/var/tmp/uploads';


$dir_handle = opendir($directorio_base);

while(($archivo = readdir($dir_handle)) !== false) {
  $ruta = $directorio_base . '/' . $archivo;
 // echo $ruta . PHP_EOL;
  if(is_file($ruta)) {
      $ext = pathinfo($ruta, PATHINFO_EXTENSION);

      
      if($ext === 'shp') {
          //hacer lo que se tiene que hacer con el archivo
          $archivoSHP= $archivo;
          echo " archivo encontrado $archivoSHP aqui estaaaa shp\n";
          
      }

        if($ext === 'shx') {
            //hacer lo que se tiene que hacer con el archivo
           // echo "archivo txt encontrado \n";
           $archivoDBF= $archivo;
           echo " archivo encontrado $archivoDBF aqui estaaaa el shx\n";
        }
        


            if($ext === 'dbf') {
                //hacer lo que se tiene que hacer con el archivo
               // echo "archivo imagen encontrado\n";
               $archivoSHX= $archivo;
               echo " archivo encontrado $archivoSHX aqui estaaaa dbf\n";
          }


                if($ext === 'prj') {
                    //hacer lo que se tiene que hacer con el archivo
                   // echo "archivo pdf encontrado\n";
            
                   $archivoPRJ= $archivo;
                   echo " archivo encontrado $archivoPRJ aqui estaaaa el prj\n";
                }
                
                    
            
 
                

                

            

        }

      }
     
closedir($dir_handle);
$rutaArchivo='/var/tmp/uploads/'.$archivoSHP;
echo $rutaArchivo;


if(isset($archivoPRJ)&& isset($archivoSHX) && isset($archivoSHP) && isset($archivoDBF)){

?>
    
    <script type="text/javascript">
                    parent.Existen();
                 </script>
    <?php
    
    
// Muestra el resultado completo del comando "ls", y devuelve la
// ultima linea de la salida en $ultima_linea. Almacena el valor de
//// retorno del comando en $retval.
//$archivoExtension=false;





/*$qdropgeom = "SELECT DropGeometryColumn('','$tblname','geom')";
$resDropGeom = pg_query($conexion,$qdropgeom);
if(!$resDropGeom){
  echo "error no existe geometria";
} else{
  echo "exito";
}*/

$qdroptable = "DROP TABLE IF EXISTS ".$tblname;

echo $qdroptable;
$resDropTbl = pg_query($conexion,$qdroptable);

if(!$resDropTbl){
  echo "error no existe tabla";
}else{
  echo "exito";
}





$queries = shell_exec("shp2pgsql -s ".$SRID."  -i -I $rutaArchivo $tblname");

echo $queries;








$Scapa=pg_query($conexion,$queries);



echo $Scapa;


if(!$Scapa) {

   ?>
    
    <script type="text/javascript">
                    parent.resultadoErrorCmd();
                 </script>
    <?php
   

    echo 'Consulta de usuario Fallida';
    exit();


   } else{

    ?>
    
    <script type="text/javascript">
                    parent.resultadoExitoCmd();
                 </script>
    <?php
   }

/*



if ($return != 0) {
    // error occurred

    ?>
    
    <script type="text/javascript">
                    parent.resultadoErrorCmd();
                 </script>
    <?php

    echo 'Comando error';
}else{
    // success
    ?>
    
    <script type="text/javascript">
                    parent.resultadoExitoCmd();
                 </script>
    <?php
    echo 'comando exitoso';

    pg_query()
}

 */ 
}
else{


    ?>
    
    <script type="text/javascript">
                    parent.resultadoErrorFalta();
                 </script>
    <?php
    
   
               


}

unlink('/var/tmp/uploads/'.$archivoSHP);
unlink('/var/tmp/uploads/'.$archivoSHX);
unlink('/var/tmp/uploads/'.$archivoPRJ);
unlink('/var/tmp/uploads/'.$archivoDBF);

?>
