function cargar_modal_usuario(){
    var tipo_busqueda="usuario";
    var ruta="tipo="+tipo_busqueda;

    var cuerpoModal_editar_usuario=document.getElementById("cuerpoModal_editar_usuario");
    $.ajax({
        url:"php_ediciones.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            cuerpoModal_editar_usuario.innerHTML="";
            $('#loader_usuario').show();//mostrar LOADER
        },
        success: function(res){
            cuerpoModal_editar_usuario.innerHTML=res;
            $('#loader_usuario').hide();//ocultar LOADER
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}// fin metodo cargar_modal_usuario

function actualizar_password(){
    var tipo_busqueda_password="password";
    

    var passActual = document.getElementById("passActual").value;
    var passNueva = document.getElementById("passNueva").value;
    var passConfirmar = document.getElementById("passConfirmar").value;

    passActual = passActual.trim();
    passNueva = passNueva.trim();
    passConfirmar = passConfirmar.trim();

    if((passActual=="") || (passNueva=="") || (passConfirmar==""))
    {
        swal('Faltan campos', 'Por favor rellena todos los campos', 'info');
        return;
    }//fin if

    if(passNueva == passActual)
    {
        swal('Cuidado', 'Estas usando la misma contraseña', 'warning');
        return;
    }//fin if

    if(passNueva != passConfirmar)
    {
        swal('Ups', 'La confirmacion no coincide', 'info');
        return;
    }//fin if


    var ruta_password="tipo="+tipo_busqueda_password+"&passActual="+passActual+"&passNueva="+passNueva;

    var actualizando = document.getElementById("actualizando");

    $.ajax({
        url:"php_ediciones.php",
        type:"POST",
        data: ruta_password,
        beforeSend:function(){
            actualizando.innerHTML="<center><span>Actualizando...</span></center>";
        },
        success: function(res){
            if(res == "ok")
            {
                swal('Perfecto', 'Se han actualizado los datos', 'success');
                $("#passActual").val('');
                $("#passNueva").val('');
                $("#passConfirmar").val('');
                actualizando.innerHTML="";
                $('#btn_cerrarModalPassoword').click();
            }
            if(res == "error")
            {
                swal('Error', 'No se realizaron los cambios', 'error');
            }
            if(res == "error_e")
            {
                swal('Error', 'Error en la contraseña', 'error');
            }
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}// fin metodo cargar_modal_password

function actualizar_usuario(){
    var correo = document.getElementById("correoUser").value;
    var nombre = document.getElementById("nombreUser").value;
    var a_paterno = document.getElementById("apUser").value;
    var a_materno = document.getElementById("amUser").value;
    var puesto = document.getElementById("puestoUser").value;
    var privilegio = document.getElementById("privilegioUser").value;

    if((correo != "") && (nombre!="") && (a_paterno!="") && (a_materno!="") && (puesto!="NA") && (privilegio!="NA"))
    {
        nombre = nombre.trim();
        a_paterno = a_paterno.trim();
        a_materno = a_materno.trim();
        
        if (/^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/.test(correo)){
            document.getElementById("correoUser").className = "form-control";
        } else {
            document.getElementById("correoUser").className = "form-control is-invalid";
            return;
        }

        var editar_usuario=document.getElementById("cuerpoModal_editar_usuario");
        var tipo_busqueda_editar="actualizar_usuario";
        var ruta_editar="tipo="+tipo_busqueda_editar+"&correo="+correo+"&nombre="+nombre+"&ap="+a_paterno+"&am="+a_materno+"&puesto="+puesto+"&privilegio="+privilegio;
        $.ajax({
            url:"php_ediciones.php",
            type:"POST",
            data: ruta_editar,
            beforeSend:function(){
                editar_usuario.innerHTML="<center>Actualizando...</center>";
                $('#loader_usuario').show();//mostrar LOADER
            },//fin beforeSend
            success: function(res){
                    if(res == "ok")
                    {
                        swal('Perfecto', 'Se han actualizado los datos', 'success');
                        $('#loader_usuario').hide();
                        $('#btn_cerrarModalUsuario').click();
                        cargar_datos_usuario();
                    }//fin if
                    if(res == "no_cambios")
                    {
                        swal('¿?', 'No realizaste ningun cambio', 'info');
                        $('#btn_cerrarModalUsuario').click();
                    }//fin if
                    if(res == "error")
                    {
                        swal('Error', 'No se realizaron los cambios', 'error');
                        $('#btn_cerrarModalUsuario').click();
                    }//fin if
            },//fin success
            error: function(){
                alert( "Error con el servidor" );
            }//fin error
        });//fin ajax
    }
    else{
        swal('Datos incompletos', 'Por favor rellena todos los datos correctamente', 'warning');
        return;
    }

}// fin metodo actualizar_usuario