<?php
session_start();
    include 'conexion.php';

    $user = $_SESSION['usuarioSession'];

    $accion = $_POST['accion'];



if($accion=='guardar'){

    $titulo = $_POST['titulo'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $usuario = $_POST['usuario'];

    $existenciaMarcador = "SELECT * FROM marcadores WHERE titulo_marcador='$titulo'";
    $resultado_existencia_marcador = pg_query($conexion,$existenciaMarcador);

    if(pg_num_rows($resultado_existencia_marcador) > 0){
        //revisa si existe la clave principal Titulo
        echo "existe";
    }//fin if
    else{
        $sql_Insertar_marcador = "insert into marcadores(titulo_marcador, latitud, longitud, usuario) values ('".$titulo."',".$latitud.",".$longitud.",'".$usuario."')";
        $resultado_Insertar_marcador = pg_query($conexion,$sql_Insertar_marcador);

        if ($resultado_Insertar_marcador) {
        echo "ok";
        }//fin if
        else {
            echo "error";
        }//fin else
    }
}//fin if guardar

if($accion=='ver'){
    $verMarcador = "SELECT * FROM marcadores WHERE usuario='$user' ORDER BY titulo_marcador ASC";
    $resultadoMarcador = pg_query($conexion,$verMarcador);

    if(!$resultadoMarcador){
        echo "<center><span><b>No hay marcadores</b></span></center>
        
        ";
    }
    else{    
    ?>
    <div class="card">
        <div class="card-header bg-white">
            Marcadores
            <button type="button" class="close" aria-label="Close" onclick="activarInformacion('ver_coordenada')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div><!--fin card-header-->
        <div class="card-body">        
    <?php
    $i=1;
    while ($filaCampoMarcador = pg_fetch_assoc($resultadoMarcador))
    {//obteniendo capas de BD
        $titulo_marcador = $filaCampoMarcador['titulo_marcador'];
        $latitud_marcador = $filaCampoMarcador['latitud'];
        $longitud_marcador = $filaCampoMarcador['longitud'];
    ?>
            <div class="row my-2" onmouseover="this.style.background='#eeeeee';" onmouseout="this.style.background=''">
                <div class="col-9">
                    <a href="#" class="text-dark card-text" onclick="buscar_coordenada_lista('<?php echo $titulo_marcador; ?>','<?php echo $latitud_marcador; ?>','<?php echo $longitud_marcador; ?>')"> <span class="icon-location text-secondary"></span> <?php echo '<b>'.$i.'.</b> '.$titulo_marcador;?></a>
                </div>
                <div class="col-3">
                <a href="#" class="text-dark float-right" onclick="borrar_coordenada_lista('<?php echo $titulo_marcador; ?>')"> <span class="icon-bin text-danger"></span></a>
                </div>
            </div>
    <?php
    $i++;
    }//fin while
    }//fin else
    ?>
        </div><!--fin card-body-->
    </div><!--fin card-->
    <?php
}//fin if ver

if($accion=='eliminar'){
    $marcador = $_POST['marcador'];

    $borrarMarcador = "delete from marcadores where titulo_marcador='".$marcador."' and usuario='".$user."'";
    $resultadoBorrarMarcador = pg_query($conexion,$borrarMarcador);
    if(!$resultadoBorrarMarcador){
        echo "error";

    }else{
        echo "ok";
    }//fin else

}//fin if eliminar

?>