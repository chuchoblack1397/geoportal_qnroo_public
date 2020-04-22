console.log("Dentro de archivo JS_Eliminar Usuario");

function eliminarProyecto(){//funcion para obtener valores de campos y eliminarlos
     console.info("-------------Dentro de la funcion CLICK eliminar Usuario------------");
     
     var cadenaProyectos = '';
     var contadorProyectos = 0;
     var sizeProyecto=0;
     
     
         $('#formid_proyectos input[type=checkbox]').each(function(){
             if (this.checked) {
                sizeProyecto=sizeProyecto+1;//obteniendo el tamaño del arreglo de checkbox
             }//fin if
        });
     
        $('#formid_proyectos input[type=checkbox]').each(function(){
            if (this.checked) {
                
                contadorProyectos = contadorProyectos+1;
                
                if(sizeProyecto === 1 || contadorProyectos == sizeProyecto){
                    cadenaProyectos += "'"+$(this).val()+"'";
                }//fin if
                else{
                    cadenaProyectos += "'"+$(this).val()+"', ";
                }//fin else
                
            }//fin if
        }); 
        

        if (sizeProyecto !== 0){//comprueba si existen ckeckbox selecccionados
        //---creando cadena de ruta de conexion
        var Ruta = "cadenaProyecto="+cadenaProyectos;
            enviarDatosEliminarProyecto(Ruta);
        }//fin if
        else{
            swal("No hay proyectos seleccionados", "Debes seleccionar por lo menos un proyecto para eliminar.", "info");
        }//fin else

        return false;
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosEliminarProyecto(ruta){

    swal({
        title: "Espera!",
        text: "¿Estas seguro que deseas eliminar proyecto(s)?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:'php_eliminarProyecto.php',
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