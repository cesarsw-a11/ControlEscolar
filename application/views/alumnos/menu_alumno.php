<?php $this->load->view("head"); ?>
<?php $this->load->view("header"); ?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4 rounded-circle" src="<?= base_url().$alumno->foto ;?>" alt="" width="150"
            height="150">
        <h2>Alumno : <?= $alumno->nombre." ".$alumno->appaterno." ".$alumno->apmaterno?></h2>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Video informativo</span>
            </h4>
            <iframe width="330" height="280" src="https://www.youtube.com/embed/fLkCsqgE1_g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <p class="text-justify">¿Qué nos definen?  
Nuestra modalidad de la secundaria técnica nos permite ofrecer, en la presecialidad una educación diferente de calidad e integral.
Horarios de 6:55 a.m. a 2:10 p.m. con tecnologías de 8 módulos a la semana con especialidades en informática, agricultura y ganadería.
Equipadas con aire acondicionado, proyectores y equipos audiovisuales.
Espacios deportivos para diferentes disciplinas: fútbol, básquetbol, voleibol, etc.
Patio cívico techado.
Promoción musical: canto, batucada, flauta guitarra
Eventos deportivos, really, cinetec 22, posada navideña, semana cultural, desfiles cívicos etc</p>
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
                        <input type="text" class="form-control" id="lastName" placeholder=""
                            value="<?= $alumno->cursando?>" disabled>
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
                        <input type="text" class="form-control" id="lastName" placeholder="" value="<?= $alumno->adeudos ?>" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="firstName">Estado:</label>
                        <?php if($alumno->estado == 1){ ?>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="ACTIVO" disabled>
                        <?php }else{ ?>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="INACTIVO" disabled>
                        <?php } ?>

                    </div>
                </div>
                <hr class="mb-4">
            </form>
        </div>
    </div>
</div>

<?php $this->load->view("footer"); ?>