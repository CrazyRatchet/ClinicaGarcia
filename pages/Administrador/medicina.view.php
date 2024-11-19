<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>
<?php include '../../db/Sintomas.php';
include '../../db/Database.php';
$database = new Database();
$db = $database->getConnection();
$sintomasObj = new Sintomas($db);
// Obtener los síntomas y pasar los datos al formulario
$sintomas = $sintomasObj->obtenerSintomas();
?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Medicinas</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
        <a href="mostrar_medicina.view.php" class="btn btn-primary btn-lg btn-block">Gestionar Medicinas</a></div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Medicina</button>
        </div>
    </div>

    <!-- Formulario de Registro de Medicina -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Medicina</h2>
        <form action="../../controllers/Admin/gestion_medicina.php" method="post" id="medicinaForm">
            <input type="hidden" name="action" value="crear">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre de la Medicina:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="costo">Costo:</label>
                    <input type="number" class="form-control" id="costo" name="costo" required step="0.01" min="0">
                </div>
                <div class="form-group col-md-6">
                    <label for="imagen">Imagen (URL):</label>
                    <input type="text" class="form-control" id="imagen" name="imagen">
                </div>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad en Inventario:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required min="0">
            </div>

            <!-- Campo de selección para los síntomas (checkboxes) -->   
            <div class="form-group">
                <label for="sintoma">Síntomas relacionados:</label>
                <div>
                    <?php if (!empty($sintomas) && is_array($sintomas)): ?>
                        <?php foreach ($sintomas as $sintoma): ?>
                            <label>
                                <input type="checkbox" name="sintomas[]" value="<?php echo $sintoma['id']; ?>">
                                <?php echo htmlspecialchars($sintoma['nombre']); ?>
                            </label><br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay síntomas registrados.</p>
                    <?php endif; ?>
                    <label>
                        <a href="sintomas.view.php" class="btn btn-link">Registrar nuevo síntoma</a>
                    </label><br>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>
   
    
</div>

<?php require '../partials/footer.php'; ?>

<script>
// Mostrar/ocultar formulario
document.getElementById('showFormBtn').addEventListener('click', function() {
    var form = document.getElementById('registerForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
});

// Cargar medicinas desde el servidor
function fetchMedicinas() {
    fetch('../../controllers/Admin/gestion_medicina.php?action=obtener')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let tbody = document.getElementById('medicinaTableBody');
            tbody.innerHTML = '';  // Limpiar la tabla
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay medicinas registradas.</td></tr>';
            } else {
                data.forEach(medicina => {
                    let sintomasList = medicina.sintomas ? medicina.sintomas : 'No hay síntomas relacionados';

                    let row = `<tr>
                        <td>${medicina.nombre}</td>
                        <td>${medicina.descripcion}</td>
                        <td>${medicina.costo}</td>
                        <td><img src="${medicina.imagen}" alt="Imagen de medicina" style="width: 50px;"></td>
                        <td>${medicina.cantidad}</td>
                        <td>${sintomasList}</td>
                        <td>
                            <a href="modificar_medicina.view.php?id=${medicina.id}" class="btn btn-warning btn-sm">Modificar</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${medicina.nombre}', ${medicina.id})">Eliminar</a>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            }
            document.getElementById('medicinaList').style.display = 'block'; // Mostrar lista de medicinas
        })
        .catch(error => console.error('Error al cargar las medicinas:', error));
}

// Función para confirmar eliminación
function confirmDelete(nombreMedicina, id) {
    if (confirm(`¿Está seguro de que desea eliminar la medicina "${nombreMedicina}"?`)) {
        window.location.href = `../../controllers/Admin/gestion_medicina.php?action=eliminar&id=${id}`;
    }
}
</script>
