<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<div class="container">
    <div class="py-5">
        <h2>Administracion de Grupos</h2>
        <img class=" mb-4 rounded-circle" src="<?= base_url().$docente->foto; ;?>" alt="" width="150" height="150">
        <h4>Maestro: <?= $docente->nombre." ".$docente->appaterno." ".$docente->apmaterno ?></h4>
    </div>
    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Grado</th>
                <th>Asignatura</th>
                <th>Plan</th>
                <th>Programa</th>
               <!--  <th></th> -->
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>
<?php $this->load->view("footer"); ?>
<script src="<?= base_url('assets/scripts/docentes.js') ?>"></script>