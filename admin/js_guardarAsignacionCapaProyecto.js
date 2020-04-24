console.log('Dentro de archivo JS Asignacion');
$(document).ready(function () {
    var btn_asignarCapas_Proyecto = document.getElementById(
        'btn_asignarCapas_Proyecto'
    ); //boton para guardar capa

    btn_asignarCapas_Proyecto.onclick = function (e) {
        //funcion para obtener valores de campos y guardarlos
        console.info(
            '-------------Dentro de la funcion CLICK Asignacion------------'
        );

        //opteniendo el valor de campos
        var capa = document.getElementById('listAsignarCapa').value;
        var chk_vistaTotalAsignada = document.getElementById(
            'chk_vistaTotalAsignada'
        );
        //Creamos un array que almacenará los valores de los input "checked"
        var proyectos = [];
        //Recorremos todos los input checkbox con name = Colores y que se encuentren "checked"
        $('#cuerpoTablaAsignacionProyecto')
            .find("input[name='inputAsignarProyectos[]']:checked")
            .each(function (index) {
                proyectos.push($(this).val());
            });

        if (capa == '') {
            alert('Debe seleccionar una capa');
            return;
        }

        if (proyectos.length == 0) {
            alert('Debe seleccionar al menos un proyecto');
            return;
        } else {
            let jsonData = {
                capa: document.getElementById('listAsignarCapa').value,
                proyectos,
            };
            data = JSON.stringify(jsonData);
            //console.table(proyectos);
            //enviando los datos optenidos
            enviarDatosGuardar_asignacion(data);
        }
    };
});
////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosGuardar_asignacion(data) {
    console.log('Dentro de AJAX Asignacion de capas');
    $.ajax({
        url: 'php_guardarAsignacionCapaProyectos.php',
        type: 'POST',
        data: { data: data },
        success: function (res) {
            checkProyectos();
        },
        error: function () {
            alert('Error con el servidor');
        },
    });
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////
