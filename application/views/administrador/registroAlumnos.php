<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>
<script src="<?php echo base_url('assets/jquery/jquery.inputmask.min.js'); ?>" type="text/javascript"></script>

<!-- The Modal -->
<div class="modal fade" id="modalAgregarAlumno">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="guardarAlumnoForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <input type="number" id="idalumno" name="idalumno" hidden>
                            <input autocomplete="off" class="form-control" id="num_control" placeholder="Numero de control" name="numcontrol" required>
                        </div>
                        <div class="col">
                            <input autocomplete="off" pattern="[A-Za-z0-9].{1,}" type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" onkeypress="return /^[A-Za-zñÑ ]+$/.test(event.key)" onkeyup="mayus(this);" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input autocomplete="off" pattern="[A-Za-z0-9].{1,}" type="text" class="form-control" id="app_paterno" placeholder="Apellido paterno" name="appaterno" onkeyup="mayus(this);" onkeypress="return /^[A-Za-zñÑ ]+$/.test(event.key)" required>
                        </div>
                        <div class="col">
                            <input autocomplete="off" pattern="[A-Za-z0-9].{1,}" type="text" class="form-control" placeholder="Apellido materno" id="apmaterno" name="apmaterno" onkeyup="mayus(this);" onkeypress="return /^[A-Za-zñÑ ]+$/.test(event.key)" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <select name="genero" name="genero" id="genero" class="form-control">
                                <option value="-1">Elija genero</option>
                                <option value="Masculino">MASCULINO</option>
                                <option value="Femenino">FEMENINO</option>
                            </select>
                        </div>
                        <div class="col">
                            <input autocomplete="off" class="form-control" id="adeudos" placeholder="Adeudos" name="adeudos" onkeyup="mayus(this);" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="text" autocomplete="off" class="form-control" id="curp" placeholder="CURP" name="curp" onkeyup="mayus(this);" required>
                        </div>
                        <div class="col">
                            <input class="form-control" autocomplete="off" id="cel" placeholder="Número celular" name="numcel" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="email" autocomplete="off" class="form-control" id="email" placeholder="Email" name="correo" required>
                        </div>
                        <div class="col">
                            <input type="text" autocomplete="off" class="form-control" id="localidad" placeholder="Localidad" name="localidad" onkeyup="mayus(this);" onkeypress="return /^[A-Za-zñÑ ]+$/.test(event.key)" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
<!--                             <input type="text" autocomplete="off" onkeyup="mayus(this);" class="form-control" id="tecnologias" placeholder="Tecnologias" name="tecnologias" onkeypress="return /^[A-Za-zñÑ ]+$/.test(event.key)" required>
 -->                            <label for="tecnologias">Tecnologias:</label>
                            <select id="tecnologias" name="tecnologias" class="form-control">
                                <option value="INFORMATICA">INFORMATICA</option>
                                <option value="GANADERIA">GANADERIA</option>
                                <option value="AGRICULTURA">AGRICULTURA</option>
                            </select>
                        </div>
                        <div class="col">
                            <input class="form-control" autocomplete="off" id="emergencia" placeholder="Número de Emergencia" name="emergencia" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="password" autocomplete="off" class="form-control" id="password" placeholder="Contraseña" name="contraseña" required>
                        </div>
                        <div class="col">
                            <input type="file" id="file" name="file" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <label for="cursando">Grado cursando:</label>
                            <select class="form-control" id="cursando" placeholder="Cursando" name="cursando">
                                <option value="-1">CURSANDO</option>
                                <?php for ($i = 1; $i <= 3; $i++) {  ?>
                                    <?php if($i == 1){ ?>
                                    <option value="<?= $i ?>" selected><?= $i ?></option>
                                    <?php }else{ ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario" value="alumnos" hidden>
                        </div>
                    </div class="row">
                    <div class="row">
                        <div class="col">
                            <label for="cursando">Grupo cursando:</label>
                            <select class="form-control" id="grupo" placeholder="grupo" name="grupo">
                                <option value="-1">GRUPO</option>
                                <option value="A" selected>A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    </div>
                </form>
                <div class="changePass"></div>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="modalCambiarContraseña">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title-contraseña"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="formcambiarContraseña">

                    <div class="row">
                        <div class="col">
                            <input type="password" class="form-control" id="cambiarContraseña" placeholder="Contraseña" name="contraseña" required>
                        </div>
                    </div><br>

            </div class="row">
            <!-- Modal footer -->
            <div class="modal-footer">
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<div class="container mt-4">
    <h2>Alumnos</h2>
    <!-- Button to Open the Modal -->

    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button type="button" class="btn btn-warning" onclick="sincronizarMateriasAlumnos()">
                Sincronizar Materias
            </button>
            <button type="button" class="btn btn-primary" onclick="ui_modalNuevoAlumno()">
                + Agregar alumno
            </button>
        </div>
    </div>


    <table id="tabla_alumnos" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Num. control</th>
                <th>Nombre</th>
                <th>A. paterno</th>
                <th>Email</th>
                <th>Genero</th>
                <th>Curp</th>
                <th>Grado</th>
                <th>Grupo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<?php $this->load->view("footer"); ?>
<script src="<?= base_url('assets/scripts/adminAlumnos.js') ?>"></script>
<script>
    $(() => {
        $("#cel").inputmask("999-999-9999");
        $("#emergencia").inputmask("999-999-9999");
        $("#num_control").inputmask("9999999999");
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
</script>