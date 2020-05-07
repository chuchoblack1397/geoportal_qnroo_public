<?php
include "conexion.php";
$variable_consulta_filtro = $_POST['variable_consulta_filtro'];
$variable_campo_filtro = $_POST['campo_filtro'];

//bigs_opb_20201q_aoi_w_4326u
if($variable_campo_filtro == '__gid'){
    $tabla_consulta = 'bigs_opb_20201q_aoi_w_4326u';
}

if($variable_campo_filtro == 'folio'){
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
            <td rowspan="2" style="vertical-align : middle;text-align:center;" class="col-1"><button onclick="buscarUbicacionFiltro('<?php echo $latitud;?>','<?php echo $longitud;?>','<?php echo $__gid;?>')" type="button" class="btn btn-link small text-danger"><span class="icon-location small"></span>Ver</button></td>
        </tr>
        <tr>
            <th scope="row">Lat/Lon:</th>
            <td><?php echo $latitud. ' | '.$longitud; ?></td>
        </tr>
    </tbody>
</table>
<hr>
<?php
    $hayContenido = true;
    }//fin while

    if($hayContenido == false){
        echo "No hay registros";
    }

}//fin else
?>