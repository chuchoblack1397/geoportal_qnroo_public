console.log("Dentro de archivo JS Asignacion");

var btn_asignarCapas_Usuario = document.getElementById('btn_asignarCapas_Usuario');//boton para guardar capa


btn_asignarCapas_Usuario.onclick = function(e)
{//funcion para obtener valores de campos y guardarlos
    console.info("-------------Dentro de la funcion CLICK Asignacion------------");

    //opteniendo el valor de campos
    var usuario = document.getElementById('listAsignarUsuario').value;
    var chk_vistaTotalAsignada = document.getElementById('chk_vistaTotalAsignada');
    //var checksCapas =['a','b','b'];
            //Creamos un array que almacenará los valores de los input "checked"
 /*   var checksCapas = [];
        //Recorremos todos los input checkbox con name = Colores y que se encuentren "checked"
        $("input[name='inputAsignarCapas']:checked").each(function ()
        {
        checksCapas.push(($(this).attr("value")));
        });
*/
var checksCapas = document.getElementsByName('inputAsignarCapas[]');
        

    if(usuario == ''){
        alert("Debe seleccionar un usuario");
        return;
    }

/*    if(checksCapas == ''){
        alert("Debe seleccionar al menos una capa");
        return;  
    }
*/
    if(chk_vistaTotalAsignada.checked == true){
        var chk_vistaTotalAsignadaOK = 'true';
        var Ruta = "usuario="+usuario+"&vista_total="+chk_vistaTotalAsignadaOK;
    }
    else{
        var chk_vistaTotalAsignadaOK = 'false';
        var Ruta = "usuario="+usuario+"&vista_total="+chk_vistaTotalAsignadaOK+"&checksCapas="+checksCapas;
    }
        
        console.log('arreglo :'+checksCapas);
        //console.log('Ruta a post :'+Ruta);
        //enviando los datos optenidos
        enviarDatosGuardar_asignacion(Ruta);

}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosGuardar_asignacion(ruta){
    console.log('Dentro de AJAX Asignacion de capas');
    $.ajax({
        url:'php_guardarAsignacionCapaUsuario.php',
        type:'POST',
        data: ruta,
        success: function(res){
          $('#respuestaUsuario').html(res);
      },
      error: function(){
        alert( "Error con el servidor" );
    } 
      });
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////
