<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <?php
        // Obtener la ruta actual (sin el dominio)
        $current_path = $_SERVER['REQUEST_URI'];

        // Determinar si quitar ../ en base a la ruta actual (puedes ajustar según sea necesario)
        $prefix = (strpos($current_path, '/ClinicaGarcia/pages/InicioSesion.view.php') !== false) ? '' : '../';
        ?>

        <!-- Logo y nombre de la clínica -->
        <a class="navbar-brand" href="<?php echo $prefix; ?>../index.php">
            <img src="<?php echo $prefix; ?>../assets/logo.png" alt="Clínica García" width="60" height="60">
            Clínica García
        </a>

        <!-- Botón para el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú desplegable -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrador
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?php echo $prefix; ?>Administrador/registrar.view.php">Registrar</a>
                            <span class="dropdown-item text-muted">Registrar</span>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $prefix; ?>Administrador/gestion_usuarios.view.php">Gestión de Usuarios</a>
                            <span class="dropdown-item text-muted">Gestión de Usuarios</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $prefix; ?>Administrador/roles.view.php">Roles</a>
                            <span class="dropdown-item text-muted">Roles</span>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $prefix; ?>Administrador/permisos.view.php">Permisos</a>
                            <span class="dropdown-item text-muted">Permisos</span>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $prefix; ?>Administrador/servicios.view.php">Servicios</a>
                            <span class="dropdown-item text-muted">Servicios</span>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo $prefix; ?>Administrador/especialidades.view.php">Especialidades</a>
                            <span class="dropdown-item text-muted">Especialidades</span>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Médico
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $prefix; ?>Medicos/Gestionar_datos_medicos.view.php">Gestionar Datos Medicos</a></li>
                        <!--<li><a class="dropdown-item" href="<?php echo $prefix; ?>Medicos/Gestionar_Historial.view.php">Gestionar Historial Medico</a></li>-->
                        <li><a class="dropdown-item" href="<?php echo $prefix; ?>Medicos/ConsultarCitas.view.php">Consultar Citas</a></li>
                    </ul>
                </li>
    
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrativos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $prefix; ?>Administrativos/RegistrarPacientes.view.php">RegistrarPacientes</a></li>
                        <li><a class="dropdown-item" href="<?php echo $prefix; ?>Administrativos/GestionarPacientes.view.php">GestionarPacientes</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Citas
                    </a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo $prefix; ?>Citas/AgendarCitas.view.php">Agendar Citas</a></li>
                    <li><a class="dropdown-item" href="<?php echo $prefix; ?>Citas/GestionarCitas.view.php">Gestionar Citas</a></li>
                    </ul>
                </li>

                <!-- Sección disabled, por ejemplo -->
                <li class="nav-item">
                    <span class="nav-link text-muted">Disabled</span>
                </li>
            </ul>

            <!-- Lógica de autenticación -->
            <?php if (isset($_SESSION['loggedin'])) : ?>
                <!-- Mostrar botón de logout si el usuario está autenticado -->
                <form method="POST" action="<?php echo $prefix; ?>../controllers/cierreSesion.php">
                    <button class="btn btn-outline-light" type="submit">Cerrar Sesión</button>
                </form>
            <?php else : ?>
                <!-- Mostrar botón de iniciar sesión si el usuario no está autenticado -->
                <a href="<?php echo $prefix; ?>InicioSesion.view.php">
                    <button class="btn btn-outline-light" type="button">Iniciar Sesión</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>