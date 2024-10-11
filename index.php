<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.min.css">
  <link rel="stylesheet" href="libs/bootstrap-icons/font/bootstrap-icons.css">
  <script src="libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <title>Clinica García</title>
</head>

<body class="d-flex flex-column min-vh-100">
<?php
session_start(); // Esto debe estar antes de cualquier salida al navegador
?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><!--Logo-->
            <img src="assets/logo.png" alt="Clínica García" width="60" height="60">
            <!--Nombre-->
            Clínica García</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="pages/Administrador/registrar.view.php">Registrar</a>
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
                <form method="POST" action="controllers/cierreSesion.php">
                    <button class="btn btn-outline-light" type="submit">Log out</button>
                </form>
            <?php else : ?>
                <!-- Mostrar botón de iniciar sesión si el usuario no está autenticado -->
                <a href="pages/InicioSesion.view.php">
                    <button class="btn btn-outline-light" type="button">Iniciar Sesión</button>
                </a>
            <?php endif; ?>

        </div>
    </div>
</nav>
<br><br><br><br><br><br><br>
  
  <!--Sección de inicio-->
  <section class="intro flex-grow-1">
    <div class="container-lg">
      <div class="row justify-content-center">
        <div class="col-md-5 text-center text-md-start">
          <h1>
            <div class="display-2 text-primario">Sistema de Administración</div>
            <div class="display-5 text-primario">Clínica García</div>
          </h1>
        </div>

        <div class="col-md-5 text-center d-none d-md-block">
          <img class="img-fluid" src="assets/image.png" alt="php">
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-primario text-white text-center py-3">
    <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
  </footer>

</body>

</html>
