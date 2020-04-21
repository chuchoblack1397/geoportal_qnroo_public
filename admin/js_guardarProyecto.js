$(document).ready(function () {
    crearProyecto();
});

function crearProyecto() {
    $('#btn_guardarProyecto').click(function () {
        let nombre = document.getElementById('nombreProyecto').value;
        if (!nombre) {
            alert('Escribe el nombre del proyecto');
            document.getElementById('nombreProyecto').focus();
            return;
        }
        let usuarios = [];
        let capas = [];

        $('#cuerpoTablaAsignacionUsuarioProyecto')
            .find("input[name='inputAsignarUsuarios[]']:checked")
            .each(function () {
                usuarios.push($(this).val());
            });

        $('#cuerpoTablaAsignacionCapaProyecto tr').each(function () {
            if (
                $(this).find('input[name="inputAsignarCapas[]"]:checked').val()
            ) {
                let capa = $(this)
                    .find('input[name="inputAsignarCapas[]"]:checked')
                    .val();
                let zindex = $(this).find('td[name="zindex"]').attr('id');
                capas.push([capa, zindex]);
            } else return;
        });

        if (usuarios.length == 0) {
            alert('Selecciona al menos un usuario');
            return;
        }
        if (capas.length == 0) {
            alert('Selecciona al menos una capa');
            return;
        }
        let Proyecto = {
            nombre: nombre,
            capas: capas,
            usuarios: usuarios,
        };

        enviarDatosGuardar_proyecto(Proyecto);
    });
}

////////////////////// FUNCION AJAX PARA ENVIAR DATOS ///////////////////////////
function enviarDatosGuardar_proyecto(Proyecto) {
    console.log('Dentro de AJAX guardar proyecto');
    $.ajax({
        url: 'php_guardarProyecto.php',
        type: 'POST',
        data: { data: JSON.stringify(Proyecto) },
        success: function (json_data) {
            if (!json_data) {
                console.log('No se ha obtenido un resultado del servidor');
                return;
            }
            let result = JSON.parse(json_data);
            console.log();
            if (result.guardar) {
                $('#formAgregarProyecto')[0].reset();
                $('#formAsignarUsuariosAProyecto')[0].reset();
                $('#formAsignarCapasAProyecto')[0].reset();
                alert('Se ha creado el proyecto exitosamente!');
            } else if (!result.guardar) {
                alert('El proyecto ya existe');
            } else {
                alert(
                    'Ha ocurrido un error en el servidor y no se ha podido crear el proyecto'
                );
            }
            //$('#scripts').html(result);
        },
        error: function () {
            alert('Error con el servidor');
        },
    });
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////
