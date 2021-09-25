<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<!-- The Modal -->
<div class="modal fade" id="modalAgregarMateria">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Agregar nueva materia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="#" id="guardarMateriaForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" id="clave" placeholder="Clave" name="clave"
                                required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Nombre materia" name="nombre"
                                id="nombre" required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <input type="number" class="form-control" id="grado" placeholder="Grado" name="grado"
                                required>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario" value="materias"
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
    <h2>Materias</h2>
    <!-- Button to Open the Modal -->

    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMateria">
                + Agregar materia
            </button>
        </div>
    </div>


    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($materias)){ 
           foreach($materias as $materia){ ?>
            <tr>
                <td><?= $materia['clave']?></td>
                <td><?= $materia['nombre']?></td>
                <td><?= $materia['grado']?></td>
                <?php if($materia['estado'] == 1){ ?>
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
<script src="<?= base_url('assets/scripts/adminMaterias.js') ?>"></script>