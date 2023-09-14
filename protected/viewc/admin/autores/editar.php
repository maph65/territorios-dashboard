<?php $autor = $data['autor']; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
        <!-- ckeditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/translations/es.js"></script>
        <!-- /ckeditor -->
        <!-- croppie -->
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- croppie -->
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Editar autor</title>
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
                                    <i class="pe page-header-icon pe-7s-users"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Autores</h3>
                                    <small>En esta sección se administran los autores del App.</small>
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
                                    Editar autor
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'autores/nuevo/crear'; ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="idautor" id="idautor" value="<?php echo $autor->id_autor; ?>" />
                                        <div class=form-group>
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" maxlength="120" value="<?php echo $autor->nombre; ?>">
                                        </div>
                                        <br/>
                                        <div class=form-group>
                                            <label>Biograf&iacute;a</label>
                                            <textarea class="form-control" rows="3" placeholder="Contenido" name="contenido" id="contenido"><?php echo $autor->bilografia; ?></textarea>
                                        </div>
                                        <div class=form-group>
                                            <label>Subir nueva foto</label>
                                            <input type="file" class="form-control" name="imagen" id="imagen">
                                            <input type="hidden" name="viewport-x" id="viewport-x" value="350">
                                            <input type="hidden" name="viewport-y" id="viewport-y" value="350">
                                            <input type="hidden" name="imagen-orig-x" id="imagen-orig-x" value="0">
                                            <input type="hidden" name="imagen-orig-y" id="imagen-orig-y" value="0">
                                            <input type="hidden" name="imagen-orig-zoom" id="imagen-orig-zoom" value="1">
                                        </div>
                                        <div class="form-group">
                                            <label>Vista previa</label>
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
                        width: 350,
                        height: 350,
                    },
                    boundary: {
                        width: 350,
                        height: 350
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
        <script>
            ClassicEditor
                .create(
                    document.querySelector( '#contenido' ), {
                        language: 'es',
                        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed']
                    }
                )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    </body>

</html>