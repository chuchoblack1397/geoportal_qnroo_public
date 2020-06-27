<?php
session_start();
include "../conexion.php";
$usuarioR = $_POST['usuario'];
$nombreUserR = $_POST['nombre'];
$apUserR = $_POST['ap'];
$amUserR = $_POST['am'];
$puestoUserR = $_POST['puesto'];
$privilegioUserR = $_POST['privilegio'];
$correoUserR = $_POST['correo'];

$miUsuario = $_SESSION['usuarioSession'];

?>
<div class="container">
    <div class="form-group">
            <h4 class="h-4">Usuario: <?php echo $usuarioR; ?></h4> 
            <a href="#" class="card-link text-danger" data-toggle="modal" data-target="#modal_cambiar_password" onclick="cambiar_password_modal('<?php echo $usuarioR; ?>','<?php echo $miUsuario; ?>')"><span class="icon-key mr-2"></span>Cambiar contraseña</a>
            
            <div class="form-row mt-3">
                <label for="nombreUser" class="small">Nombre</label>
                <input type="text" class="form-control mb-3" id="nombreUser" value="<?php echo $nombreUserR; ?>">
            </div>
            <div class="form-row">
                <label for="correoUser" class="small">Correo</label>
                <input type="email" class="form-control mb-3" id="correoUser" value="<?php echo $correoUserR; ?>">
            </div>
            <div class="form-row">
                <label for="apUser" class="small">Apellido Paterno</label>
                <input type="text" class="form-control mb-3" id="apUser"  value="<?php echo $apUserR; ?>">
            </div>
            <div class="form-row">
                <label for="amUser" class="small">Apellido Materno</label>
                <input type="text" class="form-control mb-3" id="amUser"  value="<?php echo $amUserR; ?>">
            </div>
            <div class="form-row">
                <label for="puestoUser" class="small">Puesto</label>
                <select name="userPuesto" id="puestoUser" class="custom-select my-1 mr-sm-2  mb-3">
                              <option value="NA">Selecciona...</option>
                              <?php
                                $consultaPuesto = "SELECT * FROM cat_puestos ORDER BY puesto ASC";//consulta general
                                $resultadoPuesto = pg_query($conexion,$consultaPuesto);

                                if(!$resultadoPuesto){
                                  echo "<script>console.log('ERROR');</script>";
                                }

                                while ($filaPuesto = pg_fetch_assoc($resultadoPuesto))
                                {//obteniendo capas de BD
                              ?>
                                <option value="<?php echo $filaPuesto['puesto'];?>" <?php if($filaPuesto['puesto'] == $puestoUserR){?>selected<?php } ?>><?php echo $filaPuesto['puesto'];?></option>
                              <?php
                                }//fin while
                              ?>
                </select>
            </div>
            <div class="form-row">
                <label for="privilegioUser" class="small">Privilegios</label>
                <select name="userPrivilegio" id="privilegioUser" class="custom-select my-1 mr-sm-2">
                              <option value="NA" selected>Selecciona...</option>
                              <?php
                                $consultaPrivilegio = "SELECT * FROM cat_privilegios ORDER BY privilegio ASC";//consulta general
                                $resultadoPrivilegio = pg_query($conexion,$consultaPrivilegio);

                                if(!$resultadoPrivilegio){
                                  echo "Error";
                                  exit();
                                }

                                while ($filaPrivilegio = pg_fetch_assoc($resultadoPrivilegio))
                                {//obteniendo capas de BD
                              ?>
                                <option value="<?php echo $filaPrivilegio['privilegio'];?>" <?php if($filaPrivilegio['privilegio'] == $privilegioUserR){?>selected<?php } ?>><?php echo $filaPrivilegio['privilegio'];?></option>
                              <?php
                                }//fin while
                              ?>
                            </select>
            </div>
    </div>
</div>