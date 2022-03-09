<?php $this->load->view('head'); ?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <?php if ($this->session->userdata("rol") == 3) { ?>
            <a class="navbar-brand" href="<?= base_url("alumno") ?>">
                <img src="<?= base_url("imagenes/Logo.jpg") ?>" alt="..." height="36">
            </a>
        <?php } elseif ($this->session->userdata("rol") == 2) { ?>
            <a class="navbar-brand" href<?= base_url("docente") ?>">
                <img src="<?= base_url("imagenes/Logo.jpg") ?>" alt="..." height="36">
            </a>
        <?php } else { ?>
            <a class="navbar-brand" href="<?= base_url("administrador") ?>">
                <img src="<?= base_url("imagenes/Logo.jpg") ?>" alt="..." height="36">
            </a>
        <?php } ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if ($this->session->userdata("rol") == 1 && $this->session->userdata("logged")) { ?>

            <!--   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menú de registro
                </button> -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url("administrador/alumnos") ?>">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url("administrador/docentes") ?>">Docentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url("administrador/materias") ?>">Materias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url("administrador/asignarMaterias") ?>">Asignar materia al
                        docente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url("administrador/tomarInasistencias") ?>">Inasistencias y Conducta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="https://docs.google.com/document/d/11V85zkEIod6h0L-HwGqtfZvoVuVuEEwk/edit" target="_blank">Ayuda</a>
                </li>
            </ul>
            <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?= base_url("administrador/alumnos") ?>">Alumnos</a>
                    <a class="dropdown-item" href="<?= base_url("administrador/docentes") ?>">Docentes</a>
                    <a class="dropdown-item" href="<?= base_url("administrador/materias") ?>">Materias</a>
                    <a class="dropdown-item" href="<?= base_url("administrador/asignarMaterias") ?>">Asignar materia al
                        docente</a>
                    <a class="dropdown-item" href="<?= base_url("administrador/tomarInasistencias") ?>">Inasistencias</a>
            </div> --><?php } ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <?php if ($this->session->userdata("rol") == 3) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/alumno">Inicio</a>
                    </li>
                <?php } elseif ($this->session->userdata("rol") == 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/docente">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="https://docs.google.com/document/d/1N5CakV1TKrbh6BsMqYDbyoW24_WVq3FV/edit" target="_blank">Ayuda</a>
                    </li>
                <?php } ?>
                <?php if ($this->session->userdata("rol") == 3) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/alumno/organigrama">Organigrama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/alumno/kardex">Kardex</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="https://docs.google.com/document/d/1_FXbppK-98nfoDbod9BSDN20CxYSqe7_/edit" target="_blank">Ayuda</a>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/alumno/altaMateria">+Alta Materia</a>
                </li> -->
                <?php } ?>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li> -->
            </ul>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a class="nav-link" href="<?= base_url('login/logout') ?>"><span class="glyphicon glyphicon-ok"></span>Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>
<script>
    $(document).ready(function() {
        $(".dropdown-toggle").dropdown();
    });
</script>