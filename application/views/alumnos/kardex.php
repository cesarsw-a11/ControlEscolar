<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4 rounded-circle" src="<?= base_url("imagenes/Logo.jpg") ;?>" alt="" width="150"
            height="150">
        <h4>Escuela Secundaria Técnica 22,La Huerta</h4>
        <h4>Kardex</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="firstName">Alumno:
                <?=$alumno->numcontrol." - ". $alumno->nombre." ".$alumno->appaterno." ".$alumno->apmaterno?></label>
        </div>
        <input type="text" id="id_alumno" value="<?=$alumno->idalumno?>" hidden>
        <div class="col-md-6">
            <label for="lastName">Año cursado: <?= $alumno->cursando ?></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="firstName">Programa: Secundaria Técnica 22</label>
        </div>
        <div class="col-md-6">
            <label for="lastName">Promedio:</label>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <label for="lastName">Fecha: <?= date("d/m/Y") ?></label>
        </div>
    </div>
    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Asignatura</th>
                <th>Calificación</th>
                <th>OPC</th>
                <th>Inasistencias</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>
<?php $this->load->view("footer"); ?>
<script>
$(() => {
    listarMaterias()
})

function listarMaterias() {
    var columnas = [];
    columnas.push({
        "data": "clave"
    });
    columnas.push({
        "data": "nombre"
    });
    columnas.push({
        "data": "promedio"
    });
    columnas.push({
        "data": "opc"
    });
    columnas.push({
        "data": "inasistencias"
    });

    var table = $('#tabla_materias').DataTable({
        'processing': true,
        // 'serverSide': true,
        'scrollY': "400px",
        'paging': true,
        'ajax': {
            "url": "obtenerDataKardex",
            "type": "POST",
            "data": {
                "alumno": $("#id_alumno").val()
            },
            "dataSrc": function(json) {
                console.log(json.length)
                for (var i = 0, ien = json.length; i < ien; i++) {
                    json[i]['inasistencias'] = `0`
                }
                return json;
            }
        },
        "columns": JSON.parse(JSON.stringify(columnas))

    });

}
</script>