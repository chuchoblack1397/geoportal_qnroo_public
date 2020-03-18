console.log('Dentro de archivo JS_Eliminar Capa');

function eliminarCapa() {
    //funcion para obtener valores de campos y eliminarlos
    console.info(
        '-------------Dentro de la funcion CLICK eliminar------------'
    );

    var cadenaCapas = '';
    var contador = 0;
    var size = 0;

    $('#formid input[type=checkbox]').each(function () {
        if (this.checked) {
            size = size + 1; //obteniendo el tamaño del arreglo de checkbox
        } //fin if
    });

    $('#formid input[type=checkbox]').each(function () {
        if (this.checked) {
            contador = contador + 1;

            if (size === 1 || contador == size) {
                cadenaCapas += "'" + $(this).val() + "'";
            } //fin if
            else {
                cadenaCapas += "'" + $(this).val() + "', ";
            } //fin else
        } //fin if
    });

    if (size !== 0) {
        //comprueba si existen ckeckbox selecccionados
        //---creando cadena de ruta de conexion
<<<<<<< HEAD
        var Ruta = 'cadenaCapa=' + cadenaCapas;
        enviarDatosEliminar(Ruta);
    } //fin if
    else {
        swal(
            'No hay capas seleccionadas',
            'Debes seleccionar por lo menos una capa para eliminar.',
            'info'
        );
    } //fin else

    return false;
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosEliminar(ruta) {
    swal({
        title: 'Espera!',
        text: '¿Estas seguro que deseas eliminar la(s) capa(s)?',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'php_eliminarCapa.php',
                type: 'POST',
                data: ruta,
                success: function (res) {
                    $('#respuesta').html(res);
                },
            });
        }
    });
=======
        var Ruta = "cadenaCapa="+cadenaCapas;
            enviarDatosEliminar(Ruta);
        }//fin if
        else{
            swal("No hay capas seleccionadas", "Debes seleccionar por lo menos una capa para eliminar.", "info");
        }//fin else

        return false;
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosEliminar(ruta){

    swal({
        title: "Espera!",
        text: "¿Estas seguro que deseas eliminar la(s) capa(s)?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:'php_eliminarCapa.php',
                type:'POST',
                data: ruta,
                success: function(res){
                  $('#respuesta').html(res);
              }
              });
        } 
        
      });

    
>>>>>>> Admin Usuario
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////
