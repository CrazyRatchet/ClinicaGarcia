<?php
include '../../db/Database.php';
include '../../db/Citas.php';

$database = new Database();
$db = $database->getConnection();
$citasModel = new Citas($db);

// Obtener la cita a modificar
$citaId = $_GET['id'];
$cita = $citasModel->obtenerCitaPorId($citaId);

if (!$cita) {
    $_SESSION['message'] = "Cita no encontrada.";
    $_SESSION['message_type'] = "error";
    header("Location: GestionarCitas.view.php");
    exit();
}
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
    <h2 class="text-center mb-4">Modificar Cita</h2>

    <!-- Mostrar mensajes de sesión si existen -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> text-center">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario de modificación de cita -->
    <form action="../../controllers/Citas/modificar_cita.php" method="post">
        <input type="hidden" name="id" value="<?php echo $cita['id']; ?>">

        <div class="form-group">
            <label for="paciente">Paciente:</label>
            <input type="text" class="form-control" value="<?php echo $cita['paciente']; ?>" readonly>
            <input type="hidden" name="paciente_id" value="<?php echo $cita['paciente_id']; ?>">
        </div>

        <div class="form-group">
            <label for="medico">Médico:</label>
            <input type="text" class="form-control" value="<?php echo $cita['medico']; ?>" readonly>
            <input type="hidden" name="doctor_id" value="<?php echo $cita['doctor_id']; ?>">
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $cita['fecha']; ?>" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $cita['hora']; ?>" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Cita</button>
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
