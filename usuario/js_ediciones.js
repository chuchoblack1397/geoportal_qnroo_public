function cargar_modal_usuario() {
    var tipo_busqueda = 'usuario';
    var ruta = 'tipo=' + tipo_busqueda;

    var cuerpoModal_editar_usuario = document.getElementById(
        'cuerpoModal_editar_usuario'
    );
    $.ajax({
        url: 'php_ediciones.php',
        type: 'POST',
        data: ruta,
        beforeSend: function () {
            cuerpoModal_editar_usuario.innerHTML = '';
            $('#loader_usuario').show(); //mostrar LOADER
        },
        success: function (res) {
            cuerpoModal_editar_usuario.innerHTML = res;
            $('#loader_usuario').hide(); //ocultar LOADER
        },
        error: function () {
            alert('Error con el servidor');
        },
    });
} // fin metodo cargar_modal_usuario

function actualizar_password() {
    var tipo_busqueda_password = 'password';

    var passActual = document.getElementById('passActual').value;
    var passNueva = document.getElementById('passNueva').value;
    var passConfirmar = document.getElementById('passConfirmar').value;

    passActual = passActual.trim();
    passNueva = passNueva.trim();
    passConfirmar = passConfirmar.trim();

    if (passActual == '' || passNueva == '' || passConfirmar == '') {
        swal('Faltan campos', 'Por favor rellena todos los campos', 'info');
        return;
    } //fin if

    if (passNueva == passActual) {
        swal('Cuidado', 'Estas usando la misma contraseña', 'warning');
        return;
    } //fin if

    if (passNueva != passConfirmar) {
        swal('Ups', 'La confirmacion no coincide', 'info');
        return;
    } //fin if

    var ruta_password =
        'tipo=' +
        tipo_busqueda_password +
        '&passActual=' +
        passActual +
        '&passNueva=' +
        passNueva;

    var actualizando = document.getElementById('actualizando');

    swal({
        title: 'Advertencia',
        text:
            'Estás a punto de cambiar tu contraseña. ¿Estás seguro de hacerlo?',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'php_ediciones.php',
                type: 'POST',
                data: ruta_password,
                beforeSend: function () {
                    actualizando.innerHTML =
                        '<center><span>Actualizando...</span></center>';
                },
                success: function (res) {
                    if (res == 'ok') {
                        /*
                        swal('Perfecto', 'Se han actualizado los datos', 'success');
                        $("#passActual").val('');
                        $("#passNueva").val('');
                        $("#passConfirmar").val('');
                        actualizando.innerHTML="";
                        $('#btn_cerrarModalPassoword').click();*/
                        swal({
                            title: 'Perfecto',
                            text: 'Se han actualizado los datos',
                            icon: 'success',
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete) {
                                location.href = '../cerrarSesion.php';
                            } else {
                                location.href = '../cerrarSesion.php';
                            }
                        });
                    }
                    if (res == 'error') {
                        swal('Error', 'No se realizaron los cambios', 'error');
                        $('#passActual').val('');
                        $('#passNueva').val('');
                        $('#passConfirmar').val('');
                        actualizando.innerHTML = '';
                        $('#btn_cerrarModalPassoword').click();
                    }
                    if (res == 'error_e') {
                        swal('Error', 'Error en la contraseña', 'error');
                        actualizando.innerHTML = '';
                    }
                },
                error: function () {
                    alert('Error con el servidor');
                },
            }); //fin ajax
        } //fin if
        else {
            $('#passActual').val('');
            $('#passNueva').val('');
            $('#passConfirmar').val('');
            actualizando.innerHTML = '';
            $('#btn_cerrarModalPassoword').click();
        } //fin else
    });
} // fin metodo cargar_modal_password

