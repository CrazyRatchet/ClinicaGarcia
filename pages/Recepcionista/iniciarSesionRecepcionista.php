<?php
session_start(); // Siempre debe ir al principio del archivo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Clínica García</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../cssMedico/inicioSesionMedico.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header class="hero text-center">
        <div class="container">
            <h1>Bienvenido al Sistema de Administración de Clínica García</h1>
            <p>Sesión Recepcionista</p>
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
        <form method="POST" action="../../controllers/Recepcionista/autenticarRecepcionista.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" required>
            </div>
            
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="contrasena" id="contrasena" required>
            </div>
            
            <button type="submit" class="btn btn-custom btn-success">Ingresar</button>
            
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>