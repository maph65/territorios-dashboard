<!DOCTYPE html><?php $n = $data['notificacion']; ?>
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
            <?php include(Doo::conf()->VIEWC_PATH . 'admin/common/header.php'); ?>
            <!-- End header-->
            <!-- menu -->
            <?php include(Doo::conf()->VIEWC_PATH . 'admin/common/menu.php'); ?>
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
                                    <h3 class="m-b-xs">Editar Notificaci&oacute;n</h3>
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
                                    Editar notificaci&oacute;n
                                </div>
                                <div class="panel-body">
                                    <p>Para enviar una notificaci&oacute;n a los usuarios de la App de TelevisaConnect llena el siguiente formulario.</p>
                                    <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'notificaciones/actualizar/'.$n->id_notificacion; ?>" enctype="multipart/form-data">
                                        <div class=form-group>
                                            <label>Selecciona una categor&iacute;a:</label>
                                        </div>
                                        <select class="form-control" name="categoria" id="categoria">
                                            <?php
                                            if (!empty($data['categorias'])):
                                                foreach ($data['categorias'] as $cat):
                                                    if($n->id_categoria == $cat->id_categoria ){
                                                        echo '<option value="' . $cat->id_categoria . '" selected="selected">' . utf8_encode($cat->nombre) . '</option>';
                                                    }else{
                                                        echo '<option value="' . $cat->id_categoria . '">' . utf8_encode($cat->nombre) . '</option>';
                                                    }
                                                endforeach;
                                            endif;
                                            ?>
                                        </select><br/>
                                        <div class=form-group>
                                            <label>T&iacute;tulo</label>
                                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="T&iacute;tulo" maxlength="110" value="<?php echo utf8_encode($n->titulo); ?>">
                                        </div>
                                        <br/>
                                        <div class=form-group>
                                            <label>Contenido</label>
                                            <textarea class="form-control" rows="3" placeholder="Contenido" name="contenido" id="contenido"><?php echo utf8_encode($n->detalles); ?></textarea>
                                        </div>
                                        <div class=form-group>
                                            <label>Imagen actual</label>
                                            <img src="<?php echo Doo::conf()->GLOBAL_URL.$n->imagen; ?>" alt="<?php echo utf8_encode($n->titulo); ?>" class="imagen-destacada-editar" />
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