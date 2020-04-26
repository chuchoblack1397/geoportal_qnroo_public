 <form id="formAgregarCapa">
                      <h3>
                        Añadir nueva capa
                      </h3>
                        <div class="form-group row">
                          <label for="tituloCapa" class="col-sm-2 col-form-label">Título de la Capa</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="tituloCapa" placeholder="Título de la Capa" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="urlCapa" class="col-sm-2 col-form-label">URL</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="urlCapa" placeholder="URL" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="capaCapa" class="col-sm-2 col-form-label">Capa</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="capaCapa" placeholder="Capa" required>
                            <span id="info_capaCapa" class="small text-info">Si la capa está dentro de un almacen, debe escribirse.</span><br>
                            <span id="info_capaCapa" class="small text-info">Primero el nombre del almacen, seguido de dos puntos y nombre de capa. Ej. <b>almacen:capa</b></span>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="estiloCapa" class="col-sm-2 col-form-label">Estilo (Opcional)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="estiloCapa" placeholder="Estilo (Opcional)">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="versionCapa" class="col-sm-2 col-form-label">Versión (Opcional)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="versionCapa" placeholder="Versión (Opcional)">
                          </div>
                        </div>
                        <fieldset class="form-group">
                          <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Opciones</legend>
                            <div class="col-sm-10">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio" id="pgnCapa" name="formatosCapa" class="custom-control-input" value="png" checked>
                                <label class="custom-control-label" for="pgnCapa">PNG</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jpegCapa" name="formatosCapa" class="custom-control-input" value="jpeg">
                                <label class="custom-control-label" for="jpegCapa">JPEG</label>
                              </div>
                              
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="transparenciaCapa" checked>
                                <label class="custom-control-label" for="transparenciaCapa">Transparencia</label>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <h4>
                        Avanzado
                        </h4>
                        <div class="form-group row">
                          <label for="leyendaCapa" class="col-sm-2 col-form-label">Leyenda (Opcional)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="leyendaCapa" placeholder="Leyenda (Opcional)">
                            <span id="info_leyendaCapa" class="small text-danger">Debe escribir el enlace completo de la leyenda otorgado por el servidor de mapas.</span>
                          </div>
                        </div>

                        <fieldset class="form-group mt-4">
                          <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Consulta (Opcional)</legend>
                            <div class="col-sm-10">
                              <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="chk_consultaCapa">
                                <label class="custom-control-label" for="chk_consultaCapa">¿Utilizar esta capa para consulta?</label>
                              </div>
                             
                              <div>
                                <label for="consultaCapa">Campo de consulta</label>
                                <input type="text" class="form-control" id="consultaCapa" placeholder="Campo de consulta" disabled>
                                <span id="info_consultaCapa" class="small text-danger">El campo debe ser exacto al que está en el servidor de mapas.</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>

                        <!--Botones-->
                        <div class="form-group row">
                          <div class="col-sm-10">
                            <button type="button" class="btn btn-success" id="btn_guardarCapa"><span class="icon-checkmark mr-2"></span>Guardar</button>
                            <button type="Reset" class="btn btn-secondary">Limpiar</button>
                          </div>
                        </div>
                      </form>