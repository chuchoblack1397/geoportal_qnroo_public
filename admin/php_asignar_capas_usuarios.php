<?php
session_start();
include "../conexion.php";
        $consultaCapasAsignarUsuario = "SELECT usuario, nombreusuario, apellidopaternousuario, apellidomaternousuario  FROM usuarios ORDER BY usuario ASC";//consulta general
        $resultadoCapasAsignarUsuario = pg_query($conexion,$consultaCapasAsignarUsuario);

        $i = 1;
        while ($filaCapaAsignarUsuario = pg_fetch_assoc($resultadoCapasAsignarUsuario))
        {//obteniendo capas de BD
        ?>
        <tr>
        <th scope="row">
                <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="asignar_<?php echo $filaCapaAsignarUsuario['usuario'];?>" name="inputAsignarUsuarios[]" value="<?php echo $filaCapaAsignarUsuario['usuario'];?>">
                <label class="custom-control-label" for="asignar_<?php echo $filaCapaAsignarUsuario['usuario'];?>"><?php echo $i;?></label>
                </div>
        </th>
        <td><?php echo $filaCapaAsignarUsuario['usuario'];?></td>
        <td><?php echo $filaCapaAsignarUsuario['nombreusuario'].' '.$filaCapaAsignarUsuario['apellidopaternousuario'].' '.$filaCapaAsignarUsuario['apellidomaternousuario'];?></td>
        </tr>

        <?php
        $i=$i+1;
        }//fin while
        ?>


