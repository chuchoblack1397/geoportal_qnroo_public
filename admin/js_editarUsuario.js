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
            },
            error: function()
            {
                alert( "Error con el servidor" );
            } 
        });
    
    
}