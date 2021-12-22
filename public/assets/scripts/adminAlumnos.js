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

//Función para validar una CURP
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);

    if (!validado)  //Coincide con el formato general?
        return false;

    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma = 0.0,
            lngDigito = 0.0;
        for (var i = 0; i < 17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }

    if (validado[2] != digitoVerificador(validado[1]))
        return false;

    return true; //Validado
}

function validarTelefono(num) {
    var re = /^\(?(\d{3})\)?[-]?(\d{3})[-]?(\d{4})$/,
        validado = num.match(re);

    if (!validado)  //Coincide con el formato general?
        return false;
    return true
}


function mandarFormularioConFoto(formData) {
    var files = $('#file')[0].files;
    //Validaciones de los selectores a la hora de llenar el formulario
    if ($("#cursando").val() === "-1") {
        swal("Error", "Debe seleccionar un grado", "error")
        return false
    } else if ($("#genero").val() === "-1") {
        swal("Error", "Debe seleccionar un genero", "error")
        return false
    }
    if (!curpValida($("#curp").val())) {
        swal("Error", "La CURP tiene formato incorrecto", "error")
        return false
    }
    if (!validarTelefono($("#cel").val())) {
        swal("Error", "Número de célular incorrecta", "error")
        return false
    }
    if (!validarTelefono($("#emergencia").val())) {
        swal("Error", "Número de emergencia incorrecto", "error")
        return false
    }
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
                    $("#modalAgregarAlumno").modal("hide");
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
    $(".changePass").hide()
    $("#password").show()
    $("#modalAgregarAlumno").modal()

}

function ui_modalEditarAlumno(id_alumno) {
    $(".modal-footer").html(botonGuardarCambios + botonCerrarModal)
    $(".changePass").html(`<button class="btn btn-warning" onclick=ui_mostrarCambiarContraseña(${id_alumno})>Cambiar Contraseña</div>`)
    $(".modal-title").html("Editar alumno")
    $(".changePass").show()
    $("#idalumno").val(id_alumno)
    $("#modalAgregarAlumno").modal()
    ui_obtenerMateria(id_alumno)

}

function ui_obtenerMateria(id_alumno) {
    $.ajax({
        url: base_url+'administrador/obtenerAlumnoPorId',
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
            $('#cel').inputmask('999-999-9999').val(data.numcel)
            $('#emergencia').inputmask('999-999-9999').val(data.emergencia)
            $('#tecnologias').val(data.tecnologias)
            $("#email").val(data.email)
            $("#localidad").val(data.localidad)
            $("#password").hide()
            $("#cursando").val(data.cursando)
            $("#adeudos").val(data.adeudos)
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
function ui_mostrarCambiarContraseña(id_alumno){
    $(".modal-title-contraseña").html("Editar Contraseña")
    $(".modal-footer").html(`<button class="btn btn-success" onclick="guardarNuevaContraseña(${id_alumno})">Guardar</button>`+botonCerrarModal)
    $("#modalCambiarContraseña").modal()
    $.ajax({
        url: base_url+'administrador/obtenerAlumnoPorId',
        type: 'POST',
        data: { "id": id_alumno },
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
        url: 'cambiarContrasena',
        type: 'POST',
        data: { "id": id_alumno,"contraseña" : $("#cambiarContraseña").val() },
        success: function (response) {
            swal(
                "Éxito",
                "La contraseña se ha cambiado con éxito..",
                "success"
            );
            $("#modalCambiarContraseña").modal("hide")
            $("#modalAgregarAlumno").modal("hide");

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
    formData.delete("contraseña")
    var files = $('#file')[0].files;
    if (!curpValida($("#curp").val())) {
        swal("Error", "La CURP tiene formato incorrecto", "error")
        return false
    }
    if (!validarTelefono($("#cel").val())) {
        swal("Error", "Número de célular incorrecta", "error")
        return false
    }
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    formData.append('file', files[0]);
    $.ajax({
        url: base_url+'editarAlumno',
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

function listarAlumnos() {
    var columnas = [];
    columnas.push({ "data": "numcontrol" });
    columnas.push({ "data": "nombre" });
    columnas.push({ "data": "appaterno" });
    columnas.push({ "data": "email" });
    columnas.push({ "data": "genero" });
    columnas.push({ "data": "curp" });
    columnas.push({ "data": "cursando" });
    columnas.push({ "data": "estado" });
    columnas.push({ "data": "acciones" });

    var table = $('#tabla_alumnos').DataTable({
        'processing': true,
        // 'serverSide': true,
        'scrollY': "400px",
        'paging': true,
        'ajax': {
            "url": base_url+"administrador/obtenerAlumnos",
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
        "email" : data.email,
        "genero": data.genero,
        "curp": data.curp,
        "cursando" : data.cursando,
        "estado": estatusAlumno,
        "acciones": boton_editar
    }).draw()

}