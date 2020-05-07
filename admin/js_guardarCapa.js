console.log("Dentro de archivo JS");

var btn_guardarCapa = document.getElementById('btn_guardarCapa');//boton para guardar capa

//opteniendo el estado inicial del formato de capa
var radioPNGCapa = document.getElementById('pgnCapa');
radioPNGCapa.addEventListener("change", activaTransparencia, false);
var radioJPEGCapa = document.getElementById('jpegCapa');
radioJPEGCapa.addEventListener("change", activaTransparencia, false);
var checked_png = true;
var checked_jpeg = false;
//--------


btn_guardarCapa.onclick = function(e)
{//funcion para obtener valores de campos y guardarlos
    console.info("-------------Dentro de la funcion CLICK------------");

    //opteniendo el valor de campos
    var tituloCapa = document.getElementById('tituloCapa').value;
    var urlCapa = document.getElementById('urlCapa').value;
    var capaCapa = document.getElementById('capaCapa').value;
    var estiloCapa = document.getElementById('estiloCapa').value;
    var versionCapa = document.getElementById('versionCapa').value;
    var transparenciaCapa = document.getElementById('transparenciaCapa').checked;
    var leyenda = document.getElementById('leyendaCapa').value;
    var chkConsulta = document.getElementById('chk_consultaCapa').checked;
    var campoConsulta = document.getElementById('consultaCapa').value;
    

    var tituloCapaClass = document.getElementById('tituloCapa');
    var urlCapaClass = document.getElementById('urlCapa');
    var capaCapaClass = document.getElementById('capaCapa');
    var campoConsultaClass=document.getElementById('consultaCapa');

    var formatoCapa='';

    if(tituloCapa != '' && urlCapa != '' && capaCapa != ''){//evalua los campos obligatorios
        console.clear();
        console.warn('Todos los datos obligatorios se encuentran');
        console.log('***');

        

        var idCapa = 'capa_'+arreglarCadenas(tituloCapa);
        var idCapaOK = quitarAcentos(idCapa);
        console.log('ID capa : ' + idCapaOK);

        //var tituloCapaOK = reemplazarAcentosHTML(tituloCapa);//funcion POSIBLE
        console.log('Titulo de capa : ' + tituloCapa);
        tituloCapaClass.className = "form-control is-valid";

        var UrlCapaOK = arreglarCadenas(urlCapa);
        console.log('Url de capa : ' + UrlCapaOK);
        urlCapaClass.className = "form-control is-valid";

        var capaCapaOK = arreglarCadenas(capaCapa);
        console.log('Capa de capa : ' + capaCapaOK);
        capaCapaClass.className = "form-control is-valid";

        var estiloCapaOK = arreglarCadenas(estiloCapa);
        console.log('Estilo de capa : ' + estiloCapaOK);

        var versionCapaOK = arreglarCadenas(versionCapa);
        console.log('Version de capa : ' + versionCapaOK);

        //evaluando el formato
        if(checked_png){
            formatoCapa = 'image/png';
            console.log('Formato de Capa :'+formatoCapa);
            //evaluando transparencia
            if(transparenciaCapa){
                console.log('Transparencia de Capa :'+transparenciaCapa);
            }//fin if
            else{
                console.log('Transparencia de Capa :'+transparenciaCapa);
            }//fin else

        }//fin if
        else{
            formatoCapa = 'image/jpeg';
            console.log('Formato de Capa :'+formatoCapa);
        }//fin esle

        //var chkConsulta_ok=''
        if(chkConsulta){
            console.log('Consulta :'+chkConsulta);
            if(campoConsulta != ''){
                campoConsultaClass.className = "form-control is-valid";
                console.log('Campo consulta :'+campoConsulta);
            }//fin if
            else{
                console.error('FALTA Campo de consulta');
                campoConsultaClass.className = "form-control is-invalid";
                return;
            }//fin else
            
        }//fin if
        else{
            console.log('Consulta :'+chkConsulta);
            campoConsulta = '';
            console.log('Campo consulta :'+campoConsulta);
        }//fin else

        console.log('***');
        
        //---creando cadena de ruta de conexion
        var Ruta = "idCapa="+idCapaOK+"&tituloCapaOK="+tituloCapa+"&UrlCapaOK="+UrlCapaOK+"&capaCapaOK="+capaCapaOK+
        "&estiloCapaOK="+estiloCapaOK+"&versionCapaOK="+versionCapaOK+"&formatoCapa="+formatoCapa+
        "&transparenciaCapa="+transparenciaCapa+"&leyenda="+leyenda+"&chkConsulta="+chkConsulta+"&campoConsulta="+campoConsulta;
        
        console.log('Ruta a post :'+Ruta);
        //enviando los datos optenidos
        enviarDatosGuardar_guardar(Ruta);

    }//fin if
    else{
        tituloCapaClass.className = "form-control is-valid";
        urlCapaClass.className = "form-control is-valid";
        capaCapaClass.className = "form-control is-valid";
        //si defecta que falta un campo entonces se manda  a evaluar cual campo falta
        if(tituloCapa == ''){ 
            console.error('FALTA Titulo de capa');
            tituloCapaClass.className = "form-control is-invalid";
        }
        if(urlCapa == ''){
            console.error('FALTA Url de capa');
            urlCapaClass.className = "form-control is-invalid";
        }
        if(capaCapa == ''){
            console.error('FALTA Capa de capa');
            capaCapaClass.className = "form-control is-invalid";
        }
    }//fin else


    
}

