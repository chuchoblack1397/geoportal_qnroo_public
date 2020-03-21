<?php
include "../conexion.php";
        $consultaCapasVER = "SELECT capas.*, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY idcapa ASC ";//consulta general
        $resultadoCapasVER = pg_query($conexion,$consultaCapasVER);
        
        $i=1;
    
        while ($filaCapaVER = pg_fetch_assoc($resultadoCapasVER))
        {//obteniendo capas de BD
?>
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $filaCapaVER['idcapa'];?>" name="inputEditarCapas[]" value="<?php echo $filaCapaVER['idcapa'];?>">
            <label class="custom-control-label" for="<?php echo $filaCapaVER['idcapa'];?>"><?php echo $i;?></label>
          </div>
      </th>
      <td><button id="btn_<?php echo $filaCapaVER['idcapa'];?>" type="button" class="btn btn-light botonEditarCapas" onClick="editarCapa(this)"><span class="icon-pencil2 text-info"></span></button></td>
      <td><?php echo $filaCapaVER['titulocapa'];?></td>
      <td><?php echo $filaCapaVER['urlcapa'];?></td>
      <td><?php echo $filaCapaVER['layer'];?></td>
      <td><?php echo $filaCapaVER['estilo'];?></td>
      <td><?php echo $filaCapaVER['version'];?></td>
      <td><?php echo $filaCapaVER['formato'];?></td>
      <td><?php echo $filaCapaVER['transparencia'];?></td>
      <td><?php echo $filaCapaVER['zindex'];?></td>
</tr>
<?php
    $i=$i+1;
    }//fin while
?>

