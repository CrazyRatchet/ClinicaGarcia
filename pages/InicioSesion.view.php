<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>

<form method="POST" action="../controllers/InicioSesion.php">
    <div class="mb-3">
        <label for="nombre_usuario" class="form-label">Usuario:</label>
        <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" required>
    </div>

    <div class="mb-3">
        <label for="contrasenia" class="form-label">Contraseña:</label>
        <div class="input-group">
            <input type="password" class="form-control" name="contrasenia" id="contrasenia" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-primario w-100">Ingresar</button>
</form>
