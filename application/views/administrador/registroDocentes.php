<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<!-- The Modal -->
<div class="modal fade" id="modalAgregarDocente">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar nuevo docente</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="guardarDocenteForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre"
                                required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Apellido paterno" name="appaterno"
                                id="appaterno" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="apmaterno" placeholder="Apellido materno"
                                name="apmaterno" required>
                        </div>
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
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                required>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control" id="password" placeholder="Contraseña"
                                name="password" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="file" id="file" name="file" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario" value="docentes"
                                hidden>
                        </div>
                    </div>
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
    <h2>Docentes</h2>
    <!-- Button to Open the Modal -->

    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDocente">
                + Agregar Docente
            </button>
        </div>
    </div>


    <table id="tabla_docentes" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($docentes)){ 
           foreach($docentes as $docente){ ?>
            <tr>
                <td><?= $docente['nombre']?></td>
                <td><?= $docente['email']?></td>
                <?php if($docente['estado'] == 1){ ?>
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
<script src="<?= base_url('assets/scripts/adminDocentes.js') ?>"></script>