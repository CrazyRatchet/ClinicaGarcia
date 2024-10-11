<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Registro de Usuario</h2>
    <form action="../../controllers/Admin/registrar.php" method="post">
        <!-- Datos del usuario -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>

            <div class="form-group col-md-6">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cedula">Cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" required 
                       pattern="^\d{1,2}-\d{4}-\d{4}$" 
                       title="Formato: X-XXXX-XXXX, donde X es un dígito (por ejemplo, 8-1005-2011).">
            </div>

            <div class="form-group col-md-6">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required 
                       pattern="^\d{4}-\d{4}$" 
                       title="Formato: XXXX-XXXX, donde cada X es un dígito.">
            </div>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rol">Rol:</label>
                <input type="text" class="form-control" id="rol" name="rol" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>

            <div class="form-group col-md-6">
                <label for="especialidad">Especialidad:</label>
                <input type="text" class="form-control" id="especialidad" name="especialidad" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
        </div>

        <!-- Datos de login -->
        <h4 class="mt-4">Datos de inicio de sesión</h4>

        <div class="form-group">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required pattern="^[A-Za-z0-9_]+$" title="Solo se permiten letras, números y guiones bajos.">
        </div>

        <div class="form-group">
            <label for="contrasenia">Contraseña:</label>
            <input type="password" class="form-control" id="contrasenia" name="contrasenia" required 
                   pattern=".{6,}" 
                   title="La contraseña debe tener al menos 6 caracteres.">
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Registrar">
        </div>
    </form>
</div>
