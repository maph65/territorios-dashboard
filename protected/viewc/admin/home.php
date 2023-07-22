<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Inicio</title>
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
                                    <i class="pe page-header-icon pe-7s-settings"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Bienvenido al administrador de TelevisaConnect</h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar el contenido de la App de TelevisaConnect.</small>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /header contenedor -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-filled">
                                <div class="panel-heading">
                                    <div class="panel-tools">
                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                        <a class="panel-close"><i class="fa fa-times"></i></a>
                                    </div>
                                    Enviar notificaci&oacute;n r&aacute;pida
                                </div>
                                <div class="panel-body">
                                    <p>Al enviar una notificaci&oacute;n b&aacute;sica solo se env&iacute;a la notificaci&oacute;n a los dispositivos sin que se agregue contenido a la seccion <span>Notificaciones</span> de la App.</p>
                                    <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'notifcaciones/simple/enviar'; ?>">
                                        <div class=form-group>
                                            <label>Mensaje a enviar</label>
                                            <input type="text" class="form-control" name="mensaje" placeholder="Mensaje (Máx. 110 caracteres)" maxlength="110">
                                        </div>
                                        <button type="submit" class="btn btn-default right">Enviar</button>
                                    </form>
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
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>vendor/toastr/toastr.min.js"></script>
        <!-- App scripts -->
        <script src="<?php echo Doo::conf()->GLOBAL_URL; ?>scripts/luna.js"></script>
        <?php if(isset($_GET['success']) && isset($_GET['module']) && $_GET['module'] == 'notif' ): ?>
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
                    toastr.success('<strong>Notificación enviada</strong> <br/><small>Tu notificación se ha enviado a los teléfonos con la aplicación instalada.</small>');
                }, 1600)

            });
        </script>
        <?php endif; ?>
        <?php if(isset($_GET['error']) && isset($_GET['module']) && $_GET['module'] == 'notif' ): ?>
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
                    switch (intval($_GET['error'])){
                        case 1:
                            $error = 'No puedes enviar notificaciones vacías. Coloca un texto de máximo 110 caracteres.';
                            break;
                        case 2:
                            $error = 'El mensaje es demasiado largo. Prueba con un texto más corto.';
                            break;
                        default:
                            $error = 'Tu notificación no fue enviada, intenta de nuevo más tarde';
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