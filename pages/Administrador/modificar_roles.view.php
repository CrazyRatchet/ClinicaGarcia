<?php
include '../../db/Database.php';
include '../../db/Roles.php';
include '../../db/Permisos.php';

$database = new Database();
$db = $database->getConnection();
$rolesModel = new Roles($db);
$permisosModel = new Permisos($db);

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

// Obtener los permisos seleccionados para el rol
$query = "SELECT permiso_id FROM rol_permiso WHERE rol_id = :rol_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':rol_id', $rolId);
$stmt->execute();
$permisosSeleccionados = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<form action="../../controllers/Admin/modificar_roles.php" method="post" id="modificarRolForm">
    <input type="hidden" name="action" value="modificar">
    <input type="hidden" name="id" value="<?php echo $rolId; ?>">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nombre_r">Nombre del Rol:</label>
            <input type="text" class="form-control" id="nombre_r" name="nombre_r" value="<?php echo $rol['nombre_r']; ?>" required>
        </div>
        <div class="form-group col-md-6">
            <label for="descripcion_r">Descripción:</label>
            <textarea class="form-control" id="descripcion_r" name="descripcion_r" required><?php echo $rol['descripcion_r']; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="permisos">Seleccionar Permisos:</label>
        <select id="permisos" class="form-control">
            <option value="" disabled selected>Seleccionar permisos asociados</option>
            <?php
            $result = $permisosModel->obtenerPermisos();
            if ($result === false) {
                echo "<option value='' disabled>Error al cargar permisos.</option>";
            } else {
                foreach ($result as $permiso) {
                    $selected = in_array($permiso['id'], $permisosSeleccionados) ? 'selected' : '';
                    echo "<option value='{$permiso['id']}' $selected>{$permiso['nombre_p']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <input type="hidden" name="permisos[]" id="permisosSeleccionados">
    <div id="selectedPermissions" class="mb-3"></div>

    <div class="text-center">
        <input type="submit" class="btn btn-primary" value="Modificar">
    </div>
</form>

<?php require '../partials/footer.php'; ?>

<script>
const selectedPermissionsContainer = document.getElementById('selectedPermissions');
const permisosSelect = document.getElementById('permisos');
const permisosSeleccionados = document.getElementById('permisosSeleccionados');

permisosSelect.addEventListener('change', function() {
    const selectedOption = permisosSelect.options[permisosSelect.selectedIndex];

    if (selectedOption.value) {
        // Comprobar si ya ha sido seleccionado para evitar duplicados
        if (!Array.from(permisosSeleccionados.querySelectorAll('input')).some(input => input.value === selectedOption.value)) {
            // Crear un nuevo div para mostrar el permiso seleccionado
            const permissionElement = document.createElement('div');
            permissionElement.className = 'permission-item mb-2';
            permissionElement.innerHTML = `${selectedOption.text} <button type="button" class="btn btn-sm btn-danger remove-permission" data-id="${selectedOption.value}">X</button>`;

            // Añadir el permiso seleccionado al contenedor
            selectedPermissionsContainer.appendChild(permissionElement);

            // Crear un input oculto para este permiso
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'permisos[]';
            hiddenInput.value = selectedOption.value;
            permisosSeleccionados.appendChild(hiddenInput);

            // Añadir event listener al botón de eliminar
            permissionElement.querySelector('.remove-permission').addEventListener('click', function() {
                const permissionId = this.getAttribute('data-id');

                // Eliminar el input oculto correspondiente
                const inputs = permisosSeleccionados.querySelectorAll('input[type="hidden"]');
                inputs.forEach(input => {
                    if (input.value === permissionId) {
                        input.remove();
                    }
                });

                // Eliminar el div del permiso
                this.parentElement.remove();
            });
        }

        // Resetear el select
        permisosSelect.selectedIndex = 0;
    }
});
</script>
