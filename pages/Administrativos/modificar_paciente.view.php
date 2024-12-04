<?php
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Cargar el paciente a modificar
$pacienteId = $_GET['id'] ?? null;
if (!$pacienteId) {
    echo "Error: No se especificó el ID del paciente.";
    exit();
}

// Cargar los datos del paciente
$query = "SELECT * FROM pacientes WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $pacienteId);
$stmt->execute();
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    echo "Error: Paciente no encontrado.";
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
    <h2 class="text-center mb-4">Modificar Paciente</h2>
    <form action="../../controllers/Admin/modificar_paciente.php" method="post" id="modificarPacienteForm">
        <input type="hidden" name="id" value="<?php echo $pacienteId; ?>">

        <!-- Datos del paciente -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $paciente['nombre']; ?>" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
            </div>

            <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula"  value="<?php echo $paciente['cedula']; ?>"
                required pattern="^\d{1}-\d{3}-\d{3}$|^\d{1}-\d{3}-\d{4}$|^\d{1,2}-\d{4}-\d{4}$" 
                title="Formatos válidos: X-XXX-XXX, X-XXX-XXXX o X-XXXX-XXXX, donde X es un dígito.">
            </div>

            <div class="form-group">
            <label for="correo">Correo electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo"  value="<?php echo $paciente['correo']; ?>"
                required title="Ingresa un correo electrónico válido.">
            </div>

        <!-- Botón para modificar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Paciente</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Permitir solo letras y espacios en los campos de nombre y apellido
        document.getElementById('nombre').addEventListener('keypress', function (e) {
            const char = String.fromCharCode(e.keyCode || e.which);
            if (!/^[a-zA-Z\s]+$/.test(char)) {
                e.preventDefault();
            }
        });


        // Permitir solo números y guiones en el campo de cédula
        document.getElementById('cedula').addEventListener('keypress', function (e) {
            const char = String.fromCharCode(e.keyCode || e.which);
            if (!/^[0-9-]+$/.test(char)) {
                e.preventDefault();
            }
        });
    });
</script>
<?php require '../partials/footer.php'; ?>
