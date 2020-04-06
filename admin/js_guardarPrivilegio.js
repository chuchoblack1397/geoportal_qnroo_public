console.log("Dentro de archivo JS");

var btn_guardarPrivilegio = document.getElementById('btn_guardarPrivilegio');//boton para guardar capa


btn_guardarPrivilegio.onclick = function(e)
{//funcion para obtener valores de campos y guardarlos
    console.info("-------------Dentro de la funcion CLICK------------");

    //opteniendo el valor de campos
    var campo_privilegio = document.getElementById('campo_privilegio').value;//obligatorio

    var chk_agregar_usuario = document.getElementById('chk_agregar_usuario').checked;
    var chk_ver_usuario = document.getElementById('chk_ver_usuario').checked;
    var chk_editar_usuario = document.getElementById('chk_editar_usuario').checked;
    var chk_eliminar_usuario = document.getElementById('chk_eliminar_usuario').checked;

        if(chk_agregar_usuario){ var chk_agregar_usuario_ok = 'true'; }else{ var chk_agregar_usuario_ok = 'false'; }
        if(chk_ver_usuario){ var chk_ver_usuario_ok = 'true'; }else{ var chk_ver_usuario_ok = 'false'; }
        if(chk_editar_usuario){ var chk_editar_usuario_ok = 'true'; }else{ var chk_editar_usuario_ok = 'false'; }
        if(chk_eliminar_usuario){ var chk_eliminar_usuario_ok = 'true'; }else{ var chk_eliminar_usuario_ok = 'false'; }

    var chk_agregar_capas = document.getElementById('chk_agregar_capas').checked;
    var chk_ver_capas = document.getElementById('chk_ver_capas').checked;
    var chk_editar_capas = document.getElementById('chk_editar_capas').checked;
    var chk_eliminar_capas = document.getElementById('chk_eliminar_capas').checked;

        if(chk_agregar_capas){ var chk_agregar_capas_ok = 'true'; }else{ var chk_agregar_capas_ok = 'false'; }
        if(chk_ver_capas){ var chk_ver_capas_ok = 'true'; }else{ var chk_ver_capas_ok = 'false'; }
        if(chk_editar_capas){ var chk_editar_capas_ok = 'true'; }else{ var chk_editar_capas_ok = 'false'; }
        if(chk_eliminar_capas){ var chk_eliminar_capas_ok = 'true'; }else{ var chk_eliminar_capas_ok = 'false'; }

    var chk_agregar_mapasRef = document.getElementById('chk_agregar_mapasRef').checked;
    var chk_ver_mapasRef = document.getElementById('chk_ver_mapasRef').checked;
    var chk_editar_mapasRef = document.getElementById('chk_editar_mapasRef').checked;
    var chk_eliminar_mapasRef = document.getElementById('chk_eliminar_mapasRef').checked;

        if(chk_agregar_mapasRef){ var chk_agregar_mapasRef_ok = 'true'; }else{ var chk_agregar_mapasRef_ok = 'false'; }
        if(chk_ver_mapasRef){ var chk_ver_mapasRef_ok = 'true'; }else{ var chk_ver_mapasRef_ok = 'false'; }
        if(chk_editar_mapasRef){ var chk_editar_mapasRef_ok = 'true'; }else{ var chk_editar_mapasRef_ok = 'false'; }
        if(chk_eliminar_mapasRef){ var chk_eliminar_mapasRef_ok = 'true'; }else{ var chk_eliminar_mapasRef_ok = 'false'; }

    var chk_agregar_roles = document.getElementById('chk_agregar_roles').checked;
    var chk_ver_roles = document.getElementById('chk_ver_roles').checked;
    var chk_editar_roles = document.getElementById('chk_editar_roles').checked;
    var chk_eliminar_roles = document.getElementById('chk_eliminar_roles').checked;

        if(chk_agregar_roles){ var chk_agregar_roles_ok = 'true'; }else{ var chk_agregar_roles_ok = 'false'; }
        if(chk_ver_roles){ var chk_ver_roles_ok = 'true'; }else{ var chk_ver_roles_ok = 'false'; }
        if(chk_editar_roles){ var chk_editar_roles_ok = 'true'; }else{ var chk_editar_roles_ok = 'false'; }
        if(chk_eliminar_roles){ var chk_eliminar_roles_ok = 'true'; }else{ var chk_eliminar_roles_ok = 'false'; }
   

    if(campo_privilegio != ''){//evalua los campos obligatorios
        console.clear();
        console.warn('Todos los datos obligatorios se encuentran');
        console.log('***');


        if (/\s/.test(campo_privilegio))
        {
            campo_privilegio.className = "form-control is-invalid";
            return;
        }
        else{
            campo_privilegio.className = "form-control is-valid";
        }

        var campo_privilegioOK = campo_privilegio.trim();   
        


        //---creando cadena de ruta de conexion
        var Ruta = "campo_privilegio="+campo_privilegioOK+"&usuario_crear="+chk_agregar_usuario_ok+"&usuario_ver="+chk_ver_usuario_ok+"&usuario_editar="+chk_editar_usuario_ok+"&usuario_eliminar="+chk_eliminar_usuario_ok+"&capas_crear="+chk_agregar_capas_ok+"&capas_ver="+chk_ver_capas_ok+"&capas_editar="+chk_editar_capas_ok+"&capas_eliminar="+chk_eliminar_capas_ok+"&mapas_crear="+chk_agregar_mapasRef_ok+"&mapas_ver="+chk_ver_mapasRef_ok+"&mapas_editar="+chk_editar_mapasRef_ok+"&mapas_eliminar="+chk_eliminar_mapasRef_ok+"&roles_crear="+chk_agregar_roles_ok+"&roles_ver="+chk_ver_roles_ok+"&roles_editar="+chk_editar_roles_ok+"&roles_eliminar="+chk_eliminar_roles_ok;
        
        console.log('Ruta a post :'+Ruta);
        //enviando los datos optenidos
        enviarDatosGuardar_privilegio(Ruta);

    }//fin if
    else{
        userNicknameClass.className = "form-control is-valid";
        info_userNicknameClass = "form-control is-valid";
        userPassClass = "form-control is-valid";
        userPassRepetirClass = "form-control is-valid";
        userNombreClass = "form-control is-valid";
        userAPaternoClass = "form-control is-valid";
        userPrivilegioClass = "form-control is-valid";
        userPuestoClass = "form-control is-valid";
        //si defecta que falta un campo entonces se manda  a evaluar cual campo falta
        if(userNickname == ''){ 
            console.error('FALTA userNickname');
            userNicknameClass.className = "form-control is-invalid";
        }
        if(userPass == ''){
            console.error('FALTA userPass');
            userPassClass.className = "form-control is-invalid";
        }
        if(userPassRepetir == ''){
            console.error('FALTA userPassRepetir');
            userPassRepetirClass.className = "form-control is-invalid";
        }
        if(userNombre == ''){ 
            console.error('FALTA userNombre');
            userNombreClass.className = "form-control is-invalid";
        }
        if(userAPaterno == ''){
            console.error('FALTA userAPaterno');
            userAPaternoClass.className = "form-control is-invalid";
        }
        if(userPrivilegio == ''){
            console.error('FALTA userPrivilegio');
            userPrivilegioClass.className = "form-control is-invalid";
        }
        if(userPuesto == ''){
            console.error('FALTA userPuesto');
            userPuestoClass.className = "form-control is-invalid";
        }
    }//fin else


    
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosGuardar_privilegio(ruta){
    console.log('Dentro de AJAX');
    $.ajax({
        url:'php_guardarPrivilegio.php',
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


