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
    <h2 class="text-center">Gestión de Especialidades</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
            <button id="manageEspecialidadesBtn" class="btn btn-primary btn-lg btn-block">Gestionar Especialidades</button>
        </div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Especialidad</button>
        </div>
    </div>

    <!-- Formulario de Registro de Especialidad -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Especialidad</h2>
        <form action="../../controllers/Admin/especialidades.php" method="post" id="especialidadForm">
            <input type="hidden" name="action" value="crear">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre de la Especialidad:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>

    <!-- Lista de Especialidades -->
    <div class="container mt-5" id="especialidadesList" style="display: none;">
        <h2 class="text-center mb-4">Especialidades Registradas</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="especialidadesTableBody">
                <!-- Las especialidades se cargarán aquí -->
            </tbody>
        </table>
    </div>
</div>

<?php require '../partials/footer.php'; ?>

<script>
// Mostrar/ocultar formulario
document.getElementById('showFormBtn').addEventListener('click', function() {
    var form = document.getElementById('registerForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
});

// Gestionar Especialidades
document.getElementById('manageEspecialidadesBtn').addEventListener('click', function() {
    var especialidadesList = document.getElementById('especialidadesList');
    if (especialidadesList.style.display === 'block') {
        especialidadesList.style.display = 'none'; // Ocultar lista de especialidades si ya está visible
    } else {
        fetchEspecialidades(); // Si está oculto, cargar y mostrar la lista
    }
});

// Cargar especialidades desde el servidor
function fetchEspecialidades() {
    fetch('../../controllers/Admin/especialidades.php?action=obtener')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let tbody = document.getElementById('especialidadesTableBody');
            tbody.innerHTML = '';  // Limpiar la tabla
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">No hay especialidades registradas.</td></tr>';
            } else {
                data.forEach(especialidad => {
                    let row = `<tr>
                        <td>${especialidad.nombre}</td>
                        <td>${especialidad.descripcion}</td>
                        <td>
                            <a href="modificar_especialidad.view.php?id=${especialidad.id}" class="btn btn-warning btn-sm">Modificar</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${especialidad.nombre}', ${especialidad.id})">Eliminar</a>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            }
            especialidadesList.style.display = 'block'; // Mostrar lista de especialidades
        })
        .catch(error => console.error('Error al cargar las especialidades:', error));
}

// Función para confirmar eliminación
function confirmDelete(nombreEspecialidad, id) {
    if (confirm(`¿Está seguro de que desea eliminar la especialidad "${nombreEspecialidad}"?`)) {
        window.location.href = `../../controllers/Admin/especialidades.php?action=eliminar&id=${id}`;
    }
}
</script>
