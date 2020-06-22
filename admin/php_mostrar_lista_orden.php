<?php
    include "../conexion.php";

    $proyecto = $_POST['proyecto'];
    $consultaCapas = "select * from relacion_proyecto_capas where id_proyecto =  '".$proyecto."' order by zindex DESC";//consulta general
    $resultadoCapas = pg_query($conexion,$consultaCapas);

   
    while ($filaCapa = pg_fetch_assoc($resultadoCapas))
    {//obteniendo capas de BD
    ?>
        <li id="<?php echo $filaCapa['idcapa'];?>" value ="<?php echo $filaCapa['idcapa'];?>" class="list-group-item d-flex justify-content-between align-items-center">
        <?php echo $filaCapa['idcapa'];?>
        </li>
    <?php
   
    }//fin while
  
    ?>