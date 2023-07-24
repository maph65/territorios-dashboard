<!DOCTYPE html>
<html>
    <head>
        <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
        <!-- croppie -->
        <link rel="stylesheet" href="<?php echo Doo::conf()->GLOBAL_URL . 'vendor/croppie/'; ?>croppie.css" />
        <!-- croppie -->
        <!-- Page title -->
        <title><?php echo Doo::conf()->APP_NAME; ?> | Autores</title>
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
                                    <i class="pe page-header-icon pe-7s-users"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Autores</h3>
                                    <small>En esta sección se administran los autores del App.</small>
                                    <br/><br/>
                                    <a href="<?php echo Doo::conf()->APP_URL; ?>autores/nuevo" class="btn btn-accent">Agregar autor</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /header contenedor -->
                    <div class="row">
                        <?php if(!empty($data['autores']) && is_array($data['autores'])):
                            foreach ($data['autores'] as $autor):
                                ?>
                                <div class="col-md-6 col-sm-12 col-lg-3">
                                    <div class="panel panel-filled">
                                        <div class="panel-heading">
                                            <?php echo $autor->nombre; ?>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            $urlFoto = Doo::conf()->APP_URL.'global/img/autor_sin_foto.png';
                                            if($autor->url_foto){
                                                $urlFoto = Doo::conf()->APP_URL . 'global/'. $autor->url_foto;
                                            }
                                            ?>
                                            <img src="<?php echo $urlFoto; ?>" class="foto-autor">
                                        </div>
                                        <div class="panel-footer"><a class="btn btn-danger" href="<?php echo Doo::conf()->APP_URL; ?>autores/eliminar/<?php echo $autor->id_autor; ?>">Eliminar</a></div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
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
            $mensaje = '<strong>Autor Agregado</strong> <br/><small>El autor ha sido creado de manera exitosa.</small>';
            break;
        case 2:
            $mensaje = '<strong>Autor eliminado</strong> <br/><small>Se ha eliminado el autor correctamente.</small>';
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
                                $error = 'No se pudo crear el autor.';
                                break;
                            case 2:
                                $error = 'La imágen proporcionada no es un archivo de imáge válido.';
                                break;
                            case 3:
                                $error = 'Todos los campos son olbigatorios.';
                                break;
                            default:
                                $error = 'Ocurrio un error y no se pudo crearl el autor.';
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