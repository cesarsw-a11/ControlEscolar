<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>
<style>
.divEditable {
    transition: background-color 2s ease;
    transition: color 2s ease;
    cursor: pointer;
    position: relative;
    width: 100% !important;
    height: 100% !important;
}

.div_actualizadoExito {
    transition: background-color 2s ease;
    transition: color 2s ease;
    background-color: #0fcbfa;
    color: white;
}
</style>
<div class="container">
    <div class="py-5">
        <h2>Captura de calificaciones</h2>
        <h5>Nombre de la materia : <?= $nombre_materia; ?></h5>
        <input type="text" id="id_materia" value="<?= $id_materia; ?>" hidden>
    </div>
    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No. Control</th>
                <th>Paterno</th>
                <th>Materno</th>
                <th>Nombre</th>
                <th>Unidad 1</th>
                <th>Unidad 2</th>
                <th>Unidad 3</th>
                <th>Unidad OPC</th>
                <th>Capturar</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!-- The Modal -->
    <div class="modal fade" id="modalCapturaCalificacion">
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
                            <label for="estado">Unidad 1 :</label>
                            <select class="form-control" name="unidad1" id="unidad1">
                                <option value="NC">NC</option>
                                <?php for($i=5;$i<=10; $i++){?>
                                    <option value="<?= $i?>"><?= $i?></option>
                                 <?php } ?>
                                 </select>
                            </div>
                            <div class="col">
                            <label for="estado">Unidad 2 :</label>
                            <select class="form-control" name="unidad2" id="unidad2">
                                <option value="NC">NC</option>
                                <?php for($i=5;$i<=10; $i++){?>
                                    <option value="<?= $i?>"><?= $i?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <label for="estado">Unidad 3 :</label>
                                <select class="form-control" name="unidad3" id="unidad3">
                                <option value="NC">NC</option>
                                <?php for($i=5;$i<=10; $i++){?>
                                    <option value="<?= $i?>"><?= $i?></option>
                                 <?php } ?>
                                 </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <label for="estado">Observaciones :</label>
                            <input class="form-control" type="text" name="observaciones" id="observaciones">
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
    <!-- Modal  -->
    <div id="modal_loading" class="modal container fade" tabindex="-1" data-focus-on="input:first"
        style="display: none; left:60%!important" data-backdrop="static" data-keyboard="false">
        <div class="modal-body" id="contenido_modal_loading">
            <div class="text-center">
                <h1>Procesando Petición...</h1>
                <img src="<?php echo base_url('images/icons/ajax_loading.gif'); ?>">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("footer"); ?>

<script src="<?= base_url('assets/scripts/capturaCalificaciones.js') ?>"></script>