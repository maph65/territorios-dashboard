<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Parrilla</title>
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
                                    <i class="pe page-header-icon pe-7s-display2"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Parrilla <?php
                                                        if(isset($data['location']) && isset($data['sublocation'])){
                                                            $sublocation = filter_var($data['sublocation'],FILTER_SANITIZE_STRING);
                                                            echo ucfirst($sublocation);
                                                        }
                                                    ?></h3>
                                    <small>Aqu&iacute; podr&aacute;s subir la &uacute;ltima versi&oacute;n de la Parrilla.</small>
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
                                    Publicar parrilla
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $format = 'Excel';
                                        $formAction = Doo::conf()->APP_URL . 'parrillaAction';
                                        if(isset($data['location']) && isset($data['sublocation'])){
                                            $sublocation = filter_var($data['sublocation'],FILTER_SANITIZE_STRING);
                                            $formAction = Doo::conf()->APP_URL . 'parrillaAction/'.$sublocation;
                                            if($sublocation=='abierta' || $sublocation == 'regional'){
                                                $format = 'PDF';
                                            }
                                        }
                                    ?>
                                    <form method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data" id="descarga-form">

                                        <div class=form-group>
                                            <label>Archivo en formato <?php echo $format; ?></label>
                                            <input type="file" class="form-control" name="archivo" id="archivo">
                                        </div>
                                        <br/>
                                        <button type="submit" class="btn btn-default right">Publicar</button>
                                    </form>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
                        </div>
                        <?php if (isset($data['excel'])): ?>
                            <div class="col-md-12 col-lg-6">
                                <div class="panel panel-filled">
                                    <div class="panel-heading">
                                        <div class="panel-tools">
                                            <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                        </div>
                                        Parrilla publicada
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="panel panel-filled panel-c-accent panel-collapse">
                                                <div class="panel-heading">
                                                    <div class="panel-tools">
                                                        <a class="panel-toggle"><i class="fa fa-chevron-down"></i></a>
                                                    </div>
                                                    Parrilla Televisa
                                                    <?php
                                                        if(isset($data['location']) && isset($data['sublocation'])){
                                                            $sublocation = filter_var($data['sublocation'],FILTER_SANITIZE_STRING);
                                                            echo ucfirst($sublocation);
                                                        }
                                                    ?>
                                                </div>
                                                <div class="panel-footer" style="display:none;">
                                                    <div class="buttons-container">
                                                        <a href="<?php echo $data['excel']; ?>" target="_blank" class="btn btn-success">Ver</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
            $mensaje = '<strong>Excel publicado</strong> <br/><small>Tu parrilla fue publicada en la App de TelevisaConnect.</small>';
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
            $error = 'Debe llenar todos los campos del formulario.';
            break;
        case 2:
            $error = 'El archivo proporcionado no es válido.';
            break;
        default:
            $error = 'Ocurrio un error al guardar la información. Intente de nuevo más tarde.';
            break;
    }
    ?>
                        toastr.error('<strong>Ocurrio un error</strong><br/><small><?php echo $error; ?></small>');
                    }, 1600);
                });
            </script>
        <?php endif; ?>
    </body>
</html>