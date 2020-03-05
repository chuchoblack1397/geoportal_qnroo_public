<?php
// Conectando y seleccionado la base de datos  
//$cadenaConexion ="host=74.208.210.103:8990 dbname=MXCadasQUR user=geodbadmin password=Umpalumpa007 connect_timeout=15";
//$cadenaConexion ="host=74.208.210.103 port=5432 dbname=MXCadasQUR user=geodbadmin password=Umpalumpa007 connect_timeout=15";
/*$cadenaConexion ="host=74.208.210.103 port=5432 dbname=bigs_ctm_demo user=bigsgeoadmin password=4b#Jitas connect_timeout=15";
$conexionPos = pg_connect($cadenaConexion) or die("Error en la Conexion: ".pg_last_error());
echo "<script>console.log('Conexion EXITOSA');</script>";


if(pg_close($conexionPos)){
    echo "<script>console.log('Conexion cerrada');</script>";
}else{
    echo "<script>console.log('Conexion No se pudo cerrar');</script>";
}*/

/*$dbconn = pg_connect("host='74.208.210.103' port=5432 dbname='bigs_ctm_demo' user='bigsgeoadmin' password='4b#Jitas'")
    or die('No se ha podido conectar: ' . pg_last_error());
    
*/
phpinfo();
?>