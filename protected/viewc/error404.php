<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Error 404</title>
    </head>
    <body class="blank">
        <!-- Wrapper-->
        <div class="wrapper">
            <!-- Main content-->
            <section class="content">
                <div class="logo-center center animated slideInDown">
                    <img src="<?php echo Doo::conf()->GLOBAL_URL ?>img/iconapp.png" alt="Territorios del Saber" width="100" />
                    <p class="login-name-app">Territorios del saber</p>
                </div>
                <div class="center superpadding animated slideInDown">
                    <h1>Error 404</h1>
                    <h2>El contenido solicitado no se encuentra o fue cambiado de lugar.</h2>
                    <h3><a href="<?php echo Doo::conf()->APP_URL; ?>">Vamos a <span class="pe-7s-home"></span></a></h3>
                </div>
            </section>
            <!-- End main content-->
        </div>
        <!-- End wrapper-->
        <!-- Vendor scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/pacejs/pace.min.js"></script>
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- App scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>scripts/luna.js"></script>
    </body>
</html>