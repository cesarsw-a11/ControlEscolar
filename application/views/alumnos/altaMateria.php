<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4 rounded-circle" src="<?= base_url("imagenes/Logo.jpg"); ?>" alt="" width="150" height="150">
        <h4>Escuela Secundaria Técnica 22,La Huerta</h4>
        <h4>Alta Materias</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="firstName">Alumno:
                <?= $alumno->numcontrol . " - " . $alumno->nombre . " " . $alumno->appaterno . " " . $alumno->apmaterno ?></label>
        </div>
        <div class="col-md-6">
            <label for="lastName">Año cursado: <?= $alumno->cursando ?></label>
        </div>
    </div>
    <input type="text" id="grado" value="<?= $alumno->cursando; ?>" hidden>
    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Materia</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>
<?php $this->load->view("footer"); ?>
<script>
    $(() => {
        listarMaterias()
    })

    function listarMaterias() {
        var columnas = [];
        columnas.push({
            "data": "nombre"
        });
        columnas.push({
            "data": "status"
        });

        var table = $('#tabla_materias').DataTable({
            'processing': true,
            // 'serverSide': true,
            'scrollY': "400px",
            'paging': true,
            'ajax': {
                "url": "obtenerMateriasAlumno/" + $("#grado").val(),
                "type": "POST",
                "dataSrc": function(json) {
                    console.log(json.dadaAlta)
                    for (var i = 0, ien = json.infoMateria.length; i < ien; i++) {
                        var altaMateria = 0
                        var disabled = ""
                        if (json.infoMateria[i].dadaDeAlta == "1") {
                            altaMateria = "checked";
                            disabled = "disabled"
                        }
                        json.infoMateria[i]['nombre'] = `${json.infoMateria[i].nombre}`
                        json.infoMateria[i]['status'] = `<input type="checkbox" id="checkAlta" ${altaMateria} ${disabled} onclick="darAltaMateria(${json.infoMateria[i].idmateria})">`
                    }
                    return json.infoMateria;
                }
            },
            "columns": JSON.parse(JSON.stringify(columnas))

        });

    }

    function darAltaMateria(id_materia) {
        swal({
                title: "Estas seguro?Esta acción no se puede revertir.",
                text: "Aun puedes eliminar esta acción.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, dar de Alta Materia",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: 'darAltaMateria',
                        type: 'POST',
                        data: {
                            "id_materia": id_materia
                        },
                        success: function(response) {
                            var data = JSON.parse(response)
                            if (data.error == false) {
                                swal(
                                    "Exito",
                                    data.mensaje,
                                    "success"
                                );
                                window.location.href = 'altaMateria';
                            } else {
                                swal(
                                    "Error",
                                    "No fue posible eliminar sus datos, revise su conexión.",
                                    "error"
                                );
                            }

                        },
                        error: function(error, xhr, status) {

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
</script>