<?php
// Incluimos la conexión a la base de datos y la clase de pacientes
require '../../db/Database.php';
require '../../db/Pacientes.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Pacientes
$pacientes = new Pacientes($db);

// Función para redirigir al formulario después de 5 segundos
function redirigir()
{
    echo '<script>
        setTimeout(function() {
            window.location.href = "../../pages/Administrativos/RegistrarPacientes.view.php";
        }, 5000);
    </script>';
}

// Validar los datos recibidos del formulario
$nombre = trim($_POST['nombre']);
$cedula = trim($_POST['cedula']);

// Validar que nombre y cédula no estén vacíos
if (empty($nombre) || empty($cedula)) {
    echo '<script>alert("Por favor, complete todos los campos obligatorios.");</script>';
    redirigir();
    exit;
}

// Asignar los datos validados al array asociativo en la clase Pacientes
$pacientes->datos_paciente = [
    'nombre' => $nombre,
    'cedula' => $cedula
];

// Llamar al método de creación básica de paciente
if ($pacientes->crearPacienteBasico()) {
    echo '<script>alert("Paciente registrado exitosamente.");</script>';
} else {
    echo '<script>alert("Error al registrar el paciente.");</script>';
}

// Redirigir a la vista después de 5 segundos
redirigir();
?>
