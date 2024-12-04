<?php
include '../../db/Database.php';
include '../../db/Consultas.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$consultasModel = new Consultas($db);

// Obtener el ID de la consulta y el ID del paciente desde la URL
$consultaId = isset($_GET['id']) ? $_GET['id'] : die('ERROR: El ID de la consulta no ha sido proporcionado.');
$pacienteId = isset($_GET['paciente_id']) ? $_GET['paciente_id'] : die('ERROR: El ID del paciente no ha sido proporcionado.');

// Obtener los detalles de la consulta utilizando la función obtenerConsultaPorId
$consulta = $consultasModel->obtenerConsultaPorId($consultaId, $pacienteId);
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
    <h2 class="text-center mb-4">Detalle de la Consulta</h2>

    <?php if ($consulta): ?>
        <div class="row">
            <div class="col-12">
                <h4>Fecha: <?php echo htmlspecialchars($consulta['fecha_consulta']); ?></h4>
                <p><strong>Nombre del paciente:</strong> <?php echo htmlspecialchars($consulta['nombre_completo']); ?></p>
                <p><strong>Fecha de nacimiento del paciente:</strong> <?php echo htmlspecialchars($consulta['fecha_nacimiento']); ?></p>
                <p><strong>Cedula:</strong> <?php echo htmlspecialchars($consulta['numero_identificacion']); ?></p>
                <p><strong>Antecedentes:</strong> <?php echo htmlspecialchars($consulta['antecedentes_familiares']); ?></p>
                <p><strong>Medicamentos Regulares:</strong> <?php echo htmlspecialchars($consulta['medicamentos_regulares']); ?></p>
                <p><strong>Padecimientos:</strong> <?php echo htmlspecialchars($consulta['padecimientos']); ?></p>
                <p><strong>Alergias:</strong> <?php echo htmlspecialchars($consulta['alergias']); ?></p>
                <p><strong>Sintomas:</strong> <?php echo htmlspecialchars($consulta['sintomas']); ?></p>
                <p><strong>Diagnostico:</strong> <?php echo htmlspecialchars($consulta['diagnostico']); ?></p>

                <!-- Botón para regresar a las Consultas del Paciente -->
                <a href="Ver_consultas.view.php?id=<?php echo $pacienteId; ?>" class="btn btn-secondary">Regresar a las Consultas</a>
            </div>
        </div>
    <?php else: ?>
        <p>No se encontró la consulta.</p>
    <?php endif; ?>
</div>

<?php require '../partials/footer.php'; ?>
