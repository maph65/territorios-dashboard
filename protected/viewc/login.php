<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Login</title>
    </head>
    <body class="blank">
        <!-- Wrapper-->
        <div class="wrapper">
            <!-- Main content-->
            <section class="content">
                <div class="logo-center center animated slideInUp">
                    <img src="<?php echo Doo::conf()->GLOBAL_URL ?>img/iconapp.png" alt="Territorios del Saber" width="100" />
                    <p class="login-name-app">Territorios del saber</p>
                </div>
                <div class="container-center animated slideInDown">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-unlock"></i>
                        </div>
                        <div class="header-title">
                            <h3>Iniciar sesi&oacute;n</h3>
                            <small>Ingresa con tu usuario y contrase&ntilde;a</small>
                        </div>
                    </div>
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <form action="<?php echo Doo::conf()->APP_URL; ?>loginAction" id="loginForm" method="POST" novalidate>
                                <div class="form-group">
                                    <label class="control-label" for="username">Correo electr&oacute;nico</label>
                                    <input type="text" placeholder="nombre@host.com" title="Ingresa tu correo" required="" value="" name="email" id="email" class="form-control">
                                    <!-- <span class="help-block small">Tu usuario o correo electr&oacute;nico</span>-->
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="password">Contrase&ntilde;a</label>
                                    <input type="password" title="Por favor ingresa tu contraseña" placeholder="******" required="" value="" name="passwd" id="passwd" class="form-control">
                                </div>
                                <div>
                                    <button class="btn btn-accent">Ingresar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </section>
            <!-- End main content-->
        </div>
        <!-- End wrapper-->
        <!-- Vendor scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/pacejs/pace.min.js"></script>
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/toastr/toastr.min.js"></script>
        <!-- App scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>scripts/luna.js"></script>
        <?php if (isset($_GET['error'])): ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    // Run toastr notification with Welcome message
                    setTimeout(function() {
                        toastr.options = {
                            "positionClass": "toast-top-right",
                            "closeButton": true,
                            "progressBar": true,
                            "showEasing": "swing",
                            "timeOut": "6000"
                        };
    <?php
    switch (intval($_GET['error'])) {
        case 1:
            $error = 'El usuario y/o contraseña no coiniciden.';
            break;
        default:
            $error = 'El usuario y/o contraseña no coiniciden.';
            break;
    }
    ?>
                        toastr.error('<strong>No se pudo iniciar la sesión</strong><br/><small><?php echo $error; ?></small>');
                    }, 1600)

                });
            </script>
        <?php endif; ?>
    </body>
</html>