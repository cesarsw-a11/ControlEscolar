//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(()=>{
    //Inicializamos el datatable
    $('#tabla_alumnos').DataTable();

});

//Funcion disparada con el evento click del formulario
function guardarAlumnos() {
    //Validamos los datos del formulario para que esten correctos
    $("#guardarAlumnoForm").validate({
        //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
        submitHandler: () => {
            var form = $("#guardarAlumnoForm");
            $.ajax({
                url: 'Alumnos/guardarAlumno',
                type: 'POST',
                data: form.serialize(),
                async: true,
                success: function (data) {
                    data = JSON.parse(data)

                    if (data.insertado) {

                        alumno = data.alumno

                        $("#example").append(`<tr>
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
                }
            });
        }
    });

}

//Funcion para limpiar todos los inputs al guardar un alumno
function limpiarCampos(){
    $("#genero").val("-1")
    $("#guardarAlumnoForm").find($('input')).val('')
}