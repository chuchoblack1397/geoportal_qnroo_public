console.log("Dentro de archivo JS_EDITAR Usuario");

var usuarioEditar="";
var nombreEditar="";
var apEditar="";
var amEditar="";
var puestoEditar="";
var privilegioEditar="";
var correoEditar="";

function modalUsuario(usuarioR,nombreR,apUR,amUR,puestoR,privilegioR,correoR){//funcion para obtener valores de campos y eliminarlos
    $('#btn_actualizarUsuario').css('display','block');//habilitando el boton de guardar
    $('#btn_cerrarModalUsuario').css('display','block');//cambiando texto al boton cancelar
    console.log("Editando: "+usuarioR+nombreR+apUR+amUR+puestoR+privilegioR+correoR);

    var ruta="usuario="+usuarioR+"&nombre="+nombreR+"&ap="+apUR+"&am="+amUR+"&puesto="+puestoR+"&privilegio="+privilegioR+"&correo="+correoR;
    
    usuarioEditar=usuarioR;
    nombreEditar=nombreR;
    apEditar=apUR;
    amEditar=amUR;
    puestoEditar=puestoR;
    privilegioEditar=privilegioR;
    correoEditar=correoR;

    var seccionModalUser=document.getElementById("cuerpoModalEditarUsuario");
    $.ajax({
        url:"php_modal_editar_usuario.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            seccionModalUser.innerHTML="";
            $('#loader_usuarios_modal').show();//mostrar LOADER
        },
        success: function(res){
            seccionModalUser.innerHTML=res;
            $('#loader_usuarios_modal').hide();//ocultar LOADER
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}



function editarUsuario(){
    console.log("Editando: ");
    var txt_usuarioUser = usuarioEditar;
    var txt_nombreUser = document.getElementById("nombreUser").value;
    var txt_apUser = document.getElementById("apUser").value;
    var txt_amUser = document.getElementById("amUser").value;
    var txt_puestoUser = document.getElementById("puestoUser").value;
    var txt_privilegioUser = document.getElementById("privilegioUser").value;
    var txt_correoUser = document.getElementById("correoUser").value;

    console.log("Usuario: "+txt_usuarioUser);
    console.log("Nombre: "+txt_nombreUser);
    console.log("ApPa: "+txt_apUser);
    console.log("ApMa: "+txt_amUser);
    console.log("Puesto: "+txt_puestoUser);
    console.log("Rol: "+txt_privilegioUser);
    console.log("Correo: "+txt_correoUser);


    if((txt_nombreUser == nombreEditar) && (txt_apUser == apEditar) && (txt_amUser == amEditar) && (txt_puestoUser == puestoEditar) && (txt_privilegioUser == privilegioEditar) && (txt_correoUser == correoEditar)){
        swal('¿?', 'No se ha realizado ningun cambio', 'info');
        return;
    }//fin if
    

    if (/^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/.test(txt_correoUser)){
        document.getElementById("correoUser").className = "form-control";
    } else {
        document.getElementById("correoUser").className = "form-control is-invalid";
        return;
    }


        var seccionModalUser=document.getElementById("cuerpoModalEditarUsuario");
        var rutaUpdate="usuario="+txt_usuarioUser+"&nombre="+txt_nombreUser+"&ap="+txt_apUser+"&am="+txt_amUser+"&puesto="+txt_puestoUser+"&privilegio="+txt_privilegioUser+"&correo="+txt_correoUser;
        //var rutaUpdate="usuario="+txt_usuarioUser;
        $.ajax({
            url:"php_editar_usuario_ok.php",
            type:"POST",
            data: rutaUpdate,
            beforeSend:function(){
                seccionModalUser.innerHTML="<center>Actualizando. Por favor espere...</center>";
                $('#loader_usuarios_modal').show();//mostrar LOADER
                $('#btn_cerrarModalUsuario').css('display','none');//ocultando botones
                $('#btn_actualizarUsuario').css('display','none');//ocultando botones
            },
            success: function(res){
                //$('#respuestaUsuario').html(res);
                seccionModalUser.innerHTML=res;
                $('#loader_usuarios_modal').hide();//ocultar LOADER
                $('#btn_cerrarModalUsuario').click();//dando click al boton cerrar del modal para que se oculte
                ajax_ver_usuarios();//actualizando lista de usuarios
                swal(
                    'COMPLETADO!',
                    'El usuario se ha actualizado con éxito',
                    'success'
                );
            },
            error: function()
            {
                alert( "Error con el servidor" );
            } 
        });
    
    
}


function cambiar_password_modal(usuario,userRoot){
    console.log("cargando modal password");

    var cargando_modal_pass=document.getElementById("cuerpoModal_cambiar_password");
    console.log("obteniendo id modal_pass");

    var ruta_modal_password="usuario="+usuario;

    if(usuario == userRoot){
        swal({
            title: "¡CUIDADO!",
            text: "Estás a punto de cambiar tu contraseña de administrador. ¿Estás seguro de hacerlo?. Al cambiarla se cerrará tu sesión",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:"php_modal_editar_password.php",
                    type:"POST",
                    data: ruta_modal_password,
                    beforeSend:function(){
                        $('#btn_cerrarModalUsuario').click();//dando click al boton cerrar del modal para que se oculte
                        $('#loader_pass_modal').show();//mostrar LOADER
                    },
                    success: function(res){
                        cargando_modal_pass.innerHTML=res;
                        $('#loader_pass_modal').hide();//ocultar LOADER
                    },
                    error: function(){
                        alert( "Error con el servidor" );
                    } 
                });//fin ajax
            }//fin if
            else{
                $('#btn_cerrarModalPassoword').click();
            }
            });
    }//fin if
    else{
        $.ajax({
            url:"php_modal_editar_password.php",
            type:"POST",
            data: ruta_modal_password,
            beforeSend:function(){
                $('#btn_cerrarModalUsuario').click();//dando click al boton cerrar del modal para que se oculte
                $('#loader_pass_modal').show();//mostrar LOADER
            },
            success: function(res){
                cargando_modal_pass.innerHTML=res;
                $('#loader_pass_modal').hide();//ocultar LOADER
            },
            error: function(){
                alert( "Error con el servidor" );
            } 
        });//fin ajax
    }
    
}//fin funcion cambiar_password_modal

