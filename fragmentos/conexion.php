<?php
	
	$host="localhost";
	$database="geoporta_develop"; 
	$usuario="geoporta_userDev";
	$pass="t{5-KYXKrCNv";
	
	$conexion = new mysqli($host,$usuario,$pass,$database);
	
	if(mysqli_connect_error()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	else{
		//echo "<script>console.log('Abriendo conexion');</script>";
	}
?>