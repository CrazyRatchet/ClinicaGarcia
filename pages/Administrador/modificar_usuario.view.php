<?php
include '../../db/Database.php';
include '../../db/Roles.php';
include '../../db/Especialidades.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$rolesModel = new Roles($db);
$especialidadesModel = new Especialidades($db);

// Cargar el usuario a modificar
$usuarioId = $_GET['id'] ?? null;
if (!$usuarioId) {
    echo "Error: No se especificó el ID del usuario.";
    exit();
}

// Cargar los datos del usuario
$query = "SELECT * FROM usuario WHERE id_u = :id"; // Corregido nombre de tabla de usuarios
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $usuarioId);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Error: Usuario no encontrado.";
    exit();
}

// Obtener las especialidades seleccionadas para el usuario
$query = "SELECT id_especialidad FROM especialidad_usuario WHERE id_usuario = :usuario_id"; // Corregidos nombres de columnas
$stmt = $db->prepare($query);
$stmt->bindParam(':usuario_id', $usuarioId);
$stmt->execute();
$especialidadesSeleccionadas = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>
<style>
    /* Asegura que el body ocupe toda la altura */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      flex: 1;
    }

    /* Estilo de la tarjeta */
    .card {
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Footer al final de la página */
    footer {
      margin-top: auto;
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
    }
  </style>
<div class="container mt-5">
    <h2 class="text-center mb-4">Modificar Usuario</h2>
    <form action="../../controllers/Admin/modificar_usuario.php" method="post" id="modificarUsuarioForm">
        <input type="hidden" name="id" value="<?php echo $usuarioId; ?>">

        <!-- Datos del usuario -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>

            <div class="form-group col-md-6">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cedula">Cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $usuario['cedula']; ?>" required pattern="^\d{1,2}-\d{4}-\d{4}$" title="Formato: X-XXXX-XXXX, donde X es un dígito.">
            </div>

            <div class="form-group col-md-6">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required pattern="^\d{4}-\d{4}$" title="Formato: XXXX-XXXX, donde cada X es un dígito.">
            </div>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $usuario['direccion']; ?>" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required>
        </div>

        <!-- Selección de rol y especialidades -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rol">Rol:</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="" disabled>Selecciona un rol</option>
                    <?php
                    $result = $rolesModel->obtenerRoles();
                    foreach ($result as $rol) {
                        $selected = ($usuario['rol_id'] == $rol['id']) ? 'selected' : '';
                        echo "<option value='{$rol['id']}' {$selected}>{$rol['nombre_r']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="especialidades">Especialidades:</label>
                <select class="form-control" id="especialidades" name="especialidades[]" multiple required>
                    <?php
                    $especialidades = $especialidadesModel->obtenerEspecialidades();
                    foreach ($especialidades as $especialidad) {
                        $selected = in_array($especialidad['id'], $especialidadesSeleccionadas) ? 'selected' : '';
                        echo "<option value='{$especialidad['id']}' {$selected}>{$especialidad['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- Botón para modificar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Usuario</button>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