function cambiar_password(usuario,userRoot){
    console.log("Cambiando password");

    var usuario_actual = usuario;
    var usuario_root = userRoot;

    console.log("Actual: "+usuario_actual+" | Root: "+usuario_root);

    var passNueva = document.getElementById("passNueva").value;
    var passConfirmar = document.getElementById("passConfirmar").value;

    passNueva = passNueva.trim();
    passConfirmar = passConfirmar.trim();

    if((passNueva=="") || (passConfirmar==""))
    {
        swal('Faltan campos', 'Por favor rellena todos los campos', 'info');
        return;
    }//fin if

    if(passNueva != passConfirmar)
    {
        swal('Ups', 'La confirmacion no coincide', 'info');
        return;
    }//fin if

    var ruta_password="usuario="+usuario+"&passNueva="+passNueva;


    swal({
        title: "Advertencia",
        text: "Estás a punto de cambiar una contraseña. ¿Estás seguro de hacerlo?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url:"php_cambiar_password.php",
                type:"POST",
                data: ruta_password,
                beforeSend:function(){
                    $('#loader_pass_modal').show();//mostrar LOADER
                },
                success: function(res){
                    $('#loader_pass_modal').hide();//ocultar LOADER
                    if(res == "ok")
                    {
                        $('#btn_cerrarModalPassoword').click();
                        if(usuario == userRoot){
                            swal({
                                title: "Perfecto",
                                text: "Se han actualizado tu contraseña",
                                icon: "success",
                                buttons: true,
                                dangerMode: true,
                                })
                                .then((willDelete) => {
                                    if (willDelete) {
                                        location.href ="../cerrarSesion.php";
                                    
                                    } else {
                                        location.href ="../cerrarSesion.php";
                                    }
                                });
                            }
                            else{
                                swal('Perfecto', 'Se ha actualizado la contraseña', 'success');
                            }
                        
                        
                    }
                    if(res == "error")
                    {
                        swal('Error', 'No se realizaron los cambios', 'error');
                        $("#passNueva").val('');
                        $("#passConfirmar").val('');
                    }
                    if(res == "repetida")
                    {
                        swal('¿?', 'La contraseña ya existe, intenta de nuevo', 'info');
                    }
                },
                error: function(){
                    alert( "Error con el servidor" );
                } 
            });//fin ajax
        }//fin if
        });

}//fin funcion cambiar_password