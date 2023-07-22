<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Presentaciones</title>
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
                                    <i class="pe page-header-icon pe-7s-display1"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Videos <?php
                                                        if(isset($data['location']) && isset($data['sublocation'])){
                                                            $sublocation = filter_var($data['location'],FILTER_SANITIZE_STRING);
                                                            echo ucfirst($sublocation);
                                                        }
                                                    ?></h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar los videos publicadas en la App de TelevisaConnect.</small>
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
                                    Publicar un video
                                </div>
                                <div class="panel-body">
                                    <p>Para publicar un video en la App de TelevisaConnect llena el siguiente formulario.</p>
                                    <form method="POST" action="<?php echo $data['link']; ?>" enctype="multipart/form-data" id="descarga-form">
                                        
                                        <div class=form-group>
                                            <label>Archivo de video (en Formato MP4/AVI/MOV/WMV)</label>
                                            <input type="file" class="form-control" name="file_data" id="archivo">
                                        </div>
                                        <br/>
                                        <button type="submit" class="btn btn-default right">Enviar</button>
                                    </form>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 col-lg-6">
                            <div class="panel panel-filled">
                                <div class="panel-heading">
                                    <div class="panel-tools">
                                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                    </div>
                                    Videos publicados
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if (!empty($data['descargas'])):
                                        foreach ($data['descargas'] as $descarga):
                                            ?>
                                            <div class="col-sm-12 col-md-12">
                                                <div class="panel panel-filled panel-c-accent panel-collapse">
                                                    <div class="panel-heading">
                                                        <div class="panel-tools">
                                                            <a class="panel-toggle"><i class="fa fa-chevron-down"></i></a>
                                                        </div>
                                                        <?php echo utf8_encode($descarga->titulo); ?>
                                                    </div>
                                                    <div class="panel-body" style="display:none;">
                                                        <div class="div-notif-img">
                                                            <img src="<?php echo Doo::conf()->GLOBAL_URL . $descarga->imagen; ?>" alt="<?php echo utf8_encode($descarga->titulo); ?>" class="notificaciones-imagen"/>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer" style="display:none;">
                                                        <?php echo utf8_encode($descarga->fecha_alta); ?>
                                                        &nbsp;
                                                        <div class="buttons-container">
                                                            <a href="<?php echo $descarga->url; ?>" target="_blank" class="btn btn-success">Ver</a>
                                                            <?php
                                                                if(isset($data['sublocation']) && isset($data['location'])){
                                                                    $deleteLocation = Doo::conf()->APP_URL . 'video/'.$data['location'].'/eliminar/';
                                                                }else{
                                                                    $deleteLocation = Doo::conf()->APP_URL . 'video/eliminar/';
                                                                }
                                                            ?>
                                                            <a href="<?php echo $deleteLocation . $descarga->id_descarga; ?>" class="btn btn-danger">Eliminar</a>
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
        <?php if(isset($_GET['success'])): ?>
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
            $mensaje = '<strong>Video publicado</strong> <br/><small>Tu video fue publicado en la App de TelevisaConnect.</small>';
            break;
        case 2:
            $mensaje = '<strong>Video eliminado</strong> <br/><small>Tu video fue eliminado de la App de TelevisaConnect.</small>';
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
        <?php if(isset($_GET['error']) ): ?>
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
                            $error = 'Debe llenar todos los campos del formulario.';
                            break;
                        case 2:
                            $error = 'No existe la categoría Videos.';
                            break;
                        case 3:
                            $error = 'La URL proporcionada no es un video válida';
                            break;
                        case 4:
                            $error = 'La imágen o el archivo proporcionado no son válidos.';
                            break;
                        case 5:
                            $error = 'Los datos proporcionados no son válidos.';
                            break;
                        case 6:
                            $error = 'Ocurrio un error al guardar la información. Intente de nuevo más tarde.';
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