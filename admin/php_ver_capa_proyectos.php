<?php
session_start();
include "../conexion.php";
if (isset($_POST['capa'])) {
    $capa = $_POST['capa'];
    //consulta general
    $consultaProyectosCapas = 'SELECT * FROM proyectos WHERE "id_proyecto" NOT IN (SELECT id_proyecto FROM relacion_proyecto_capas WHERE idcapa = ' . "'$capa'" . ') ORDER BY 2 ASC';
    $result = pg_query($conexion, $consultaProyectosCapas);
    $filas = pg_num_rows($result);
    $i = 1;
    if (pg_num_rows($result) > 0) {
        while ($proyectos = pg_fetch_assoc($result)) { //obteniendo capas de BD
?>
            <tr>
                <th scope="row">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="asignar_<?php echo $proyectos['id_proyecto']; ?>" name="inputAsignarProyectos[]" value="<?php echo $proyectos['id_proyecto']; ?>">
                        <label class="custom-control-label" for="asignar_<?php echo $proyectos['id_proyecto']; ?>"><?php echo $i; ?></label>
                    </div>
                </th>
                <td><?php echo $proyectos['nombre_proyecto']; ?></td>
            </tr>
        <?php
            $i = $i + 1;
        } //fin while
    } else { ?>
        <tr>
            <th scope="row" colspan="2">
                <p>Todos los proyectos ya tienen asignada la capa seleccionada...</p>
            </th>
        </tr>
    <?php
    }
} else {
    $consultaCapasAsignar = "SELECT * FROM proyectos ORDER BY 2 ASC"; //consulta general
    $resultadoCapasAsignar = pg_query($conexion, $consultaCapasAsignar);

    $i = 1;

    while ($filaCapaAsignar = pg_fetch_assoc($resultadoCapasAsignar)) { //obteniendo capas de BD
    ?>
        <tr>
            <th scope="row">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="asignar_<?php echo $filaCapaAsignar['id_proyecto']; ?>" name="inputAsignarProyectos[]" value="<?php echo $filaCapaAsignar['id_proyecto']; ?>">
                    <label class="custom-control-label" for="asignar_<?php echo $filaCapaAsignar['id_proyecto']; ?>"><?php echo $i; ?></label>
                </div>
            </th>
            <td><?php echo $filaCapaAsignar['nombre_proyecto']; ?></td>
        </tr>
<?php
        $i = $i + 1;
    } //fin while
}
