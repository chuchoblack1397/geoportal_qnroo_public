 <form id="formAgregarPrivilegio">
                      <h3>
                        Añadir nuevo privilegio/rol
                      </h3>
                        <div class="form-group row">
                          <label for="campo_privilegio" class="col-sm-2 col-form-label">Título</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="campo_privilegio" placeholder="" required>
                            <span id="info_campo_privilegio" class="small text-info">Evita usar espacios en blanco al inicio, en medio y al final.</span>
                          </div>
                        </div><!--fin row-->
                        <div class="form-group row">
                          <label for="userPass" class="col-sm-2 col-form-label">Características</label>
                          <div class="col-sm-10">
                              <div class="row">
                                  <div class="col">
                                    <label class="font-italic font-weight-bold" for="">Usuarios</label>

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_seleccionar_todo_usuarios" onclick="seleccionar_todo(this,'usuarios')">
                                      <label class="custom-control-label font-italic mb-1" for="chk_seleccionar_todo_usuarios">Seleccionar todo</label>
                                    </div><!--fin checkbox seleccionar todo-->

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_agregar_usuario" name="chk_usuarios">
                                      <label class="custom-control-label" for="chk_agregar_usuario">Agregar usuarios</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_ver_usuario" name="chk_usuarios">
                                      <label class="custom-control-label" for="chk_ver_usuario">Ver usuarios</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_editar_usuario" name="chk_usuarios">
                                      <label class="custom-control-label" for="chk_editar_usuario">Editar usuarios</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_eliminar_usuario" name="chk_usuarios">
                                      <label class="custom-control-label" for="chk_eliminar_usuario">Cancelar usuarios</label>
                                    </div><!--fin checkbox-->
                                  </div><!--fin col-->
                                  <div class="col">
                                    <label class="font-italic font-weight-bold" for="">Capas</label>

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_seleccionar_todo_capas" onclick="seleccionar_todo(this,'capas')">
                                      <label class="custom-control-label font-italic mb-1" for="chk_seleccionar_todo_capas">Seleccionar todo</label>
                                    </div><!--fin checkbox seleccionar todo-->

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_agregar_capas" name="chk_capas">
                                      <label class="custom-control-label" for="chk_agregar_capas">Agregar capas</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_ver_capas" name="chk_capas">
                                      <label class="custom-control-label" for="chk_ver_capas">Ver capas</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_editar_capas" name="chk_capas">
                                      <label class="custom-control-label" for="chk_editar_capas">Editar capas</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_eliminar_capas" name="chk_capas">
                                      <label class="custom-control-label" for="chk_eliminar_capas">Cancelar capas</label>
                                    </div><!--fin checkbox-->
                                  </div><!--fin col-->
                              </div><!--fin row-->
                              <div class="row mt-4">
                                  <div class="col">
                                    <label class="font-italic font-weight-bold" for="">Mapas de referencia</label>

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_seleccionar_todo_mapasRef" onclick="seleccionar_todo(this,'mapasRef')">
                                      <label class="custom-control-label font-italic mb-1" for="chk_seleccionar_todo_mapasRef">Seleccionar todo</label>
                                    </div><!--fin checkbox seleccionar todo-->

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_agregar_mapasRef" name="chk_mapasRef">
                                      <label class="custom-control-label" for="chk_agregar_mapasRef">Agregar mapas de referencia</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_ver_mapasRef" name="chk_mapasRef">
                                      <label class="custom-control-label" for="chk_ver_mapasRef">Ver mapas de referencia</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_editar_mapasRef" name="chk_mapasRef">
                                      <label class="custom-control-label" for="chk_editar_mapasRef">Editar mapas de referencia</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_eliminar_mapasRef" name="chk_mapasRef">
                                      <label class="custom-control-label" for="chk_eliminar_mapasRef">Cancelar mapas de referencia</label>
                                    </div><!--fin checkbox-->
                                  </div><!--fin col-->
                                  <div class="col">
                                    <label class="font-italic font-weight-bold" for="">Privilegios/Roles</label>

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_seleccionar_todo_roles" onclick="seleccionar_todo(this,'roles')">
                                      <label class="custom-control-label font-italic mb-1" for="chk_seleccionar_todo_roles">Seleccionar todo</label>
                                    </div><!--fin checkbox seleccionar todo-->

                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_agregar_roles" name="chk_roles">
                                      <label class="custom-control-label" for="chk_agregar_roles">Agregar privilegios/roles</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_ver_roles" name="chk_roles">
                                      <label class="custom-control-label" for="chk_ver_roles">Ver privilegios/roles</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_editar_roles" name="chk_roles">
                                      <label class="custom-control-label" for="chk_editar_roles">Editar privilegios/roles</label>
                                    </div><!--fin checkbox-->
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="chk_eliminar_roles" name="chk_roles">
                                      <label class="custom-control-label" for="chk_eliminar_roles">Cancelar privilegios/roles</label>
                                    </div><!--fin checkbox-->
                                  </div><!--fin col-->
                              </div><!--fin row-->
                          </div><!--fin col-sm-10-->
                        </div><!--fin row-->
                        <div class="form-group row">
                          <div class="col-sm-10">
                            <button type="button" class="btn btn-success" id="btn_guardarPrivilegio"><span class="icon-checkmark mr-2"></span>Guardar</button>
                            <button type="Reset" class="btn btn-secondary">Limpiar</button>
                          </div>
                        </div><!--fin row-->
                      </form>
<script>

function seleccionar_todo(idChk,dato){

  var chk_select = document.getElementById(idChk.id);

  if(chk_select.checked == true){
    $("input[type=checkbox][name='chk_"+dato+"']").prop("checked", true);
  }//fin if
  else{
    $("input[type=checkbox][name='chk_"+dato+"']").prop("checked", false);
  }//fin else
}//fin funcion

/*ESTE ES PARA SELECIONAR TODO DESDE UN CLICK
$("#chk_seleccionar_todo_roles").click(function() {
    $("input[type=checkbox][name='chk_roles']").prop("checked", $(this).prop("checked"));
});*/

//FUNCIONES PARA DESHABILITAR EL CHECKBOX DE SELECCNAR TODO!S
$("input[type=checkbox][name='chk_usuario']").click(function() {
    if (!$(this).prop("checked")) {
        $("#chk_seleccionar_todo_usuarios").prop("checked", false);
    }
});

$("input[type=checkbox][name='chk_capas']").click(function() {
    if (!$(this).prop("checked")) {
        $("#chk_seleccionar_todo_capas").prop("checked", false);
    }
});

$("input[type=checkbox][name='chk_mapasRef']").click(function() {
    if (!$(this).prop("checked")) {
        $("#chk_seleccionar_todo_mapasRef").prop("checked", false);
    }
});

$("input[type=checkbox][name='chk_roles']").click(function() {
    if (!$(this).prop("checked")) {
        $("#chk_seleccionar_todo_roles").prop("checked", false);
    }
});

</script>