<?php
include "../conexion.php";
$idproyecto = $_POST['idproyecto'];

$sql_consulta_editar_proyecto_capas =  "SELECT idcapa FROM relacion_proyecto_capas WHERE id_proyecto='".$idproyecto."' ORDER BY idcapa ASC";
    $resultado_sql_consulta_editar_proyecto_capas = pg_query($conexion, $sql_consulta_editar_proyecto_capas);
    while ($filaCapa_editar = pg_fetch_assoc($resultado_sql_consulta_editar_proyecto_capas)) { //obteniendo capas de BD
        $arregloCapas_editar[] = $filaCapa_editar; //agregando los valores de la BD al arreglo
    } //fin while

$sql_consulta_editar_proyecto_usuarios = "SELECT usuario FROM relacion_proyecto_usuarios WHERE id_proyecto='".$idproyecto."'  ORDER BY usuario ASC";
    $resultado_sql_consulta_editar_proyecto_usuarios = pg_query($conexion, $sql_consulta_editar_proyecto_usuarios);
    while ($filaUsuario_editar = pg_fetch_assoc($resultado_sql_consulta_editar_proyecto_usuarios)) { //obteniendo capas de BD
        $arregloUsuario_editar[] = $filaUsuario_editar; //agregando los valores de la BD al arreglo
    } //fin while

?>
<div class="container">
    <div class="form-group">
            <h5 class="h5">Id: <?php echo $idproyecto; ?></h5>
            <h6 class="h6">Selecciona las capas:</h6>
                <div class="form-group row">
                    
                    <div class="col mr-1">
                        <div class="table-responsive">
                            <div style="position: relative; height: 200px; overflow: auto; display: block;">
                                <form>
                                    <table class="table table-condensed table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Título</th>
                                                <th scope="col">zindex</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $consultaCapasAsignar_editar = "SELECT capas.*, ordencapas.zindex FROM capas INNER JOIN ordencapas ON capas.idcapa = ordencapas.idcapa ORDER BY idcapa ASC "; //consulta general
                                                $resultadoCapasAsignar_editar = pg_query($conexion, $consultaCapasAsignar_editar);

                                                $i = 1;

                                                while ($filaCapaAsignar_editar = pg_fetch_assoc($resultadoCapasAsignar_editar)) { //obteniendo capas de BD
                                                ?>
                                                <tr>
                                                    <th scope="row">
                                                    <div class="custom-control custom-checkbox">
                                                    <?php
                                                    foreach ($arregloCapas_editar as $clave_capa => $campo_capa) {
                                                        if($campo_capa['idcapa'] == $filaCapaAsignar_editar['idcapa']){
                                                            ?>
                                                            <input type="checkbox" class="custom-control-input" id="asignar_editar<?php echo $filaCapaAsignar_editar['idcapa']; ?>" name="inputAsignarCapas_editar[]" value="<?php echo $filaCapaAsignar_editar['idcapa']; ?>" checked>
                                                        <?php
                                                        }//fin if
                                                        else{
                                                            ?>
                                                            <input type="checkbox" class="custom-control-input" id="asignar_editar<?php echo $filaCapaAsignar_editar['idcapa']; ?>" name="inputAsignarCapas_editar[]" value="<?php echo $filaCapaAsignar_editar['idcapa']; ?>">
                                                    <?php
                                                        }//fin else
                                                    }//fin foreach
                                                    ?>
                                                        <label class="custom-control-label" for="asignar_editar<?php echo $filaCapaAsignar_editar['idcapa']; ?>"><?php echo $i; ?></label>
                                                    </div>
                                                    </th>
                                                    <td><?php echo $filaCapaAsignar_editar['titulocapa']; ?></td>
                                                    <td name='zindex' id="<?= $filaCapaAsignar_editar['zindex'] ?>"><?php echo $filaCapaAsignar_editar['zindex']; ?></td>
                                                </tr>
                                                <?php
                                                $i = $i + 1;
                                                } //fin while
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                                </div>
                        </div><!--fin div table-responsive-->
                    </div><!--fin div col mr-1-->
                </div><!--fin div form-group row-->

                <h6 class="h6">Selecciona los usuarios:</h6>
                <div class="form-group row">
                <div class="col ml-1">
                    <div class="table-responsive">
                        <div style="position: relative; height: 200px; overflow: auto; display: block;">
                            <form>
                                <table class="table table-condensed table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nombre Usuario</th>
                                            <th scope="col">Nombre Completo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                                $consultaCapasAsignarUsuario_editar = "SELECT usuario, nombreusuario, apellidopaternousuario, apellidomaternousuario  FROM usuarios";//consulta general
                                                $resultadoCapasAsignarUsuario_editar = pg_query($conexion,$consultaCapasAsignarUsuario_editar);

                                                $i = 1;
                                                while ($filaCapaAsignarUsuario_editar = pg_fetch_assoc($resultadoCapasAsignarUsuario_editar))
                                                {//obteniendo capas de BD
                                                ?>
                                                <tr>
                                                <th scope="row">
                                                        <div class="custom-control custom-checkbox">
                                                    <?php
                                                        foreach ($arregloUsuario_editar as $clave_usuario => $campo_usuario) {
                                                            if($campo_usuario['usuario'] == $filaCapaAsignarUsuario_editar['usuario']){
                                                                ?>
                                                                <input type="checkbox" class="custom-control-input" id="asignar_editar<?php echo $filaCapaAsignarUsuario_editar['usuario'];?>" name="inputAsignarUsuarios_editar[]" value="<?php echo $filaCapaAsignarUsuario_editar['usuario'];?>" checked>
                                                            <?php
                                                            }//fin if
                                                            else{
                                                                ?>
                                                            <input type="checkbox" class="custom-control-input" id="asignar_editar<?php echo $filaCapaAsignarUsuario_editar['usuario'];?>" name="inputAsignarUsuarios_editar[]" value="<?php echo $filaCapaAsignarUsuario_editar['usuario'];?>">
                                                        <?php
                                                            }//fin else
                                                        }//fin foreach
                                                    ?>
                                                        
                                                        <label class="custom-control-label" for="asignar_editar<?php echo $filaCapaAsignarUsuario_editar['usuario'];?>"><?php echo $i;?></label>
                                                        </div>
                                                </th>
                                                <td><?php echo $filaCapaAsignarUsuario_editar['usuario'];?></td>
                                                <td><?php echo $filaCapaAsignarUsuario_editar['nombreusuario'].' '.$filaCapaAsignarUsuario_editar['apellidopaternousuario'].' '.$filaCapaAsignarUsuario_editar['apellidomaternousuario'];?></td>
                                                </tr>

                                                <?php
                                                $i=$i+1;
                                                }//fin while
                                    ?>
                                    </tbody>
                                </table>
                                <!--LOADER-->
                                <div style='display:none, width:100%' id="loader_proyecto2">
                                    <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
                                </div>
                                <!--fin LOADER-->
                            </form>
                        </div>
                    </div>
                </div><!--fin div col mr-1-->
            </div><!--fin div form-group row-->
    </div><!--fin div form-group-->
</div><!--fin div container-->