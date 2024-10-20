<?php
include '../../db/Database.php';
include '../../db/Servicios.php';
include '../../db/Permisos.php';

$database = new Database();
$db = $database->getConnection();
$serviciosModel = new Servicios($db);

// Cargar el permiso a modificar
$permisoId = $_GET['id'] ?? null;
if (!$permisoId) {
    echo "Error: No se especificó el ID del permiso.";
    exit();
}

// Cargar los datos del permiso
$query = "SELECT * FROM permiso WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $permisoId);
$stmt->execute();
$permiso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$permiso) {
    echo "Error: Permiso no encontrado.";
    exit();
}

// Obtener los servicios seleccionados para el permiso
$query = "SELECT servicio_id FROM servicio_permiso WHERE permiso_id = :permiso_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':permiso_id', $permisoId);
$stmt->execute();
$serviciosSeleccionados = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<form action="../../controllers/Admin/modificar_permiso.php" method="post" id="modificarPermisoForm">
    <input type="hidden" name="action" value="modificar">
    <input type="hidden" name="id" value="<?php echo $permisoId; ?>">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nombre_p">Nombre del Permiso:</label>
            <input type="text" class="form-control" id="nombre_p" name="nombre_p" value="<?php echo $permiso['nombre_p']; ?>" required>
        </div>
        <div class="form-group col-md-6">
            <label for="descripcion_p">Descripción:</label>
            <textarea class="form-control" id="descripcion_p" name="descripcion_p" required><?php echo $permiso['descripcion_p']; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="servicios">Seleccionar Servicios:</label>
        <select id="servicios" class="form-control">
            <option value="" disabled selected>Seleccionar servicios asociados</option>
            <?php
            $result = $serviciosModel->obtenerServicios();
            if ($result === false) {
                echo "<option value='' disabled>Error al cargar servicios.</option>";
            } else {
                foreach ($result as $servicio) {
                    $selected = in_array($servicio['id'], $serviciosSeleccionados) ? 'selected' : '';
                    echo "<option value='{$servicio['id']}' $selected>{$servicio['nombre_s']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <input type="hidden" name="servicios[]" id="serviciosSeleccionados">
    <div id="selectedServices" class="mb-3"></div>

    <div class="text-center">
        <input type="submit" class="btn btn-primary" value="Modificar">
    </div>
</form>

<?php require '../partials/footer.php'; ?>

<script>
const selectedServicesContainer = document.getElementById('selectedServices');
const serviciosSelect = document.getElementById('servicios');
const serviciosSeleccionados = document.getElementById('serviciosSeleccionados');

serviciosSelect.addEventListener('change', function() {
    const selectedOption = serviciosSelect.options[serviciosSelect.selectedIndex];

    if (selectedOption.value) {
        // Comprobar si ya ha sido seleccionado para evitar duplicados
        if (!Array.from(serviciosSeleccionados.querySelectorAll('input')).some(input => input.value === selectedOption.value)) {
            // Crear un nuevo div para mostrar el servicio seleccionado
            const serviceElement = document.createElement('div');
            serviceElement.className = 'service-item mb-2';
            serviceElement.innerHTML = `${selectedOption.text} <button type="button" class="btn btn-sm btn-danger remove-service" data-id="${selectedOption.value}">X</button>`;

            // Añadir el servicio seleccionado al contenedor
            selectedServicesContainer.appendChild(serviceElement);

            // Crear un input oculto para este servicio
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'servicios[]';
            hiddenInput.value = selectedOption.value;
            serviciosSeleccionados.appendChild(hiddenInput);

            // Añadir event listener al botón de eliminar
            serviceElement.querySelector('.remove-service').addEventListener('click', function() {
                const serviceId = this.getAttribute('data-id');

                // Eliminar el input oculto correspondiente
                const inputs = serviciosSeleccionados.querySelectorAll('input[type="hidden"]');
                inputs.forEach(input => {
                    if (input.value === serviceId) {
                        input.remove();
                    }
                });

                // Eliminar el div del servicio
                this.parentElement.remove();
            });
        }

        // Resetear el select
        serviciosSelect.selectedIndex = 0;
    }
});
</script>