<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Detalles del video</title>
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
                                    <p>A continuaci&oacute;n proporciona la informaci&oacute;n del video</p>
                                    <?php 
                                        $formAction = Doo::conf()->APP_URL . 'videos/agregar';
                                        if(isset($data['location']) && isset($data['sublocation'])){
                                            $sublocation = filter_var($data['location'],FILTER_SANITIZE_STRING);
                                            $formAction = Doo::conf()->APP_URL . 'videos/'.$sublocation.'/agregar';
                                        }
                                    ?>
                                    <form method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data" id="descarga-form">
                                        <div class=form-group>
                                            <label>T&iacute;tulo del video</label>
                                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="T&iacute;tulo" maxlength="110">
                                        </div>
                                        <br/>
                                        <div class=form-group>
                                            <label>Descripci&oacute;n</label>
                                            <textarea class="form-control" rows="3" placeholder="descripcion" name="descripcion" id="descripcion"></textarea>
                                        </div>
                                         <div class=form-group>
                                            <label>Imagen destacada</label>
                                            <input type="file" class="form-control" name="imagen" id="imagen">
                                            <input type="hidden" name="viewport-x" id="viewport-x" value="360">
                                            <input type="hidden" name="viewport-y" id="viewport-y" value="200">
                                            <input type="hidden" name="imagen-orig-x" id="imagen-orig-x" value="0">
                                            <input type="hidden" name="imagen-orig-y" id="imagen-orig-y" value="0">
                                            <input type="hidden" name="imagen-orig-zoom" id="imagen-orig-zoom" value="1">
                                        </div>
                                        <div class="form-group">
                                            <div id="imagen-crop"></div>
                                            <div class="render-imagen"></div>
                                        </div>
                                        <div class="form-group">
                                            <iframe src="<?php echo $data['video_uri_https']; ?>" frameborder="0" class="video-frame" webkitallowfullscreen mozallowfullscreen allowfullscreen allowtransparency="true"></iframe>
                                        </div>
                                        <input type="hidden" class="form-control" name="archivo" id="archivo" value="<?php echo $data['video_uri']; ?>">
                                        <input type="hidden" class="form-control" name="vimeo_uri" id="vimeo_uri" value="<?php echo $data['vimeo_uri']; ?>">
                                        <br/>
                                        <button type="submit" class="btn btn-default right">Publicar</button>
                                    </form>
                                </div>
                                <div class="panel-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6"></div>
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
                            $error = 'La URL proporcionada no es un video válido';
                            break;
                        case 4:
                            $error = 'La imágen o el archivo proporcionado no son válidos.';
                            break;
                        case 5:
                            $error = 'Los datos proporcionados no son válidos.';
                            break;
                        case 6:
                            $error = 'Ocurrio un error al guardar la niformación. Intente de nuevo más tarde.';
                            break;
                        default:
                            $error = 'Ocurrio un error al guardar la niformación. Intente de nuevo más tarde.';
                            break;
                    }
                    ?>
                    toastr.error('<strong>Ocurrio un error</strong><br/><small><?php echo $error; ?></small>');
                }, 1600);
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