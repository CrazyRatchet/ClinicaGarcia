<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Obtener la lista de pacientes
$pacientes = $pacientesModel->busquedaPacientesSeleccionados();
?>

<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <h2 class="text-center mb-4">Gestionar Datos Medicos</h2>

    <div class="row">
        <!-- Formulario de búsqueda -->
        <div class="col-12 mb-4">
            <form id="searchForm" onsubmit="buscarPorCedula(event)">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por cédula" />
                    <button class="btn btn-primary" type="submit">Buscar</button>
                    <button class="btn btn-secondary" type="button" onclick="mostrarTodos()">Mostrar Todos</button>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <h4>Lista de Pacientes</h4>
            <div id="pacientesList" class="list-group">
                <?php foreach ($pacientes as $paciente): ?>
                    <a href="#" class="list-group-item list-group-item-action paciente-item" 
                       data-id="<?php echo $paciente['id']; ?>" 
                       data-cedula="<?php echo htmlspecialchars($paciente['cedula']); ?>" 
                       onclick="cargarDatosMedicos(<?php echo $paciente['id']; ?>)">
                        <?php echo htmlspecialchars($paciente['nombre'] . ' ' . $paciente['cedula']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <h4>Registrar/Modificar Datos Médicos</h4>
            <div id="datosMedicosContainer" style="display:none;">
                <form id="datosMedicosForm" action="../../controllers/Medicos/registrar_datos_medicos.php" method="post">
                    <input type="hidden" name="id" id="pacienteId">

                    <!-- Campos de datos médicos -->
                    <div class="form-group">
                        <label for="sexo">Sexo:</label>
                        <select class="form-control" id="sexo" name="sexo" required>
                            <option value="">Seleccione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="peso">Peso (kg):</label>
                        <input type="number" step="1" class="form-control" id="peso" name="peso" required>
                    </div>

                    <div class="form-group">
                        <label for="altura">Altura (m):</label>
                        <input type="number" step="0.01=" class="form-control" id="altura" name="altura" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_sangre">Tipo de Sangre:</label>
                        <input type="text" class="form-control" id="tipo_sangre" name="tipo_sangre" required>
                    </div>

                    <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" oninput="calcularEdad()" required>
                    </div>

                    <div class="form-group">
                    <label for="edad">Edad:</label>
                    <input type="number" class="form-control" id="edad" name="edad" readonly>
                    </div>

                    <div class="form-group">
                        <label for="alergias">Alergias:</label>
                        <textarea class="form-control" id="alergias" name="alergias"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="medicamentos_regulares">Medicamentos Regulares:</label>
                        <textarea class="form-control" id="medicamentos_regulares" name="medicamentos_regulares"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="padecimientos">Padecimientos:</label>
                        <input type="text" class="form-control" id="padecimientos" name="padecimientos">
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_datos">Fecha de Registro de Datos:</label>
                        <input type="date" class="form-control" id="fecha_datos" name="fecha_datos">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn">Registrar/Modificar Datos Médicos</button>
                    </div>
                </form>

                <div id="modificarContainer" style="display:none;">
                    <h5>Datos Médicos Existentes</h5>
                    <p>Sexo: <span id="sexoExistente"></span></p>
                    <p>Peso: <span id="pesoExistente"></span></p>
                    <p>Altura: <span id="alturaExistente"></span></p>
                    <p>Tipo de Sangre: <span id="tipoSangreExistente"></span></p>
                    <p>Fecha de Nacimiento: <span id="fechaNacimientoExistente"></span></p>
                    <p>Edad: <span id="edadExistente"></span></p>
                    <p>Alergias: <span id="alergiasExistente"></span></p>
                    <p>Medicamentos regulares: <span id="medicamentosRegularesExistente"></span></p>
                    <p>Padecimientos: <span id="padecimientosExistente"></span></p>
                    <p>Ultima fecha de datos: <span id="fechaDatosExistente"></span></p>
                    <button class="btn btn-warning" id="btnModificar" onclick="activarModificar()">Modificar Datos Médicos</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cargarDatosMedicos(pacienteId) {
        // Mostrar el formulario de datos médicos
        document.getElementById('pacienteId').value = pacienteId;

        // Realizar una solicitud AJAX para cargar los datos médicos del paciente
        fetch(`../../controllers/Medicos/obtener_datos_medicos.php?id=${pacienteId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    // Llenar los campos con datos existentes
                    document.getElementById('sexoExistente').innerText = data.sexo || 'No registrado';
                    document.getElementById('pesoExistente').innerText = data.peso || 'No registrado';
                    document.getElementById('alturaExistente').innerText = data.altura || 'No registrado';
                    document.getElementById('tipoSangreExistente').innerText = data.tipo_sangre || 'No registrado';
                    document.getElementById('fechaNacimientoExistente').innerText = data.fecha_nacimiento || 'No registrado';
                    document.getElementById('edadExistente').innerText = data.edad || 'No registrado';
                    document.getElementById('alergiasExistente').innerText = data.alergias || 'No registrado';
                    document.getElementById('medicamentosRegularesExistente').innerText = data.medicamentos_regulares || 'No registrado';
                    document.getElementById('padecimientosExistente').innerText = data.padecimientos || 'No registrado';
                    document.getElementById('fechaDatosExistente').innerText = data.fecha_datos || 'No registrado';

                    // Mostrar el contenedor de datos médicos
                    document.getElementById('datosMedicosContainer').style.display = 'block';

                    // Mostrar modificar si hay datos existentes
                    if (data.sexo || data.peso || data.altura || data.tipo_sangre || data.fecha_nacimiento || data.edad || data.alergias || data.medicamentos_regulares || data.padecimientos || data.fecha_datos) {
                        // Llenar los campos del formulario para modificar
                        document.getElementById('sexo').value = data.sexo || '';
                        document.getElementById('peso').value = data.peso || '';
                        document.getElementById('altura').value = data.altura || '';
                        document.getElementById('tipo_sangre').value = data.tipo_sangre || '';
                        document.getElementById('fecha_nacimiento').value = data.fecha_nacimiento || '';
                        document.getElementById('edad').value = data.edad || '';
                        document.getElementById('alergias').value = data.alergias || '';
                        document.getElementById('medicamentos_regulares').value = data.medicamentos_regulares || '';
                        document.getElementById('padecimientos').value = data.padecimientos || '';
                        document.getElementById('fecha_datos').value = data.fecha_datos || '';
                        

                        // Mostrar contenedor de modificación y ocultar el formulario de registro
                        document.getElementById('modificarContainer').style.display = 'block';
                        document.getElementById('datosMedicosForm').style.display = 'none';

                        // Cambiar el texto del botón a "Modificar Datos Médicos"
                        document.getElementById('submitBtn').innerText = 'Modificar Datos Médicos';
                    } else {
                        // Si no hay datos, mostrar el formulario para registrar
                        document.getElementById('modificarContainer').style.display = 'none';
                        document.getElementById('datosMedicosForm').style.display = 'block';

                        // Cambiar el texto del botón a "Registrar Datos Médicos"
                        document.getElementById('submitBtn').innerText = 'Registrar Datos Médicos';
                    }
                } else {
                    alert('No se encontraron datos médicos para este paciente.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error al cargar los datos médicos.");
            });
    }

    function activarModificar() {
        // Hacer visibles los campos del formulario para modificar datos
        document.getElementById('modificarContainer').style.display = 'none';
        document.getElementById('datosMedicosForm').style.display = 'block';
    }

    function calcularEdad() {
        const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
        const edadInput = document.getElementById('edad');
        
        if (fechaNacimiento) {
            const hoy = new Date();
            const nacimiento = new Date(fechaNacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const mes = hoy.getMonth() - nacimiento.getMonth();
            
            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }

            edadInput.value = edad >= 0 ? edad : 0;
        } else {
            edadInput.value = '';
        }
    }
// Función para buscar por cédula
function buscarPorCedula(event) {
        event.preventDefault();
        const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
        const pacientesList = document.querySelectorAll('.paciente-item');

        pacientesList.forEach(item => {
            const cedula = item.dataset.cedula.toLowerCase();
            if (cedula.includes(searchInput)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Función para mostrar todos los pacientes
    function mostrarTodos() {
        const pacientesList = document.querySelectorAll('.paciente-item');
        pacientesList.forEach(item => {
            item.style.display = 'block';
        });
        document.getElementById('searchInput').value = '';
    }

    // Resto de las funciones existentes
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['message'])): ?>
            const messageType = "<?php echo $_SESSION['message_type']; ?>";
            const message = "<?php echo $_SESSION['message']; ?>";
            Swal.fire({
                icon: messageType,
                title: messageType === 'success' ? 'Éxito' : 'Error',
                text: message,
                confirmButtonText: 'Aceptar'
            });
            <?php 
            // Destruir la sesión del mensaje después de mostrarlo
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
    });
</script>
<?php require '../partials/footer.php'; ?>
