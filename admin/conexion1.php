<?php
	
	echo "<script>console.log('Dentro archivo conexion');</script>";

	//$host        = "host = localhost";144.91.126.153
	$host        = "host = 144.91.126.153";
	$port        = "port = 5432";
	$dbname      = "dbname = geoarenero_00";
	$credentials = "user = geoadmin password = Overkill23004";
 
	$conexion = pg_connect( "$host $port $dbname $credentials"  );
	if(!$conexion) {
	 echo 'Conexion Fallida : ', pg_connect_error();
	 exit();
	} else {
	   echo "<script>console.log('Abriendo conexion');</script>";
	}
 
?>