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
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo $prefix; ?>Administrador/registrar.view.php">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
            </ul>

            <!-- Lógica de autenticación -->
            <?php if (isset($_SESSION['usuario'])) : ?>
                <!-- Mostrar botón de logout si el usuario está autenticado -->
                <form method="POST" action="<?php echo $prefix; ?>../controllers/cierreSesion.php">
                    <button class="btn btn-outline-light" type="submit">Log out</button>
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
