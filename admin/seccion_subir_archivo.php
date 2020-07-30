<script type="text/javascript"> 
            function cargando(){
                swal({
        title: "Subiendo!",
        text: "Preparando archivo, no recargue la pagina",
        icon: "success",
       
      });
} 
function resultadoOk(){
    swal({
        title: "Exito!",
        text: "El archivo se ha subido correctamente, Descomprimiendo",
        icon: "success",
        buttons: false,
       
      });
} 
function resultadoErrorCmd(){
    swal({
        title: "Error!",
        text: "Ha ocurrido un error en el servidor",
        icon: "warning",
       
      });

} 
function resultadoExitoCmd(){
    swal({
        title: "Exito!",
        text: "La capa se ha subido correctamente",
        icon: "success",
       
      });


} 


function Existen(){
    swal({
      html:true,
        title: "Archivos Correctos!",
        text: "dbf : ✓\nprj : ✓\nshp : ✓\nshx : ✓",
        icon: "success",
       
      });

} 


function resultadoErrorFalta(){
    swal({
        title: "Error!",
        text: "Archivos Faltantes",
        icon: "warning",
       
      });

}
function resultadoExtraccionCorrecta(){
    swal({
        title: "Exito!",
        text: "Extraccion correcta , escribiendo en la base de datos",
        icon: "success",

        buttons: false,
       
      });
 
}

function resultadoErrorExtraccion(){
    swal({
        title: "Error!",
        text: "No se pudo extraer el archivo",
        icon: "warning",
       
      });
} 


function resultadoErrorExt(){
    swal({
        title: "Error!",
        text: "Archivos faltantes o error de extencion.",
        icon: "warning",
       
      });
} 




   function swalE(){
    swal({
  title: "Aviso",
  text: "Esta accion no se puede deshacer.",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $('#formulario').submit();
  } else {
    swal("Your imaginary file is safe!");
  }
});
   }


function validateForm() {
  var x = document.forms["formulario"]["capa-nombre"].value;
  var y = document.forms["formulario"]["srid"].value;
  var z = document.forms["formulario"]["fichero_usuario"].value;
  if (x == "" || y == ""||z=="") {
    swal({
  title: "Aviso",
  text: "No puede haber campos vacios.",
  icon: "warning",
 
  
});
    return false;
  } 
  
   swal({
  title: "Aviso",
  text: "Esta accion no se puede deshacer.",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $('#formulario').submit();
  } else {
    swal("Your imaginary file is safe!");
  }
});
  
}

</script>

<div class="container">
  <center>
    <form id="formulario" method="POST" action="archivo.php" enctype="multipart/form-data" class="was-validated" target="subir-archivo"  >
    <div class="form-group">
    <img src="img/upload.png" alt="Subir archivo" title="Subir archivo" width="150px">
    <br>
    <br>
    <br>
    <div class="form-group row">
    <label for="capa-nombre" class="col-sm-2 col-form-label">Nombre de la capa</label>
    <div class="col-sm-10">
    <input type="text"  class="form-control" name="capa-nombre" id="capa-nombre" >
    <span id="info_capaCapa" class="small text-info">Debe contener solo caracteres de A...Z y solo usar guion bajo (no guion medio).</span><br>
    </div>
    </div>
    <div class="form-group row">
    <label for="srid" class="col-sm-2 col-form-label">Ingrese SRID</label>
   
    <div class="col-sm-10">
    <input type="text"  class="form-control" name="srid" id="srid" >
    <span id="info_capaCapa" class="small text-info"> El SRID debe ser un número válido en el índice EPSG 2016.</span><br>
    </div>
    </div>
    
    <div class="custom-file">
    
    <input type="file"   class="form-control" class="custom-file-input" id="validatedCustomFile" name="fichero_usuario"/>
    <label class="custom-file-label" for="validatedCustomFile">Seleccione Archivo Zip</label>
    <div class="invalid-feedback">No se ha seleccionado ningun archivo.</div>
    </div>
    </div>
  
   
   <button type="button" class="btn btn-success mt-3 mb-2" title="Subir archivo" onClick="validateForm();"><span class="icon-upload3 mr-3" ></span>Subir Archivo</button>
    <br>
    <span class="text-muted">Solo se permiten archivos <b>.zip</b></span>

<br>
<br>
    <div id="respuesta"></div>
    <iframe width="1" height="1" frameborder="0" name="subir-archivo" style="display=none;"></iframe>
    </form>
  </center>
</div>