<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Registro de Usuario</h2>
    <form action="../../controllers/Admin/registrar.php" method="post" id="usuarioForm">
        <!-- Datos del usuario -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>

            <div class="form-group col-md-6">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cedula">Cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" required
                    pattern="^\d{1,2}-\d{4}-\d{4}$"
                    title="Formato: X-XXXX-XXXX, donde X es un dígito (por ejemplo, 8-1005-2011).">
            </div>

            <div class="form-group col-md-6">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required
                    pattern="^\d{4}-\d{4}$"
                    title="Formato: XXXX-XXXX, donde cada X es un dígito.">
            </div>
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>

        <div class="form-group">
            <label for="correo">Correo electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rol">Rol:</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="" disabled selected>Selecciona un rol</option>
                    <?php
                    include '../../db/Database.php';
                    include '../../db/Roles.php';
                    $database = new Database();
                    $db = $database->getConnection();
                    $roles = new Roles($db);
                    $result = $roles->obtenerRoles();
                    if ($result === false) {
                        echo "<option value='' disabled>Error al cargar roles.</option>";
                    } else {
                        foreach ($result as $rol) {
                            echo "<option value='{$rol['id']}'>{$rol['nombre_r']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="especialidades">Especialidades:</label>
                <select id="especialidades" class="form-control">
                    <option value="" disabled selected>Selecciona especialidades</option>
                    <?php
                    include '../../db/Especialidades.php';
                    $especialidades = new Especialidades($db);
                    $result = $especialidades->obtenerEspecialidades();
                    if ($result === false) {
                        echo "<option value='' disabled>Error al cargar especialidades.</option>";
                    } else {
                        foreach ($result as $especialidad) {
                            echo "<option value='{$especialidad['id']}'>{$especialidad['nombre']}</option>";
                        }
                    }
                    ?>
                </select>
                <small class="form-text text-muted">Selecciona una o más especialidades.</small>
            </div>
        </div>

        <!-- Contenedor para mostrar las especialidades seleccionadas -->
        <div id="selectedSpecialties" class="mb-3"></div>

        <!-- Campo oculto para almacenar los IDs de las especialidades seleccionadas -->
        <div id="especialidadesSeleccionadas" style="display: none;"></div>

        <!-- Datos de login -->
        <h4 class="mt-4">Datos de inicio de sesión</h4>

        <div class="form-group">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required pattern="^[A-Za-z0-9_]+$" title="Solo se permiten letras, números y guiones bajos.">
        </div>

        <div class="form-group">
            <label for="contrasenia">Contraseña:</label>
            <input type="password" class="form-control" id="contrasenia" name="contrasenia" required
                pattern=".{6,}"
                title="La contraseña debe tener al menos 6 caracteres.">
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Registrar">
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>

<script>
    const selectedSpecialtiesContainer = document.getElementById('selectedSpecialties');
    const especialidadesSelect = document.getElementById('especialidades');
    const especialidadesSeleccionadas = document.getElementById('especialidadesSeleccionadas');

    especialidadesSelect.addEventListener('change', function() {
        const selectedOption = especialidadesSelect.options[especialidadesSelect.selectedIndex];
        if (selectedOption.value) {
            const specialtyElement = document.createElement('div');
            specialtyElement.className = 'specialty-item mb-2';
            specialtyElement.innerHTML = `${selectedOption.text} <button type="button" class="btn btn-sm btn-danger remove-specialty" data-id="${selectedOption.value}">X</button>`;

            selectedSpecialtiesContainer.appendChild(specialtyElement);

            // Añadir la especialidad seleccionada al campo oculto
            const selectedSpecialtyId = selectedOption.value;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'especialidades[]'; // Cada especialidad se añadirá al array
            hiddenInput.value = selectedSpecialtyId;
            especialidadesSeleccionadas.appendChild(hiddenInput);

            // Eliminar especialidad al hacer clic en 'X'
            specialtyElement.querySelector('.remove-specialty').addEventListener('click', function() {
                const specialtyId = this.getAttribute('data-id');
                const specialtyOption = Array.from(especialidadesSelect.options).find(opt => opt.value === specialtyId);
                if (specialtyOption) {
                    // Eliminar la especialidad del campo oculto
                    const inputs = especialidadesSeleccionadas.querySelectorAll('input[type="hidden"]');
                    inputs.forEach(input => {
                        if (input.value === specialtyId) {
                            input.remove(); // Eliminar del DOM
                        }
                    });
                    this.parentElement.remove(); // Eliminar el elemento del DOM
                }
            });

            // Reiniciar la selección
            especialidadesSelect.selectedIndex = 0; // Volver al primer elemento
        }
    });
</script>
