<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Clínica García - Menú Principal - Médico</title>

    <link rel="stylesheet" href="../../css/main.min.css">
    <link rel="stylesheet" href="../../libs/bootstrap-icons/font/bootstrap-icons.css">
    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primario">
        <div class="container-fluid">
        <a class="navbar-brand text-light" href="../../index.php">
          <!--Logo-->
          <img src="../../assets/logo.png" alt="Clínica García" width="60" height="60">
          <!--Nombre-->
          Clínica García</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../controllers/Medico/logoutMedico.php">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor para las alertas -->
    <div class="container mt-3">
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-' . $_SESSION['mensaje']['tipo'] . ' alert-dismissible fade show" role="alert">';
            echo $_SESSION['mensaje']['texto'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['mensaje']);
        }
        ?>
    </div>

    <!-- Contenido principal -->
    <div class="container flex-grow-1 mt-5">
        <h1 class="text-center mb-4">Bienvenido al Sistema de Gestión de Clínica García</h1>
        <div class="row row-cols-1 row-cols-md-2 g-4">

            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Ver historial médico del paciente</h5>
                        <p class="card-text">Consulta el historial médico completo de tus pacientes.</p>
                        <a href="#" class="btn btn-secundario w-100">Ver historial médico</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Ver lista de citas</h5>
                        <p class="card-text">Accede a la lista de citas programadas para tus pacientes.</p>
                        <a href="#" class="btn btn-secundario w-100">Ver lista de citas</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primario text-white text-center py-3 mt-auto">
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
    </footer>

</body>

</html>
