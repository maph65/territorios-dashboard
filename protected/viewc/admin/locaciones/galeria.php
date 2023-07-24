<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . 'common/headmetalinks.php'); ?>
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
            <?php include( Doo::conf()->VIEWC_PATH . 'admin/common/header.php'); ?>
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
                                    <i class="pe page-header-icon pe-7s-photo-gallery"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Galeria de <?php echo $data['locacion']->nombre; ?></h3>
                                    <small>Aqu&iacute; podr&aacute;s administrar las imagenes de la locación para la App Territorios del Saber.</small>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /header contenedor -->
                    <div class="row">
                        <?php
                        if(is_array($data['galeria']) && count($data['galeria'])):
                            foreach ($data['galeria'] as $media):
                                ?>
                                <div class="col-sm-12 col-lg-4 col-md-4">
                                    <div class="panel panel-filled">
                                        <div class="panel-body">
                                            <img src="<?php echo Doo::conf()->APP_URL.'global/'.$media->ruta; ?>" class="image-gallery">
                                        </div>
                                        <div class="panel-footer">
                                            <a href="<?php echo Doo::conf()->APP_URL.'galeria/eliminar/'.$media->id_media; ?>" class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="panel panel-filled">
                                <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'galeria/publicar'; ?>" enctype="multipart/form-data" id="form-images">
                                    <div class="panel-heading">
                                        Subir fotos
                                    </div>
                                    <div class="panel-body">
                                        <div class="upload__box">
                                            <div class="upload__btn-box">
                                                <label class="upload__btn">
                                                    <p>Seleccionar imágenes</p>
                                                    <input type="file" id="images-input" multiple="" data-max_length="20" class="upload__inputfile" name="images-upload[]" accept="image/jpeg, image/png, image/jpg">
                                                </label>
                                            </div>
                                            <div class="upload__img-wrap" id="image-upload-container"></div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <input class="btn btn-accent" type="submit" value="Guardar imagenes" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--div class="col-sm-12 col-md-6">
                            <div class="panel panel-filled">
                                <div class="panel-body">
                                    Subir foto
                                </div>
                                <div class="panel-footer">
                                    Footer
                                </div>
                            </div>
                        </div-->
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
            var imgArray = [];
            $(document).ready(function () {
                ImgUpload();
            });

            function ImgUpload() {
                var imgWrap = "";

                $('.upload__inputfile').each(function () {
                    $(this).on('change', function (e) {
                        imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                        var maxLength = $(this).attr('data-max_length');

                        var files = e.target.files;
                        var filesArr = Array.prototype.slice.call(files);
                        var iterator = 0;
                        filesArr.forEach(function (f, index) {

                            if (!f.type.match('image.*')) {
                                return;
                            }

                            if (imgArray.length > maxLength) {
                                return false
                            } else {
                                var len = 0;
                                for (var i = 0; i < imgArray.length; i++) {
                                    if (imgArray[i] !== undefined) {
                                        len++;
                                    }
                                }
                                if (len > maxLength) {
                                    return false;
                                } else {
                                    imgArray.push(f);
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                        imgWrap.append(html);
                                        iterator++;
                                    }
                                    reader.readAsDataURL(f);
                                }
                            }
                        });
                    });
                });

                $('body').on('click', ".upload__img-close", function (e) {
                    var file = $(this).parent().data("file");
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i].name === file) {
                            imgArray.splice(i, 1);
                            break;
                        }
                    }
                    $(this).parent().parent().remove();
                });
            }
            $("#form-images").submit( function(e) {
                e.preventDefault();
                var formData = new FormData();
                let files = imgArray;
                for (let i = 0; i < imgArray.length; i++) {
                    formData.append('bfuploadimg['+i+']', files[i]);
                }
                console.log('form with data');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Doo::conf()->APP_URL . 'galeria/publicar/'.$data['locacion']->id_locacion; ?>',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        console.log(data);
                        location.reload();
                    }
                });
                //return true;
            });
        </script>
    </body>

</html>