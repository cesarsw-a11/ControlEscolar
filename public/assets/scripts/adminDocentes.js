'use strict'
const botonGuardarNuevaMateria = `<button type="submit" class="btn btn-primary">Guardar</button>`
const botonGuardarCambios = `<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar()">Guardar</button>`
const botonCerrarModal = `<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>`
const nombreFormulario = $("form").attr("id");
//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    listarDocentes();

    $("#" + nombreFormulario).submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        mandarFormularioConFoto(formData)

        return true;
    });
});

function mandarFormularioConFoto(formData) {
    var files = $('#file')[0].files;
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    if (files.length > 0) {
        formData.append('file', files[0]);
        $.ajax({
            url: base_url+'administrador/guardar',
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
                    $("#modalAgregarDocente").modal("hide");
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

function ui_modalNuevoDocente() {
    limpiarCampos(nombreFormulario);
    $(".modal-title").html("Agregar nuevo docente")
    $(".changePass").hide()
    $("#password").show()
    $(".modal-footer").html(botonGuardarNuevaMateria + botonCerrarModal)
    $("#modalAgregarDocente").modal()

}

function ui_modalEditarDocente(id_docente) {
    $(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".changePass").html(`<button class="btn btn-warning" onclick=ui_mostrarCambiarContraseña(${id_docente})>Cambiar Contraseña</div>`)
    $(".modal-title").html("Editar Docente")
    $("#iddocente").val(id_docente)
    $(".changePass").show()
    $("#password").hide()
    $("#modalAgregarDocente").modal()
    ui_obtenerMateria(id_docente)

}

function ui_mostrarCambiarContraseña(id_docente){
    $(".modal-title-contraseña").html("Editar Contraseña")
    $(".modal-footer").html(`<button class="btn btn-success" onclick="guardarNuevaContraseña(${id_docente})">Guardar</button>`+botonCerrarModal)
    $("#modalCambiarContraseña").modal()
    $.ajax({
        url: base_url+'administrador/obtenerDocentePorId',
        type: 'POST',
        data: { "id": id_docente },
        success: function (response) {
            var data = JSON.parse(response)
            data = data.datos
            $("#cambiarContraseña").val(data.password)

        },
        error: function (error, xhr, status) {

            swal(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        }
    });
}

function guardarNuevaContraseña(id_alumno){
    $.ajax({
        url: base_url+'administrador/cambiarContrasenaDocente',
        type: 'POST',
        data: { "id": id_alumno,"contraseña" : $("#cambiarContraseña").val() },
        success: function (response) {
            swal(
                "Éxito",
                "La contraseña se ha cambiado con éxito..",
                "success"
            );
            $("#modalAgregarDocente").modal("hide");
            $("#modalCambiarContraseña").modal("hide")

        },
        error: function (error, xhr, status) {

            swal(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        }
    });

}

function ui_obtenerMateria(id_docente) {
    $.ajax({
        url: base_url+'administrador/obtenerDocentePorId',
        type: 'POST',
        data: { "id": id_docente },
        success: function (response) {
            var data = JSON.parse(response)
            data = data.datos
            $("#nombre").val(data.nombre)
            $("#appaterno").val(data.appaterno)
            $("#apmaterno").val(data.apmaterno)
            $("#genero").val(data.genero)
            $("#email").val(data.email)
            $("#password").val(data.password)
            $("#estado").val(data.estado)
            $("#password").hide()

        },
        error: function (error, xhr, status) {

            swal(
                "Error",
                "No fue posible guardar sus datos, revise su conexión.",
                "error"
            );
        }
    });

}

function ui_modalEliminarDocente(id_docente) {
    var table = $('#tabla_docentes').DataTable();
    swal({
        title: "Estas seguro?",
        text: "Aun puedes eliminar esta acción.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, estoy seguro",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: base_url+'administrador/eliminarDocente',
                    type: 'POST',
                    data: { "iddocente": id_docente },
                    success: function (response) {
                        var data = JSON.parse(response)
                        if (data.error == false) {
                            swal(
                                "Exito",
                                data.mensaje,
                                "success"
                            );
                            table.ajax.reload();
                        } else {
                            swal(
                                "Error",
                                "No fue posible eliminar sus datos, revise su conexión.",
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
                    }
                });
            } else {
                swal("Cancelado", "Acción cancelada :)", "error");
            }
        });
}

function guardarCambiosEditar() {
    var table = $('#tabla_docentes').DataTable();
    var formData = new FormData($("#" + nombreFormulario)[0])
    var files = $('#file')[0].files;
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    formData.append('file', files[0]);
    $.ajax({
        url: base_url+'administrador/editarDocente',
        type: 'POST',
        data: formData,
        success: function (response) {
            var data = JSON.parse(response)
            if (data.error == false) {
                swal(
                    "Exito",
                    data.mensaje,
                    "success"
                );
                $("#modalAgregarDocente").modal("hide")
                $('#file').val("");
                table.ajax.reload();
            } else {
                swal(
                    "Error",
                    "No fue posible guardar sus datos, revise su conexión.",
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

function listarDocentes() {
    var columnas = [];
    columnas.push({ "data": "nombreDocente" });
    columnas.push({ "data": "email" });
    columnas.push({ "data": "estado" });
    columnas.push({ "data": "acciones" });

    var table = $('#tabla_docentes').DataTable({
        'processing': true,
        // 'serverSide': true,
        'scrollY': "400px",
        'paging': true,
        'ajax': {
            "url": "obtenerDocentes",
            "type": "POST",
            "dataSrc": function (json) {
                for (var i = 0, ien = json.length; i < ien; i++) {
                    json[i]['nombreDocente'] = json[i]['nombre']+" "+json[i]['appaterno']+" "+json[i]['apmaterno']
                    json[i]['estado'] = json[i].estado == 1 ? 'Activo' : 'Inactivo'
                    json[i]['acciones'] = `<button class="btn btn-info" onclick="ui_modalEditarDocente(${json[i].iddocente})">Editar</button>
                <button class="btn btn-danger" onclick="ui_modalEliminarDocente(${json[i].iddocente})">Eliminar</button>`
                }
                return json;
            }
        },
        "columns": JSON.parse(JSON.stringify(columnas))

    });

}

function llenarTabla(response, tipoFormulario) {
    let data = response.data,
        estatusDocente = data.estado == 1 ? 'Activo' : 'Inactivo',
        table = $('#tabla_docentes').DataTable(),
        boton_editar = `<button class="btn btn-info" onclick="ui_modalEditarDocente(${data.iddocente})">Editar</button>
        <button class="btn btn-danger" onclick="ui_modalEliminarDocente(${data.iddocente})">Eliminar</button>`,
        rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
        "nombreDocente": data.nombre+" "+data.appaterno+" "+data.apmaterno,
        "email": data.email,
        "estado": estatusDocente,
        "acciones": boton_editar
    }).draw()

}