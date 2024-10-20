<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Roles</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
            <button id="manageRolesBtn" class="btn btn-primary btn-lg btn-block">Gestionar Roles</button>
        </div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Rol</button>
        </div>
    </div>

    <!-- Formulario de Registro de Rol -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Rol</h2>
        <!-- Formulario -->
        <form action="../../controllers/Admin/roles.php" method="post" id="rolForm">
            <input type="hidden" name="action" value="crear">

            <!-- Información del Rol -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre_r">Nombre del Rol:</label>
                    <input type="text" class="form-control" id="nombre_r" name="nombre_r" required pattern="[A-Za-z\s\-]+" title="Solo se permiten letras, espacios y guiones.">
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion_r">Descripción:</label>
                    <textarea class="form-control" id="descripcion_r" name="descripcion_r" required></textarea>
                </div>
            </div>

            <!-- Selección de Permisos -->
            <div class="form-group">
                <label for="permisos">Seleccionar Permisos:</label>
                <select id="permisos" class="form-control">
                    <option value="" disabled selected>Seleccionar permisos asociados</option>
                    <?php
                    include '../../db/Database.php';
                    include '../../db/Permisos.php';
                    $database = new Database();
                    $db = $database->getConnection();
                    $permisos = new Permisos($db);
                    $result = $permisos->obtenerPermisos();
                    if ($result === false) {
                        echo "<option value='' disabled>Error al cargar permisos.</option>";
                    } else {
                        foreach ($result as $permiso) {
                            echo "<option value='{$permiso['id']}'>{$permiso['nombre_p']}</option>";
                        }
                    }
                    ?>
                </select>
                <small class="form-text text-muted">Selecciona un permiso para agregarlo a la lista.</small>
            </div>

            <!-- Campo oculto para almacenar los IDs de los permisos seleccionados -->
            <div id="permisosSeleccionados"></div>

            <!-- Contenedor para mostrar los permisos seleccionados -->
            <div id="selectedPermissions" class="mb-3"></div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Registrar">
            </div>
        </form>
    </div>

    <!-- Lista de Roles -->
    <div class="container mt-5" id="rolesList" style="display: none;">
        <h2 class="text-center mb-4">Roles Registrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Permisos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="rolesTableBody">
                <!-- Los roles se cargarán aquí -->
            </tbody>
        </table>
    </div>
</div>

<?php require '../partials/footer.php'; ?>

<script>
    // Mostrar/ocultar formulario de registro de rol
    document.getElementById('showFormBtn').addEventListener('click', function() {
        var form = document.getElementById('registerForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // Gestionar Roles
    document.getElementById('manageRolesBtn').addEventListener('click', function() {
        var rolesList = document.getElementById('rolesList');
        if (rolesList.style.display === 'none' || rolesList.style.display === '') {
            fetchRoles(); // Si está oculto, cargar y mostrar la lista
            rolesList.style.display = 'block'; // Mostrar la lista
        } else {
            rolesList.style.display = 'none'; // Ocultar la lista si ya está visible
        }
    });

    // Función para cargar roles
    function fetchRoles() {
        fetch('../../controllers/Admin/roles.php?action=obtener')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('rolesTableBody');
                tableBody.innerHTML = ''; // Limpiar contenido anterior

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center">No hay roles registrados</td></tr>';
                    document.getElementById('rolesList').style.display = 'block'; // Mostrar la lista
                } else {
                    const rolesAgrupados = data.reduce((acc, rol) => {
                        const permiso = rol.permisos || 'Sin Permiso'; // Cambia esto si los nombres no coinciden
                        if (!acc[rol.rol_id]) { // Asegúrate de que uses 'rol_id'
                            acc[rol.rol_id] = {
                                nombre: rol.nombre_r,
                                descripcion: rol.descripcion_r,
                                permisos: []
                            };
                        }
                        acc[rol.rol_id].permisos.push(permiso);
                        return acc;
                    }, {});

                    for (const id in rolesAgrupados) {
                        const rol = rolesAgrupados[id];
                        const permisosStr = rol.permisos.join(', ');
                        tableBody.innerHTML += `
                        <tr>
                            <td>${rol.nombre}</td>
                            <td>${rol.descripcion}</td>
                            <td>${permisosStr}</td>
                            <td>
                                <button class="btn btn-warning btn-sm modify-role" data-id="${id}">Modificar</button>
                                <button class="btn btn-danger btn-sm delete-role" data-id="${id}">Eliminar</button>
                            </td>
                        </tr>
                    `;
                    }

                    // Mostrar la lista de roles
                    document.getElementById('rolesList').style.display = 'block';

                    // Manejar la eliminación de roles
                    document.querySelectorAll('.delete-role').forEach(button => {
                        button.addEventListener('click', function() {
                            const rolId = this.getAttribute('data-id');
                            eliminarRol(rolId);
                        });
                    });

                    // Manejar la modificación de roles
                    document.querySelectorAll('.modify-role').forEach(button => {
                        button.addEventListener('click', function() {
                            const rolId = this.getAttribute('data-id');

                            // Redirigir a modificar_roles.view.php con el ID del rol
                            window.location.href = `modificar_roles.view.php?id=${rolId}`;
                        });
                    });
                }
            })
            .catch(error => console.error('Error al cargar roles:', error));
    }

    // Función para eliminar roles
    function eliminarRol(rolId) {
        if (confirm('¿Estás seguro de que deseas eliminar este rol?')) {
            fetch('../../controllers/Admin/roles.php?action=eliminar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${rolId}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(msg => {
                    alert(msg); // Mostrar mensaje de éxito/error
                    fetchRoles(); // Recargar roles
                })
                .catch(error => console.error('Error al eliminar rol:', error));
        }
    }

    const selectedPermissionsContainer = document.getElementById('selectedPermissions');
    const permisosSelect = document.getElementById('permisos');
    const permisosSeleccionados = document.getElementById('permisosSeleccionados');

    permisosSelect.addEventListener('change', function() {
        const selectedOption = permisosSelect.options[permisosSelect.selectedIndex];
        if (selectedOption.value) {
            const permissionElement = document.createElement('div');
            permissionElement.className = 'permission-item mb-2';
            permissionElement.innerHTML = `${selectedOption.text} <button type="button" class="btn btn-sm btn-danger remove-permission" data-id="${selectedOption.value}">X</button>`;

            selectedPermissionsContainer.appendChild(permissionElement);

            // Añadir el permiso seleccionado al campo oculto
            const selectedPermissionId = selectedOption.value;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'permisos[]'; // Array de permisos
            hiddenInput.value = selectedPermissionId;
            permisosSeleccionados.appendChild(hiddenInput);

            // Eliminar permiso al hacer clic en el botón 'X'
            permissionElement.querySelector('.remove-permission').addEventListener('click', function() {
                selectedPermissionsContainer.removeChild(permissionElement);
                permisosSeleccionados.removeChild(hiddenInput);
            });
        }
    });
</script>

