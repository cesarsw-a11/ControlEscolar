'use strict'
//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    $('#tabla_alumnos').DataTable();

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
                    llenarTabla(data, data.tipoFormulario)
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

function llenarTabla(response, tipoFormulario) {
    let data = response.data,
        estatusAlumno = data.estado == 1 ? 'Activo' : 'Inactivo',
        table =     $('#tabla_alumnos').DataTable(),
        rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add([
        data.numcontrol,
        data.nombre,
        data.appaterno,
        data.genero,
        data.curp,
        estatusAlumno
    ]).node();
    table.draw();

}