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
.PEL_descuentoActualizadoExito {
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
        <input type="text" id = "id_materia" value="<?= $id_materia; ?>">
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
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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

<script src="<?= base_url('assets/scripts/capturaCalificaciones.js') ?>"></script>