window.onload = activaTransparencia();

//funcion para activar o desactivar la opcion de transparencia
//dependiendo del tipo de formato seleccionado
function activaTransparencia(){
    checked_png = radioPNGCapa.checked;//detecta formato png
    checked_jpeg = radioJPEGCapa.checked;//detecta formato jpeg

    if(checked_png){
        console.info('Transparencia ACTIVADA');
        $("#transparenciaCapa").prop("disabled", false);//ACTIVA
        $("#transparenciaCapa").prop("checked", true);//SELECCIONA
    }//fin if
    if(checked_jpeg){
        console.warn('Transparencia DES-ACTIVADA');
        $("#transparenciaCapa").prop("disabled", true);//DESACTIVA
        $("#transparenciaCapa").prop("checked", false);//DESELECCIONA
    }//fin if
    
}

//--Funcion para limpiar las cadenas de texto de espacios enblanco
function arreglarCadenas(cadenaOriginal){
    var cadenaTrim = cadenaOriginal.trim();//limpia la cadena de espacios al inicio y al final

    var patron = / /g; //detecta el espacio
    var nuevoValor = "_"; //sustituye el espacio por _
    var cadenaNueva = cadenaTrim.replace(patron, nuevoValor);//detecta los espacios y sustituye la cadena original

    return  cadenaNueva;//retorna el valor obtenido de la cadena nueva
}

function quitarAcentos(cadena){
	var charsQuitar={
		"á":"a", "é":"e", "í":"i", "ó":"o", "ú":"u",
		"à":"a", "è":"e", "ì":"i", "ò":"o", "ù":"u", "ñ":"n",
		"Á":"A", "É":"E", "Í":"I", "Ó":"O", "Ú":"U",
		"À":"A", "È":"E", "Ì":"I", "Ò":"O", "Ù":"U", "Ñ":"N"}

	var exprQuitar=/[áàéèíìóòúùñ]/ig;
	var resQuitar=cadena.replace(exprQuitar,function(e){return charsQuitar[e]});
	return resQuitar;
}

function reemplazarAcentosHTML(cadena){//funcion POSIBLE!!!! NO ESTOY EJECUTANDOLA
	var charsReemplazar={

		"á":"&aacute;", "é":"&eacute;", "í":"&iacute;", "ó":"&oacute;", "ú":"&uacute;",
		"à":"&aacute;", "è":"&eacute;", "ì":"&iacute;", "ò":"&oacute;", "ù":"&uacute;", "ñ":"&ntilde;",
		"Á":"&Aacute;", "É":"&Eacute;", "Í":"&Iacute;", "Ó":"&Oacute;", "Ú":"&Uacute;",
		"À":"&Aacute;", "È":"&Eacute;", "Ì":"&Iacute;", "&Òacute;":"&Oacute;", "Ù":"&Uacute;", "Ñ":"&Ntilde;"}

	var exprReemplazar=/[áàéèíìóòúùñ]/ig;
	var resReemplazar=cadena.replace(exprReemplazar,function(e){return charsReemplazar[e]});
	return resReemplazar;
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosGuardar_guardar(ruta){
    console.log('Dentro de AJAX');
    $.ajax({
        url:'guardarCapa_guardar.php',
        type:'POST',
        data: ruta,
        success: function(res){
          $('#respuesta').html(res);
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

//--metodo obtener chek de consulta
var checkboxConsulta = document.getElementById('chk_consultaCapa');
checkboxConsulta.addEventListener("change", validaCheckboxConsulta, false);

function validaCheckboxConsulta(){
  var checkedConsulta = checkboxConsulta.checked;
  if(checkedConsulta){
    console.log("Consulta ON");
    document.getElementById("consultaCapa").removeAttribute('disabled');
  }
  else{
    console.log("Consulta OFF");
    document.getElementById("consultaCapa").setAttribute('disabled', 'disabled');
  }
}
//--fin metodo obtener chek de consulta

