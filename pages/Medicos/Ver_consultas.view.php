<?php
include '../../db/Database.php';
include '../../db/Consultas.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$consultasModel = new Consultas($db);

// Obtener el ID del paciente desde la URL
$pacienteId = isset($_GET['id']) ? $_GET['id'] : die('ERROR: El ID del paciente no ha sido proporcionado.');

// Obtener las consultas del paciente utilizando el método obtenerConsultasPorPaciente
$consultas = $consultasModel->obtenerConsultasPorPaciente($pacienteId);
?>

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
    <h2 class="text-center mb-4">Consultas del Paciente</h2>

    <?php if ($consultas): ?>
        <div class="row">
            <?php foreach ($consultas as $consulta): ?>
                <div class="col-12 mb-3">
                    <h5>Consulta ID: <?php echo htmlspecialchars($consulta['id']); ?></h5>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($consulta['fecha_consulta']); ?></p>
                    <a href="Detalle_consulta.view.php?id=<?php echo $consulta['id']; ?>&paciente_id=<?php echo $pacienteId; ?>" class="btn btn-info">Ver Consulta</a>
                </div>
            <?php endforeach; ?>
            <div class="col-12 mb-3">
            <a href="Gestionar_consultas.view.php?id=<?php echo $pacienteId; ?>" class="btn btn-secondary ">Regresar a la Gestion de consultas</a>
            </div>
                </div>
        </div>
    <?php else: ?>
        <p>No hay consultas registradas para este paciente.</p>
    <?php endif; ?>
</div>
<?php require '../partials/footer.php'; ?>
