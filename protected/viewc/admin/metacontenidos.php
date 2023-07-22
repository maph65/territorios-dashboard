<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <!-- croppie -->
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- croppie -->
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Newsletter Metacontenidos</title>
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
                                    <i class="pe page-header-icon pe-7s-mail-open-file"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Newsletter Metacontenidos</h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar los Newsletters publicados en la App de TelevisaConnect.</small>
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
                                    Publicar un Newsletter de Metacontenidos 
                                </div>
                                <div class="panel-body">
                                    <p>Para publicar un Newsletter de Metacontenidos en la App de TelevisaConnect llena el siguiente formulario.</p>
                                    <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'newsletter/agregar'; ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="categoria" id="categoria" value="metacontenidos">
                                        <div class=form-group>
                                            <label>T&iacute;tulo del Newsletter de Metacontenidos</label>
                                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="T&iacute;tulo" maxlength="110">
                                        </div>
                                        <br/>
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
                                    &Uacute;ltimos Newsletters
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
                                                        <br/>
                                                        <p class="detalles"><?php echo utf8_encode(nl2br($descarga->descripcion)); ?></p>
                                                    </div>
                                                    <div class="panel-footer" style="display:none;">
                                                        <?php echo utf8_encode($descarga->fecha_alta); ?>
                                                        &nbsp;
                                                        <div class="buttons-container">
                                                            <a href="<?php echo Doo::conf()->GLOBAL_URL . $descarga->url; ?>" target="_blank" class="btn btn-success">Ver</a>
                                                            <a href="<?php echo Doo::conf()->APP_URL . 'newsletter/editar/' . $descarga->id_descarga.'/news-metacontenidos'; ?>" class="btn btn-success">Editar</a>
                                                            <a href="<?php echo Doo::conf()->APP_URL . 'newsletter/eliminar/' . $descarga->id_descarga.'/metacontenidos'; ?>" class="btn btn-danger">Eliminar</a>
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
        <?php if(isset($_GET['success']) ): ?>
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
            $mensaje = '<strong>Newsletter publicado</strong> <br/><small>Tu Newsletter fue publicado en la App de TelevisaConnect.</small>';
            break;
        case 2:
            $mensaje = '<strong>Newsletter eliminado</strong> <br/><small>Tu Newsletter fue eliminado de la App de TelevisaConnect.</small>';
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
                            $error = 'No existe la categoría.';
                            break;
                        case 3:
                            $error = 'La URL proporcionada no es una descarga de iBooks válida';
                            break;
                        case 4:
                            $error = 'La imágen proporcionada no es válida.';
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
                
                $uploadCrop.on('update', function (ev, data) {
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