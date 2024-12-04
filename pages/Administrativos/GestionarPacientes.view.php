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
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-secundario text-white text-center">
                    <h3>Gestionar Pacientes</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button id="btnMostrarPacientes" class="btn btn-secundario">Mostrar Pacientes</button>
                        
                        <!-- Botón para mostrar el menú de búsqueda -->
                        <button id="btnBuscarPaciente" class="btn btn-secundario" data-bs-toggle="collapse" data-bs-target="#searchMenu" aria-expanded="false" aria-controls="searchMenu">
                            Buscar Paciente
                        </button>
                        
                        <!-- Menú desplegable para ingresar la cédula y buscar -->
                        <div class="collapse" id="searchMenu">
                            <div class="text-center mt-3">
                                <input type="text" id="inputCedula" class="form-control mb-2" placeholder="Ingresa la Cédula">
                                <button id="btnBuscar" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pacientesList" class="row mt-4"></div> <!-- Aquí se mostrarán los pacientes en tarjetas -->
</div>

<script>
    // Mostrar pacientes
    document.getElementById('btnMostrarPacientes').addEventListener('click', function() {
        fetch('../../controllers/Admin/gestion_pacientes.php')
            .then(response => response.json())
            .then(data => {
                mostrarPacientes(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('pacientesList').innerHTML = '<div class="alert alert-danger text-center">Error al cargar los pacientes.</div>';
            });
    });

    // Buscar paciente por cédula
    document.getElementById('btnBuscar').addEventListener('click', function() {
        const cedula = document.getElementById('inputCedula').value.trim();
        
        if (cedula !== '') {
            fetch(`../../controllers/Admin/gestion_pacientes.php?cedula=${cedula}`)
                .then(response => response.json())
                .then(data => {
                    mostrarPacientes(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('pacientesList').innerHTML = '<div class="alert alert-danger text-center">Error al buscar el paciente.</div>';
                });
        } else {
            Swal.fire('Por favor ingresa una cédula para buscar.');
        }
    });

    // Función para mostrar pacientes en tarjetas
    function mostrarPacientes(pacientes) {
        if (pacientes.length > 0) {
            let pacientesHTML = '';
            pacientes.forEach(paciente => {
                pacientesHTML += `
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-vcard" style="font-size: 4rem;"></i> <!-- Ícono de perfil -->
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${paciente.nombre}</h5>
                                    <p class="card-text">Cédula: ${paciente.cedula}</p>
                                    <a href="modificar_paciente.view.php?id=${paciente.id}" class="btn btn-primary mb-2">Modificar</a>
                                    <button class="btn btn-outline-danger" onclick="confirmDelete(${paciente.id})">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
            document.getElementById('pacientesList').innerHTML = pacientesHTML;
        } else {
            document.getElementById('pacientesList').innerHTML = '<div class="alert alert-warning text-center">No se encontraron pacientes.</div>';
        }
    }

    // Función de confirmación para eliminar un paciente
    function confirmDelete(pacienteId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hacer una solicitud para eliminar el paciente
                fetch(`../../controllers/Admin/gestion_pacientes.php?action=delete&id=${pacienteId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El paciente ha sido eliminado correctamente.',
                            'success'
                        );
                        // Recargar la lista de pacientes
                        document.getElementById('btnMostrarPacientes').click();
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el paciente.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Hubo un problema al eliminar el paciente.',
                        'error'
                    );
                });
            }
        });
    }

    // Mostrar mensaje de sesión si está presente
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
