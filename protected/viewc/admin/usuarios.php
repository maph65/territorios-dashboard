<!DOCTYPE html>
<html>
<head>
    <?php include(Doo::conf()->VIEWC_PATH . '/common/headmetalinks.php'); ?>
    <!-- Page title -->
    <title><?php echo Doo::conf()->APP_NAME; ?> | Inicio</title>
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
                            <i class="pe page-header-icon pe-7s-user"></i>
                        </div>
                        <div class="header-title">
                            <h3 class="m-b-xs">Administrar  usuarios</h3>
                            <small>Aqu&iacute; podr&aacute;s administrar los usuarios de &eacute;ste panel administrativo.</small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <!-- /header contenedor -->
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            Crear un nuevo usuario
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="<?php echo Doo::conf()->APP_URL . 'usuario/crear'; ?>">
                                <div class=form-group>
                                    <label>Nombre del usuario</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" maxlength="60">
                                </div>
                                <div class=form-group>
                                    <label>Correo electr&oacute;nico</label>
                                    <input type="text" class="form-control" name="email" placeholder="Correo electr&oacute;nico" maxlength="60">
                                </div>
                                <div class=form-group>
                                    <label>Contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="passwd" placeholder="**********" maxlength="60">
                                </div>
                                <div class=form-group>
                                    <label>Confirmar contrase&ntilde;a</label>
                                    <input type="password" class="form-control" name="passwdconf" placeholder="**********" maxlength="60">
                                </div>
                                <div class=form-group>
                                    <label>Permisos:</label>

                                    <?php
                                    if (!empty($data['permisos'])):
                                        foreach ($data['permisos'] as $key => $permiso):
                                            //echo '<option value="' . $id . '">' . $permiso . '</option>';
                                            echo '<div class="checkbox"><label> <input type="checkbox" name="permisos[]" value="' . $key . '"> ' . $permiso . ' </label> </div>';
                                        endforeach;
                                    endif;
                                    ?><br/>
                                </div>
                                <button type="submit" class="btn btn-default right">Registrar</button>
                            </form>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div>
                            Usuarios registados
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Correo electr&oacute;nico</td>
                                    <td>Eliminar</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //print_r($data['usuarios']);
                                if(!empty($data['usuarios']) && is_array($data['usuarios'])){
                                    foreach ($data['usuarios'] as $usr){
                                        echo '<tr><td>'.$usr->nombre.'</td><td>'.$usr->correo.'</td><td><a href="'.Doo::conf()->APP_URL.'usuario/eliminar/'.$usr->id_usuario.'" class="btn btn-danger">Eliminar</a></td></tr>';
                                    }
                                }else{
                                    echo '<tr><td colspan="3">No ha usuarios registrados</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
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
                switch (intval($_GET['success'])) {
                    case 1:
                        $mensaje = '<strong>Usuario creado</strong> <br/><small>El usuario fue creado exitosamente.</small>';
                        break;
                    case 2:
                        $mensaje = '<strong>Usuario eliminado</strong> <br/><small>El usuario fue eliminado exitosamente.</small>';
                        break;
                    default:
                        $mensaje = 'El usuario no pudo ser creado, intenta de nuevo más tarde.';
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
                        $error = 'Todos los campos del formulario son obligatorios.';
                        break;
                    case 2:
                        $error = 'El correo electrónico proporcionado no es válido.';
                        break;
                    case 3:
                        $error = 'Ya existe una cuenta de usuario con el correo electrónico proporcionado.';
                        break;
                    case 4:
                        $error = 'Las contraseñas no coiniciden.';
                        break;
                    default:
                        $error = 'El usuario no pudo ser creado, intenta de nuevo más tarde.';
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