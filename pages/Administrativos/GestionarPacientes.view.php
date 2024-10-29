<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-secundario text-white text-center">
                    <h3>Mostrar Pacientes</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button id="btnMostrarPacientes" class="btn btn-secundario">Mostrar Pacientes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pacientesList" class="row mt-4"></div> <!-- Aquí se mostrarán los pacientes en tarjetas -->
</div>

<script>
    document.getElementById('btnMostrarPacientes').addEventListener('click', function() {
        // Hacer una solicitud a tu controlador para obtener la lista de pacientes
        fetch('../../controllers/Admin/gestion_pacientes.php')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let pacientesHTML = '';
                    
                    data.forEach(paciente => {
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
                                            </p>
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
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('pacientesList').innerHTML = '<div class="alert alert-danger text-center">Error al cargar los pacientes.</div>';
            });
    });

    function confirmDelete(pacienteId) {
        if (confirm("¿Estás seguro de que quieres eliminar a este paciente?")) {
            // Hacer una solicitud para eliminar el paciente
            fetch(`../../controllers/Admin/gestion_pacientes.php?action=delete&id=${pacienteId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Paciente eliminado correctamente.");
                    // Recargar la lista de pacientes
                    document.getElementById('btnMostrarPacientes').click();
                } else {
                    alert("Error al eliminar el paciente.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error al eliminar el paciente.");
            });
        }
    }
</script>

<?php require '../partials/footer.php'; ?>
