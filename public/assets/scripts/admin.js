//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(()=>{
    //Inicializamos el datatable
    $('#tabla_alumnos').DataTable();

});

$("#guardarAlumnoForm").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);
    var files = $('#file')[0].files;
        
    //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
    if(files.length > 0 ){
       formData.append('file',files[0]);
    $.ajax({
        url: 'administrador/guardarAlumno',
        type: 'POST',
        data: formData,
        success: function (data) {
            data = JSON.parse(data)

            if (data.insertado) {

                alumno = data.alumno

                $("#tabla_alumnos").append(`<tr>
          <td>${alumno.numcontrol}</td>,
          <td>${alumno.nombre}</td>
          <td>${alumno.appaterno}</td>
          <td>${alumno.genero}</td>
          <td>${alumno.curp}</td>
          <td>${alumno.estado}</td>
          </tr>`);

                limpiarCampos();

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
}else{
    swal("Error","Debe seleccionar una foto.","error")
}
});

//Funcion para limpiar todos los inputs al guardar un alumno
function limpiarCampos() {
    $("#genero").val("-1")
    $("#guardarAlumnoForm").find($('input')).val('')
}