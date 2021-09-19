//Cargamos todo el javascript una vez que el DOM esta cargado
$(document).ready(function() {
    //Validamos los datos del formulario para que esten correctos
    $("#login-form").validate({
        usuario:{
            required: true,
            email : true
        },
        //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
        submitHandler : () =>{
            //Obtenemos los valores de los input para enviarlos al backend
            let usuario = $("#usuario").val()
            let password = $("#pass").val()
            let rol = $("#rol").val()
            //Si el rol no tiene ninguna opcion selecionada se retornara false
            if(rol === "-1"){
                swal(
                    "Error",
                    "Es necesario elegir un rol",
                    "error"
                );
                return false;
            }
            $.ajax({
                url:  "login/acceder",
                data :{'nombre' : usuario, 'password' : password, 'rol' : rol },
                type: "POST",
                success: function (response)
                {
                    respuesta = JSON.parse(response)
                    if(respuesta.respuesta == 1){
                        window.location.href = "alumnos"
                    }else if(respuesta.respuesta == 0){
                        swal(
                            "Error",
                            "Favor de revisar sus datos de acceso.",
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
  function guardarAlumnos(){
      //Validamos los datos del formulario para que esten correctos
    $("#guardarAlumnoForm").validate({
        //En caso de que los datos sean llenados y esten correctos del lado del cliente se mandaran al backend para validarlos
        submitHandler : () =>{
            var form = $("#guardarAlumnoForm");
            $.ajax({
                url: 'Alumnos/guardarAlumno',
                type: 'POST',
                data: form.serialize(),
                async: true,
                success: function (data) {
                  data = JSON.parse(data)
    
                  if(data.insertado){
                    swal(
                        "Exito",
                         data.mensaje,
                        "success"
                    );
                  }else{
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
