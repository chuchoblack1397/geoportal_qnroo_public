//funcion para cerrar ventana controlPanel
/*var botonCerrarControlPanel = document.getElementById('botonCerrarControl');
botonCerrarControlPanel.addEventListener("change", validaCheckboxControlPanel, false);

var textoBoton = document.getElementById("botonCerrarControl_label");*/

//var checked = botonCerrarControlPanel.checked;
var checked = true;

$("#btnCerrarMenu").click(function(){
  checked = false;
  
  validaBotonControlPanel();
});

$("#btnAbrirMenu").click(function(){
  checked = true;
  
  validaBotonControlPanel();
  document.getElementById("SwipeOcultar").style.display="none";
});

window.onload = validaBotonControlPanel(); //al cargar la pagina va a validar el boton chekbox

function validaBotonControlPanel(){//funcion para evaluar el boton chkbox
  
  if(checked){
    console.log("ABRIENDO MENU");
    document.getElementById('controlMenuPanel').style.left='0px';
    document.getElementById('btnAbrirMenu').style.display='none';
    //textoBoton.innerHTML = "<";
  }//fin if
  else{
    console.log("CERRANDO MENU");
    document.getElementById('controlMenuPanel').style.left='-340px';
    document.getElementById('btnAbrirMenu').style.display='block';
    //textoBoton.innerHTML = ">";
  }
}//fin funcion  cerrar ventana controlPanel

//document.getElementById("SwipeOcultar").style.display="none";