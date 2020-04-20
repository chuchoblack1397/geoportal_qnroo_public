<?php
session_start();
include "../conexion.php";
        $consultaProyectoVER = "SELECT * FROM proyectos ORDER BY nombre_proyecto ASC";//consulta general
        $resultadoProyectoVER = pg_query($conexion,$consultaProyectoVER);
        
        $i=1;
    
        while ($filaProyectoVER = pg_fetch_assoc($resultadoProyectoVER))
        {//obteniendo capas de BD
?>
<tr>
      <th scope="row">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="<?php echo $filaProyectoVER['id_proyecto'];?>" name="inputEditarProyectos[]" value="<?php echo $filaProyectoVER['id_proyecto'];?>">
            <label class="custom-control-label" for="<?php echo $filaProyectoVER['id_proyecto'];?>"><?php echo $i;?></label>
          </div>
      </th>
      <?php
       if($_SESSION['rol_capa_u']=='true') {
                        ?>
      <td><button id="btn_<?php echo $filaProyectoVER['id_proyecto'];?>" type="button" class="btn btn-light botonEditarProyectos" onClick="editarProyecto(this)"><span class="icon-pencil2 text-info"></span></button></td>
      <?php
      }
      ?>
      <td><?php echo $filaProyectoVER['nombre_proyecto'];?></td>

</tr>
<?php
    $i=$i+1;
    }//fin while
?>

