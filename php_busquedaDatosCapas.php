<?php
include "conexion.php";
$variable_consulta_filtro = $_POST['variable_consulta_filtro'];
/*
$consulta="select * from opb_predios_202003_dcm_32616_u where folio='".$variable_consulta_filtro."'";
//$consulta= "SELECT * FROM propietarios WHERE idpropietario=".$idPropietario;
$datosConsulta = pg_query($conexion, $consulta);

if(!$datosConsulta){
    echo "<script> console.log('Error en la consulta del filtro php'); </script>";
    exit;
}
else{
    echo "<script> console.log('OK OK OK php'); </script>";
}
*/

?>
<table class="table table-borderless table-md small">
    <thead class="thead-dark">
        <tr>
        <th scope="col" colspan="3">#1521 - Imagencita tatatan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Dir:</th>
            <td class="col-9">Calle fulana No.1</td>
            <td rowspan="2" style="vertical-align : middle;text-align:center;" class="col-1"><button onclick="buscarUbicacionFiltro('18.537008055555557','-88.285151388888892','3550')" type="button" class="btn btn-link small text-danger"><span class="icon-location small"></span>Ver</button></td>
        </tr>
        <tr>
            <th scope="row">Lat/Lon:</th>
            <td>12.5515 | -102.1554</td>
        </tr>
    </tbody>
</table>
<hr>
<table class="table table-borderless table-md small">
    <thead class="thead-dark">
        <tr>
        <th scope="col" colspan="3">#5145 - registro chunchun</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Dir:</th>
            <td class="col-9">Col. perengana No.17</td>
            <td rowspan="2" style="vertical-align : middle;text-align:center;" class="col-1"><button onclick="buscarUbicacionFiltro('18.522911388888890','-88.308823055555550','1804')" type="button" class="btn btn-link small text-danger"><span class="icon-location small"></span>Ver</button></td>
        </tr>
        <tr>
            <th scope="row">Lat/Lon:</th>
            <td>12.7415 | -102.5454</td>
        </tr>
    </tbody>
</table>
<hr>