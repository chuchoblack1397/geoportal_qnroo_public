console.log("Dentro de archivo JS");

var btn_guardarUsuario = document.getElementById('btn_guardarUsuario');//boton para guardar capa


btn_guardarUsuario.onclick = function(e)
{//funcion para obtener valores de campos y guardarlos
    console.info("-------------Dentro de la funcion CLICK------------");

    //opteniendo el valor de campos
    var userNickname = document.getElementById('userNickname').value;//obligatorio
    var userPass = document.getElementById('userPass').value;//obligatorio
    var userPassRepetir = document.getElementById('userPassRepetir').value;//obligatorio
    var userNombre = document.getElementById('userNombre').value;//obligatorio
    var userAPaterno = document.getElementById('userAPaterno').value;//obligatorio
    var userAMaterno = document.getElementById('userAMaterno').value;
    var userPrivilegio = document.getElementById('userPrivilegio').value;//obligatorio
    var userPuesto = document.getElementById('userPuesto').value;//obligatorio
    
    var userNicknameClass = document.getElementById('userNickname');
    var info_userNicknameClass = document.getElementById('info_userNickname');
    var userPassClass = document.getElementById('userPass')
    var userPassRepetirClass = document.getElementById('userPassRepetir');
    var userNombreClass = document.getElementById('userNombre');
    var userAPaternoClass = document.getElementById('userAPaterno');
    var userAMaternoClass = document.getElementById('userAMaterno');
    var userPrivilegioClass = document.getElementById('userPrivilegio');
    var userPuestoClass = document.getElementById('userPuesto');

    if(userNickname != '' && userPass != '' && userPassRepetir != '' && userNombre != '' && userAPaterno != '' && userPrivilegio != '' && userPuesto != ''){//evalua los campos obligatorios
        console.clear();
        console.warn('Todos los datos obligatorios se encuentran');
        console.log('***');


        if (/\s/.test(userNickname))
        {
            userNicknameClass.className = "form-control is-invalid";
            info_userNicknameClass.className = "small text-danger";
            return;
        }
        else{
            userNicknameClass.className = "form-control is-valid";
            info_userNicknameClass.className = "small text-success";
        }

        var userNicknameOK = userNickname.trim();   
        var userPassOK = userPass.trim();
        var userPassRepetirOK = userPassRepetir.trim();
        var userNombreOK = userNombre.trim();
        var userAPaternoOK =userAPaterno.trim();
        var userAMaternoOK = userAMaterno.trim();

        if(userPassOK != userPassRepetirOK){
            userPassClass.className = "form-control is-invalid";
            userPassRepetirClass.className = "form-control is-invalid";
            return;
        }
       
        userPassClass.className = "form-control is-valid";
        userPassRepetirClass.className = "form-control is-valid";
        userNombreClass.className = "form-control is-valid";
        userAPaternoClass.className = "form-control is-valid";
        userAMaternoClass.className = "form-control is-valid";
        userPrivilegioClass.className = "form-control is-valid";
        userPuestoClass.className = "form-control is-valid";

        //---creando cadena de ruta de conexion
        var Ruta = "userNickname="+userNicknameOK+"&userPass="+userPassOK+"&userNombre="+userNombreOK+"&userAPaterno="+userAPaternoOK+"&userAMaterno="+userAMaternoOK+"&userPrivilegio="+userPrivilegio+"&userPuesto="+userPuesto;
        
        console.log('Ruta a post :'+Ruta);
        //enviando los datos optenidos
        enviarDatosGuardar_user(Ruta);

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
function enviarDatosGuardar_user(ruta){
    console.log('Dentro de AJAX');
    $.ajax({
        url:'php_guardarUsuario.php',
        type:'POST',
        data: ruta,
        success: function(res){
<<<<<<< HEAD
          $('#respuestaUsuario').html(res);
=======
          $('#respuesta').html(res);
>>>>>>> Admin Usuario
      },
      error: function(){
        alert( "Error con el servidor" );
    } 
      });
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////

function mostrarAlertas(obj){
    $('.alert').alert('close');
    
    var html = '<div class="alert alert-' + obj.class + ' alert-dismissible fade show" role="alert">'+
        '   <strong>' + obj.message + '</strong>'+
        '       <button class="close" type="button" data-dismiss="alert" aria-label="Close">'+
        '           <span aria-hidden="true">×</span>'+
        '       </button>'
        '   </div>';

    $('#alert').append(html);
}

