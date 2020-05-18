<?php
// En versiones de PHP anteriores a la 4.1.0, debería utilizarse $HTTP_POST_FILES en lugar
// de $_FILES.

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
          
      }else{

        if($ext === 'shx') {
            //hacer lo que se tiene que hacer con el archivo
           // echo "archivo txt encontrado \n";
           $archivoDBF= $archivo;
           echo " archivo encontrado $archivoDBF aqui estaaaa el shx\n";
        }
        else{


            if($ext === 'dbf') {
                //hacer lo que se tiene que hacer con el archivo
               // echo "archivo imagen encontrado\n";
               $archivoSHX= $archivo;
               echo " archivo encontrado $archivoSHX aqui estaaaa dbf\n";
            }else{


                if($ext === 'prj') {
                    //hacer lo que se tiene que hacer con el archivo
                   // echo "archivo pdf encontrado\n";
            
                   $archivoPRJ= $archivo;
                   echo " archivo encontrado $archivoPRJ aqui estaaaa el prj\n";
                }
                else{
                    ?>
                     <script type="text/javascript">
                    parent.resultadoErrorExt();
                 </script>
                    
                    <?php
                   
                    echo "Error en extenciones";
                break;
            
 
                

                }

            }

        }

      }
     

      
   

   

    
    

  }

 
}
closedir($dir_handle);





if(isset($archivoPRJ)&& isset($archivoSHX) && isset($archivoSHP) && isset($archivoDBF)){

    
    
// Muestra el resultado completo del comando "ls", y devuelve la
// ultima linea de la salida en $ultima_linea. Almacena el valor de
// retorno del comando en $retval.
$archivoExtension=false;



$rutaArchivo='/var/tmp/uploads/'.$archivoSHP;



$queries = exec("shp2pgsql -s ".$SRID." -d -i -I $rutaArchivo $tblname",$output,$return);

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
}

    
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
