console.log("Dentro de archivo JS_Eliminar Usuario");

function eliminarUsuario(){//funcion para obtener valores de campos y eliminarlos
     console.info("-------------Dentro de la funcion CLICK eliminar Usuario------------");
     
     var cadenaUsuarios = '';
     var contadorUser = 0;
     var sizeUser=0;
     
     
         $('#formid_users input[type=checkbox]').each(function(){
             if (this.checked) {
                sizeUser=sizeUser+1;//obteniendo el tamaño del arreglo de checkbox
             }//fin if
        });
     
        $('#formid_users input[type=checkbox]').each(function(){
            if (this.checked) {
                
                contadorUser = contadorUser+1;
                
                if(sizeUser === 1 || contadorUser == sizeUser){
                    cadenaUsuarios += "'"+$(this).val()+"'";
                }//fin if
                else{
                    cadenaUsuarios += "'"+$(this).val()+"', ";
                }//fin else
                
            }//fin if
        }); 
        

        if (sizeUser !== 0){//comprueba si existen ckeckbox selecccionados
        //---creando cadena de ruta de conexion
        var Ruta = "cadenaUsuario="+cadenaUsuarios;
            enviarDatosEliminarUsuario(Ruta);
        }//fin if
        else{
            swal("No hay Usuarios seleccionados", "Debes seleccionar por lo menos un usuario para eliminar.", "info");
        }//fin else

        return false;
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosEliminarUsuario(ruta){

    swal({
        title: "Espera!",
        text: "¿Estas seguro que deseas eliminar usuario(s)?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:'php_eliminarUsuario.php',
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


function archivo(){
    $('#btn-submit').on('click',function(e){
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: "Espera",
            text: "¿Seguro que quieres continuar?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si",
            closeOnConfirm: false
        }, function(isConfirm){
            if (isConfirm) form.submit();
        });
    });


}