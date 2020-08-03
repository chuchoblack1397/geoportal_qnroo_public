<script type="text/javascript"> 
function cargando(){
                Swal.fire({
        title: "Subiendo!",
        text: "Preparando archivo, no recargue la pagina",
     
        onBeforeOpen: () => {
          Swal.showLoading()
        }
       
      });
      $('#loader_zip').show();//mostrar LOADER
} 


function cargando2(){
                Swal.fire({
        title: "Actualizando Datos!",
        text: "Por favor, no recargue la pagina",
     
        onBeforeOpen: () => {
          Swal.showLoading()
        }
       
      });
      $('#loader_zip').show();//mostrar LOADER
} 


function resultadoOk(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
        title: "Exito!",
        text: "El archivo se ha subido correctamente, Descomprimiendo",
        icon: "success",
        buttons: false,
       
      });
      
} 
function resultadoErrorCmd(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
        title: "Error!",
        text: "Ha ocurrido un error en el servidor",
        icon: "error",
       
      });
      

} 
function resultadoExitoCmd(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
  title: 'Exito',
  text: "La capa se ha subido correctamente!",
  icon: 'success',
  showCancelButton: false,

  confirmButtonText: 'Cerrar'
}).then((result) => {
  if (result.value) {
   $("#subir_archivo").load("seccion_subir_archivo.php");
  }
})


} 


function Existen(){
      let timerInterval
Swal.fire({
  title: 'Archivos Correctos',
  icon:'success',
  html: 'dbf : <i class="icon-checkmark"></i><br>prj : <i class="icon-checkmark"></i><br>shx : <i class="icon-checkmark"></i><br>shp : <i class="icon-checkmark"></i>',
  timer: 2000,
  timerProgressBar: true,
  onBeforeOpen: () => {
    Swal.showLoading()
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
   cargando2();
  }
})




} 


function resultadoErrorFalta(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
        title: "Error!",
        text: "Archivos Faltantes",
        icon: "error",
       
      });

}
function resultadoExtraccionCorrecta(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
        title: "Exito!",
        text: "Extraccion correcta , escribiendo en la base de datos",
        icon: "success",

        buttons: false,
       
      });
 
}

function resultadoErrorExtraccion(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
        title: "Error!",
        text: "No se pudo extraer el archivo",
        icon: "error",
       
      });
} 


function resultadoErrorExt(){
  $('#loader_zip').hide();//mostrar LOADER
  Swal.fire({
        title: "Error!",
        text: "Archivos faltantes o error de extencion.",
        icon: "error",
       
      });
} 




   function swalE(){
    Swal.fire({
  title: "Aviso",
  text: "Esta accion no se puede deshacer.",
  icon: "warning",
  buttons: true,
  dangerMode: true,
  showCancelButton: true,
})
.then((willDelete) => {
  if (willDelete) {
    $('#formulario').submit();
  } else {
    swal("Accion Cancelada Correctamente");
  }
});
   }


function validateForm() {
  var x = document.forms["formulario"]["capa-nombre"].value;
  var y = document.forms["formulario"]["srid"].value;
  var z = document.forms["formulario"]["fichero_usuario"].value;
  if (x == "" || y == ""||z=="") {
    Swal.fire({
  title: "Aviso",
  text: "No puede haber campos vacios.",
  icon: "warning",
 
  
});
    return false;
  } 
  
    Swal.fire({
  title: 'Advertencia?',
  text: "Esta accion no se puede deshacer!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText:'Cancelar',
  confirmButtonText: 'Continuar'
}).then((result) => {
  if (result.value) {
    cargando();
    $('#formulario').submit();
  }
})
  
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
    <input type="number"  class="form-control" name="srid" id="srid" >
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
<!--LOADER-->
<div style='display:none; width:100%' id="loader_zip">
        <center><img src='img/loading.gif' alt='Cargando...' width='24px'></center>
    </div>
<!--fin LOADER-->
    <div id="respuesta"></div>
    <iframe width="1" height="1" frameborder="0" name="subir-archivo" style="display=none;"></iframe>
    </form>
  </center>
</div>