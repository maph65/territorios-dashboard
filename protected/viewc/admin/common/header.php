<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <div id="mobile-menu">
                <div class="left-nav-toggle">
                    <a href="#">
                        <i class="stroke-hamburgermenu"></i>
                    </a>
                </div>
            </div>
            <a class="navbar-brand" href="<?php echo Doo::conf()->APP_URL; ?>">
                <img src="<?php echo Doo::conf()->GLOBAL_URL ?>img/iconapp.png" alt="Territorios" width="40" />
                <p>Territorios del Saber</p>
            </a>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="left-nav-toggle">
                <a href="">
                    <i class="stroke-hamburgermenu"></i>
                </a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                
                <li class=" profil-link">
                    <a href="#">
                        <span class="profile">Has iniciado sesi&oacute;n como <?php echo $data['usr']->nombre; ?></span>
                    </a>
                </li>
            </ul>
        </div>


    </div>
</nav>