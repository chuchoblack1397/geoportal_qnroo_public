<?php
    session_start();

    $usuario_session = $_SESSION['usuarioSession'];
    $tipo_busqueda = $_POST['tipo'];

    include "../conexion.php";

    if($tipo_busqueda == "usuario"){

        $consultaUsuario = "select * from usuarios where usuario = '".$usuario_session."'";//consulta general
        $resultadoUsuario = pg_query($conexion,$consultaUsuario);

        if(!$resultadoUsuario){
            echo "<script>console.log('ERROR');</script>";
            exit();
        }//fin if

        while ($filaPuesto = pg_fetch_assoc($resultadoUsuario))
            {//obteniendo capas de BD
                $usuarioR = $filaPuesto['usuario'];
                $nombreUserR = $filaPuesto['nombreusuario'];
                $apUserR = $filaPuesto['apellidopaternousuario'];
                $amUserR = $filaPuesto['apellidomaternousuario'];
                $puestoUserR = $filaPuesto['puesto'];
                $privilegioUserR = $filaPuesto['privilegio'];
                $correoUserR = $filaPuesto['correo'];
        ?>

        <div class="container">
    <div class="form-group">
            <h4 class="h-4">Usuario: <?php echo $usuarioR; ?></h4>
            <div class="form-row">
                <label for="correoUser" class="small">Correo</label>
                <input type="email" class="form-control mb-3" id="correoUser" value="<?php echo $correoUserR; ?>">
            </div>
            <div class="form-row">
                <label for="nombreUser" class="small">Nombre</label>
                <input type="text" class="form-control mb-3" id="nombreUser" value="<?php echo $nombreUserR; ?>">
            </div>
            <div class="form-row">
                <label for="apUser" class="small">Apellido Paterno</label>
                <input type="text" class="form-control mb-3" id="apUser"  value="<?php echo $apUserR; ?>">
            </div>
            <div class="form-row">
                <label for="amUser" class="small">Apellido Materno</label>
                <input type="text" class="form-control mb-3" id="amUser"  value="<?php echo $amUserR; ?>">
            </div>
            <div class="form-row">
                <label for="puestoUser" class="small">Puesto</label>
                <select name="userPuesto" id="puestoUser" class="custom-select my-1 mr-sm-2  mb-3">
                    <option value="NA">Selecciona...</option>
                    <?php
                    $consultaPuesto = "SELECT * FROM cat_puestos ORDER BY puesto ASC";//consulta general
                    $resultadoPuesto = pg_query($conexion,$consultaPuesto);

                    if(!$resultadoPuesto){
                        echo "<script>console.log('ERROR resultadoPuesto');</script>";
                        exit();
                    }

                    while ($filaPuesto = pg_fetch_assoc($resultadoPuesto))
                    {//obteniendo capas de BD
                    ?>
                    <option value="<?php echo $filaPuesto['puesto'];?>" <?php if($filaPuesto['puesto'] == $puestoUserR){?>selected<?php } ?>><?php echo $filaPuesto['puesto'];?></option>
                    <?php
                    }//fin while
                    ?>
                </select>
            </div>
            <div class="form-row">
                <label for="privilegioUser" class="small">Privilegios</label>
                <select name="userPrivilegio" id="privilegioUser" class="custom-select my-1 mr-sm-2">
                    <option value="NA" selected>Selecciona...</option>
                    <?php
                    $consultaPrivilegio = "SELECT * FROM cat_privilegios ORDER BY privilegio ASC";//consulta general
                    $resultadoPrivilegio = pg_query($conexion,$consultaPrivilegio);

                    if(!$resultadoPrivilegio){
                        echo "Error";
                        exit();
                    }

                    while ($filaPrivilegio = pg_fetch_assoc($resultadoPrivilegio))
                    {//obteniendo capas de BD
                    ?>
                    <option value="<?php echo $filaPrivilegio['privilegio'];?>" <?php if($filaPrivilegio['privilegio'] == $privilegioUserR){?>selected<?php } ?>><?php echo $filaPrivilegio['privilegio'];?></option>
                    <?php
                    }//fin while
                    ?>
                </select>
            </div>
        </div>
    </div>
<?php
        }//fin while
    }//fin if datos

    if($tipo_busqueda == "actualizar_usuario"){
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $ap = $_POST['ap'];
        $am = $_POST['am'];
        $puesto = $_POST['puesto'];
        $privilegio = $_POST['privilegio'];

        //consulta para existencia de Titulo
        $verificar_datos = "SELECT * FROM usuarios WHERE usuario='$usuario_session'";
        $resultado_existencia = pg_query($conexion,$verificar_datos);

        if(!$resultado_existencia){
            echo "<script>console.log('ERROR');</script>";
            exit();
        }//fin if

        while ($filaExistencia = pg_fetch_assoc($resultado_existencia))
            {//obteniendo capas de BD
                $correo_db = $filaExistencia['correo'];
                $nombre_db = $filaExistencia['nombreusuario'];
                $ap_db = $filaExistencia['apellidopaternousuario'];
                $am_db = $filaExistencia['apellidomaternousuario'];
                $puesto_db = $filaExistencia['puesto'];
                $privilegio_db = $filaExistencia['privilegio'];
            }//fin while

        if(($correo == $correo_db) && ($nombre == $nombre_db) && ($ap == $ap_db) && ($am == $am_db) && ($puesto == $puesto_db) && ($privilegio == $privilegio_db))
        {
            echo "no_cambios";
        }//fin if
        else
        {
            $consulta_update_user = "update usuarios set nombreusuario='".$nombre."', apellidopaternousuario='".$ap."', apellidomaternousuario='".$am."', puesto='".$puesto."', privilegio='".$privilegio."', correo='".$correo."' where usuario='".$usuario_session."'";
            $resultado_update_user= pg_query($conexion,$consulta_update_user);

            if(!$resultado_update_user){
                echo "error";
            }//fin if
            else{
                echo "ok";
            }//fin else
        }//fin else

    }//fin if actualizar_usuario

    if($tipo_busqueda == "password"){
        $passActual = $_POST['passActual'];
        $passNueva = $_POST['passNueva'];
        
        $validarPass="select pass from usuarios where usuario='".$usuario_session."'";
        $resultadoPass= pg_query($conexion,$validarPass);

        if(!$resultadoPass) {
            echo 'Consulta de password Fallida';
            exit();
        }//fin if

        if($row=pg_num_rows($resultadoPass) > 0){//comprueba si existe el usuario
            while ($UserPass = pg_fetch_assoc($resultadoPass))
            {
                $pass = $UserPass['pass'];           
            }//fin while
        }//fin if

        if (password_verify($passActual, $pass)) {
            $hash= password_hash($passNueva, PASSWORD_DEFAULT);
            $sql_actualizarPass = "update usuarios set pass ='".$hash."' where usuario='".$usuario_session."'";
            $resultado_updatePass = pg_query($conexion,$sql_actualizarPass);
            if(!$resultado_updatePass) {
                echo 'error';
                exit();
            }//fin if
            echo "ok";
        }//fin if
        else{
            echo "error_e";
        }//fin else

    }//fin if password

?>