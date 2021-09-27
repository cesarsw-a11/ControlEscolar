'use strict'
const botonGuardarNuevaMateria = `<button type="submit" class="btn btn-primary">Guardar</button>`
const botonGuardarCambios = `<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar()">Guardar</button>`
const botonCerrarModal = `<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>`
const nombreFormulario = $("form").attr("id");
//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(() => {
    //Inicializamos el datatable
    listarAlumnos();

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

function ui_modalNuevoAlumno() {
    limpiarCampos(nombreFormulario);
    $(".modal-title").html("Agregar nuevo alumno")
    $(".modal-footer").html(botonGuardarNuevaMateria + botonCerrarModal)
    $("#modalAgregarAlumno").modal()

}

function ui_modalEditarAlumno(id_alumno) {
    $(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".modal-title").html("Editar alumno")
    $("#idalumno").val(id_alumno)
    $("#modalAgregarAlumno").modal()
    ui_obtenerMateria(id_alumno)

}

function ui_obtenerMateria(id_alumno) {
    $.ajax({
        url: 'obtenerAlumnoPorId',
        type: 'POST',
        data: { "id": id_alumno },
        success: function (response) {
            var data = JSON.parse(response)
            data = data.datos
            $("#num_control").val(data.numcontrol)
            $("#nombre").val(data.nombre)
            $("#app_paterno").val(data.appaterno)
            $("#apmaterno").val(data.apmaterno)
            $("#genero").val(data.genero)
            $("#curp").val(data.curp)
            $("#cel").val(data.numcel)
            $("#email").val(data.email)
            $("#localidad").val(data.localidad)
            $("#password").val(data.password)
            $("#cursando").val(data.cursando)
            $("#estado").val(data.estado)

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

function ui_modalEliminarAlumno(id_alumno) {
    var table = $('#tabla_alumnos').DataTable();
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
                    url: 'eliminarAlumno',
                    type: 'POST',
                    data: { "idalumno": id_alumno },
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
    var table = $('#tabla_alumnos').DataTable();
    var formData = new FormData($("#" + nombreFormulario)[0])
    var files = $('#file')[0].files;
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    formData.append('file', files[0]);
    $.ajax({
        url: 'editarAlumno',
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
                $("#modalAgregarAlumno").modal("hide")
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

function listarAlumnos() {
    var columnas = [];
    columnas.push({ "data": "numcontrol" });
    columnas.push({ "data": "nombre" });
    columnas.push({ "data": "appaterno" });
    columnas.push({ "data": "genero" });
    columnas.push({ "data": "curp" });
    columnas.push({ "data": "estado" });
    columnas.push({ "data": "acciones" });

    var table = $('#tabla_alumnos').DataTable({
        'processing': true,
        // 'serverSide': true,
        'scrollY': "400px",
        'paging': true,
        'ajax': {
            "url": "obtenerAlumnos",
            "type": "POST",
            "dataSrc": function (json) {
                for (var i = 0, ien = json.length; i < ien; i++) {
                    json[i]['estado'] = json[i].estado == 1 ? 'Activo' : 'Inactivo'
                    json[i]['acciones'] = `<button class="btn btn-info" onclick="ui_modalEditarAlumno(${json[i].idalumno})">Editar</button>
                <button class="btn btn-danger" onclick="ui_modalEliminarAlumno(${json[i].idalumno})">Eliminar</button>`
                }
                return json;
            }
        },
        "columns": JSON.parse(JSON.stringify(columnas))

    });

}

function llenarTabla(response, tipoFormulario) {
    let data = response.data,
        estatusAlumno = data.estado == 1 ? 'Activo' : 'Inactivo',
        table = $('#tabla_alumnos').DataTable(),
        boton_editar = `<button class="btn btn-info" onclick="ui_modalEditarAlumno(${data.idalumno})">Editar</button>
        <button class="btn btn-danger" onclick="ui_modalEliminarAlumno(${data.idalumno})">Eliminar</button>`,
        rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
        "numcontrol": data.numcontrol,
        "nombre": data.nombre,
        "appaterno": data.appaterno,
        "genero": data.genero,
        "curp": data.curp,
        "estado": estatusAlumno,
        "acciones": boton_editar
    }).draw()

}