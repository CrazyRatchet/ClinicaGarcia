<?php
session_start(); // Siempre debe ir al principio del archivo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Clínica García</title>
    
    <link rel="stylesheet" href="../../css/main.min.css">
    <link rel="stylesheet" href="../../libs/bootstrap-icons/font/bootstrap-icons.css">
    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header class="hero text-center">
        <div class="container">
            <h1>Bienvenido al Sistema de Administración de Clínica García</h1>
            <p>Administre su clínica de manera eficiente y rápida</p>
        </div>
    </header>

    <div class="form-container">
        <?php
        // Código para mostrar mensajes de alerta
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-' . $_SESSION['mensaje']['tipo'] . ' alert-dismissible fade show mt-4" role="alert">';
            echo $_SESSION['mensaje']['texto'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['mensaje']); // Limpiamos el mensaje después de mostrarlo
        }
        ?>

        <h2 class="text-center">Iniciar Sesión</h2>
        <form method="POST" action="../../controllers/Admin/autenticarAdmin.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" required>
            </div>
            
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="contrasena" id="contrasena" required>
            </div>
            
            <button type="submit" class="btn btn-custom btn-success">Ingresar</button>
            <p class="text-center mt-3"><a href="registrarAdmin.php">¿No tienes cuenta? Regístrate aquí</a></p>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
        </div>
    </footer>

   
</body>
</html>