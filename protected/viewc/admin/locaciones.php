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
                                    <br/><br/>
                                    <a href="<?php echo Doo::conf()->APP_URL; ?>locaciones/agregar" class="btn btn-accent">Agregar locación</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /header contenedor -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
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
                                            <div class="col-sm-12 col-md-6">
                                                <div class="panel panel-filled panel-c-accent ">
                                                    <div class="panel-heading">
                                                        <?php echo utf8_encode($estado['nombre']) .' ('.$estado['cantidad'].')'; ?>
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

        <?php if (isset($_GET['success'])): ?>
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
                        $mensaje = '';
                        switch (intval($_GET['success'])) {
                            case 1:
                                $mensaje = '<strong>Locacion creada</strong> <br/><small>Se ha guardado la información de manera correcta.</small>';
                                break;
                            case 2:
                                $mensaje = '<strong>Locacion eliminada</strong> <br/><small>Se ha eliminado la información de manera correcta.</small>';
                                break;
                            default:
                                $mensaje = '<strong>Listo</strong> <br/><small>La acción solicitada se realizo exitosamente.</small>';
                                break;
                        }
                        ?>
                        toastr.success('<?php echo $mensaje; ?>');
                    }, 1600)

                });
            </script>
        <?php endif; ?>
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
                                $error = 'No se pudo crear la locacion.';
                                break;
                            case 2:
                                $error = 'La imágen proporcionada no es un archivo de imáge válido.';
                                break;
                            case 3:
                                $error = 'Todos los campos son obligatorios.';
                                break;
                            case 4:
                                $error = 'Ocurrio un error y no se pudo crear la locación. Intenta de nuevo más tarde.';
                                break;
                            default:
                                $error = 'No se pudo crear la locación.';
                                break;
                        }
                        ?>
                        toastr.error('<strong>Ocurrio un error</strong><br/><small><?php echo $error; ?></small>');
                    }, 1600)

                });
            </script>
        <?php endif; ?>

    </body>

</html>