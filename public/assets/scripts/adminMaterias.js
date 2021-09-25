'use strict'
//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    $('#tabla_materias').DataTable();

   var nombreFormulario = $("form").attr("id");

    $("#" + nombreFormulario).submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        if (nombreFormulario == "guardarMateriaForm") {
            mandarFormularioSinFoto(formData)
            return true;
        }

    });

function mandarFormularioSinFoto(formData) {
    $.ajax({
        url: 'guardar',
        type: 'POST',
        data: formData,
        success: function (data) {
            data = JSON.parse(data)

            if (data.insertado) {
                llenarTabla(data)
                limpiarCampos(nombreFormulario);

                swal(
                    "Exito",
                    data.mensaje,
                    "success"
                );
            } else {
                swal(
                    "Error",
                    data.mensaje,
                    "error"
                );
            }
        },
        error: function (error, xhr, status) {

            swal(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

});

function llenarTabla(response) {
    let data = response.data
    let estatusMateria = data.estado == 1 ? 'Activo' : 'Inactivo'
    let table =     $('#tabla_materias').DataTable();
    let rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add([
        data.clave,
        data.nombre,
        data.grado,
        estatusMateria
    ]).node();
    table.draw();
}