function actualizar_usuario() {
    var correo = document.getElementById('correoUser').value;
    var nombre = document.getElementById('nombreUser').value;
    var a_paterno = document.getElementById('apUser').value;
    var a_materno = document.getElementById('amUser').value;
    var puesto = document.getElementById('puestoUser').value;
    var privilegio = document.getElementById('privilegioUser').value;

    if (
        correo != '' &&
        nombre != '' &&
        a_paterno != '' &&
        a_materno != '' &&
        puesto != 'NA' &&
        privilegio != 'NA'
    ) {
        nombre = nombre.trim();
        a_paterno = a_paterno.trim();
        a_materno = a_materno.trim();

        if (
            /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/.test(
                correo
            )
        ) {
            document.getElementById('correoUser').className = 'form-control';
        } else {
            document.getElementById('correoUser').className =
                'form-control is-invalid';
            return;
        }

        var editar_usuario = document.getElementById(
            'cuerpoModal_editar_usuario'
        );
        var tipo_busqueda_editar = 'actualizar_usuario';
        var ruta_editar =
            'tipo=' +
            tipo_busqueda_editar +
            '&correo=' +
            correo +
            '&nombre=' +
            nombre +
            '&ap=' +
            a_paterno +
            '&am=' +
            a_materno +
            '&puesto=' +
            puesto +
            '&privilegio=' +
            privilegio;
        $.ajax({
            url: 'php_ediciones.php',
            type: 'POST',
            data: ruta_editar,
            beforeSend: function () {
                editar_usuario.innerHTML = '<center>Actualizando...</center>';
                $('#loader_usuario').show(); //mostrar LOADER
            }, //fin beforeSend
            success: function (res) {
                if (res == 'ok') {
                    swal('Perfecto', 'Se han actualizado los datos', 'success');
                    $('#loader_usuario').hide();
                    $('#btn_cerrarModalUsuario').click();
                    cargar_datos_usuario();
                } //fin if
                if (res == 'no_cambios') {
                    swal('¿?', 'No realizaste ningun cambio', 'info');
                    $('#btn_cerrarModalUsuario').click();
                } //fin if
                if (res == 'error') {
                    swal('Error', 'No se realizaron los cambios', 'error');
                    $('#btn_cerrarModalUsuario').click();
                } //fin if
            }, //fin success
            error: function () {
                alert('Error con el servidor');
            }, //fin error
        }); //fin ajax
    } else {
        swal(
            'Datos incompletos',
            'Por favor rellena todos los datos correctamente',
            'warning'
        );
        return;
    }
} // fin metodo actualizar_usuario

// Subir imagen
$('#foto_geo').submit(function (e) {
    e.preventDefault();
});
function subirImagen() {
    if (!$('#fotografia_georreferenciada')[0].files[0]) {
        $('#imageTooltip').show();
        return;
    }
    var fd = new FormData();
    var files = $('#fotografia_georreferenciada')[0].files[0];
    var nota = $('#nota').val();
    fd.append('file', files);
    fd.append('nota', nota);
    $('#fotografia_georreferenciada').prop('disabled', true);
    $('#nota').prop('disabled', true);
    $('#btn_subirImagen').prop('disabled', true);

    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener(
                'progress',
                function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round(
                            (evt.loaded / evt.total) * 100
                        );
                        //$('#barra_progreso').width(percentComplete +'%');
                        $('#barra_progreso')
                            .attr('aria-valuenow', percentComplete)
                            .css('width', percentComplete + '%');
                        $('#barra_progreso').html(percentComplete + '%');
                    }
                },
                false
            );
            return xhr;
        },
        url: 'php_read_exif.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#barra_progreso').show();
            $('#barra_progreso').attr('aria-valuenow', '0').css('width', '0%');
            $('#barra_progreso').addClass(
                'progress-bar progress-bar-striped bg-info'
            );
        },
        /* uploadProgress: function(event, position, total, percentageComplete){
                $('#barra_progreso').attr('aria-valuenow', percentageComplete).css('width', percentageComplete+'%');
                /*$('#barra_progreso').animate({
                    width: percentageComplete + '%'
                },{
                    duration: 1000
                });
            },*/
        success: function (response) {
            $('#barra_progreso')
                .attr('aria-valuenow', '100')
                .css('width', '100%');
            $('#barra_progreso').addClass(
                'progress-bar progress-bar-striped bg-success'
            );
            if (response != 0) {
                console.log(response);
                if (response == 3) {
                    swal(
                        'Perfecto',
                        'Se ha subido la fotografia al sistema',
                        'success'
                    );

                    $('#modal_subir_fotoGeo').modal('toggle');
                    $('#foto_geo').trigger('reset');
                }
                if (response == 2) {
                    swal(
                        'Error',
                        'No se pudo extraer información exif de la imagen',
                        'error'
                    );
                }
                if (response == 1) {
                    swal(
                        'Error',
                        'No se pudo subir la fotografia al sistema',
                        'error'
                    );
                }
                if (response == 0) {
                    swal('Error', 'La extension no es valida', 'error');
                }
            } else {
                swal(
                    'Error',
                    'No se pudo subir la fotografia al sistema',
                    'error'
                );
            }
            $('#barra_progreso').hide();
            $('#fotografia_georreferenciada').prop('disabled', false);
            $('#nota').prop('disabled', false);
            $('#btn_subirImagen').prop('disabled', false);
        },
    });
}
