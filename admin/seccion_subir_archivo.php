<script type="text/javascript"> 
            function cargando(){
    $("#respuesta").html('Subiendo archivo');
} 
function resultadoOk(){
    $("#respuesta").html('El archivo ha sido subido exitosamente.');
} 
function resultadoErrorCmd(){
    $("#respuesta").html('Error en el servidor.');
} 
function resultadoExitoCmd(){
    $("#respuesta").html('La capa se ha subido correctamente.');
} 

function resultadoErrorFalta(){
    $("#respuesta").html('Error: Archivos Faltantes.');
}
function resultadoExtraccionCorrecta(){
    $("#respuesta").html('Extraccion Correcta');
}

function resultadoErrorExtraccion(){
    $("#respuesta").html('Error: No se pudo descomprimir el archivo.');
}

function resultadoErrorExt(){
    $("#respuesta").html('Error: Extencion invalida de archivos.');
}
$(document).ready(function(){
    $("#boton-enviar").click(function(){
    cargando();
    });
});
</script>

<div class="container">
  <center>
    <form method="POST" action="archivo.php" enctype="multipart/form-data" class="was-validated" target="subir-archivo">
    <div class="form-group">
    <img src="img/upload.png" alt="Subir archivo" title="Subir archivo" width="150px">
    <br>
    <br>
    <br>
    <div class="form-group row">
    <label for="capa-nombre" class="col-sm-2 col-form-label">Nombre de la capa</label>
    <div class="col-sm-10">
    <input type="text"  class="form-control" name="capa-nombre" id="capa-nombre" required>
    </div>
    </div>
    <div class="form-group row">
    <label for="srid" class="col-sm-2 col-form-label">Ingrese SRID</label>
    <div class="col-sm-10">
    <input type="text"  class="form-control" name="srid" id="srid" required>
    </div>
    </div>
    
    <div class="custom-file">
    
    <input type="file"  class="form-control" class="custom-file-input" id="validatedCustomFile" name="fichero_usuario" required/>
    <label class="custom-file-label" for="validatedCustomFile">Seleccione Archivo Zip</label>
    <div class="invalid-feedback">No se ha seleccionado ningun archivo.</div>
    </div>
    </div>
  
    
   <button type="submit"class="btn btn-success mt-3 mb-2" title="Subir archivo" id="boton-enviar"><span class="icon-upload3 mr-3"></span>Subir Archivo</button>
    <br>
    <span class="text-muted">Solo se permiten archivos <b>.zip</b></span>

<br>
<br>
    <div id="respuesta"></div>
    <iframe width="1" height="1" frameborder="0" name="subir-archivo" style="display=none;"></iframe>
    </form>
  </center>
</div>