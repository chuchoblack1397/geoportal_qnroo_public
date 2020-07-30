window.onload = cargar_datos_usuario();
window.onload = cargar_proyectos_usuario();
window.onload = cargar_marcadores_usuario();
window.onload = cargar_foto();

function cargar_datos_usuario(){
    var tipo_busqueda="datos";
    var ruta="tipo_busqueda="+tipo_busqueda;

    var datos_usuario=document.getElementById("datos_usuario");
    $.ajax({
        url:"php_cargar_informacion.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            datos_usuario.innerHTML="Cargando...";
        },
        success: function(res){
            datos_usuario.innerHTML=res;
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}

function cargar_foto(){
    var tipo_busqueda="foto";
    var ruta="tipo_busqueda="+tipo_busqueda;

    $.ajax({
        url:"php_cargar_informacion.php",
        type:"POST",
        data: ruta,
        beforeSend: function(){
            document.getElementById('foto_perfil').src="../img/loading.gif";
        },
        success: function(data){
            document.getElementById('foto_perfil').src="imagenes/"+data;
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}

function cargar_proyectos_usuario(){
    var tipo_busqueda="proyectos";
    var ruta="tipo_busqueda="+tipo_busqueda;

    var proyectos_usuario=document.getElementById("proyectos_usuario");
    $.ajax({
        url:"php_cargar_informacion.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            proyectos_usuario.innerHTML="Cargando...";
        },
        success: function(res){
            proyectos_usuario.innerHTML=res;
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}

function cargar_marcadores_usuario(){
    var tipo_busqueda="marcadores";
    var ruta="tipo_busqueda="+tipo_busqueda;

    var marcadores_usuario=document.getElementById("marcadores_usuario");
    $.ajax({
        url:"php_cargar_informacion.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            marcadores_usuario.innerHTML="Cargando...";
        },
        success: function(res){
            marcadores_usuario.innerHTML=res;
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}