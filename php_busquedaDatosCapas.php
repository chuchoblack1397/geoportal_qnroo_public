<?php
include "conexion.php";
$variable_consulta_filtro = $_POST['variable_consulta_filtro'];
$variable_campo_filtro = $_POST['campo_filtro'];

//bigs_opb_20201q_aoi_w_4326u
if($variable_campo_filtro == '__gid'){
    $tabla_consulta = 'bigs_opb_20201q_aoi_w_4326u';
}

if($variable_campo_filtro == 'folio' || $variable_campo_filtro == 'clave_cata' || $variable_campo_filtro == 'propietari' || $variable_campo_filtro == 'nombre_col'){
    $tabla_consulta = 'opb_predios_202003_dcm_32616_u';
}


$consulta="select * from $tabla_consulta where $variable_campo_filtro='".$variable_consulta_filtro."'";
//$consulta= "SELECT * FROM propietarios WHERE idpropietario=".$idPropietario;
$datosConsulta = pg_query($conexion, $consulta);

if(!$datosConsulta){
    echo "<script> console.log('Error en la consulta del filtro php'); </script>";
    exit;
}
else{
    echo "<script> console.log('Registros encontrados'); </script>";

$hayContenido = false;

    while ($filaCampoFiltro = pg_fetch_assoc($datosConsulta))
    {//obteniendo capas de BD

        if($variable_campo_filtro == '__gid'){//if en caso de __gid

            $gid = $filaCampoFiltro['gid'];
            $__gid = $filaCampoFiltro['__gid'];
            $name = $filaCampoFiltro['name'];
            $latitud = $filaCampoFiltro['lat'];
            $longitud = $filaCampoFiltro['lon'];
            ?>
                <table class="table table-borderless table-md small">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col" colspan="3">#<?php echo $gid.' - '.$__gid; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Name:</th>
                            <td class="col-9"><?php echo $name;?></td>
                            <td rowspan="2" style="vertical-align : middle;text-align:center;" class="col-1"><button onclick="buscarUbicacionFiltro('<?php echo $latitud;?>','<?php echo $longitud;?>','<?php echo $__gid;?>','','<?php echo $variable_campo_filtro;?>','<?php echo $tabla_consulta;?>')" type="button" class="btn btn-link small text-danger"><span class="icon-location small"></span>Ver</button></td>
                        </tr>
                        <tr>
                            <th scope="row">Lat/Lon:</th>
                            <td><?php echo $latitud. ' | '.$longitud; ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            <?php
        }//fin if __gid

        if($variable_campo_filtro == 'folio' || $variable_campo_filtro == 'clave_cata' || $variable_campo_filtro == 'propietari' || $variable_campo_filtro == 'nombre_col'){//if en caso de folio

            $gid = $filaCampoFiltro['gid'];
            $folio = $filaCampoFiltro['folio'];
            $clave_cata = $filaCampoFiltro['clave_cata'];
            $clave_loca = $filaCampoFiltro['clave_loca'];
            $nombre_loc = $filaCampoFiltro['nombre_loc'];
            $numero_man = $filaCampoFiltro['numero_man'];
            $numero_lot = $filaCampoFiltro['numero_lot'];
            $direccion = $filaCampoFiltro['direccion'];
            $nombre_col = $filaCampoFiltro['nombre_col'];
            $codigo_pos = $filaCampoFiltro['codigo_pos'];
            $superficie = $filaCampoFiltro['superficie'];
            $propietari = $filaCampoFiltro['propietari'];
            $razon_soci = $filaCampoFiltro['razon_soci'];
            $uso_predio = $filaCampoFiltro['uso_predio'];

            $consultaCoordenadas="select ST_AsText(ST_Centroid(geom)) as puntito from ".$tabla_consulta." where folio ='".$folio."'";// linea de consulta a postgress

        $resultCoordenadas = pg_query($conexion, $consultaCoordenadas);//ejecuta la consulta de postgress
            if (!$resultCoordenadas) {//evalua si exite un error en la consulta
            echo "Ocurrió un error.\n";
            exit;
            }//fin if
            else
            {
                echo "<script>console.log('CONSULTA - Recibida');</script>";
            
                while ($filaPos = pg_fetch_row($resultCoordenadas)) {//busca el resultado obtenido de la consulta
                    $centroide = $filaPos [0];//muestra en pantalla el resultado
                }//fin while
            }//fin else

            //---SECCION PARA TRANSFORMAR COORDENADAS DE UTM A GEOM 
            $consultaCoordeandasOK = "WITH coordesp AS (select st_geomfromtext('$centroide',32616) geom32616) SELECT ST_asText(ST_transform(geom32616,4326)) txtgeom4326 FROM coordesp";
            $resultCoordenadasOK = pg_query($conexion, $consultaCoordeandasOK);//ejecuta la consulta de postgress

            if (!$resultCoordenadasOK) {//evalua si exite un error en la consulta
                echo "Ocurrió un error.\n";
                exit;
                }//fin if
                else
                {
                    echo "<script>console.log('CONSULTA Transform - Recibida');</script>";
                
                    while ($filaPosOK = pg_fetch_row($resultCoordenadasOK)) {//busca el resultado obtenido de la consulta
                        $centroideOK = $filaPosOK [0];//muestra en pantalla el resultado
                    }//fin while

                    echo "<script>console.log('$centroideOK');</script>";
                    
                }//fin else
            //---FIN SECCION PARA TRANSFORMAR COORDENADAS DE UTM A GEOM 
            ?>
                <table class="table table-borderless table-md small">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col" colspan="3">Folio: <?php echo $folio.' - GID: '.$gid; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if($propietari != ''){ ?>
                            <th scope="row">Propietario:</th>
                            <td class="col-9"><?php  echo $propietari;?></td>
                            <?php
                            }//fin if
                            else{
                                if($razon_soci != ''){
                                    ?>
                                    <th scope="row">Razón Social:</th>
                                    <td class="col-9"><?php  echo $razon_soci;?></td>
                                    <?php
                                }//fin if
                                else{
                                    ?>
                                    <th scope="row">Propietario:</th>
                                    <td class="col-9"><?php  echo 'Desconocido';?></td>
                                    <?php
                                }
                            }//fin else
                            ?>
                            <td  rowspan="5" style="vertical-align : middle;text-align:center;" class="col-1"><button onclick="buscarUbicacionFiltro('','','<?php echo $folio;?>','<?php echo $centroideOK;?>','folio','<?php echo $tabla_consulta;?>')" type="button" class="btn btn-link small text-danger"><span class="icon-location small"></span>Ver</button></td>
                        </tr>
                        <tr>
                            <th scope="row">Dirección:</th>
                            <td><?php echo $nombre_col.', '.$direccion.' Lt: '.$numero_lot.' Man: '. $numero_man.' Localidad:'. $nombre_loc.' CP: '.$codigo_pos; ?></td>
                        </tr>
                        
                        <tr>
                            <th scope="row">Clave Catastral:</th>
                            <td><?php echo $clave_cata; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Superficie:</th>
                            <td><?php echo $superficie ?> m<sup>2</sup></td>
                        </tr>
                        <tr>
                            <th scope="row">Uso de predio:</th>
                            <td><?php echo $uso_predio; ?></td>
                        </tr>
                        
                    </tbody>
                </table>
            <?php
        }//fin if folio

        $hayContenido = true;//exitencia de registros
    }//fin while

    //evaluacion de existencia de registros
    if($hayContenido == false){
        echo "No hay registros";
    }//fin if

}//fin else
?>