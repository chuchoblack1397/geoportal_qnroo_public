<?php
include "../conexion.php";
$id_capa = $_POST['id_capa'];
$titulo_capa = $_POST['titulo_capa'];
$url = $_POST['url'];
$layer = $_POST['layer'];
$estilo = $_POST['estilo'];
$version = $_POST['version'];
$transparencia = $_POST['transparencia'];
$formato = $_POST['formato'];
$leyenda = $_POST['leyenda'];
$activo_consulta=  $_POST['activoConsulta'];
$consulta = $_POST['consulta'];
?>
<div class="container">
    <div class="form-group">
            <h4 class="h-4">Capa: <?php echo $titulo_capa; ?></h4>
            <div class="form-group row">
                          <label for="tituloCapa_editar" class="col-sm-2 col-form-label">Título de la Capa</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="tituloCapa_editar" placeholder="Título de la Capa" required value="<?php echo $titulo_capa; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="urlCapa_editar" class="col-sm-2 col-form-label">URL</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="urlCapa_editar" placeholder="URL" required value="<?php echo $url; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="capaCapa_editar" class="col-sm-2 col-form-label">Capa</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="capaCapa_editar" placeholder="Capa" required value="<?php echo $layer; ?>">
                            <span id="info_capaCapa1_editar" class="small text-info">Si la capa está dentro de un almacen, debe escribirse.</span><br>
                            <span id="info_capaCapa2_editar" class="small text-info">Primero el nombre del almacen, seguido de dos puntos y nombre de capa. Ej. <b>almacen:capa</b></span>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="estiloCapa_editar" class="col-sm-2 col-form-label">Estilo (Opcional)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="estiloCapa_editar" placeholder="Estilo (Opcional)" value="<?php echo $estilo; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="versionCapa_editar" class="col-sm-2 col-form-label">Versión (Opcional)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="versionCapa_editar" placeholder="Versión (Opcional)" value="<?php echo $version; ?>">
                          </div>
                        </div>
                        <fieldset class="form-group">
                          <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Opciones</legend>
                            <div class="col-sm-10">
                            <div class="custom-control custom-radio custom-control-inline mb-3">
                                <input type="radio" id="pgnCapa_editar" name="formatosCapa" class="custom-control-input" onchange="activar_png_jpeg(this)" value="png" <?php if($formato == "image/png"){ ?>checked<?php } ?>>
                                <label class="custom-control-label" for="pgnCapa_editar">PNG</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jpegCapa_editar" name="formatosCapa" class="custom-control-input" onchange="activar_png_jpeg(this)" value="jpeg" <?php if($formato == "image/jpeg"){ ?>checked<?php } ?>>
                                <label class="custom-control-label" for="jpegCapa_editar">JPEG</label>
                              </div>
                              
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="transparenciaCapa_editar" <?php if($transparencia == "true"){ ?>checked<?php } ?>>
                                <label class="custom-control-label" for="transparenciaCapa_editar">Transparencia</label>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <h4>
                        Avanzado
                        </h4>
                        <div class="form-group row">
                          <label for="leyendaCapa_editar" class="col-sm-2 col-form-label">Leyenda (Opcional)</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="leyendaCapa_editar" placeholder="Leyenda (Opcional)"  value="<?php echo $leyenda; ?>">
                            <span id="info_leyendaCapa_editar" class="small text-danger">Debe escribir el enlace completo de la leyenda otorgado por el servidor de mapas.</span>
                          </div>
                        </div>

                        <fieldset class="form-group mt-4">
                          <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">Consulta (Opcional)</legend>
                            <div class="col-sm-10">
                              <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" onchange="validaCheckboxConsulta_editar(this)" id="chk_consultaCapa_editar_ok" <?php if($activo_consulta == 'true'){ ?>checked<?php } ?>>
                                <label class="custom-control-label" for="chk_consultaCapa_editar_ok">¿Utilizar esta capa para consulta?</label>
                              </div>

                              <div>
                                <label for="consultaCapa_editar_ok">Campo de consulta</label>
                                <input type="text" class="form-control" id="consultaCapa_editar_ok"  <?php if($consulta == "" || $consulta == null){ ?>placeholder="Campo de consulta"<?php }else{ ?> placeholder="Valor original: <?php echo $consulta; ?>" <?php } ?>  <?php if($consulta == "" || $consulta == null){ ?>disabled value=""<?php }else{ ?> value="<?php echo $consulta; ?>" <?php } ?>>
                                <span id="info_consultaCapa_editar_ok" class="small text-danger">El campo debe ser exacto al que está en el servidor de mapas.</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>

    </div>
</div>

