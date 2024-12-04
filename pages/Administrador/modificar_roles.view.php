<?php
include '../../db/Database.php';
include '../../db/Roles.php';

$database = new Database();
$db = $database->getConnection();
$rolesModel = new Roles($db);

// Cargar el rol a modificar
$rolId = $_GET['id'] ?? null;
if (!$rolId) {
    echo "Error: No se especificó el ID del rol.";
    exit();
}

// Cargar los datos del rol
$query = "SELECT * FROM rol WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $rolId);
$stmt->execute();
$rol = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rol) {
    echo "Error: Rol no encontrado.";
    exit();
}

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
<!-- Contenedor para centrar el formulario, pero con espacio superior -->
<div class="d-flex justify-content-center" style="min-height: 100vh; align-items: flex-start; padding-top: 80px;">
    <div class="card p-4" style="width: 400px;">

        <form action="../../controllers/Admin/modificar_roles.php" method="post" id="modificarRolForm">
            <input type="hidden" name="action" value="modificar">
            <input type="hidden" name="id" value="<?php echo $rolId; ?>">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="nombre_r">Nombre del Rol:</label>
                    <input type="text" class="form-control" id="nombre_r" name="nombre_r" value="<?php echo $rol['nombre_r']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="permiso_administrador">Permiso Administrador:</label>
                <input type="checkbox" id="permiso_administrador" name="permiso_administrador" value="1" <?php echo $rol['permiso_administrador'] ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="permiso_medico">Permiso Médico:</label>
                <input type="checkbox" id="permiso_medico" name="permiso_medico" value="1" <?php echo $rol['permiso_medico'] ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="permiso_administrativos">Permiso Administrativos:</label>
                <input type="checkbox" id="permiso_administrativos" name="permiso_administrativos" value="1" <?php echo $rol['permiso_administrativos'] ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="permiso_citas">Permiso Citas:</label>
                <input type="checkbox" id="permiso_citas" name="permiso_citas" value="1" <?php echo $rol['permiso_citas'] ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="permiso_inventario">Permiso Inventario:</label>
                <input type="checkbox" id="permiso_inventario" name="permiso_inventario" value="1" <?php echo $rol['permiso_inventario'] ? 'checked' : ''; ?>>
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Modificar">
            </div>
        </form>

    </div>
</div>

<?php require '../partials/footer.php'; ?>
