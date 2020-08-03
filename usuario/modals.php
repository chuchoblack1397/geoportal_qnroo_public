<!-- Modal  editar usuario-->
<div class="modal fade" id="modal_editar_usuario" tabindex="-1" role="dialog" aria-labelledby="modal_editar_usuarioTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editar_usuarioTitle">Editar información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cuerpoModal_editar_usuario">
            </div>
            <!--LOADER-->
            <div style='display:none; width:100%;' id="loader_usuario" class="mb-4">
                <center><img src='../img/loading.gif' alt='Cargando...' width='24px'></center>
            </div>
            <!--fin LOADER-->
            <div class="modal-footer">
                <button id="btn_cerrarModalUsuario" type="button" class="btn btn-danger" data-dismiss="modal"><span class="icon-cross"></span> Cancelar</button>
                <button id="btn_actualizarUsuario" type="button" class="btn btn-success" onclick="actualizar_usuario()"><span class="icon-checkmark"></span> Actualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- fin Modal  editar usuario-->

<!-- Modal  editar password usuario-->
<div class="modal fade" id="modal_cambiar_password" tabindex="-1" role="dialog" aria-labelledby="modal_cambiar_passwordTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cambiar_passwordTitle">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cuerpoModal_cambiar_password">
                <div class="container">
                    <div class="form-group">
                        <div class="form-row">
                            <label for="passActual">Contraseña actual</label>
                            <input type="password" class="form-control mb-3" id="passActual" title="Contraseña actual" value="">
                        </div>
                        <div class="form-row">
                            <label for="passNueva">Nueva contraseña</label>
                            <input type="password" class="form-control mb-3" id="passNueva" title="Nueva contraseña" value="">
                        </div>
                        <div class="form-row">
                            <label for="passConfirmar">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control mb-3" id="passConfirmar" title="Confirmar nueva contraseña" value="">
                        </div>
                    </div>
                </div>
                <div id="actualizando">
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_cerrarModalPassoword" type="button" class="btn btn-danger" data-dismiss="modal"><span class="icon-cross"></span> Cancelar</button>
                <button id="btn_actualizarPassoword" type="button" class="btn btn-success" onclick="actualizar_password()"><span class="icon-checkmark"></span> Actualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- fin Modal  editar password usuario-->


<!-- Modal  Subir fotografías georreferenciadas-->
<div class="modal fade" id="modal_subir_fotoGeo" tabindex="-1" role="dialog" aria-labelledby="modal_subir_fotoGeoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered " role="document">
        <div class="modal-content">
            <form id="foto_geo">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_subir_fotoGeoTitle">Subir fotografía georreferenciada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="cuerpomodal_subir_fotoGeo">
                    <div class="form-group">
                        <label for="fotografia_georreferenciada">Fotografía georreferenciada</label>
                        <input type="file" class="form-control-file" id="fotografia_georreferenciada" name="fotografia_georreferenciada" accept="image/x-png,image/gif,image/jpeg" required>
                    </div>
                    <div class="form-group">
                        <label for="nota">Nota (opcional)</label>
                        <textarea class="form-control" id="nota" name="nota" rows="3"></textarea>
                    </div>
                </div>
                <div class="progress mx-3 mb-2">
                    <div id="barra_progreso" class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="modal-footer">
                    <button id="btn_cerrarModalUsuario" type="button" class="btn btn-danger" data-dismiss="modal"><span class="icon-cross"></span> Cancelar</button>
                    <button id="btn_subirImagen" onclick="subirImagen()" type="submit" class="btn btn-success"><span class="icon-upload3"></span> Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin Modal  editar usuario-->