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
                                if($docentes){
                                foreach($docentes as $docente){ ?>
                                    <option value="<?= $docente['iddocente']?>"><?= $docente['nombre']?></option>
                                <?php }
                                }else{?>
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
                                if($materias){
                                foreach($materias as $materia){ ?>
                                    <option value="<?= $materia['idmateria']?>"><?= $materia['nombre']?></option>
                                <?php }
                                }else{?>
                                <option value="-1">Aun no hay materias creadas</option>
                                <?php } ?>
                            </select>
                            <input type="text" class="form-control" id="formulario" name="formulario"  hidden>
                            <input type="text" class="form-control" id="id" name="id"  hidden>
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
        <div class="p-2">
            <button type="button" class="btn btn-primary" onclick="ui_modalAsignarMateria()">
                + Agregar materia
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
</div>
<?php $this->load->view("footer"); ?>
<script src="<?= base_url('assets/scripts/adminMateriasDocentes.js') ?>"></script>