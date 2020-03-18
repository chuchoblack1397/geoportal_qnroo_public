<?php
include '../conexion.php';
?>
<div id="contenidoCapas" class="panel">
          <ul class="list-group" id="listaCapa">
              <?php 
                $consultaCapas = "SELECT capas.idcapa, capas.titulocapa, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY ordencapas.zindex DESC ";//consulta general
                $resultadoCapas = pg_query($conexion,$consultaCapas);

                while ($filaCapa = pg_fetch_assoc($resultadoCapas))
                	   {//obteniendo capas de BD
                	     ?>
					        <li id="<?php echo $filaCapa['idcapa'];?>" class="list-group-item d-flex justify-content-between align-items-center">
                              <?php echo $filaCapa['titulocapa'];?>
                            </li>
					       <?php
					    }//fin while
              ?>
          </ul><!--fin ul capaz-->
</div><!--fin div capaz-->