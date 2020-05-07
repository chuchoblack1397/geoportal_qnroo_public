<?php

echo "<script>console.log('Dentro archivo conexion');</script>";

//$host        = "host = localhost";
$host        = "host = 144.91.126.153";
$port        = "port = 5432";
$dbname      = "dbname = opb_geoportal_00";
$credentials = "user = bigsgeoadmin password = Overkill23004";

$conexion = pg_connect("$host $port $dbname $credentials");
if (!$conexion) {
    echo 'Conexion Fallida : ', pg_last_error();
    exit();
} else {
    echo "<script>console.log('Abriendo conexion');</script>";
}
