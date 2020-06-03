<option value="NA" selected>Selecciona...</option>
<?php
include "../conexion.php";
$consultaPuesto = "SELECT * FROM proyectos ORDER BY nombre_proyecto ASC";//consulta general
$resultadoPuesto = pg_query($conexion,$consultaPuesto);

if(!$resultadoPuesto){
    echo "<script>console.log('ERROR');</script>";
}

while ($filaPuesto = pg_fetch_assoc($resultadoPuesto))
{//obteniendo capas de BD
?>
    <option value="<?php echo $filaPuesto['id_proyecto'];?>"><?php echo $filaPuesto['nombre_proyecto'];?></option>
<?php
}//fin while
?>
