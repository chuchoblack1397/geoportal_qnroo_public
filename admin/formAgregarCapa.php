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
                       
                        <div class="form-group row">
                          <div class="col-sm-10">
                            <button type="button" class="btn btn-success" id="btn_guardarCapa"><span class="icon-checkmark mr-2"></span>Guardar</button>
                            <button type="Reset" class="btn btn-secondary">Limpiar</button>
                          </div>
                        </div>
                      </form>