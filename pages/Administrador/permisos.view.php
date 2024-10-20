<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Permisos</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
            <button id="managePermissionsBtn" class="btn btn-primary btn-lg btn-block">Gestionar Permisos</button>
        </div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Permiso</button>
        </div>
    </div>

    <!-- Formulario de Registro de Permiso -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Permiso</h2>
        <!-- Formulario -->
        <form action="../../controllers/Admin/permisos.php" method="post" id="permisoForm">
            <input type="hidden" name="action" value="crear">

            <!-- Información del Permiso -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre_p">Nombre del Permiso:</label>
                    <input type="text" class="form-control" id="nombre_p" name="nombre_p" required pattern="[A-Za-z\s\-]+" title="Solo se permiten letras, espacios y guiones.">
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion_p">Descripción:</label>
                    <textarea class="form-control" id="descripcion_p" name="descripcion_p" required></textarea>
                </div>
            </div>

            <!-- Selección de Servicios -->
            <div class="form-group">
                <label for="servicios">Seleccionar Servicios:</label>
                <select id="servicios" class="form-control">
                    <option value="" disabled selected>Seleccionar servicios asociados</option>
                    <?php
                    include '../../db/Database.php';
                    include '../../db/Servicios.php';
                    $database = new Database();
                    $db = $database->getConnection();
                    $servicios = new Servicios($db);
                    $result = $servicios->obtenerServicios();
                    if ($result === false) {
                        echo "<option value='' disabled>Error al cargar servicios.</option>";
                    } else {
                        foreach ($result as $servicio) {
                            echo "<option value='{$servicio['id']}'>{$servicio['nombre_s']}</option>";
                        }
                    }
                    ?>
                </select>
                <small class="form-text text-muted">Selecciona un servicio para agregarlo a la lista.</small>
            </div>

            <!-- Campo oculto para almacenar los IDs de los servicios seleccionados -->
            <div id="serviciosSeleccionados"></div>

            <!-- Contenedor para mostrar los servicios seleccionados -->
            <div id="selectedServices" class="mb-3"></div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>

    <!-- Lista de Permisos -->
    <div class="container mt-5" id="permissionsList" style="display: none;">
        <h2 class="text-center mb-4">Permisos Registrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Servicios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="permissionsTableBody">
                <!-- Los permisos se cargarán aquí -->
            </tbody>
        </table>
    </div>

</div>

<?php require '../partials/footer.php'; ?>

<script>
    // Mostrar/ocultar formulario de registro de permiso
    document.getElementById('showFormBtn').addEventListener('click', function() {
        var form = document.getElementById('registerForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // Gestionar Permisos
    document.getElementById('managePermissionsBtn').addEventListener('click', function() {
        var permissionsList = document.getElementById('permissionsList');
        if (permissionsList.style.display === 'none' || permissionsList.style.display === '') {
            fetchPermissions(); // Si está oculto, cargar y mostrar la lista
            permissionsList.style.display = 'block'; // Mostrar la lista
        } else {
            permissionsList.style.display = 'none'; // Ocultar la lista si ya está visible
        }
    });
    // Función para cargar permisos
    function fetchPermissions() {
        fetch('../../controllers/Admin/permisos.php?action=obtener')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('permissionsTableBody');
                tableBody.innerHTML = ''; // Limpiar contenido anterior

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center">No hay permisos registrados</td></tr>';
                    document.getElementById('permissionsList').style.display = 'block'; // Mostrar la lista
                } else {
                    const permisosAgrupados = data.reduce((acc, permiso) => {
                        const servicio = permiso.servicios || 'Sin Servicio'; // Cambia esto si los nombres no coinciden
                        if (!acc[permiso.permiso_id]) { // Asegúrate de que uses 'permiso_id'
                            acc[permiso.permiso_id] = {
                                nombre: permiso.nombre_p,
                                descripcion: permiso.descripcion_p,
                                servicios: []
                            };
                        }
                        acc[permiso.permiso_id].servicios.push(servicio);
                        return acc;
                    }, {});

                    for (const id in permisosAgrupados) {
                        const permiso = permisosAgrupados[id];
                        const serviciosStr = permiso.servicios.join(', ');
                        tableBody.innerHTML += `
                        <tr>
                            <td>${permiso.nombre}</td>
                            <td>${permiso.descripcion}</td>
                            <td>${serviciosStr}</td>
                            <td>
                                <button class="btn btn-warning btn-sm modify-permission" data-id="${id}">Modificar</button>
                                <button class="btn btn-danger btn-sm delete-permission" data-id="${id}">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    }

                    // Mostrar la lista de permisos
                    document.getElementById('permissionsList').style.display = 'block';

                    // Manejar la eliminación de permisos
                    document.querySelectorAll('.delete-permission').forEach(button => {
                        button.addEventListener('click', function() {
                            const permisoId = this.getAttribute('data-id');
                            eliminarPermiso(permisoId);
                        });
                    });

                    // Manejar la modificación de permisos
                    document.querySelectorAll('.modify-permission').forEach(button => {
                        button.addEventListener('click', function() {
                            const permisoId = this.getAttribute('data-id');

                            // Redirigir a modificar_permisos.view.php con el ID del permiso
                            window.location.href = `modificar_permisos.view.php?id=${permisoId}`;
                        });
                    });

                }
            })
            .catch(error => console.error('Error al cargar permisos:', error));
    }

    // Función para eliminar permisos
    function eliminarPermiso(permisoId) {
        if (confirm('¿Estás seguro de que deseas eliminar este permiso?')) {
            fetch('../../controllers/Admin/permisos.php?action=eliminar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${permisoId}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(msg => {
                    alert(msg); // Mostrar mensaje de éxito/error
                    fetchPermissions(); // Recargar permisos
                })
                .catch(error => console.error('Error al eliminar permiso:', error));
        }
    }


    const selectedServicesContainer = document.getElementById('selectedServices');
    const serviciosSelect = document.getElementById('servicios');
    const serviciosSeleccionados = document.getElementById('serviciosSeleccionados');

    serviciosSelect.addEventListener('change', function() {
        const selectedOption = serviciosSelect.options[serviciosSelect.selectedIndex];
        if (selectedOption.value) {
            const serviceElement = document.createElement('div');
            serviceElement.className = 'service-item mb-2';
            serviceElement.innerHTML = `${selectedOption.text} <button type="button" class="btn btn-sm btn-danger remove-service" data-id="${selectedOption.value}">X</button>`;

            selectedServicesContainer.appendChild(serviceElement);

            // Añadir el servicio seleccionado al campo oculto
            const selectedServiceId = selectedOption.value;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'servicios[]'; // Cada servicio se añadirá al array
            hiddenInput.value = selectedServiceId;
            serviciosSeleccionados.appendChild(hiddenInput);

            // Eliminar servicio al hacer clic en 'X'
            serviceElement.querySelector('.remove-service').addEventListener('click', function() {
                const serviceId = this.getAttribute('data-id');
                const serviceOption = Array.from(serviciosSelect.options).find(opt => opt.value === serviceId);
                if (serviceOption) {
                    // Eliminar el servicio del campo oculto
                    const inputs = serviciosSeleccionados.querySelectorAll('input[type="hidden"]');
                    inputs.forEach(input => {
                        if (input.value === serviceId) {
                            input.remove(); // Eliminar del DOM
                        }
                    });
                    this.parentElement.remove(); // Eliminar el elemento del DOM
                }
            });

            // Reiniciar la selección
            serviciosSelect.selectedIndex = 0; // Volver al primer elemento
        }
    });
</script>