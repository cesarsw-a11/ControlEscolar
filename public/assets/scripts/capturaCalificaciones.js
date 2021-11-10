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
                json[i]['unidad1'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno} data-nombre-columna = "unidad1" contenteditable class="divEditable" >${json[i].unidad1}</div>` 
                json[i]['unidad2'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno} data-nombre-columna = "unidad2" contenteditable class="divEditable" >${json[i].unidad2}</div>` 
                json[i]['unidad3'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno}  data-nombre-columna = "unidad3" contenteditable class="divEditable" >${json[i].unidad3}</div>` 
                json[i]['opc'] = `<div data-id-calificacion = ${json[i].idCalificacion} id = ${json[i].idalumno} data-nombre-columna = "opc" contenteditable class="divEditable" >${json[i].opc}</div>` 
            }
           return json;
        }
    },
    "columns": JSON.parse(JSON.stringify(columnas))
    
});
}

$(document).on('focus', '.divEditable', function(e){
    requestAnimationFrame(() => document.execCommand('selectAll',false,null));
});

$(document).on('keypress', '.divEditable', function(e){
    const keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        e.stopPropagation();
        e.preventDefault();
            
        const idalumno = $(this).attr('id'),
        valorColumna = $(this).text(),
        nombreColumna = $(this).attr('data-nombre-columna'),
        idCalificacion = $(this).attr('data-id-calificacion')

        actualizarRegistroRango(idalumno,valorColumna,nombreColumna,idCalificacion);
    }
});

function animarDescuento(idCelda, tipo = 'exito'){
    let claseAgregar = (tipo == 'exito') ? 'PEL_descuentoActualizadoExito' : 'PEL_descuentoActualizadoError';
    let celdaSelector = `#${idCelda}`;

    $(celdaSelector).removeClass('PEL_descuentoActualizadoError PEL_descuentoActualizadoExito');
    $(celdaSelector).addClass(claseAgregar);

    setTimeout(function() {
        $(celdaSelector).removeClass('PEL_descuentoActualizadoError PEL_descuentoActualizadoExito');
    }, 1000);
}

// Actualiza los datos de celdas de manera lineal
function actualizarRegistroRango(idalumno, valorColumna,nombreColumna,idCalificacion) {
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
