<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>
<div class="container mt-4">
    <h2>Inasistencias y Conducta</h2>
    <!-- Button to Open the Modal -->


    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No. Control</th>
                <th>Alumno</th>
                <th>Correo</th>
                <th>Adeudos</th>
                <th>Inasistencias</th>
                <th>Conducta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $contador = 0;
            foreach ($alumnos as $alumno) {
                $contador++ ?>
                <tr>
                    <td><?= $alumno['nombre'] . " " . $alumno['appaterno'] . " " . $alumno['apmaterno'] ?></td>
                    <td><?= $alumno['adeudos'] ?></td>
                    <td><input type="text" data-idalumno="<?= $alumno['idalumno'] ?>" value="<?= $alumno['inasistencias'] ?>" name="inasistencias" id="inasistencias<?= $contador ?>" /></td>
                    <td><button class="btn btn-success" onclick="actualizarAsistencia(<?= $contador ?>)">Guardar</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $(() => {
        listarMaterias()
    })

    function listarMaterias() {
        var columnas = [];
        columnas.push({
            "data": "numcontrol"
        });
        columnas.push({
            "data": "nombreCompleto"
        });
        columnas.push({
            "data": "email"
        });
        columnas.push({
            "data": "adeudos"
        });
        columnas.push({
            "data": "inasistenciasInput"
        });
        columnas.push({
            "data": "conductaInput"
        });
        columnas.push({
            "data": "botonEditar"
        });

        var table = $('#tabla_materias').DataTable({
            'processing': true,
            // 'serverSide': true,
            'scrollY': "400px",
            'paging': true,
            'ajax': {
                "url": base_url + "administrador/obtenerDataInasistencias",
                "type": "POST",
                "dataSrc": function(json) {
                    for (var i = 0, ien = json.length; i < ien; i++) {
                        json[i]['inasistenciasInput'] = `<input type ="text" data-idalumno="${json[i].idalumno}" value="${json[i].inasistencias}" name="inasistencias" id="inasistencias${i}"/>`
                        json[i]['conductaInput'] = `<input type ="text" data-idalumno="${json[i].idalumno}" value="${json[i].conducta}" name="conducta" id="conducta${i}"/>`
                        json[i]['nombreCompleto'] = json[i].nombre + " " + json[i].appaterno + " " + json[i].apmaterno
                        json[i]['botonEditar'] = `<button class="btn btn-success" onclick="actualizarAsistencia(${i})">Guardar</button>`
                    }
                    return json;
                }
            },
            "columns": JSON.parse(JSON.stringify(columnas))

        });
    }

    function actualizarAsistencia(row) {
        var inputInasistencia = $("#inasistencias" + row).val();
        var idalumno = $("#inasistencias" + row).attr("data-idalumno");
        var conducta = $("#conducta" + row).val();
        $.ajax({
            url: base_url+'administrador/actualizarInasistencias',
            type: 'POST',
            data: {
                "inasistencia": inputInasistencia,
                "idalumno": idalumno,
                "conducta" : conducta
            },
            success: function(response) {
                var data = JSON.parse(response)
                if (data.error == false) {
                    swal(
                        "Exito",
                        "Inasistencia y conducta guardadas.",
                        "success"
                    );
                } else {
                    swal(
                        "Error",
                        "No fue posible eliminar sus datos, revise su conexión.",
                        "error"
                    );
                }

            },
            error: function(error, xhr, status) {

                swal(
                    "Error",
                    "No fue posible guardar sus datos, revise su conexión.",
                    "error"
                );
            }
        });

    }
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