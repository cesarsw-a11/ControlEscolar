<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<!-- The Modal -->
<div class="modal fade" id="modalAgregarMateria">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="guardarMateriaForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <input type="number" id="idmateria" name="idmateria" hidden>
                            <input type="text" class="form-control" id="clave" placeholder="Clave" name="clave" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Nombre materia" name="nombre" id="nombre" onkeypress="return /^[A-Za-z ]+$/.test(event.key)" required>
                        </div>
                    </div><br>
                    <select class="form-control" id="grado" placeholder="Grado" name="grado">
                        <option value="-1">GRADO</option>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <label for="grupo">Grupo:</label>
                    <select class="form-control" id="grupo" placeholder="Grupo" name="grupo">
                        <option value="1A" selected>1A</option>
                        <option value="2A">2A</option>
                        <option value="3A">3A</option>
                        <option value="1B">1B</option>
                        <option value="2B">2B</option>
                        <option value="3B">3B</option>
                        <option value="1C">1C</option>
                        <option value="2C">2C</option>
                        <option value="3C">3C</option>
                    </select>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario" value="materias" hidden>
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
    <h2>Materias</h2>
    <!-- Button to Open the Modal -->

    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button type="button" class="btn btn-warning" onclick="sincronizarMateriasAlumnos()">
                Sincronizar Materias
            </button>
            <button type="button" class="btn btn-primary" onclick="ui_modalNuevaMateria()">
                + Agregar materia
            </button>
        </div>
    </div>


    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<?php $this->load->view("footer"); ?>
<script src="<?= base_url('assets/scripts/adminMaterias.js') ?>"></script>
<script>
    function sincronizarMateriasAlumnos() {
        $.ajax({
            url: base_url+'administrador/cronActualizarMaterias',
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
</script>