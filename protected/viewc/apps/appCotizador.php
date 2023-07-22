<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | App</title>
    </head>
    <body class="blank">
        <!-- Wrapper-->
        <div class="wrapper">
            <!-- Main content-->
            <section class="content">
                <div class="logo-center center animated slideInDown">
                    <img src="<?php echo Doo::conf()->GLOBAL_URL ?>img/cotizador_large@2x.png" alt="Televisa Cotizador" width="210" />
                </div>
                <div class="row center animated slideInDown">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="panel panel-filled">
                                <div class="panel-heading">
                                    <div class="panel-tools">
                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                    Instala la &uacute;ltima versi&oacute;n de la App Cotizador
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
                                            <img src="<?php echo Doo::conf()->APP_URL.'app/cotizadorDist/logo_cotizador_180x180.png'; ?>" alt="Televisa Cotizador" class="logo-app">
                                            <br/><br/><br/>
                                        </div>
                                        <div class="col-sm-8 col-xs-8 col-md-6 col-lg-6 descripcion-app">
                                            <span class="app-title">Televisa Cotizador</span>
                                            <span class="app-version">Versi&oacute;n 1.3.0</span>
                                            <p class="app-version-description">Televisa Cotizador.</p>
                                        </div>
                                        <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                                            <a href="itms-services://?action=download-manifest&url=<?php echo Doo::conf()->APP_URL.'app/cotizadorDist/manifest.plist' ?>" class="btn btn-default btn-lg">Instalar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
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
        <!-- App scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>scripts/luna.js"></script>
    </body>
</html>