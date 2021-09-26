'use strict'
//Cargamos todo el javascript una vez que el DOM esta cargado
var botonGuardarNuevaMateria = `<button type="submit" class="btn btn-primary">Guardar</button>`
var botonGuardarCambios = `<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar()">Guardar</button>`
var botonCerrarModal = `<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>`
var nombreFormulario = $("form").attr("id");

$(document).ready(() => {
    //Inicializamos el datatable
    listarMaterias()

    $("#" + nombreFormulario).submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        if (nombreFormulario == "guardarMateriaForm") {
            mandarFormularioSinFoto(formData)
            return true;
        }

    });
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

function listarMaterias(){
    var columnas = [];
    columnas.push({"data" : "clave"});
    columnas.push({"data" : "nombre"});
    columnas.push({"data" : "grado"});
    columnas.push({"data" : "estado"});
    columnas.push({"data" : "botonEditar"});

var table = $('#tabla_materias').DataTable({
    'processing': true,
    // 'serverSide': true,
    'scrollY': "400px",
    'paging': true,
    'ajax': {
        "url": "obtenerMaterias",
        "type": "POST",
        "dataSrc": function (json) {
            for (var i = 0, ien = json.length; i < ien; i++) {
                json[i]['estado'] = json[i].estado == 1 ? 'Activo' : 'Inactivo'
                json[i]['botonEditar'] = `<button class="btn btn-info" onclick="ui_modalEditarMateria(${json[i].idmateria})">Editar</button>
                <button class="btn btn-danger" onclick="ui_modalEliminarMateria(${json[i].idmateria})">Eliminar</button>` 
            }
           return json;
        }
    },
    "columns": JSON.parse(JSON.stringify(columnas))
    
});
}

function ui_modalNuevaMateria() {
    limpiarCampos(nombreFormulario);
    $(".modal-title").html("Agregar nueva materia")
    $(".modal-footer").html(botonGuardarNuevaMateria + botonCerrarModal)
    $("#modalAgregarMateria").modal()

}

function ui_modalEditarMateria(id_materia) {
    $(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".modal-title").html("Editar materia")
    $("#idmateria").val(id_materia)
    $("#modalAgregarMateria").modal()
    ui_obtenerMateria(id_materia)
}

function ui_obtenerMateria(id_materia) {
    $.ajax({
        url: 'obtenerMateriaPorId',
        type: 'POST',
        data: { "id": id_materia },
        success: function (response) {
            var data = JSON.parse(response)
            data = data.datos
            $("#clave").val(data.clave)
            $("#nombre").val(data.nombre)
            $("#grado").val(data.grado)
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

function guardarCambiosEditar() {
    var table = $('#tabla_materias').DataTable();
    var formData = $("#" + nombreFormulario).serialize();
    $.ajax({
        url: 'editarMateria',
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
                $("#modalAgregarMateria").modal("hide")
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

function ui_modalEliminarMateria(id_materia){
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
      function(isConfirm){
        if (isConfirm) {
            $.ajax({
                url: 'eliminarMateria',
                type: 'POST',
                data: {"idmateria":id_materia},
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

function llenarTabla(response) {
    let table = $('#tabla_materias').DataTable();
    let data = response.data
    let estatusMateria = data.estado == 1 ? 'Activo' : 'Inactivo'
    let boton_editar = `<button class="btn btn-info" onclick="ui_modalEditarMateria(${data.idmateria})">Editar</button>
    <button class="btn btn-danger" onclick="ui_modalEliminarMateria(${data.idmateria})">Eliminar</button>`;
    let rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
       "clave": data.clave,
       "nombre":data.nombre,
       "grado":data.grado,
       "estado":estatusMateria,
       "botonEditar":boton_editar
    }).draw();
}