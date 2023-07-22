<!DOCTYPE html><?php $d = $data['descarga']; ?>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH.'/common/headmetalinks.php'); ?>
        <!-- croppie -->
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- croppie -->
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | iBooks</title>
    </head>
    <body>
        <!-- Wrapper-->
        <div class="wrapper">
            <!-- Header-->
            <?php include(Doo::conf()->VIEWC_PATH.'admin/common/header.php'); ?>
            <!-- End header-->
            <!-- menu -->
            <?php include(Doo::conf()->VIEWC_PATH.'admin/common/menu.php'); ?>
            <!-- /menu -->
            <!-- Main content-->
            <section class="content">
                <div class="container-fluid">
                    <!-- header contenedor -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="view-header">
                                <div class="header-icon">
                                    <i class="pe page-header-icon pe-7s-bookmarks"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">iBooks</h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar los iBooks publicados en la App de TelevisaConnect.</small>
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
                                    Editar iBook
                                </div>
                                <div class="panel-body">
                                    <?php
                                        if(isset($data['sublocation']) && isset($data['location'])){
                                            $sublocation = filter_var($data['location'],FILTER_SANITIZE_STRING);
                                            $formAction = Doo::conf()->APP_URL . 'ibooks/'.$sublocation.'/actualizar/';
                                        }else{
                                            $formAction = Doo::conf()->APP_URL . 'ibooks/actualizar/';
                                        }
                                    ?>
                                    <form method="POST" action="<?php echo $formAction.$d->id_descarga; ?>" enctype="multipart/form-data">
                                        <div class=form-group>
                                            <label>T&iacute;tulo del iBook</label>
                                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="T&iacute;tulo" maxlength="110" value="<?php echo utf8_encode($d->titulo); ?>">
                                        </div>
                                        <br/>
                                        <div class=form-group>
                                            <label>Descripci&oacute;n</label>
                                            <textarea class="form-control" rows="3" placeholder="descripcion" name="descripcion" id="contenido"><?php echo utf8_encode($d->descripcion); ?></textarea>
                                        </div>
                                         <div class=form-group>
                                            <label>Imagen Actual</label>
                                            <img src="<?php echo Doo::conf()->GLOBAL_URL.$d->imagen; ?>" alt="<?php echo utf8_encode($d->titulo); ?>" class="imagen-destacada-editar" />
                                            <label>Imagen</label>
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
                                        <br/>
                                        <div class=form-group>
                                            <label>URL de descarga del iBook</label>
                                            <input type="text" class="form-control" name="url" id="url" placeholder="http://ejemplo.com/url-del-ibook.ibook" maxlength="250" value="<?php echo utf8_encode($d->url); ?>">
                                        </div>
                                        <br/>
                                        <button type="submit" class="btn btn-default right">Actualizar</button>
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