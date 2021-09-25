'use strict'
//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    $('#tabla_docentes').DataTable();

});
var nombreFormulario = $("form").attr("id");

$("#" + nombreFormulario).submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    mandarFormularioConFoto(formData)

    return true;
});

function mandarFormularioConFoto(formData) {
    var files = $('#file')[0].files;
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    if (files.length > 0) {
        formData.append('file', files[0]);
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
    } else {
        swal("Error", "Debe seleccionar una foto.", "error")
    }
}

function llenarTabla(response) {
    let data = response.data
    let estatusDocente = data.estado == 1 ? 'Activo' : 'Inactivo'
    let table =     $('#tabla_docentes').DataTable();
    let rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add([
        data.nombre,
        data.email,
        estatusDocente
    ]).node();
    table.draw();
}