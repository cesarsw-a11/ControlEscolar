//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(function () {
    $('#example').DataTable();
    //Validamos los datos del formulario para que esten correctos
    $("#login-form").validate({
        usuario: {
            required: true,
            email: true
        },
        //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
        submitHandler: () => {
            //Obtenemos los valores de los input para enviarlos al backend
            let usuario = $("#usuario").val()
            let password = $("#pass").val()
            let rol = $("#rol").val()
            //Si el rol no tiene ninguna opcion selecionada se retornara false
            if (rol === "-1") {
                swal(
                    "Error",
                    "Es necesario elegir un rol",
                    "error"
                );
                return false;
            }
            $.ajax({
                url: "login/acceder",
                data: { 'nombre': usuario, 'password': password, 'rol': rol },
                type: "POST",
                success: function (response) {
                    respuesta = JSON.parse(response)
                    if (respuesta.respuesta == 1) {
                        window.location.href = "alumnos"
                    } else if (respuesta.respuesta == 0) {
                        swal(
                            "Error",
                            "Favor de revisar sus datos de acceso.",
                            "error"
                        );
                    }else if(respuesta.respuesta == 2){
                        swal(
                            "Error",
                            "Favor de seleccionar el rol correspondiente.",
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
            });
        }
    });
});
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
