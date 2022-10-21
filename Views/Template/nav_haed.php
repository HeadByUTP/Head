<header>
            <!-- Inicio Header -->
            <div class="header-area">
                <div class="main-header ">
                    <div class="header-top d-lg-block">
                        <div class="container">
                            <div class="col-xl-12">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="header-info-left">
                                        <ul>
                                            <li>
                                                <i class="far fa-clock"></i>
                                                <script>
                                                    var f = new Date();
                                                    document.write(f.getDate() + "/" + (
                                                        f.getMonth() + 1
                                                    ) + "/" + f.getFullYear());
                                                </script>
                                            </li>
                                            <li>
                                                <b>Herramienta de Autoevaluación Docente HAED</b>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="header-info-right"> 
                                        <ul class="header-social">
                                            <li>Hola: <b><?php echo empty($_SESSION['userData']['nombres']) ? 'Usuario' : ($_SESSION['userData']['nombres']); ?></b></li>
                                            <li class="submenu dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <img src="http://assets.stickpng.com/thumbs/585e4bf3cb11b227491c339a.png" width="30" height="30" class="rounded-circle m-0">
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <?php if(!(empty($_SESSION['login']))){ ?>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/usuarios/perfil">Mi perfil</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/respuestas">Resultados</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/salir">Cerrar sesión</a>
                                                    </li>
                                                    <?php } else{?>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/iniciar">Iniciar sesión</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/registro">Registrarse</a>
                                                    </li> 
                                                    <?php } ?>
                                                    <nav class="cd-main-nav js-main-nav"></nav>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-bottom  header-sticky">
                        <div class="container">
                            <div
                                class="row align-items-center">
                                <!-- Logo -->
                                <div class="col-xl-2 col-lg-8">
                                    <div class="logo">
                                        <a
                                            href="<?= base_url(); ?>">
                                            <!-- <img width="40" height="25" src="<?= media(); ?>/haedclient/images/logo_TICeducativa_normal.png" alt=""> -->
                                            <img width="80" height="40" src="<?= media(); ?>/haedclient/images/logo_TICeducativa_normal.png" alt="">
                                            <img width="60" height="60" src="<?= media(); ?>/haedclient/images/calidad.png" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-4">
                                    <div
                                        class="menu-wrapper  d-flex align-items-center justify-content-end">
                                        <!-- Main-menu -->
                                        <div class="main-menu d-none d-lg-block">
                                            <nav>
                                                <ul id="navigation">
                                                    <li>
                                                        <a href="<?= base_url(); ?>">Inicio</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/descubre">Descubre
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/autoevaluacion">Autoevaluación</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/canal">Canal YouTube</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?= base_url(); ?>/contacto">Contacto</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <!-- Mobil Menu -->
                                <div class="col-12">
                                    <div class="mobile_menu d-block d-lg-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final Header -->
        </header>