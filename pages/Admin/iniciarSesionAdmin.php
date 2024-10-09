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

<body class="d-flex flex-column min-vh-100">
    <!-- Header con bienvenida -->
    <header class="bg-primario text-white text-center py-4">
        <div class="container">
            <h1>Bienvenido al Sistema de Administración de Clínica García</h1>
            <p>Administre su clínica de manera eficiente y rápida</p>
        </div>
    </header>

    <!-- Contenedor del formulario -->
    <div class="container flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="w-100" style="max-width: 400px;">
            <!-- Mostrar alertas -->
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-' . $_SESSION['mensaje']['tipo'] . ' alert-dismissible fade show mt-4" role="alert">';
                echo $_SESSION['mensaje']['texto'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['mensaje']); // Limpiamos el mensaje después de mostrarlo
            }
            ?>

            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form method="POST" action="../../controllers/Admin/autenticarAdmin.php">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" required>
                </div>
                
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="contrasena" id="contrasena" required>
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primario w-100">Ingresar</button>
                <p class="text-center mt-3 text-primario"><a href="registrarAdmin.php">¿No tienes cuenta? Regístrate aquí</a></p>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primario text-white text-center py-3 mt-auto">
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
    </footer>

    <script>
        // Mostrar u ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordField = document.getElementById('contrasena');
            var passwordFieldType = passwordField.getAttribute('type');
            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordField.setAttribute('type', 'password');
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    </script>
</body>
</html>
