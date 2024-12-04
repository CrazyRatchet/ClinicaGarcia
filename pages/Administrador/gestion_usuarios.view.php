<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mostrar Empleados</title>

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
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="card shadow-lg">
          <div class="card-header bg-secundario text-white text-center">
            <h3>Mostrar Empleados</h3>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <button id="btnMostrarEmpleados" class="btn btn-secundario">Mostrar Empleados</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="empleadosList" class="row mt-4"></div> <!-- Aquí se mostrarán los empleados en tarjetas -->
  </div>


  <?php require '../partials/footer.php'; ?>

</body>

</html>

<script>
    document.getElementById('btnMostrarEmpleados').addEventListener('click', function() {
        // Hacer una solicitud a tu controlador para obtener la lista de empleados
        fetch('../../controllers/Admin/gestion_usuarios.php')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let empleadosHTML = '';
                    
                    data.forEach(empleado => {
                        empleadosHTML += `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="row no-gutters">
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-vcard" style="font-size: 4rem;"></i> <!-- Ícono de perfil -->
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">${empleado.nombre} ${empleado.apellido}</h5>
                                            <p class="card-text">Cédula: ${empleado.cedula}</p>
                                            <p class="card-text">Especialidades: ${empleado.especialidades}</p>
                                            <p class="card-text">Rol: ${empleado.rol}</p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    Dirección: ${empleado.direccion}<br>
                                                    Correo: ${empleado.correo}<br>
                                                    Teléfono: ${empleado.telefono}
                                                </small>
                                            </p>
                                            <a href="modificar_usuario.view.php?id=${empleado.id_u}" class="btn btn-primary mb-2">Modificar</a>
                                            <button class="btn btn-outline-danger" onclick="confirmDelete(${empleado.id_u})">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });

                    document.getElementById('empleadosList').innerHTML = empleadosHTML;
                } else {
                    document.getElementById('empleadosList').innerHTML = '<div class="alert alert-warning text-center">No se encontraron empleados.</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('empleadosList').innerHTML = '<div class="alert alert-danger text-center">Error al cargar los empleados.</div>';
            });
    });

    function confirmDelete(userId) {
        if (confirm("¿Estás seguro de que quieres eliminar a este usuario?")) {
            // Hacer una solicitud para eliminar el usuario
            fetch(`../../controllers/Admin/gestion_usuarios.php?action=delete&id=${userId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Usuario eliminado correctamente.");
                    // Recargar la lista de empleados
                    document.getElementById('btnMostrarEmpleados').click();
                } else {
                    alert("Error al eliminar el usuario.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error al eliminar el usuario.");
            });
        }
    }
</script>
