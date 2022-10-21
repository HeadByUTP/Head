    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media();?>/images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>">
                <i class="app-menu__icon fa fa-globe"></i>
                <span class="app-menu__label">Ir al sitio web</span>
            </a>
        </li>
        <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][2]['r'])){ ?>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
                <span class="app-menu__label">Usuarios</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?= base_url(); ?>/usuarios"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
                <li><a class="treeview-item" href="<?= base_url(); ?>/roles"><i class="icon fa fa-circle-o"></i> Roles</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/clientes">
                <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
                <span class="app-menu__label">Profesores</span>
            </a>
        </li> 
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][4]['r'])){ ?>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fas fa-school" aria-hidden="true"></i>
                <span class="app-menu__label">Datos académicos</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?= base_url(); ?>/universidades"><i class="icon fa fa-circle-o"></i> Universidades</a></li>
                <li><a class="treeview-item" href="<?= base_url(); ?>/carreras"><i class="icon fa fa-circle-o"></i> Carreras</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][5]['r']) || !empty($_SESSION['permisos'][6]['r']) || !empty($_SESSION['permisos'][7]['r']) || !empty($_SESSION['permisos'][8]['r']) || !empty($_SESSION['permisos'][9]['r']) || !empty($_SESSION['permisos'][10]['r']) ){ ?>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon far fa-file-alt" aria-hidden="true"></i>
                <span class="app-menu__label">HAED</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/cuestionario"><i class="icon fa fa-circle-o"></i> Cuestionario</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][6]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/cuatrimestres"><i class="icon fa fa-circle-o"></i> Cuatrimestres</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][7]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/temas"><i class="icon fa fa-circle-o"></i> Temas</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][8]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/secciones"><i class="icon fa fa-circle-o"></i> Secciones</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][9]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/tipopreguntas"><i class="icon fa fa-circle-o"></i> Tipo preguntas</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][14]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/preguntasinicio"><i class="icon fa fa-circle-o"></i> Preguntas</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][11]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/respuestas">
                <i class="app-menu__icon fas fa-poll-h" aria-hidden="true"></i>
                <span class="app-menu__label">Respuestas</span>
            </a>
        </li> 
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][13]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/contactos">
                <i class="app-menu__icon fas fa-envelope" aria-hidden="true"></i>
                <span class="app-menu__label">Contactos</span>
            </a>
        </li> 
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][12]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/videos">
                <i class="app-menu__icon fas fa-poll-h" aria-hidden="true"></i>
                <span class="app-menu__label">Videos</span>
            </a>
        </li> 
        <?php } ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/logout">
                <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
                <span class="app-menu__label">Cerrar sesión</span>
            </a>
        </li>
      </ul>
    </aside>