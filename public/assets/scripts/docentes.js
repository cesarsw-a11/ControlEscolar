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
        $.ajax({
            url: base_url+'administrador/guardar',
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
    columnas.push({"data" : "grupo"});
    columnas.push({"data" : "grado"});
    columnas.push({"data" : "nombreMateria"});
    columnas.push({"data" : "Plan"});
    columnas.push({"data" : "Programa"});
    /* columnas.push({"data" : "Listas"}); */
    columnas.push({"data" : "Captura"});

var table = $('#tabla_materias').DataTable({
    'processing': true,
    // 'serverSide': true,
    'scrollY': "400px",
    'paging': true,
    'ajax': {
        "url": `${base_url}docente/obtenerData`,
        "type": "POST",
        "dataSrc": function (json) {
            for (var i = 0, ien = json.length; i < ien; i++) {
                json[i]['Plan'] = `<h6>Técnica-20 10-224</h6>` 
                json[i]['Programa'] = `<h6>Técnica 22</h6>` 
                /* json[i]['Listas'] = `<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>Listas`  */
                json[i]['Captura'] = `<i class="fa fa-hand-pointer-o fa-lg" aria-hidden="true"></i><a href="${base_url}docente/capturaCalificaciones/${json[i].grado}/${json[i].id_materia}/${json[i].nombreMateria}">Captura</a>` 
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
    $(".modal-title").html("Editar materia")
    $("#idmateria").val(id_materia)
    $("#modalAsignarMateria").modal()
    ui_obtenerMateria(id_materia)
}

function ui_obtenerMateria(id_materia) {
    $.ajax({
        url: base_url+'administrador/obtenerMateriaPorId',
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
        url: base_url+'administrador/editarMateriaDocente',
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
                url: base_url+'administrador/eliminarRelacionMateriaDocente',
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
    let boton_editar = `<button class="btn btn-info" onclick="ui_modalEditarMateria(${data.idAsignacionMateria})">Editar</button>
    <button class="btn btn-danger" onclick="ui_modalEliminarMateria(${data.idAsignacionMateria})">Eliminar</button>`;
    let rowNode;
    //Agregamos la fila a la tabla
    rowNode = table.row.add({
       "nombreDocente": data.datosJoin[0].nombreDocente,
       "nombreMateria":data.datosJoin[0].nombreMateria,
       "botonEditar":boton_editar
    }).draw();
}