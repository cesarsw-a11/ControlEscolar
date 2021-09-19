<?php $this->load->view("head"); ?>
<div class="container">
    <h2>Alumnos</h2>
    <p>Crear alumno</p>
    <form action="#" id="guardarAlumnoForm">
        <div class="row">
            <div class="col">
                <input type="number" class="form-control" id="num_control" placeholder="Numero de control"
                    name="numcontrol" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" required>
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" id="app_paterno" placeholder="Apellido paterno" name="appaterno"
                    required>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Apellido materno" name="apmaterno" required>
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                <select name="genero" name="genero" id="genero" class="form-control">
                    <option value="-1">Elija genero</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" id="curp" placeholder="CURP" name="curp" required>
            </div>
            <div class="col">
                <input type="number" class="form-control" id="cel" placeholder="Número celular" name="numcel" required>
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                <input type="email" class="form-control" id="email" placeholder="Email" name="correo" required>
            </div>
            <div class="col">
                <input type="text" class="form-control" id="localidad" placeholder="Localidad" name="localidad"
                    required>
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contraseña"
                    required>
            </div>
            <div class="col">
                <input type="text" class="form-control" id="foto" placeholder="Foto perfil" name="foto" required>
            </div>
            <div class="col">
                <input type="estado" class="form-control" id="estado" placeholder="Estado" name="estado" required>
            </div>
            <div class="col">
                <input type="cursando" class="form-control" id="cursando" placeholder="Cursando" name="cursando"
                    required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3" onclick="guardarAlumnos()">Guardar</button>
    </form>
</div>
<script src="<?= base_url('assets/scripts/login.js') ?>"></script>