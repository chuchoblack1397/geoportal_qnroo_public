console.log("Dentro de archivo JS_Eliminar Privilegio");

function eliminarPrivilegio(){//funcion para obtener valores de campos y eliminarlos
     console.info("-------------Dentro de la funcion CLICK eliminar Privilegio------------");
     
     var cadenaPrivilegios = '';
     var contadorPrivilegio = 0;
     var sizePrivilegio=0;
     
     
         $('#formid_privilegios input[type=checkbox]').each(function(){
             if (this.checked) {
                sizePrivilegio=sizePrivilegio+1;//obteniendo el tamaño del arreglo de checkbox
             }//fin if
        });
     
        $('#formid_privilegios input[type=checkbox]').each(function(){
            if (this.checked) {
                
                contadorPrivilegio = contadorPrivilegio+1;
                
                if(sizePrivilegio === 1 || contadorPrivilegio == sizePrivilegio){
                    cadenaPrivilegios += "'"+$(this).val()+"'";
                }//fin if
                else{
                    cadenaPrivilegios += "'"+$(this).val()+"', ";
                }//fin else
                
            }//fin if
        }); 
        

        if (sizePrivilegio !== 0){//comprueba si existen ckeckbox selecccionados
        //---creando cadena de ruta de conexion
        var Ruta = "cadenaPrivilegio="+cadenaPrivilegios;
            enviarDatosEliminarPrivilegio(Ruta);
        }//fin if
        else{
            swal("No hay privilegios seleccionados", "Debes seleccionar por lo menos un privilegio para eliminar.", "info");
        }//fin else

        return false;
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosEliminarPrivilegio(ruta){

    swal({
        title: "Espera!",
        text: "¿Estas seguro que deseas eliminar privilegio(s)?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:'php_eliminarPrivilegio.php',
                type:'POST',
                data: ruta,
                success: function(res){
                  $('#respuesta').html(res);
              }
              });
        } 
        
      });

    
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////