'use strict'
$(document).ready(() => {
    //Inicializamos el datatable
    listarMaterias()
});

console.log(base_url)
 function listarMaterias(){
    var columnas = [];
    columnas.push({"data" : "numcontrol"});
    columnas.push({"data" : "appaterno"});
    columnas.push({"data" : "apmaterno"});
    columnas.push({"data" : "nombre"});
    columnas.push({"data" : "unidad1"});
    columnas.push({"data" : "unidad2"});
    columnas.push({"data" : "unidad3"});
    columnas.push({"data" : "opc"});
    columnas.push({"data" : "btnCapturar"});

var table = $('#tabla_materias').DataTable({
    'processing': true,
    // 'serverSide': true,
    'scrollY': "400px",
    'paging': true,
    'ajax': {
        "url": `${base_url}docente/obtenerAlumnosmaterias`,
        "type": "POST",
        "dataSrc": function (json) {
            for (var i = 0, ien = json.length; i < ien; i++) {
                json[i]['unidad1'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno} data-nombre-columna = "unidad1"  >${json[i].unidad1}</div>` 
                json[i]['unidad2'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno} data-nombre-columna = "unidad2"  >${json[i].unidad2}</div>` 
                json[i]['unidad3'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno}  data-nombre-columna = "unidad3"  >${json[i].unidad3}</div>` 
                json[i]['opc'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno} data-nombre-columna = "opc"  >${json[i].opc}</div>` 
                json[i]['btnCapturar'] = `<div><button id="btnCapturar" onclick="mostrarModal(${json[i].calificacion},${json[i].idalumno})" class="btn btn-success">Capturar</button></div>`
            }
           return json;
        }
    },
    "columns": JSON.parse(JSON.stringify(columnas))
    
});
}

function mostrarModal(calificacion,idalumno){
    $("#modalCapturaCalificacion").modal()
    $(".modal-footer").html(`<button type="button" class="btn btn-primary" onclick="guardarCambiosEditar(${calificacion},${idalumno},${$("#id_materia").val()})">Guardar</button>`)
    $(".modal-title").html("Capturar Materia")
    $.ajax({
        url: `${base_url}docente/obtenerDataCalificacion`,
        method: 'POST',
        data: { "idCalificacion" : calificacion },
        success: function (data) {
            data = JSON.parse(data)
            console.log(data)
            // Agregar clase a registro
            $("#unidad1").val(data[0].unidad1)
            $("#unidad2").val(data[0].unidad2)
            $("#unidad3").val(data[0].unidad3)
        },
        complete: function(){
            $('#tabla_materias').DataTable().ajax.reload();
        }
    });
}

function guardarCambiosEditar(idCalificacion,idalumno,idmateria) {
    var table = $('#tabla_materias').DataTable();
    var formData = new FormData($("#guardarMateriaForm")[0])
    formData.append("idCalificacion",idCalificacion)
    formData.append("idAlumno",idalumno)
    formData.append("idMateria",idmateria)
    $.ajax({
        url: base_url+'docente/editarCapturaCalificacion',
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
                $("#modalCapturaCalificacion").modal("hide")
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

$(document).on('focus', '.divEditable', function(e){
    requestAnimationFrame(() => document.execCommand('selectAll',false,null));
});

/* $(document).on('click', '#btnCapturar', function(e){

    $("#modalCapturaCalificacion").modal()
    const keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        e.stopPropagation();
        e.preventDefault();
            
        const idalumno = $(this).attr('id'),
        valorColumna = $(this).text(),
        nombreColumna = $(this).attr('data-nombre-columna'),
        idCalificacion = $(this).attr('data-id-calificacion')

        actualizarRegistro(idalumno,valorColumna,nombreColumna,idCalificacion);
    }
}); */

function animarDescuento(idCelda, tipo = 'exito'){
    let claseAgregar = (tipo == 'exito') ? 'div_actualizadoExito' : 'div_actualizadoError';
    let celdaSelector = `#${idCelda}`;

    $(celdaSelector).removeClass('div_actualizadoError div_actualizadoExito');
    $(celdaSelector).addClass(claseAgregar);

    setTimeout(function() {
        $(celdaSelector).removeClass('div_actualizadoError div_actualizadoExito');
    }, 1000);
}

// Actualiza los datos de celdas de manera lineal
function actualizarRegistro(idalumno, valorColumna,nombreColumna,idCalificacion) {
    ui_inicioPeticion();

    var tipoAnimacion = 'error';

    $.ajax({
        url: `${base_url}docente/capturarCalificacion`,
        method: 'POST',
        data: { "idalumno" : idalumno, "valorColumna": valorColumna , "idmateria": $("#id_materia").val(),"nombreColumna" : nombreColumna,"idCalificacion" : idCalificacion },
        success: function (data) {
            // Agregar clase a registro
            ui_exitoPeticion();
            tipoAnimacion = 'exito';
            return true;
        },
        complete: function(){
            $('#tabla_materias').DataTable().ajax.reload();
        }
    });
}

function ui_inicioPeticion() {
    $('#modal_loading').show();
}
function ui_exitoPeticion() {
    $('#modal_loading').hide();
}
