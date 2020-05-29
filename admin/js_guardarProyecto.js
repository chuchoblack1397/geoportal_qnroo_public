$(document).ready(function () {
    crearProyecto();
});

function crearProyecto() {
    $('#btn_guardarProyecto').click(function () {
        let nombre = document.getElementById('nombreProyecto').value;
        if (!nombre) {
            swal('¿?', 'Escribe el nombre del proyecto', 'info');
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


        if (capas.length == 0) {
            swal('¿?', 'Selecciona al menos una capa', 'info');
            return;
        }

        if (usuarios.length == 0) {
            swal('¿?', 'Selecciona al menos un usuario', 'info');
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
            try {
                let result = JSON.parse(json_data);
                if (result.guardar) {
                    $('#formAgregarProyecto')[0].reset();
                    $('#formAsignarUsuariosAProyecto')[0].reset();
                    $('#formAsignarCapasAProyecto')[0].reset();
                    $('#scripts').html(result.scripts);
                    console.log('Se ha creado el proyecto exitosamente!');
                    let res = swal(
                        'COMPLETADO!',
                        'Proyecto se ha creado con éxito',
                        'success'
                    );
                    $('#respuesta').html(res);
                } else if (!result.guardar) {
                    console.log('El proyecto ya existe');
                    let res = swal(
                        'Error!',
                        'El proyecto ya existe!',
                        'warning'
                    );
                    $('#respuesta').html(res);
                    $('#nombreProyecto').focus();
                } else {
                    console.log(
                        'Ha ocurrido un error en el servidor y no se ha podido crear el proyecto'
                    );
                    let res = swal(
                        'Error',
                        'Ha ocurrido un error en el servidor y no se ha podido crear el proyecto',
                        'error'
                    );
                    $('#respuesta').html(res);
                }
            } catch (error) {
                console.log(
                    'Ocurrio un error al procesar la informacion obtenida del server!'
                );
            }
        },
        error: function () {
            alert('Error con el servidor');
        },
    });
}
////////////////////// fin FUNCION AJAX PARA ENVIAR DATOS ////////////////////////
