<?php
    session_start();
    if(isset($_SESSION['usuarioSession'])){
      $varSession = $_SESSION['usuarioSession'];
    }//fin if
    else{
      $varSession = "";
    }//fin else
    if($varSession == null || $varSession = ""){
?>
<!doctype html>
<html lang="es">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Portal IDT Oth&oacute;n P. Blanco</title>

        <style>

    @media only screen and (max-width: 900px) {
    .contLogin{
        width:95% !important;
    }
}
</style>
  </head>
  <body>


    <div class="container my-5 bg-light py-5 px-5 contLogin" style="width:30%;">
            <center>
              <img src="img/images.png" alt="" class="mb-4" style="width:40%">
            </center>
            <center>
                <h4>Portal geoespacial de la Infraestructura de Datos Territoriales del Municipio de Oth&oacute;n P. Blanco</h4>
            </center>
            <br>
          <form method="POST" action="ymagomundi.php">
          <div class="form-group" style="width:100%">
            <label for="campUsuario">Usuario:</label>
            <input type="text" class="form-control" name="campUsuario" id="campUsuario" aria-describedby="emailHelp" required>
          </div>
          <div class="form-group">
            <label for="campoContra">Contrase&ntildea:</label>
            <input type="password" class="form-control" name="campoContra" id="campoContra" required>
          </div>
          <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <br>
        <center>
           <h6>Ver. 0.9.1255</h6>
        </center>


    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php
}//fin if
else{
    header("Location: ymagomundi.php");
}
?>
