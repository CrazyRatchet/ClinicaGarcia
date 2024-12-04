<?php
include '../../db/Database.php';
include '../../db/Citas.php';

$database = new Database();
$db = $database->getConnection();
$citasModel = new Citas($db);

// Inicializar variables
$citas = [];
$fechaSeleccionada = '';

// Verificar si se ha enviado una fecha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha'])) {
    $fechaSeleccionada = $_POST['fecha'];
    // Obtener las citas para la fecha seleccionada
    $citas = $citasModel->obtenerCitasPorFecha($fechaSeleccionada);
}

require '../partials/head.php';
require '../partials/nav.php';
?>
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
    <h2 class="text-center mb-4">Ver Citas por Día</h2>

    <form action="ConsultarCitas.view.php" method="post" class="mb-4">
        <div class="form-group">
            <label for="fecha">Selecciona la fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fechaSeleccionada; ?>" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Ver Citas</button>
        </div>
    </form>

    <?php if (!empty($citas)): ?>
        <h4 class="text-center">Citas del <?php echo $fechaSeleccionada; ?></h4>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?php echo $cita['id']; ?></td>
                                <td><?php echo $cita['paciente']; ?></td>
                                <td><?php echo $cita['medico']; ?></td>
                                <td><?php echo $cita['hora']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="text-center">No hay citas para la fecha seleccionada.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require '../partials/footer.php'; ?>
