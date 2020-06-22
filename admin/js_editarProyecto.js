console.log("Dentro de archivo JS_EDITAR Usuario");

let idproyecto_editar = "";

function modalProyecto(idproyecto){//funcion para obtener valores de campos y eliminarlos
    $('#btn_actualizarProyecto').css('display','block');//habilitando el boton de guardar
    $('#btn_cerrarModalProyecto').css('display','block');//cambiando texto al boton cancelar
    console.log("Editando: "+idproyecto);

    var ruta="idproyecto="+idproyecto;
    
    idproyecto_editar = idproyecto;

    var seccionModalProyecto=document.getElementById("cuerpoModalEditarProyecto");
    $.ajax({
        url:"php_modal_editar_proyecto.php",
        type:"POST",
        data: ruta,
        beforeSend:function(){
            seccionModalProyecto.innerHTML="";
            $('#loader_proyectos_modal').show();//mostrar LOADER
        },
        success: function(res){
            seccionModalProyecto.innerHTML=res;
            $('#loader_proyectos_modal').hide();//ocultar LOADER
        },
        error: function(){
        alert( "Error con el servidor" );
        } 
    });
}



function editarProyecto(){
    console.log("Editando: "+idproyecto_editar);
    let id_proyecto = idproyecto_editar;

    let usuarios_editar = [];
    let capas_editar = [];


    /*if((txt_nombreUser == nombreEditar) && (txt_apUser == apEditar) && (txt_amUser == amEditar) && (txt_puestoUser == puestoEditar) && (txt_privilegioUser == privilegioEditar)){
        swal('¿?', 'No se ha realizado ningun cambio', 'info');
        return;
    }//fin if*/

    //generar arreglo de usuarios
    $('#cuerpoTablaAsignacionUsuarioProyecto_editar')
    .find("input[name='inputAsignarUsuarios_editar[]']:checked")
    .each(function () {
        usuarios_editar.push($(this).val());
        //console.log('insertando usuarios');
    });//fin agregar arreglo de usuarios

    //generar arreglo de capas y zindex
    $('#cuerpoTablaAsignacionCapaProyecto_editar tr').each(function () {
        if (
            $(this).find('input[name="inputAsignarCapas_editar[]"]:checked').val()
        ) {
            let capa_editar = $(this)
                .find('input[name="inputAsignarCapas_editar[]"]:checked')
                .val();
            let zindex_editar = $(this).find('td[name="zindex"]').attr('id');
            capas_editar.push([capa_editar, zindex_editar]);
            //console.log('insertando capas');
        } else return;
    });//fin agregar arreglo de capas

    if (usuarios_editar.length == 0) {
        swal('¿?', 'Selecciona al menos un usuario', 'info');
        return;
    }
    if (capas_editar.length == 0) {
        swal('¿?', 'Selecciona al menos una capa', 'info');
        return;
    }
    let Proyecto_editar = {
        id_proyecto: id_proyecto,
        capas: capas_editar,
        usuarios: usuarios_editar,
    };

    if (Proyecto_editar.length == 0) {
        alert('El arreglo Proyecto_editar está vacio');
        return;
    }
    console.log(Proyecto_editar);
    
    var seccionModalProyecto=document.getElementById("cuerpoModalEditarProyecto");

        console.log('Dentro de AJAX actualizar proyecto');

        $.ajax({
            url: 'php_editar_proyecto_ok.php',
            type: 'POST',
            data: { data: JSON.stringify(Proyecto_editar) },
            beforeSend:function(){
                seccionModalProyecto.innerHTML="<center>Actualizando. Por favor espere...</center>";
                $('#loader_proyectos_modal').show();//mostrar LOADER
                $('#btn_cerrarModalProyecto').css('display','none');//ocultando botones
                $('#btn_actualizarProyecto').css('display','none');//ocultando botones
            },
            success: function (json_data) {
                if (!json_data) {
                    console.log('No se ha obtenido un resultado del servidor');
                    return;
                }
                try {
                    let result = JSON.parse(json_data);
                    if (result.guardar) {
                        $('#scripts').html(result.scripts);
                        console.log('Se ha creado el proyecto exitosamente!');
                        let res = swal(
                            'COMPLETADO!',
                            'Proyecto se ha actualizado con éxito',
                            'success'
                        );
                        $('#respuesta').html(res);
                    } else if (!result.guardar) {
                        console.log('El proyecto ya existe');
                    } else {
                        console.log(
                            'Ha ocurrido un error en el servidor y no se ha podido actualizar el proyecto'
                        );
                        let res = swal(
                            'Error',
                            'Ha ocurrido un error en el servidor y no se ha podido actualizar el proyecto',
                            'error'
                        );
                        $('#respuesta').html(res);
                    }
                } catch (error) {
                    console.error(
                        'Ocurrio un error al procesar la informacion obtenida del server!'
                    );
                }

                $('#loader_proyectos_modal').hide();//ocultar LOADER
                $('#btn_cerrarModalProyecto').click();//dando click al boton cerrar del modal para que se oculte
                ajax_ver_proyectos();//actualizando lista de usuarios
            },
            error: function () {
                seccionModalProyecto.innerHTML="<center>Ha ocurrido un problema...</center>";
                alert('Error con el servidor');
            },
        });//fin ajax
    
}