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
    <h2 class="text-center">Gestión de Roles</h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-3">
            <button id="manageRolesBtn" class="btn btn-primary btn-lg btn-block">Ver Roles</button>
        </div>
        <div class="col-md-6 text-center mb-3">
            <button class="btn btn-success btn-lg btn-block" id="showFormBtn">Registrar Rol</button>
        </div>
    </div>

    <!-- Formulario de Registro de Rol -->
    <div class="container mt-5" id="registerForm" style="display: none;">
        <h2 class="text-center mb-4">Registro de Rol</h2>
        <form action="../../controllers/Admin/roles.php" method="post">
            <input type="hidden" name="action" value="crear">

            <!-- Información del Rol -->
            <div class="form-group">
                <label for="nombre_r">Nombre del Rol:</label>
                <input type="text" class="form-control" id="nombre_r" name="nombre_r" required pattern="[A-Za-z\s\-]+" title="Solo se permiten letras, espacios y guiones.">
            </div>

            <!-- Permisos -->
            <div class="form-group">
                <label>Permisos:</label><br>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="permiso_administrador" name="permiso_administrador">
                    <label class="form-check-label" for="permiso_administrador">Permiso Administrador</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="permiso_medico" name="permiso_medico">
                    <label class="form-check-label" for="permiso_medico">Permiso Médico</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="permiso_administrativos" name="permiso_administrativos">
                    <label class="form-check-label" for="permiso_administrativos">Permiso Administrativos</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="permiso_citas" name="permiso_citas">
                    <label class="form-check-label" for="permiso_citas">Permiso Citas</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="permiso_inventario" name="permiso_inventario">
                    <label class="form-check-label" for="permiso_inventario">Permiso Inventario</label>
                </div>
            </div>

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
                    <th>Administrador</th>
                    <th>Médico</th>
                    <th>Administrativos</th>
                    <th>Citas</th>
                    <th>Inventario</th>
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
    // Mostrar/ocultar formulario de registro
    document.getElementById('showFormBtn').addEventListener('click', function() {
        var form = document.getElementById('registerForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // Cargar lista de roles
    document.getElementById('manageRolesBtn').addEventListener('click', function() {
        var rolesList = document.getElementById('rolesList');
        if (rolesList.style.display === 'none' || rolesList.style.display === '') {
            fetchRoles();
            rolesList.style.display = 'block';
        } else {
            rolesList.style.display = 'none';
        }
    });

    function fetchRoles() {
        fetch('../../controllers/Admin/roles.php?action=obtener')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('rolesTableBody');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No hay roles registrados</td></tr>';
                } else {
                    data.forEach(rol => {
                        tableBody.innerHTML += `
                        <tr>
                            <td>${rol.nombre_r}</td>
                            <td>${rol.permiso_administrador ? 'Sí' : 'No'}</td>
                            <td>${rol.permiso_medico ? 'Sí' : 'No'}</td>
                            <td>${rol.permiso_administrativos ? 'Sí' : 'No'}</td>
                            <td>${rol.permiso_citas ? 'Sí' : 'No'}</td>
                            <td>${rol.permiso_inventario ? 'Sí' : 'No'}</td>
                            <td>
                                <a href="modificar_roles.view.php?id=${rol.id}" class="btn btn-warning btn-sm">Modificar</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${rol.nombre_r}', ${rol.id})">Eliminar</a>
                            </td>
                        </tr>`;
                    });
                }
            })
            .catch(error => console.error('Error al cargar roles:', error));
    }

// Función para confirmar eliminación
function confirmDelete(nombreRol, id) {
    if (confirm(`¿Está seguro de que desea eliminar la especialidad "${nombreRol}"?`)) {
        window.location.href = `../../controllers/Admin/roles.php?action=eliminar&id=${id}`;
    }
}
</script>
