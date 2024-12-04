<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientes = new Pacientes($db);

// Verificar que se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $correo = trim($_POST['correo']);

    // Validar que nombre y cédula no estén vacíos
    if (empty($nombre) || empty($cedula) || empty($correo))  {
        $_SESSION['message'] = "Por favor, complete todos los campos obligatorios.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrativos/RegistrarPacientes.view.php");
        exit();
    }

    // Verificar si el paciente ya existe
    if ($pacientes->verificarPacienteExistente($cedula)) {
        $_SESSION['message'] = "El paciente con esta cédula ya está registrado.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrativos/RegistrarPacientes.view.php");
        exit();
    }

    // Asignar los datos validados al array asociativo en la clase Pacientes
    $pacientes->datos_paciente = [
        'nombre' => $nombre,
        'cedula' => $cedula,
        'correo' => $correo
    ];

    // Intentar registrar el paciente
    if ($pacientes->crearPacienteBasico()) {
        $_SESSION['message'] = "Paciente registrado exitosamente.";
        $_SESSION['message_type'] = "success";
        header("Location: /ClinicaGarcia/pages/Administrativos/GestionarPacientes.view.php");
        exit();
    } else {
        $_SESSION['message'] = "Error al registrar el paciente. Intente nuevamente.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrativos/RegistrarPacientes.view.php");
        exit();
    }
} else {
    // Redirigir si el acceso no es por POST
    header("Location: /ClinicaGarcia/pages/Administrativos/RegistrarPacientes.view.php");
    exit();
}
?>