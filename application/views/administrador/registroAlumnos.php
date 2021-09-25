<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<!-- The Modal -->
<div class="modal fade" id="modalAgregarAlumno">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar nuevo alumno</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="guardarAlumnoForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" id="num_control" placeholder="Numero de control"
                                name="numcontrol" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre"
                                required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="app_paterno" placeholder="Apellido paterno"
                                name="appaterno" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Apellido materno" name="apmaterno"
                                required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <select name="genero" name="genero" id="genero" class="form-control">
                                <option value="-1">Elija genero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="curp" placeholder="CURP" name="curp" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" id="cel" placeholder="Número celular"
                                name="numcel" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="correo"
                                required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="localidad" placeholder="Localidad"
                                name="localidad" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="password" class="form-control" id="password" placeholder="Contraseña"
                                name="contraseña" required>
                        </div>
                        <div class="col">
                            <input type="file" id="file" name="file" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <label for="cursando">Grado cursando:</label>
                            <input type="text" class="form-control" id="cursando" placeholder="Cursando" name="cursando"
                                required>
                        </div>
                        <div class="col">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario" value="alumnos"
                                hidden>
                        </div>
                    </div class="row">
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarAlumno">
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
                <th>Genero</th>
                <th>Curp</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($alumnos)){ 
           foreach($alumnos as $alumno){ ?>
            <tr>
                <td><?= $alumno['numcontrol']?></td>
                <td><?= $alumno['nombre']?></td>
                <td><?= $alumno['appaterno']?></td>
                <td><?= $alumno['genero']?></td>
                <td><?= $alumno['curp']?></td>
                <?php if($alumno['estado'] == 1){ ?>
                <td>Activo</td>
                <?php }else{ ?>
                <td>Inactivo</td>
                <?php } ?>
            </tr>
            <?php }
        } ?>
        </tbody>
    </table>
</div>
<script src="<?= base_url('assets/scripts/adminAlumnos.js') ?>"></script>