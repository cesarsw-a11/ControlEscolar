<?php $this->load->view('head'); ?>
<link rel="stylesheet" href="<?= base_url("estilos/login.css")?>">
<div class="main-bg">
    <div class="login-container text-c animated flipInX">
        <div>
            <img src="<?= base_url("imagenes/Logo.jpg")?>" width="200" height="200" class="d-inline-block align-top"
                alt=""> </div>
        <h3 class="text-whitesmoke">Control Escolar</h3>
        <p class="text-whitesmoke"></p>
        <div class="container-content">
            <form class="margin-t" id="login-form">
                <div class="form-group">
                    <input id="usuario" name="usuario" type="email" class="form-control" placeholder="Usuario" autocomplete="off"
                        required />
                </div>
                <div class="form-group">
                    <input id="pass" name="password" type="password" class="form-control" placeholder="*****" autocomplete="off"
                        required />
                </div>
               <!--  <div class="form-group">
                    <select class="form-control" id="rol">
                        <option value="-1">Rol</option>
                        <?php if(isset($roles)){ ?>
                        <?php foreach($roles as $rol) { ?>
                        <option value="<?php echo $rol['id_rol'] ?>"><?php echo $rol['nombreRol'] ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div> -->
                <button type="submit" class="form-button button-l margin-b" id="btn-login">Iniciar Sesión</button>

            </form>
            <p class="margin-t text-whitesmoke"><small>&copy; 2021</small> </p>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/scripts/login.js') ?>"></script>