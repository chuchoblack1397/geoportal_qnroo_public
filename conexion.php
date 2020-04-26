<?php

echo "<script>console.log('Dentro archivo conexion');</script>";

//$host        = "host = localhost";
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = test_opb_geoportal_qroo";
$credentials = "user = postgres password = Miguel290497*";

$conexion = pg_connect("$host $port $dbname $credentials");
if (!$conexion) {
	echo 'Conexion Fallida : ', pg_last_error();
	exit();
} else {
	echo "<script>console.log('Abriendo conexion');</script>";
}
