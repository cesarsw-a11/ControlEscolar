<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>
<div class="container mt-4">
    <h2>Inasistencias</h2>
    <!-- Button to Open the Modal -->


    <table id="tabla_materias" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Inasistencias</th>
                <th>Inasistencias</th>
            </tr>
        </thead>
        <tbody>
        <?php $contador = 0;
         foreach($alumnos as $alumno){
            $contador++?>
        <tr>
            <td><?= $alumno['nombre']." ".$alumno['appaterno']." ".$alumno['apmaterno'] ?></td>
            <td><input type ="text" data-idalumno="<?= $alumno['idalumno']?>" value="<?= $alumno['inasistencias']?>" name="inasistencias" id="inasistencias<?=$contador?>"/></td>
            <td><button class="btn btn-success" onclick="actualizarAsistencia(<?= $contador ?>)">Guardar</button></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>
function actualizarAsistencia(row){
   var inputInasistencia = $("#inasistencias"+row).val();
   var idalumno = $("#inasistencias"+row).attr("data-idalumno");
   $.ajax({
                    url: 'actualizarInasistencias',
                    type: 'POST',
                    data: { "inasistencia": inputInasistencia ,"idalumno" : idalumno },
                    success: function (response) {
                        var data = JSON.parse(response)
                        if (data.error == false) {
                            swal(
                                "Exito",
                                "Inasistencia guardada.",
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
                    error: function (error, xhr, status) {

                        swal(
                            "Error",
                            "No fue posible guardar sus datos, revise su conexión.",
                            "error"
                        );
                    }
                });
   
}
</script>