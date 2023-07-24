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
                                    <i class="pe page-header-icon pe-7s-map-marker"></i>
                                </div>
                                <div class="header-title">
                                    <h3 class="m-b-xs">Locación</h3>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!-- /header contenedor -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'locaciones/guardar'; ?>" enctype="multipart/form-data">
                                <div class="panel panel-filled">
                                    <div class="panel-heading">
                                        Agregar locación
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label>Selecciona un estado:</label>
                                            <select class="form-control" name="estado" id="estado">
                                                <?php
                                                if (!empty($data['estados'])):
                                                    foreach ($data['estados'] as $estado):
                                                        echo '<option value="' . $estado->id_estado . '">' . $estado->nombre . '</option>';
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label>Nombre de la locaci&oacute;n</label>
                                            <input type="text" class="form-control" name="nombre-locacion" id="nombre-locacion" placeholder="Nombre" maxlength="110">
                                        </div>
                                        <br/>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label>Direcci&oacute;n:</label>
                                            <textarea class="form-control" rows="3"  name="direccion" id="direccion" placeholder="Direcci&oacute;n"></textarea>
                                        </div>
                                        <br/>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label>Contenido</label>
                                            <textarea class="form-control" rows="3" placeholder="Contenido" name="contenido" id="contenido"></textarea>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label>Autor:</label>
                                            <select class="form-control" name="autor" id="autor">
                                                <?php
                                                if (!empty($data['autores'])):
                                                    foreach ($data['autores'] as $autor):
                                                        echo '<option value="' . $autor->id_autor . '">' . $autor->nombre . '</option>';
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-lg-6">
                                            <label>Visible:</label>
                                            <br/>
                                            <input type="checkbox" id="visible" name="visible">
                                            <label for="visible">Visible en la App</label>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <button type="submit" class="btn btn-default right">Guardar</button>
                                    </div>
                                </div>
                            </form>
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
    </body>

</html>