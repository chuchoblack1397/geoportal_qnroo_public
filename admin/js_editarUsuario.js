console.log("Dentro de archivo JS_EDITAR Usuario");

var usuarioEditar="";
var nombreEditar="";
var apEditar="";
var amEditar="";
var puestoEditar="";
var privilegioEditar="";

function modalUsuario(usuarioR,nombreR,apUR,amUR,puestoR,privilegioR){//funcion para obtener valores de campos y eliminarlos
    console.log("Editando: "+usuarioR+nombreR+apUR+amUR+puestoR+privilegioR);

    var ruta="usuario="+usuarioR+"&nombre="+nombreR+"&ap="+apUR+"&am="+amUR+"&puesto="+puestoR+"&privilegio="+privilegioR;
    
    usuarioEditar=usuarioR;
    nombreEditar=nombreR;
    apEditar=apUR;
    amEditar=amUR;
    puestoEditar=puestoR;
    privilegioEditar=privilegioR;

    var seccionModalUser=document.getElementById("cuerpoModalEditarUsuario");
    $.ajax({
        url:"php_modal_editar_usuario.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            seccionModalUser.innerHTML="Cargando...";
        },
        success: function(res){
            seccionModalUser.innerHTML=res;
            
        },
        error: function(){
          alert( "Error con el servidor" );
      } 
    });
}



function editarUsuario(){
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
    
    var seccionModalUser=document.getElementById("cuerpoModalEditarUsuario");
        //var rutaUpdate="usuario="+usuarioEditar+"&nombre="+txt_nombreUser+"&ap="+txt_apUser+"&am="+txt_amUser+"&puesto="+txt_puestoUser+"&privilegio="+txt_privilegioUser;
        var rutaUpdate="usuario="+txt_usuarioUser;
        $.ajax({
            url:"php_editar_usuario_ok.php",
            type:"POST",
            data: rutaUpdate,
            beforeSend:function(){
                seccionModalUser.innerHTML="Cargando. Por favor espere...";
            },
            success: function(res){
                $('#respuestaUsuario').html(res);
                seccionModalUser.innerHTML=res;
                //$('#modalEditarUsuario').modal('hide');
               // ajax_ver_usuarios();
            },
            error: function(){
              alert( "Error con el servidor" );
          } 
        });
    
    
}