<!--Barra de acciones
<div class="bg-light" id="barraAcciones">
   <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalAgregar"><span class="icon-plus text-secondary"></span><br><small class="text-secondary">Agregar</small></button>
      <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalConsulta"><span class="icon-search text-secondary"></span><br><small class="text-secondary">Consultar</small></button>
      <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modalEliminar"><span class="icon-bin text-secondary"></span><br><small class="text-secondary">Eliminar</small></button>
    </div>
</div>
<!--fin Barra de acciones-->

<!-- Modal -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Agregar Punto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--
            <form>
                <div class="form-group">
                     <label for="categoriaViolencia" class="small">Categor&iacute;a</label>
                      <select id="categoriaViolencia" class="form-control">
                        <option selected>Selecciona una</option>
                        <option>Violencia 1</option>
                        <option>Violencia 2</option>
                        <option>Violencia 3</option>
                      </select>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="nombreViolentado" class="small">Nombre</label>
                      <input type="text" class="form-control" id="nombreViolentado" placeholder="Nombre">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="edadViolentado" class="small">Edad</label>
                      <input type="number" class="form-control number" id="edadViolentado" placeholder="Edad" min="0" max="100">
                    </div>
                  </div>
                   <div class="form-group">
                      <label for="inputPassword4" class="small">Sexo</label>
                      <div class="form-row">
                      <div class="form-group col-md-6 text-center">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="sexoHombre" name="sexoViolentado" class="custom-control-input">
                              <label class="custom-control-label small" for="sexoHombre">Hombre</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-center">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="sexoMujer" name="sexoViolentado" class="custom-control-input">
                              <label class="custom-control-label small" for="sexoMujer">Mujer</label>
                            </div>
                        </div>
                        </div>
                   </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="cargoViolentado" class="small">Cargo</label>
                      <input type="text" class="form-control" id="cargoViolentado" placeholder="Cargo">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="cargoPoliticoViolentado" class="small">Cargo pol&iacute;tico</label>
                      <input type="text" class="form-control" id="cargoPoliticoViolentado" placeholder="Cargo pol&iacute;tico">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="statusViolentado" class="small">Status de cargo</label>
                      <input type="text" class="form-control" id="statusViolentado" placeholder="Status de cargo">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="partidoViolentado" class="small">Partido</label>
                      <select id="partidoViolentado" class="form-control">
                        <option selected>Selecciona uno</option>
                        <option>Partido 1</option>
                        <option>Partido 2</option>
                        <option>Partido 3</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="lugarDelitoViolentado" class="small">Lugar del delito</label>
                    <input type="text" class="form-control" id="lugarDelitoViolentado" placeholder="Lugar del delito">
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="metodoUtiViolentado" class="small">M&eacute;todo utilizado</label>
                      <select id="metodoUtiViolentado" class="form-control">
                        <option selected>Selecciona uno</option>
                        <option>Metodo util 1</option>
                        <option>Metodo util 2</option>
                        <option>Metodo util 3</option>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="metodoViolentado" class="small">M&eacute;todo</label>
                      <select id="metodoViolentado" class="form-control">
                        <option selected>Selecciona uno</option>
                        <option>Metodo 1</option>
                        <option>Metodo 2</option>
                        <option>Metodo 3</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="fecheIncViolentado" class="small">Fecha del incidente</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text icon-calendar" id="inputGroupPrepend"></span>
                                </div>
                                <input type="date" class="form-control date" id="fecheIncViolentado" placeholder="Fecha del incidente" aria-describedby="inputGroupPrepend">
                            </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="fechaActViolentado" class="small">Fecha actual</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text icon-calendar" id="inputGroupPrepend"></span>
                                    </div>
                                    <input type="date" class="form-control date" id="fechaActViolentado" placeholder="Fecha actual" aria-describedby="inputGroupPrepend">
                                </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="referenciaViolentado" class="small">Referencia</label>
                    <input type="text" class="form-control" id="referenciaViolentado" placeholder="Referencia">
                  </div>
                  <div class="form-group">
                    <label for="fuenteViolentado" class="small">Fuente</label>
                    <input type="text" class="form-control" id="fuenteViolentado" placeholder="Fuente">
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="latitudViolentado" class="small">Latitud</label>
                      <input type="text" class="form-control" id="latitudViolentado" placeholder="Latitud">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="longitudViolentado" class="small">Longitud</label>
                      <input type="text" class="form-control" id="longitudViolentado" placeholder="Longitud">
                    </div>
                  </div>
            </form>
            -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success">Enviar</button>
      </div>
    </div>
  </div>
</div>
<!--fin modal-->

<!-- Modal -->
<div class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Consulta de Punto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Buscar</button>
      </div>
    </div>
  </div>
</div>
<!--fin modal-->

<!-- Modal -->
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Eliminar Punto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!--fin modal-->

<div class="modal fade" id="actualizarCapa" tabindex="-1" role="dialog" aria-labelledby="actualizarCapaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <form action="excel.php" enctype="multipart/form-data" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="actualizarCapaTitle">Actualizar capa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Selecciona un archivo de Excel (.xlsx ó .xls) para actualizar una capa.</p>
          <label for="archivoExcel">Archivo: </label>
          <input id="archivoExcel" name="archivoExcel" class="mb-2" type="file">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <input type="submit" class="btn btn-danger" value="Actualizar" />
        </div>
    </div>
    </form>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_informacion" tabindex="-1" role="dialog" aria-labelledby="modal_informacionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_informacionLabel">Acerca de IDT-OPB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-justify">

        El <b>Portal geoespacial de la Infraestructura de Datos Territoriales del Catastro del Municipio de Othón P. Blanco (IDT-OPB)</b>, 
          es una herramienta colaborativa de datos geoespaciales, 
          construida con visión del territorio para gestionar datos 
          e información a través de mapas que integra imágenes aéreas de 
          muy alta definición, datos puntuales, datos estadísticos e 
          información catastral municipal, para su visualización y análisis, apoyados 
          con otras herramientas y funcionalidades, para facilitar la labor de ubicar,
          analizar y administrar diversos procesos y agilizar la comunicación interna
            y externa de la información, de una manera rápida, ágil y segura.

        </p>
        <p class="text-justify">

        La <b>IDT-OPB</b>, fue realizada gracias al apoyo de <b>MCITI</b> en la administración
          municipal 2018-2021 del municipio de <i>Othón P. Blanco</i>, como 
          un elemento estratégico de la gestión municipal.

        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>