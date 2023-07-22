<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
        <!-- croppie -->
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- croppie -->
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Notificaciones</title>
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
                                    <i class="pe page-header-icon pe-7s-comment"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Notificaciones</h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar las notificaciones de la App de TelevisaConnect.</small>
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
                                    Agregar y enviar una notificaci&oacute;n
                                </div>
                                <div class="panel-body">
                                    <p>Para enviar una notificaci&oacute;n a los usuarios de la App de TelevisaConnect llena el siguiente formulario.</p>
                                    <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'notifcaciones/completa/enviar'; ?>" enctype="multipart/form-data">
                                        <div class=form-group>
                                            <label>Selecciona una categor&iacute;a:</label>
                                        </div>
                                        <select class="form-control" name="categoria" id="categoria">
                                            <?php
                                            if (!empty($data['categorias'])):
                                                foreach ($data['categorias'] as $cat):
                                                    echo '<option value="' . $cat->id_categoria . '">' . utf8_encode($cat->nombre) . '</option>';
                                                endforeach;
                                            endif;
                                            ?>
                                        </select><br/>
                                        <div class=form-group>
                                            <label>Enviar notificaci&oacute;n</label>
                                            <p class="help-block">Marca la casilla para enviar la notificaci&oacute;n a los dispositivos.</p>
                                            <input type="checkbox" name="enviar" id="enviar"> Enviar notificaci&oacute;n
                                        </div>
                                        <div class=form-group>
                                            <label>Mensaje de la notificaci&oacute;n</label>
                                            <p class="help-block">&Eacute;ste ser&aacute; el mensaje que se env&iacute;e v&iacute;a Push Notification a los dispositivos.</p>
                                            <input type="text" class="form-control" name="mensaje" id="mensaje" placeholder="Mensaje (Máx. 110 caracteres)" maxlength="110">
                                        </div>
                                        <br/>
                                        <div class=form-group>
                                            <label>T&iacute;tulo</label>
                                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="T&iacute;tulo" maxlength="110">
                                        </div>
                                        <br/>
                                        <div class=form-group>
                                            <label>Contenido</label>
                                            <textarea class="form-control" rows="3" placeholder="Contenido" name="contenido" id="contenido"></textarea>
                                        </div>
                                        <div class=form-group>
                                            <label>Imagen</label>
                                            <input type="file" class="form-control" name="imagen" id="imagen">
                                            <input type="hidden" name="viewport-x" id="viewport-x" value="360">
                                            <input type="hidden" name="viewport-y" id="viewport-y" value="200">
                                            <input type="hidden" name="imagen-orig-x" id="imagen-orig-x" value="0">
                                            <input type="hidden" name="imagen-orig-y" id="imagen-orig-y" value="0">
                                            <input type="hidden" name="imagen-orig-zoom" id="imagen-orig-zoom" value="1">
                                        </div>
                                        <div class="form-group">
                                            <label>Imagen destacada</label>
                                            <div id="imagen-crop"></div>
                                            <div class="render-imagen"></div>
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
                                    &Uacute;ltimas notificaciones
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if (!empty($data['notificaciones'])):
                                        foreach ($data['notificaciones'] as $notif):
                                            ?>
                                            <div class="col-sm-12 col-md-12">
                                                <div class="panel panel-filled panel-c-accent panel-collapse">
                                                    <div class="panel-heading">
                                                        <div class="panel-tools">
                                                            <a class="panel-toggle"><i class="fa fa-chevron-down"></i></a>
                                                        </div>
                                                        <?php echo utf8_encode($notif->titulo); ?>
                                                    </div>
                                                    <div class="panel-body" style="display:none;">
                                                        <div class="div-notif-img">
                                                            <img src="<?php echo Doo::conf()->GLOBAL_URL . $notif->imagen; ?>" alt="<?php echo utf8_encode($notif->titulo); ?>" class="notificaciones-imagen"/>
                                                        </div>
                                                        <p class="detalles"><?php echo utf8_encode(nl2br($notif->detalles)); ?></p>
                                                    </div>
                                                    <div class="panel-footer" style="display:none;">
                                                        <?php echo utf8_encode($notif->CtCategoriaNotificacion->nombre . ' - ' . $notif->fecha); ?>
                                                        &nbsp;
                                                        <div class="buttons-container">
                                                            <a href="<?php echo Doo::conf()->APP_URL.'notificaciones/eliminar/'.$notif->id_notificacion; ?>" class="btn btn-danger">Eliminar</a>
                                                            <a href="<?php echo Doo::conf()->APP_URL.'notificaciones/editar/'.$notif->id_notificacion; ?>" class="btn btn-success">Editar</a>
                                                            <!-- <a href="#" class="btn btn-success">Editar</a> -->
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
            $mensaje = '<strong>Notificación enviada</strong> <br/><small>Tu notificación se ha enviado a los teléfonos con la aplicación instalada.</small>';
            break;
        case 2:
            $mensaje = '<strong>Notificación eliminada</strong> <br/><small>Se ha eliminado correctamente la notificación.</small>';
            break;
        case 2:
            $mensaje = '<strong>Notificación actualizada</strong> <br/><small>Se ha actualizado correctamente la notificación.</small>';
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
            $error = 'No puedes enviar notificaciones vacías. Coloca un texto de máximo 110 caracteres.';
            break;
        case 2:
            $error = 'La imágen proporcionada no es un archivo de imáge válido.';
            break;
        case 3:
            $error = 'Todos los campos son olbigatorios.';
            break;
        case 4:
            $error = 'Ocurrio un error y no se pudo enviar la notificación. Intenta de nuevo más tarde.';
            break;
        case 5:
            $mensaje = '<strong>Notificación no encontrada</strong> <br/><small>No se encontró la notificación solicitada.</small>';
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
        <script type="text/javascript">
            $(document).ready(function() {
                var $uploadCrop;
                function readFile(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $uploadCrop.croppie('bind', {
                                url: e.target.result
                            });
                            $('.render-imagen').addClass('ready');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                    else {
                        swal("Sorry - you're browser doesn't support the FileReader API");
                    }
                }
                $uploadCrop = $('#imagen-crop').croppie({
                    viewport: {
                        width: 360,
                        height: 200,
                    },
                    boundary: {
                        width: 360,
                        height: 200
                    },
                    exif: true
                });

                $uploadCrop.on('update', function(ev, data) {
                    //console.log(data);
                    origx = data.points[0];
                    origy = data.points[1];
                    zoom = data.zoom;
                    $('#imagen-orig-x').val(origx);
                    $('#imagen-orig-y').val(origy);
                    $('#imagen-orig-zoom').val(zoom);
                });

                $('#imagen').on('change', function() {
                    readFile(this);
                });
                $('.render-imagen').on('click', function(ev) {
                    $uploadCrop.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function(resp) {
                        popupResult({
                            src: resp
                        });
                    });
                });
            });
        </script>
        <script src="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.min.js"></script>
    </body>

</html>