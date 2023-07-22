<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
        <!-- croppie -->
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- croppie -->
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Locaciones</title>
    </head>
    <body>
        <!-- Wrapper-->
        <div class="wrapper">
            <!-- Header-->
            <?php include('common/header.php'); ?>
            <!-- End header-->
            <!-- menu -->
            <?php include('common/menu.php'); ?>
            <!-- /menu -->
            <!-- Main content-->
            <section class="content">
                <div class="container-fluid">
                    <!-- header contenedor -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="view-header">
                                <div class="header-icon">
                                    <i class="pe page-header-icon pe-7s-map-marker"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Locaciones</h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar las locaciones de la App Territorios del Saber.</small>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /header contenedor -->
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="panel panel-filled">
                                <div class="panel-heading">
                                    <div class="panel-tools">
                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                    Estados
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if (!empty($data['estados'])):
                                        foreach ($data['estados'] as $estado):
                                            ?>
                                            <div class="col-sm-12 col-md-12">
                                                <div class="panel panel-filled panel-c-accent ">
                                                    <div class="panel-heading">
                                                        <?php echo $estado['nombre'] .' ('.$estado['cantidad'].')'; ?>
                                                        <div class="buttons-container">
                                                            <a href="<?php echo Doo::conf()->APP_URL.'locaciones/estado/'.$estado['id_estado']; ?>" class="btn btn-danger">Ver locaciones</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
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
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/toastr/toastr.min.js"></script>
        <!-- App scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>scripts/luna.js"></script>
    </body>

</html>