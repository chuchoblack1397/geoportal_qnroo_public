 <form id="formAgregarUsuario">
                      <h3>
                        Añadir nuevo usuario
                      </h3>
                        <div class="form-group row">
                          <label for="userNickname" class="col-sm-2 col-form-label">Nickname</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="userNickname" placeholder="Ej: user_123, josePablo, etc." required>
                            <span id="info_userNickname" class="small text-info">Evita usar espacios en blanco al inicio, en medio y al final de tu nickname.</span>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userCorreo" class="col-sm-2 col-form-label">Correo</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="userCorreo" placeholder="Ej: user_123@empresa.com" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userPass" class="col-sm-2 col-form-label">Contraseña</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="userPass" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userPassRepetir" class="col-sm-2 col-form-label">Repetir Contraseña</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="userPassRepetir" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userNombre" class="col-sm-2 col-form-label">Nombre(s)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="userNombre" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userAPaterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="userAPaterno" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userAMaterno" class="col-sm-2 col-form-label">Apellido Materno</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="userAMaterno" placeholder="Opcional">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userPrivilegio" class="col-sm-2 col-form-label">Privilegio o Rol</label>
                          <div class="col-sm-10">
                            <select name="userPrivilegio" id="userPrivilegio" class="custom-select my-1 mr-sm-2">
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
                                <option value="<?php echo $filaPrivilegio['privilegio'];?>"><?php echo $filaPrivilegio['privilegio'];?></option>
                              <?php
                                }//fin while
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="userPuesto" class="col-sm-2 col-form-label">Puesto</label>
                          <div class="col-sm-10">
                            <select name="userPuesto" id="userPuesto" class="custom-select my-1 mr-sm-2">
                              <option value="NA" selected>Selecciona...</option>
                              <?php
                                $consultaPuesto = "SELECT * FROM cat_puestos ORDER BY puesto ASC";//consulta general
                                $resultadoPuesto = pg_query($conexion,$consultaPuesto);

                                if(!$resultadoPuesto){
                                  echo "<script>console.log('ERROR');</script>";
                                }

                                while ($filaPuesto = pg_fetch_assoc($resultadoPuesto))
                                {//obteniendo capas de BD
                              ?>
                                <option value="<?php echo $filaPuesto['puesto'];?>"><?php echo $filaPuesto['puesto'];?></option>
                              <?php
                                }//fin while
                              ?>
                            </select>
                          </div>
                        </div>                       
                        <div class="form-group row">
                          <div class="col-sm-10">
                            <button type="button" class="btn btn-success" id="btn_guardarUsuario"><span class="icon-checkmark mr-2"></span>Guardar</button>
                            <button type="Reset" class="btn btn-secondary">Limpiar</button>
                          </div>
                        </div>
                      </form>