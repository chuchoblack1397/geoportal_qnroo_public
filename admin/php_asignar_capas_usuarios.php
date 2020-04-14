<?php
session_start();
include "../conexion.php";
        $consultaCapasAsignarUsuario = "SELECT usuario FROM usuarios";//consulta general
        $resultadoCapasAsignarUsuario = pg_query($conexion,$consultaCapasAsignarUsuario);
?>
        <option selected value="">Selecciona...</option>
        <?php 
        while ($filaCapaAsignarUsuario = pg_fetch_assoc($resultadoCapasAsignarUsuario))
        {//obteniendo capas de BD
        ?>
        <option value="<?php echo $filaCapaAsignarUsuario['usuario'];?>"><?php echo $filaCapaAsignarUsuario['usuario'];?></option>
        <?php
        }//fin while
        ?>


