<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// Incluir conexión a la base de datos
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Obtener la lista de pacientes
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);
$pacientes = $pacientesModel->obtenerTodosLosPacientes();
?>
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
    <h2 class="text-center mb-4">Gestión de Recetas Médicas</h2>

    <!-- Menú principal -->
    <div id="menuPrincipal" class="text-center mb-4">
        <button class="btn btn-primary me-2" onclick="mostrarFormularioNuevaReceta()">Crear Nueva Receta</button>
        <button class="btn btn-secondary" onclick="mostrarBusquedaRecetas()">Buscar/Mostrar Recetas</button>
    </div>

    <!-- Formulario para nueva receta -->
    <div id="formularioNuevaReceta" style="display:none;">
    <h4 class="text-center mb-4">Nueva Receta Médica</h4>
    <form id="nuevaRecetaForm" action="../../controllers/Medicos/crear_receta.php" method="post">
        <div class="form-group mb-3">
            <label for="paciente_id">Paciente:</label>
            <select class="form-control" id="paciente_id" name="paciente_id" required onchange="actualizarCorreoCedula()">
                <option value="" data-correo="" data-cedula="">Seleccione un paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?php echo $paciente['id']; ?>" 
                            data-correo="<?php echo htmlspecialchars($paciente['correo']); ?>" 
                            data-cedula="<?php echo htmlspecialchars($paciente['cedula']); ?>">
                        <?php echo htmlspecialchars($paciente['nombre'] . ' (' . $paciente['cedula'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="correo_paciente">Correo del Paciente:</label>
            <input type="email" class="form-control" id="correo_paciente" name="correo_paciente" placeholder="Correo electrónico" required>
        </div>

        <div class="form-group mb-3">
            <label for="medicamentos">Medicamentos Recetados:</label>
            <textarea class="form-control" id="medicamentos" name="medicamentos" rows="4" placeholder="Lista de medicamentos" required></textarea>
        </div>

        <!-- Campo oculto para enviar la cédula -->
        <input type="hidden" id="cedula_paciente" name="cedula">

        <div class="text-center">
            <button type="submit" class="btn btn-success">Crear Receta</button>
            <button type="button" class="btn btn-secondary" onclick="volverAlMenu()">Cancelar</button>
        </div>
    </form>
</div>

</div>
    <!-- Búsqueda y listado de recetas -->
    <div id="busquedaRecetas" style="display:none;">
        <h4 class="text-center mb-4">Buscar o Mostrar Recetas</h4>

        <div class="row">
            <!-- Formulario de búsqueda -->
            <div class="col-12 mb-4">
                <form id="searchRecetasForm" onsubmit="buscarRecetasPorCedula(event)">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchRecetaInput" placeholder="Buscar por cédula" />
                        <button class="btn btn-primary" type="submit">Buscar</button>
                        <button class="btn btn-secondary" type="button" onclick="mostrarTodasRecetas()">Mostrar Todas</button>
                    </div>
                </form>
            </div>

            <!-- Lista de recetas -->
            <div id="recetasList" class="list-group">
                <!-- Este contenido será generado dinámicamente -->
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-secondary" onclick="volverAlMenu()">Volver al Menú</button>
        </div>
    </div>
</div>


<script>
      // Función para actualizar el correo del paciente al seleccionar uno
// Función para actualizar el correo del paciente automáticamente
// Función para actualizar el correo y la cédula del paciente
function actualizarCorreoCedula() {
    var pacienteSelect = document.getElementById('paciente_id');
    var selectedOption = pacienteSelect.options[pacienteSelect.selectedIndex];

    // Obtener el correo y la cédula del paciente seleccionado
    var correoPaciente = selectedOption.getAttribute('data-correo');
    var cedulaPaciente = selectedOption.getAttribute('data-cedula');

    // Actualizar los campos de correo y cédula
    document.getElementById('correo_paciente').value = correoPaciente;
    document.getElementById('cedula_paciente').value = cedulaPaciente;
}


    // Función para mostrar el formulario de nueva receta
    function mostrarFormularioNuevaReceta() {
        document.getElementById('menuPrincipal').style.display = 'none';
        document.getElementById('formularioNuevaReceta').style.display = 'block';
    }

    // Función para mostrar la sección de búsqueda de recetas
    function mostrarBusquedaRecetas() {
        document.getElementById('menuPrincipal').style.display = 'none';
        document.getElementById('busquedaRecetas').style.display = 'block';

        // Cargar todas las recetas al mostrar esta sección
        mostrarTodasRecetas();
    }

    // Función para volver al menú principal
    function volverAlMenu() {
        document.getElementById('menuPrincipal').style.display = 'block';
        document.getElementById('formularioNuevaReceta').style.display = 'none';
        document.getElementById('busquedaRecetas').style.display = 'none';
    }

    // Función para buscar recetas por cédula
    function buscarRecetasPorCedula(event) {
        event.preventDefault();
        const cedula = document.getElementById('searchRecetaInput').value.trim();

        fetch(`../../controllers/Medicos/buscar_receta.php?cedula=${cedula}`)
            .then(response => response.json())
            .then(data => {
                const recetasList = document.getElementById('recetasList');
                recetasList.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(receta => {
                        const recetaItem = document.createElement('a');
                        recetaItem.className = 'list-group-item list-group-item-action';
                        recetaItem.innerText = `Receta ID: ${receta.id}, Cedula: ${receta.cedula}, Medicamentos: ${receta.medicamentos}`;
                        recetasList.appendChild(recetaItem);
                    });
                } else {
                    recetasList.innerHTML = '<p class="text-center">No se encontraron recetas.</p>';
                }
            })
            .catch(error => console.error('Error al buscar recetas:', error));
    }

    // Función para mostrar todas las recetas
    function mostrarTodasRecetas() {
        fetch(`../../controllers/Medicos/mostrar_recetas.php`)
            .then(response => response.json())
            .then(data => {
                const recetasList = document.getElementById('recetasList');
                recetasList.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(receta => {
                        const recetaItem = document.createElement('a');
                        recetaItem.className = 'list-group-item list-group-item-action';
                        recetaItem.innerText = `Receta ID: ${receta.id},  Cedula: ${receta.cedula}, Medicamentos: ${receta.medicamentos}`;
                        recetasList.appendChild(recetaItem);
                    });
                } else {
                    recetasList.innerHTML = '<p class="text-center">No se encontraron recetas.</p>';
                }
            })
            .catch(error => console.error('Error al mostrar recetas:', error));
    }
</script>

<?php require '../partials/footer.php'; ?>
