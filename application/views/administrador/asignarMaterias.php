<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<!-- The Modal -->
<div class="modal fade" id="modalAsignarMateria">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="asignarMateriaForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <label for="docente">Docente:</label>
                            <select id="docente" name="docente" class="form-control">
                                <?php
                                if ($docentes) {
                                    foreach ($docentes as $docente) { ?>
                                <option value="<?= $docente['iddocente'] ?>">
                                    <?= $docente['nombre'] . " " . $docente['appaterno'] . " " . $docente['apmaterno'] ?>
                                </option>
                                <?php }
                                } else { ?>
                                <option value="-1">Aun no hay docentes creados</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="materia">Materia:</label>
                            <select id="materia" name="materia" class="form-control">
                                <?php
                                if ($materias) {
                                    foreach ($materias as $materia) { ?>
                                <option value="<?= $materia['idmateria'] ?>">
                                    <?= $materia['nombre'] . "-" . $materia['grupo'] ?></option>
                                <?php }
                                } else { ?>
                                <option value="-1">Aun no hay materias creadas</option>
                                <?php } ?>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario" hidden>
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <h2>Asignar materias al docente</h2>
    <!-- Button to Open the Modal -->

    <div class="d-flex flex-row-reverse">
        <div class="p-2" id="botonera">
            <button <?php echo ($abrirCiclo == 1) ? 'style = "display:none";' : '' ?> id="btnAbrirCiclo" type="button"
                class="btn btn-warning">
                Abrir Altas Materias
            </button>
            <button id="btnSincronizar" type="button" class="btn btn-warning" onclick="sincronizarMateriasAlumnos()">
                Sincronizar Materias
            </button>
            <button <?php echo ($abrirCiclo == 1) ? 'style = "display:none";' : 'disabled ' ?> id="btnAsignar"
                type="button" class="btn btn-primary" onclick="ui_modalAsignarMateria()">
                + Asignar materia a Docente
            </button>
            <button <?php echo ($abrirCiclo == 1) ? '' : 'style = "display:none";' ?> id="btnAbrirNuevoCiclo"
                type="button" class="btn btn-warning">
                Abrir Nuevo Ciclo
            </button>
        </div>
    </div>


    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Docente</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <button <?php echo ($abrirCiclo == 1) ? '' : 'style = "display:none";' ?> id="btnAbrir"
                type="button" class="btn btn-warning">
                Cerrar Ciclo de Año
            </button>
</div>
<?php $this->load->view("footer"); ?>
<script src="<?= base_url('assets/scripts/adminMateriasDocentes.js') ?>"></script>
<script>
$(() => {
    $("#btnSincronizar").css("display", "none")
})

function sincronizarMateriasAlumnos() {
    $.ajax({
        url: base_url + 'administrador/cronActualizarMaterias',
        type: 'POST',
        success: function(data) {


            swal(
                "Exito",
                "Se han sincronizado correctamente las materias.",
                "success"
            );

        },
        error: function(error, xhr, status) {

            swal(
                "Error",
                "Error durante la sincronizacíon , intente nuevamente",
                "error"
            );
        }
    });
}
$("#btnAbrirCiclo").click(() => {
    $("#btnAsignar").prop("disabled", false)
    $("#btnAbrirCiclo").css('display', 'none')
    $("#botonera").append(`<button id="btnCerraCiclo" type="button" onclick="cerrarCiclo()" class="btn btn-warning">
                Cerrar Altas Materias
            </button>`)
})

$("#btnAbrir").click(()=>{
    swal({
            title: "Estas seguro de cerrar el ciclo, no se puede revertir?",
            text: "Aun puedes eliminar esta acción.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, estoy seguro",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    method: 'POST',
                    data: {
                        status: 1
                    },
                    url: base_url + "administrador/cerrarCicloAno",
                    success: function(response) {
                        $("#btnAbrirCiclo").css('display', 'none')
                        $("#btnAsignar").css('display', 'none')
                        $("#btnCerraCiclo").css('display', 'none')
                        $("#btnAbrirNuevoCiclo").css('display', 'inline')
                        $("#btnSincronizar").css("display", "inline")
                        $("#btnAbrir").css("display","inline")
                        $("#btnAbrir").css('display', 'none')
                        swal(
                            "Exito",
                            "Ciclo cerrado correctamente.",
                            "success"
                        );

                    }
                })
            } else {
                swal("Cancelado", "Acción cancelada :)", "error");
            }
        });

})

function cerrarCiclo() {

    swal({
            title: "Estas seguro de cerrar el ciclo, no se puede revertir?",
            text: "Aun puedes eliminar esta acción.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, estoy seguro",
            cancelButtonText: "No, cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    method: 'POST',
                    data: {
                        status: 1
                    },
                    url: base_url + "administrador/cerrarCiclo",
                    success: function(response) {
                        $("#btnAbrirCiclo").css('display', 'none')
                        $("#btnAsignar").css('display', 'none')
                        $("#btnCerraCiclo").css('display', 'none')
                        $("#btnAbrirNuevoCiclo").css('display', 'inline')
                        $("#btnSincronizar").css("display", "inline")
                        $("#btnAbrir").css("display","inline")
                        swal(
                            "Exito",
                            "Ciclo cerrado correctamente.",
                            "success"
                        );

                    }
                })
            } else {
                swal("Cancelado", "Acción cancelada :)", "error");
            }
        });
}

$("#btnAbrirNuevoCiclo").click(() => {
    var table = $('#tabla_materias').DataTable();
    var longitud_tabla = table.data().count()

    if (longitud_tabla > 0) {
        swal("Advertencia", "Solo puede abrir nuevo ciclo ya que todas las materias sean " +
            "capturadas :)", "warning");
    } else {
        swal({
                title: "Estas seguro de abrir un nuevo ciclo.",
                text: "Aun puedes eliminar esta acción.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, estoy seguro",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: 'POST',
                        data: {
                            status: 0
                        },
                        url: base_url + "administrador/abrirCiclo",
                        success: function(response) {

                            window.location.reload()

                        }
                    })
                } else {
                    swal("Cancelado", "Acción cancelada :)", "error");
                }
            });
    }
})
</script>