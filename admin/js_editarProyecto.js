console.log("Dentro de archivo JS_EDITAR Usuario");


function modalProyecto(idproyecto){//funcion para obtener valores de campos y eliminarlos
    console.log("Editando: "+idproyecto);

    var ruta="idproyecto="+idproyecto;
    

    var seccionModalProyecto=document.getElementById("cuerpoModalEditarProyecto");
    $.ajax({
        url:"php_modal_editar_proyecto.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            seccionModalProyecto.innerHTML="";
            $('#loader_proyectos_modal').show();//mostrar LOADER
        },
        success: function(res){
            seccionModalProyecto.innerHTML=res;
            $('#loader_proyectos_modal').hide();//ocultar LOADER
        },
        error: function(){
        alert( "Error con el servidor" );
        } 
    });
}



function editarProyecto(){
    console.log("Editando: "+usuarioEditar);
    var txt_usuarioUser = usuarioEditar;
    var txt_nombreUser = document.getElementById("nombreUser").value;
    var txt_apUser = document.getElementById("apUser").value;
    var txt_amUser = document.getElementById("amUser").value;
    var txt_puestoUser = document.getElementById("puestoUser").value;
    var txt_privilegioUser = document.getElementById("privilegioUser").value;

    console.log(txt_nombreUser);
    console.log(txt_apUser);
    console.log(txt_amUser);
    console.log(txt_puestoUser);
    console.log(txt_privilegioUser);


    if((txt_nombreUser == nombreEditar) && (txt_apUser == apEditar) && (txt_amUser == amEditar) && (txt_puestoUser == puestoEditar) && (txt_privilegioUser == privilegioEditar)){
        swal('¿?', 'No se ha realizado ningun cambio', 'info');
        return;
    }//fin if
    
    var seccionModalProyecto=document.getElementById("cuerpoModalEditarProyecto");
        //var rutaUpdate="usuario="+usuarioEditar+"&nombre="+txt_nombreUser+"&ap="+txt_apUser+"&am="+txt_amUser+"&puesto="+txt_puestoUser+"&privilegio="+txt_privilegioUser;
        var rutaUpdate="usuario="+txt_usuarioUser;
        $.ajax({
            url:"php_editar_usuario_ok.php",
            type:"POST",
            data: rutaUpdate,
            beforeSend:function(){
                seccionModalProyecto.innerHTML="Cargando. Por favor espere...";
            },
            success: function(res){
                $('#respuestaUsuario').html(res);
                seccionModalProyecto.innerHTML=res;
                //$('#modalEditarUsuario').modal('hide');
               // ajax_ver_usuarios();
            },
            error: function(){
                alert( "Error con el servidor" );
            } 
        });
    
    
}