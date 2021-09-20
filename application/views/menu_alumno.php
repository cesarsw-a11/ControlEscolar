<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4 rounded-circle" src="<?= $alumno->foto ;?>" alt="" width="150" height="150">
        <h2>Alumno : <?= $alumno->nombre." ".$alumno->appaterno." ".$alumno->apmaterno?></h2>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Video informativo</span>
            </h4>
            <!-- Aqui ira un video informativo -->
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Datos</h4>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Num. Control:</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="<?= $alumno->numcontrol?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Genero</label>
                        <input type="text" class="form-control" id="lastName" placeholder=""
                            value="<?= $alumno->genero?>" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Plantel:</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="Secundaria Técnica 22." disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Año cursado:</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="4" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Nombre:</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="<?= $alumno->nombre?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="lastName" placeholder=""
                            value="<?= $alumno->appaterno?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Apellido Materno:</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="<?= $alumno->apmaterno?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Seguro:</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="SI" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">CURP:</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="<?= $alumno->curp?>" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Adeudos:</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="firstName">Estado:</label>
                        <input type="text" class="form-control" id="firstName" placeholder=""
                            value="<?= $alumno->estado?>" disabled>
                    </div>
                </div>
                <hr class="mb-4">
            </form>
        </div>
    </div>