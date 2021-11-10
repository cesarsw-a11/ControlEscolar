<?php $this->load->view('head'); ?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= base_url("imagenes/Logo.jpg")?>" alt="..." height="36">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if($this->session->userdata("rol") == 1 && $this->session->userdata("logged")){?>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menú de registro
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="<?= base_url("administrador/alumnos")?>">Alumnos</a>
                <a class="dropdown-item" href="<?= base_url("administrador/docentes")?>">Docentes</a>
                <a class="dropdown-item" href="<?= base_url("administrador/materias")?>">Materias</a>
                <a class="dropdown-item" href="<?= base_url("administrador/asignarMaterias")?>">Asignar materia al
                    docente</a>
            </div>
        </div><?php } ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <?php if($this->session->userdata("rol") == 3){?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/alumno">Home</a>
                </li>
                <?php }else{ ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <?php } ?>
                <?php if($this->session->userdata("rol") == 3){?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/alumno/organigrama">Organigrama</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/alumno/kardex">Kardex</a>
                </li>
                <?php } ?>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li> -->
            </ul>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a class="nav-link" href="<?= base_url('login/logout')?>"><span
                        class="glyphicon glyphicon-ok"></span>Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>
<script>
$(document).ready(function() {
    $(".dropdown-toggle").dropdown();
});
</script>