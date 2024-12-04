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
    <h2 class="text-center">Gestión de Síntomas</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
            <button id="manageSintomasBtn" class="btn btn-primary btn-lg btn-block">Gestionar Síntomas</button>
        </div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Síntoma</button>
        </div>
    </div>

    <!-- Formulario de Registro de Síntoma -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Síntoma</h2>
        <form action="../../controllers/Admin/gestion_sintomas.php" method="post" id="sintomaForm">
            <input type="hidden" name="action" value="crear">
            <div class="form-group">
                <label for="nombre">Nombre del Síntoma:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>

    <!-- Lista de Síntomas -->
    <div class="container mt-5" id="sintomasList" style="display: none;">
        <h2 class="text-center mb-4">Síntomas Registrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="sintomasTableBody">
                <!-- Los síntomas se cargarán aquí -->
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

// Gestionar Síntomas
document.getElementById('manageSintomasBtn').addEventListener('click', function() {
    var sintomasList = document.getElementById('sintomasList');
    if (sintomasList.style.display === 'block') {
        sintomasList.style.display = 'none'; // Ocultar lista de síntomas si ya está visible
    } else {
        fetchSintomas(); // Si está oculto, cargar y mostrar la lista
    }
});

// Cargar síntomas desde el servidor
function fetchSintomas() {
    fetch('../../controllers/Admin/gestion_sintomas.php?action=obtener')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let tbody = document.getElementById('sintomasTableBody');
            tbody.innerHTML = '';  // Limpiar la tabla
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">No hay síntomas registrados.</td></tr>';
            } else {
                data.forEach(sintoma => {
                    let row = `<tr>
                        <td>${sintoma.nombre}</td>
                        <td>${sintoma.descripcion || 'Sin descripción'}</td>
                        <td>
                            <a href="modificar_sintoma.view.php?id=${sintoma.id}" class="btn btn-warning btn-sm">Modificar</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${sintoma.nombre}', ${sintoma.id})">Eliminar</a>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            }
            sintomasList.style.display = 'block'; // Mostrar lista de síntomas
        })
        .catch(error => console.error('Error al cargar los síntomas:', error));
}

// Función para confirmar eliminación
function confirmDelete(nombreSintoma, id) {
    if (confirm(`¿Está seguro de que desea eliminar el síntoma "${nombreSintoma}"?`)) {
        window.location.href = `../../controllers/Admin/gestion_sintomas.php?action=eliminar&id=${id}`;
    }
}
</script>
