<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="miestilo.css">
</head>
<body>
   <!--ControlPanel-->
   <div id="controlPanel">
              <div id="contenidoControlPanel">
                 <div id="contenidoRadios">
                    <input type="radio" id="radio_csm" name="radioGrupo" value="csm">
                    <label for="radio_csm">CSM</label>
                    <input type="radio" id="radio_calles" name="radioGrupo" value="calles">
                    <label for="radio_calles">Calles</label>
                    <input type="radio" id="radio_grises" name="radioGrupo" value="grises">
                    <label for="radio_grises">Calles</label>
                 </div>
                  

                      <hr>

                  <input type="checkbox" id="chk_wms" name="chkGrupo" value="wms">
                  <label for="chk_wms">WMS</label>
                  <input type="checkbox" id="chk_predios" name="chkGrupo" value="predios">
                  <label for="chk_predios">Predios</label>
                  <input type="checkbox" id="chk_ciudades" name="chkGrupo" value="ciudades">
                  <label for="chk_ciudades">Ciudades</label>
              </div> 
          </div>
          <!--fin controlPanel-->
</body>
<script>
//radioButtons
        var radioButtonControl_csm = document.getElementById('radio_csm');
        radioButtonControl_csm.addEventListener("change", validaRadioButtonControl, false);
        var radioButtonControl_calles = document.getElementById('radio_calles');
        radioButtonControl_calles.addEventListener("change", validaRadioButtonControl, false);

        window.onload = validaRadioButtonControl(); //al cargar la pagina va a validar el boton chekbox

        function validaRadioButtonControl(){//funcion para evaluar el boton chkbox
            var checked_csm = radioButtonControl_csm.checked;
            var checked_calles = radioButtonControl_calles.checked;

            if(checked_csm){
            console.log("CMS");
            }//fin if
            else{
                if(checked_calles){
                    console.log("Calle");
                }//fin if
                else{
                    console.log("Nada");
                }//fin else
            }//fin else

        }//fin funcion validaRadioButtonControl
//fin radiobuttons

//checkbox
        var chkBoxControl_wms = document.getElementById('chk_wms');
        chkBoxControl_wms.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_predios = document.getElementById('chk_predios');
        chkBoxControl_predios.addEventListener("change", validaChkBoxControl, false);
        var chkBoxControl_ciudades = document.getElementById('chk_ciudades');
        chkBoxControl_ciudades.addEventListener("change", validaChkBoxControl, false);
        

        window.onload = validaChkBoxControl(); //al cargar la pagina va a validar el boton chekbox

        function validaChkBoxControl(){//funcion para evaluar el boton chkbox
            var checked_chkBoxControl_wms = chkBoxControl_wms.checked;
            var checked_chkBoxControl_predios = chkBoxControl_predios.checked;
            var checked_chkBoxControl_ciudades = chkBoxControl_ciudades.checked;

            if(checked_chkBoxControl_wms){
                console.log("WMS");
            }//fin if
            else{
                console.log("No-WMS");
            }//fin else

            if(checked_chkBoxControl_predios){
                console.log("Predios");
            }//fin if
            else{
                console.log("No-Predios");
            }//fin else

            if(checked_chkBoxControl_ciudades){
                console.log("Cuidades");
            }//fin if
            else{
                console.log("No-Cuidades");
            }//fin else

        }//fin funcion validaRadioButtonControl
//fin checkbox


</script>
</html>