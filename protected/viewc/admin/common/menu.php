<?php 
$usuario = unserialize($_SESSION['usuario']);
$permisos = isset($usuario->permisos) ? unserialize($usuario->permisos) : array();
$location = (isset($data['location'])) ? $data['location'] : 'inicio';  
$sublocation = (isset($data['sublocation'])) ? $data['sublocation'] : NULL;
?>
<!-- Navigation-->
<aside class="navigation">
    <nav>
        <ul class="nav luna-nav">
            <li class="nav <?php if($location=='inicio'){ echo 'active'; } ?>">
                <a href="<?php echo Doo::conf()->APP_URL . 'locaciones'; ?>">Inicio</a>
            </li>
            <li class="nav <?php if($location=='locaciones'){ echo 'active'; } ?>"><a href="<?php echo Doo::conf()->APP_URL . 'locaciones'; ?>">Locaciones</a></li>
        </ul>
    </nav>
</aside>
<!-- End navigation-->