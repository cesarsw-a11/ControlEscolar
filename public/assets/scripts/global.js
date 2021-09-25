'use strict'
//Funcion para limpiar todos los inputs al guardar un alumno
function limpiarCampos(nombreFormulario) {
    let tipoFormulario = $("#formulario").val()
    $("#genero").val("-1")
    $("#" + nombreFormulario).find($('input')).val('')
    $("#formulario").val(tipoFormulario)
}