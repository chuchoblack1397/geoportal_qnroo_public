<?php
session_start();
if(isset($_SESSION['usuarioSession']) && isset($_SESSION['usuarioPrivilegio'])){//verificando si existe una session iniciada
    if($_SESSION['usuarioPrivilegio'] == "administrador"){
        
     
        include 'conexion.php';
        
        if(isset($_POST['idPunto']) && isset($_POST['path']) && isset($_POST['name']) && isset($_POST['datetime']) && isset($_POST['direction'])){
            $idPunto = $_POST['idPunto'];
            $pathPuntoOriginal = $_POST['path'];
            $namePuntoOriginal = $_POST['name'];
            $datePuntoOriginal = $_POST['datetime'];
            $dirPuntoOriginal = $_POST['direction'];

            
            
            echo "ok";//Mensaje de confirmacion OK al AJAX
        }//fin if
        else{
            //Mensaje de ERROR al AJAX
            echo "No se han recibido los datos";
        }//fin else
       
    
        
    }//fin if session
    else
        {
            header("Location: ../index.php");
        }//fin else
 }//fin if
        else
        {
            header("Location: ../index.php");
        }//fin else
?>