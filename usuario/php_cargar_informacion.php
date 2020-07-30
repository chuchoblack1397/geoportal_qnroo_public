<?php
    session_start();
    $usuario_session = $_SESSION['usuarioSession'];

    $tipo_busqueda = $_POST['tipo_busqueda'];

    include "../conexion.php";

    if($tipo_busqueda == "datos"){

        $consultaUsuarioVER = "select * from usuarios where usuario='".$usuario_session."'";//consulta general
        $resultadoUsuarioVER = pg_query($conexion,$consultaUsuarioVER);

        while ($filaUserVer = pg_fetch_assoc($resultadoUsuarioVER))
        {//obteniendo capas de BD
            $usuario=$filaUserVer['usuario'];
            $nombreUser=$filaUserVer['nombreusuario'];
            $apUser=$filaUserVer['apellidopaternousuario'];
            $amUser=$filaUserVer['apellidomaternousuario'];
            $puestoUser=$filaUserVer['puesto'];
            $privilegioUser=$filaUserVer['privilegio'];
            $correoUser=$filaUserVer['correo'];

    ?>
        <h4 class="card-title"><?php echo $nombreUser." ".$apUser." ".$amUser; ?></h4>
        <ul class="list-unstyled">
            <li title="Usuario"><p class="card-text"><span class="icon-user mr-2"></span><?php echo $usuario; ?></p></li>
            <li title="Email"><p class="card-text"><span class="icon-mail4 mr-2"></span><?php echo $correoUser; ?></p></li>
            <!--<li title="Teléfono"><p class="card-text"><span class="icon-phone mr-2"></span>+52 7445465508</p></li>-->
            <li title="Privilegio"><p class="card-text"><span class="icon-tree mr-2"></span><?php echo $privilegioUser; ?></p></li>
            <li title="Puesto"><p class="card-text"><span class="icon-user-tie mr-2"></span><?php echo $puestoUser; ?></p></li>
            <!--<li title="Fecha de alta"><p class="card-text"><small class="text-muted"><b>Fecha de alta:</b> 23/01/2020</small></p></li>
            <li title="Ultima conexión"><p class="card-text"><small class="text-muted"><b>Ultima conexión:</b> 23/01/2020</small></p></li>-->
        </ul><!--fin ul-->
    <?php
        }//fin while
    }//fin if datos

    if($tipo_busqueda == "proyectos"){

        $consultaProyecto = "select distinct proyectos.nombre_proyecto from relacion_proyecto_usuarios INNER JOIN proyectos on relacion_proyecto_usuarios.id_proyecto = proyectos.id_proyecto and usuario = '".$usuario_session."' ORDER BY proyectos.nombre_proyecto ASC";//consulta general
        $resultadoProyecto = pg_query($conexion,$consultaProyecto);

        while ($filaProyecto = pg_fetch_assoc($resultadoProyecto))
        {//obteniendo capas de BD
            $proyecto=$filaProyecto['nombre_proyecto'];
        ?>
            <li><?php echo $proyecto; ?></li>
        <?php
        }//if while

    }//fin if

    if($tipo_busqueda == "marcadores"){
        
        $consultaMarcadores = "select titulo_marcador from marcadores where usuario = '".$usuario_session."' order by titulo_marcador asc";//consulta general
        $resultadoMarcadores = pg_query($conexion,$consultaMarcadores);

        while ($filaMarcador = pg_fetch_assoc($resultadoMarcadores))
        {//obteniendo capas de BD
            $marcador=$filaMarcador['titulo_marcador'];
        ?>
            <li><?php echo $marcador; ?></li>
        <?php
        }//if while
    }//fin if

    if($tipo_busqueda == "foto"){
        $consultaFoto = "select foto_perfil from usuarios where usuario = '".$usuario_session."'";//consulta general
        $resultadoFoto = pg_query($conexion,$consultaFoto);

        while ($filaFoto = pg_fetch_assoc($resultadoFoto))
        {//obteniendo capas de BD
            $foto=$filaFoto['foto_perfil'];
            
        }//if while
        if($foto != ''){
            echo $foto;
        }else{
            echo "default.png";
        }
    }
?>