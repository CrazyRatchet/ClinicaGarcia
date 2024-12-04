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
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-secundario text-white text-center">
                    <h3>Mostrar Medicamentos</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button id="btnMostrarMedicinas" class="btn btn-secundario">Mostrar Medicamentos</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="medicinasList" class="row mt-4"></div> <!-- Aquí se mostrarán los medicamentos en tarjetas -->
</div>

<script>
    document.getElementById('btnMostrarMedicinas').addEventListener('click', function() {
        // Hacer una solicitud a tu controlador para obtener la lista de medicamentos
        fetch('../../controllers/Admin/gestion_medicina.php?action=obtener')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let medicinasHTML = '';
                    
                    data.forEach(medicina => {
                        let sintomasList = medicina.sintomas ? medicina.sintomas : 'No hay síntomas relacionados';
                        medicinasHTML += `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="row no-gutters">
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                      <!--  <i class="bi bi-capsule-pill" style="font-size: 4rem;"></i>  Ícono de medicina -->
                                        <img src="${medicina.imagen}" alt="Imagen de medicina" style="width: 100px;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">${medicina.nombre}</h5>
                                            <p class="card-text">Descripción: ${medicina.descripcion}</p>
                                            <p class="card-text">Cantidad en Inventario: ${medicina.cantidad}</p>
                                            <p class="card-text">Precio: $${medicina.costo}</p>
                                            <p class="card-text">Síntomas: ${sintomasList}</p>
                                            <a href="modificar_medicina.view.php?id=${medicina.id_m}" class="btn btn-primary mb-2">Modificar</a>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('${medicina.nombre}', ${medicina.id})">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });

                    document.getElementById('medicinasList').innerHTML = medicinasHTML;
                } else {
                    document.getElementById('medicinasList').innerHTML = '<div class="alert alert-warning text-center">No se encontraron medicamentos.</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('medicinasList').innerHTML = '<div class="alert alert-danger text-center">Error al cargar los medicamentos.</div>';
            });
    });

    // Función para confirmar eliminación
function confirmDelete(nombreMedicina, id) {
    if (confirm(`¿Está seguro de que desea eliminar la medicina "${nombreMedicina}"?`)) {
        window.location.href = `../../controllers/Admin/gestion_medicina.php?action=eliminar&id=${id}`;
    }
}
</script>

<?php require '../partials/footer.php'; ?>
