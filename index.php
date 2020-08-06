<?php
session_start();
if (isset($_SESSION['usuarioSession'])) {
  $varSession = $_SESSION['usuarioSession'];
} //fin if
else {
  $varSession = "";
} //fin else
if ($varSession == null || $varSession = "") {
?>
  <!doctype html>
  <html lang="es">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Portal IDT Oth&oacute;n P. Blanco</title>

    <style>
      @media only screen and (max-width: 900px) {
        .contLogin {
          width: 95% !important;
        }
      }
    </style>
  </head>

  <body class="bg-light">


    <!--<div class="container my-5 py-5 px-5 contLogin" style="width:30%;">-->
    <div class="container contLogin">
    <div class="row">
      <div class="col m-5 p-4">
        <div class="container"  style="width:80%">
          <center>
              <img src="img/images.png" alt="" class="mb-4" style="width:40%">
            </center>
            <center>
              <h4>Portal geoespacial de la Infraestructura de Datos Territoriales del Municipio de Oth&oacute;n P. Blanco</h4>
            </center>
        </div>
          
            <br>
            <div class="container" style="width:80%">
            <form method="POST" action="ymagomundi.php">
              <div class="form-group" style="width:100%">
                <label for="campUsuario">Usuario:</label>
                <input type="text" class="form-control" name="campUsuario" id="campUsuario" aria-describedby="emailHelp" required>
              </div>
              <div class="form-group">
                <label for="campoContra">Contrase&ntildea:</label>
                <input type="password" class="form-control" name="campoContra" id="campoContra" required>
              </div>
              <button type="submit" class="btn btn-primary float-right">Entrar</button>
            </form>
            <br>
            <center>
              <h6 class="mt-3">Ver. 1.07.17</h6>
            </center>
            </div>
            
      </div>
      <div class="col my-5 p-4">
        <div class="card shadow">
          <h5 class="card-header">Acerca de IDT-OPB</h5>
          <div class="card-body pt-3 pb-5">
            <p class="card-text text-justify" style="text-indent: 1.5em;">
              El <b>Portal geoespacial de la Infraestructura de Datos Territoriales del 
              Catastro del Municipio de Othón P. Blanco (IDT-OPB)</b>, 
              es una herramienta colaborativa de datos geoespaciales, 
              construida con visión del territorio para gestionar datos 
              e información a través de mapas que integra imágenes aéreas de 
              muy alta definición, datos puntuales, datos estadísticos e 
              información catastral municipal, para su visualización y análisis, apoyados 
              con otras herramientas y funcionalidades, para facilitar la labor de ubicar,
              analizar y administrar diversos procesos y agilizar la comunicación interna
                y externa de la información, de una manera rápida, ágil y segura.
            </p>
            <p class="card-text text-justify" style="text-indent: 1.5em;">
              La <b>IDT-OPB</b>, fue realizada gracias al apoyo de <b>MCITI</b> en la administración
              municipal 2018-2021 del municipio de <i>Othón P. Blanco</i>, como 
              un elemento estratégico de la gestión municipal.
            </p> 
  </div>
</div>
      </div>
    </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>

  </html>
<?php
} //fin if
else {
  header("Location: ymagomundi.php");
}
?>