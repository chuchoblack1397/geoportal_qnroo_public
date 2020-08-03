console.log("Dentro de archivo JS_EDITAR Capa");

var id_capa_editar="";
var titulo_capa_editar="";
var url_capa_editar="";
var layer_capa_editar="";
var estilo_capa_editar="";
var version_capa_editar="";
var transparencia_capa_editar="";
var formato_capa_editar="";
var leyenda_capa_editar="";
var activo_consulta_editar="";
var consulta_capa_editar="";

function editarCapa(id_capaR,titulo_capaR,url_capaR,layerR,estiloR,versionR,transpR,formatoR,leyendaR,activoConsultaR,consultaR){//funcion para obtener valores de campos y eliminarlos
    $('#btn_actualizarCapa').css('display','block');//habilitando el boton de guardar
    $('#btn_cerrarModalCapa').css('display','block');//cambiando texto al boton cancelar
    
    console.log("Editando: "+id_capaR);
    var ruta="id_capa="+id_capaR+"&titulo_capa="+titulo_capaR+"&url="+url_capaR+"&layer="+layerR+"&estilo="+estiloR+"&version="+versionR+"&transparencia="+transpR+"&formato="+formatoR+"&leyenda="+leyendaR+"&activoConsulta="+activoConsultaR+"&consulta="+consultaR;

    id_capa_editar=id_capaR;
    titulo_capa_editar=titulo_capaR;
    url_capa_editar=url_capaR;
    layer_capa_editar=layerR;
    estilo_capa_editar=estiloR;
    version_capa_editar=versionR;
    transparencia_capa_editar=transpR;
    if(formatoR == "image/png"){formato_capa_editar="png";}
    if(formatoR == "image/jpeg"){formato_capa_editar="jpeg";}
    leyenda_capa_editar=leyendaR;
    activo_consulta_editar = activoConsultaR;
    consulta_capa_editar=consultaR;



    var seccionModalUser=document.getElementById("cuerpoModalEditarCapa");
    $.ajax({
        url:"php_modal_editar_capa.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            seccionModalUser.innerHTML="";
            $('#loader_capas_modal').show();//mostrar LOADER
        },
        success: function(res){
            seccionModalUser.innerHTML=res;
            $('#loader_capas_modal').hide();//ocultar LOADER
        },
        error: function(){
            alert( "Error con el servidor" );
        } 
    });
}

//metodo para chk consulta editar
function validaCheckboxConsulta_editar(chk){
if (chk.checked) {
    console.log("Consulta ON");
    document.getElementById("consultaCapa_editar_ok").removeAttribute('disabled');
    
  }
  else{
    console.log("Consulta OFF");
    document.getElementById("consultaCapa_editar_ok").setAttribute('disabled', 'disabled');
    document.getElementById("consultaCapa_editar_ok").value="";
  }

}//fin metodos

function activar_png_jpeg(radio_button){
    if(radio_button.value=="png"){
        console.info('Transparencia ACTIVADA');
        $("#transparenciaCapa_editar").prop("disabled", false);//ACTIVA
        $("#transparenciaCapa_editar").prop("checked", true);//SELECCIONA
    }
    if(radio_button.value=="jpeg"){
        console.warn('Transparencia DES-ACTIVADA');
        $("#transparenciaCapa_editar").prop("disabled", true);//DESACTIVA
        $("#transparenciaCapa_editar").prop("checked", false);//DESELECCIONA
    }
}

//var btn_actualizarCapa = document.getElementById('btn_actualizarCapa');//boton para guardar capa

//--ACTUALIZAR CAPA
function actualizar_capa()
{
    console.log("ACTUALIZANDO CAPA");
    
    var titulo_capa_ok = document.getElementById("tituloCapa_editar").value;
    var urlCapa_editar_ok = document.getElementById("urlCapa_editar").value;
    var capaCapa_editar = document.getElementById("capaCapa_editar").value;
    var estiloCapa_editar_ok = document.getElementById("estiloCapa_editar").value;
    var versionCapa_editar_ok = document.getElementById("versionCapa_editar").value;
    var pgnCapa_editar = document.getElementById("pgnCapa_editar");
    var jpegCapa_editar = document.getElementById("jpegCapa_editar");
    if(pgnCapa_editar.checked){ var formato_capa_editar_ok = pgnCapa_editar.value;}
    if(jpegCapa_editar.checked){ var formato_capa_editar_ok = jpegCapa_editar.value;}
    var transparenciaCapa = document.getElementById("transparenciaCapa_editar").checked;
    if(transparenciaCapa){var transparenciaCapa_editar_ok = "true";}else{var transparenciaCapa_editar_ok = "false";}
    var leyendaCapa_editar_ok = document.getElementById("leyendaCapa_editar").value;
    var chk_consultaCapa = document.getElementById("chk_consultaCapa_editar_ok").checked;
    if(chk_consultaCapa){var chk_consultaCapa_editar_ok = "true";}else{var chk_consultaCapa_editar_ok = "false";}
    var consultaCapa_editar_ok = document.getElementById("consultaCapa_editar_ok").value;

    if((titulo_capa_ok == titulo_capa_editar) && (urlCapa_editar_ok==url_capa_editar) && (capaCapa_editar==layer_capa_editar) && (estiloCapa_editar_ok==estilo_capa_editar) && (versionCapa_editar_ok==version_capa_editar) && (formato_capa_editar_ok==formato_capa_editar) && (transparenciaCapa_editar_ok==transparencia_capa_editar) && (leyendaCapa_editar_ok==leyenda_capa_editar) && (chk_consultaCapa_editar_ok==activo_consulta_editar) && (consultaCapa_editar_ok==consulta_capa_editar) ){
        swal('¿?', 'No se ha realizado ningun cambio', 'info');
        return;
    }//fin if
    else{
        titulo_capa_ok = titulo_capa_ok.trim();
        consultaCapa_editar_ok = consultaCapa_editar_ok.trim();


        var seccionModalCapa=document.getElementById("cuerpoModalEditarCapa");
        var ruta = "idcapa="+id_capa_editar+"&titulo="+titulo_capa_ok+"&url="+urlCapa_editar_ok+"&layer="+capaCapa_editar+"&estilo="+estiloCapa_editar_ok+"&version="+versionCapa_editar_ok+"&formato="+formato_capa_editar_ok+"&transp="+transparenciaCapa_editar_ok+"&leyenda="+leyendaCapa_editar_ok+"&activa_consulta="+chk_consultaCapa_editar_ok+"&consulta="+consultaCapa_editar_ok;

        $.ajax({
                url:'php_editar_capa_ok.php',
                type:'POST',
                data: ruta,
                beforeSend:function(){
                    seccionModalCapa.innerHTML="<center>Actualizando. Por favor espere...</center>";
                    $('#loader_capas').show();//mostrar LOADER
                    $('#btn_cerrarModalCapa').css('display','none');//ocultando botones
                    $('#btn_actualizarCapa').css('display','none');//ocultando botones
                },
                success: function(res){
                //$('#respuesta').html(res);
                    seccionModalCapa.innerHTML=res;
                    $('#loader_capas').hide();//ocultar LOADER
                    $('#btn_cerrarModalCapa').click();//dando click al boton cerrar del modal para que se oculte
                    ajax_ver_capas();//actualizando lista de usuarios
            },
            error: function(){
                alert( "Error con el servidor" );
            } 
        });
    }


}


