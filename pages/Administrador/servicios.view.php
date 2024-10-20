<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Servicios</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
            <button id="manageServicesBtn" class="btn btn-primary btn-lg btn-block">Gestionar Servicios</button>
        </div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Servicio</button>
        </div>
    </div>

    <!-- Formulario de Registro de Servicio -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Servicio</h2>
        <form action="../../controllers/Admin/servicios.php" method="post" id="servicioForm">
            <input type="hidden" name="action" value="crear">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre_s">Nombre del Servicio:</label>
                    <input type="text" class="form-control" id="nombre_s" name="nombre_s" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion_s">Descripción:</label>
                    <textarea class="form-control" id="descripcion_s" name="descripcion_s" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="equipamiento_s">Equipamiento:</label>
                    <input type="text" class="form-control" id="equipamiento_s" name="equipamiento_s" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="costo_s">Costo:</label>
                    <input type="number" class="form-control" id="costo_s" name="costo_s" required step="0.01" min="0">
                </div>
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>

    <!-- Lista de Servicios -->
    <div class="container mt-5" id="servicesList" style="display: none;">
        <h2 class="text-center mb-4">Servicios Registrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Equipamiento</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="servicesTableBody">
                <!-- Los servicios se cargarán aquí -->
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

// Gestionar Servicios
document.getElementById('manageServicesBtn').addEventListener('click', function() {
    var servicesList = document.getElementById('servicesList');
    if (servicesList.style.display === 'block') {
        servicesList.style.display = 'none'; // Ocultar lista de servicios si ya está visible
    } else {
        fetchServices(); // Si está oculto, cargar y mostrar la lista
    }
});

// Cargar servicios desde el servidor
function fetchServices() {
    fetch('../../controllers/Admin/servicios.php?action=obtener')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            let tbody = document.getElementById('servicesTableBody');
            tbody.innerHTML = '';  // Limpiar la tabla
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay servicios registrados.</td></tr>';
            } else {
                data.forEach(servicio => {
                    let row = `<tr>
                        <td>${servicio.nombre_s}</td>
                        <td>${servicio.descripcion_s}</td>
                        <td>${servicio.equipamiento_s}</td>
                        <td>${servicio.costo_s}</td>
                        <td>
                            <a href="modificar_servicio.view.php?id=${servicio.id}" class="btn btn-warning btn-sm">Modificar</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${servicio.nombre_s}', ${servicio.id})">Eliminar</a>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            }
            servicesList.style.display = 'block'; // Mostrar lista de servicios
        })
        .catch(error => console.error('Error al cargar los servicios:', error));
}

// Función para confirmar eliminación
function confirmDelete(nombreServicio, id) {
    if (confirm(`¿Está seguro de que desea eliminar el servicio "${nombreServicio}"?`)) {
        window.location.href = `../../controllers/Admin/servicios.php?action=eliminar&id=${id}`;
    }
}
</script>
