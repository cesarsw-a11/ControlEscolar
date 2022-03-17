'use strict'
//Cargamos todo el javascript una vez que el DOM esta cargado
const botonGuardarNuevaMateria = `<button type="submit" class="btn btn-primary" id="btnGuardar">Asignar</button>`
const botonGuardarCambios = `<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar()">Guardar</button>`
const botonCerrarModal = `<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>`
const nombreFormulario = $("form").attr("id");

$(document).ready(() => {
    //Inicializamos el datatable
    listarMaterias()

    $("#" + nombreFormulario).submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        if (nombreFormulario == "asignarMateriaForm") {
            mandarFormularioSinFoto(formData)
            return true;
        }

    });
});

function mandarFormularioSinFoto(formData) {
    if ($("#docente").val() === "-1") {
        swal("Error", "No hay docentes para agregar", "error")
        return false
    }
    if ($("#materia").val() === "-1") {
        swal("Error", "No hay materias para agregar", "error")
        return false
    }
    $.ajax({
        url: base_url + 'administrador/guardar',
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
                $("#modalAsignarMateria").modal("hide")
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

function listarMaterias() {
    var columnas = [];
    columnas.push({ "data": "nombre" });
    columnas.push({ "data": "nombreMaterias" });
    columnas.push({ "data": "botonEditar" });

    var table = $('#tabla_materias').DataTable({
        'processing': true,
        // 'serverSide': true,
        'scrollY': "400px",
        'paging': true,
        'ajax': {
            "url": "obtenerRelacionMateriasDocentes",
            "type": "POST",
            "dataSrc": function (json) {
                for (var i = 0, ien = json.length; i < ien; i++) {
                    json[i]['nombre'] = json[i]['nombreDocente'] + " " + json[i]['appaterno'] + " " + json[i]['apmaterno']
                    json[i]['nombreMaterias'] = json[i]['nombreMateria'] + " " + json[i]['grupo'] + " - " + json[i]['grado'] + "° Grado"
                    json[i]['botonEditar'] = `<button class="btn btn-info" data-toggle="tooltip" title="Editar"  onclick="ui_modalEditarMateria(${json[i].id})"><i class="fa fa-pencil" ></i></button>
                <button class="btn btn-danger"  data-toggle="tooltip" title="Eliminar" onclick="ui_modalEliminarMateria(${json[i].id})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                <button class="btn btn-success"  data-toggle="tooltip" title="Cerrar Materia" onclick="ui_modalCerrarMateria(${json[i].id})"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></button>`
                }
                return json;
            }
        },
        "columns": JSON.parse(JSON.stringify(columnas))

    });
}

function ui_modalAsignarMateria() {
    limpiarCampos(nombreFormulario);
    $(".modal-title").html("Asignar materia a profesor.")
    $("#formulario").val("materiasDocentes")
    $(".modal-footer").html(botonGuardarNuevaMateria + botonCerrarModal)
    $("#modalAsignarMateria").modal()

}

function ui_modalEditarMateria(id_materia) {
    $(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".modal-title").html("Editar asignación de materia al docente")
    $("#idmateria").val(id_materia)
    $("#modalAsignarMateria").modal()
    ui_obtenerMateria(id_materia)
}

function ui_obtenerMateria(id_materia) {
    $.ajax({
        url: base_url + 'administrador/obtenerMateriaPorId',
        type: 'POST',
        data: { "id": id_materia },
        success: function (response) {
            var data = JSON.parse(response)
            data = data.datos
            $("#docente").val(data.id_docente)
            $("#materia").val(data.id_materia)
            $("#id").val(data.id)

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

function guardarCambiosEditar() {
    var table = $('#tabla_materias').DataTable();
    var formData = $("#" + nombreFormulario).serialize();
    $.ajax({
        url: base_url + 'administrador/editarMateriaDocente',
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
                $("#modalAsignarMateria").modal("hide")
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
        }
    });
}

function ui_modalEliminarMateria(id_materia) {
    var table = $('#tabla_materias').DataTable();
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
                    url: base_url + 'administrador/eliminarRelacionMateriaDocente',
                    type: 'POST',
                    data: { "idmateria": id_materia },
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

function ui_modalCerrarMateria(id_materia) {
    var table = $('#tabla_materias').DataTable();
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
                    url: base_url + 'administrador/cambiarEstadoMateria',
                    type: 'POST',
                    data: { "idmateria": id_materia },
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
                    }
                });
            } else {
                swal("Cancelado", "Acción cancelada :)", "error");
            }
        });
}

function llenarTabla(response) {
    let table = $('#tabla_materias').DataTable();
    let data = response.data
    let boton_editar = `<button class="btn btn-info" data-toggle="tooltip" title="Editar"  onclick="ui_modalEditarMateria(${data.idAsignacionMateria})"><i class="fa fa-pencil" ></i></button>
    <button class="btn btn-danger"  data-toggle="tooltip" title="Eliminar" onclick="ui_modalEliminarMateria(${data.idAsignacionMateria})"><i class="fa fa-trash" aria-hidden="true"></i></button>
    <button class="btn btn-success"  data-toggle="tooltip" title="Cerrar Materia" onclick="ui_modalCerrarMateria(${data.idAsignacionMateria})"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></button>`;
    let rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
        "nombre": data.datosJoin[0].nombreDocente + " " + data.datosJoin[0].appaterno + " " + data.datosJoin[0].apmaterno,
        "nombreMaterias": data.datosJoin[0].nombreMateria + " " + data.datosJoin[0].grupo + " - " + data.datosJoin[0].grado + "° Grado",
        "botonEditar": boton_editar
    }).draw();
}