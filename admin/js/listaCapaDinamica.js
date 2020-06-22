let nuevoOrden = [];
let nuevoZindex  = [];

$('#listaCapa_orden').sortable({

    start: function (event, ui) {
        var start_pos = ui.item.index();
        ui.item.data('start_pos', start_pos);
    },//fin start
    change: function (event, ui) {
        var start_pos = ui.item.data('start_pos');
        var index = ui.placeholder.index();
        if (start_pos < index) {
            $('#listaCapa_orden li:nth-child(' + index + ')').addClass('highlights');
        }//fin if
        else {
            $('#listaCapa_orden li:eq(' + (index + 1) + ')').addClass('highlights');
        }//else
    },//fin change
    update: function (event, ui) {
        $('#listaCapa_orden li').removeClass('highlights');

        var ordenElementos = $(this).sortable('toArray');
        var numCapa = 100;

        nuevoOrden = [];//reiniciando el orden de capas a 0
        nuevoZindex  = [];
        for (i = 0; i < ordenElementos.length; i++) {
            nuevoZindex.push(numCapa);
            console.log(numCapa+' - '+ordenElementos[i]);
            numCapa = numCapa - 1;
            nuevoOrden.push(ordenElementos[i]);

        } //fin for
    },//fin update
});

function guardarOrdenCapas() {

    let proyecto = document.getElementById('select_proyecto_orden_capas').value;

    let orden = {
        proyecto : proyecto,
        capas : nuevoOrden
    };

    if(nuevoOrden == ''){//evaluando si existen cambios en el arreglo de capa
        console.log("No hay cambios");
        swal('¿?', 'No se ha realizado ningun cambio', 'info');
        return;
    }else{
        $.ajax({
            type: "POST",
            url: "php_guardarOrdenCapas.php",
            data: {'orden': JSON.stringify(orden)},//capturo array
            beforeSend: function(){
                document.getElementById("listaCapa_orden").innerHTML="<center>Actualizando el orden de capas. <br> Por favor espere...</center>";//vaciar la tabla
                $('#loader_orden_capas').show();//mostrar LOADER
                $('#btn_guardarOrdenCapas').hide();//mostrar LOADER
            },
            success: function(json_data){
                if (!json_data) {
                    console.log('No se ha obtenido un resultado del servidor');
                    return;
                }//fin if
                try {
                    let result = JSON.parse(json_data);
                    if (result.guardar) {
                        console.log('Se ha creado el proyecto exitosamente!');
                        swal(
                            'COMPLETADO!',
                            'Proyecto se han realizado los cambios',
                            'success'
                        );
                        select_proyecto_ordenar();
                    }//fin if
                    else{
                        swal(
                            'Error!',
                            'No se pudo actualizar!',
                            'warning'
                        );
                    }//fin else
                }//fin try
                catch (error) {
                    console.log('Ocurrio un error al procesar la informacion obtenida del server!');
                }//fin catch

            //let result = JSON.parse(data);
            //console.log(result);
            }//fin success
        });// fin ajax
    }//fin else
    //console.log(nuevoOrden); 
    
}
