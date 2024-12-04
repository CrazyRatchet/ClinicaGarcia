<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Verificar que el método de solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();
    $paciente = new Pacientes($db);

    // Obtener datos del formulario
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $correo = trim($_POST['correo']);

    // Validación de campos obligatorios
    if (!empty($nombre) && !empty($cedula) && !empty($correo)) {
        // Intentar modificar el paciente
        if ($paciente->modificarPaciente($id, $nombre, $cedula, $correo)) {
            $_SESSION['message'] = "Paciente modificado correctamente.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error al modificar el paciente.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Todos los campos son obligatorios.";
        $_SESSION['message_type'] = "warning";
    }

    // Redirigir a la página de gestión de pacientes
    header("Location: ../../pages/Administrativos/GestionarPacientes.view.php");
    exit();
} else {
    // Redirigir si el acceso no es por POST
    $_SESSION['message'] = "Acceso no permitido.";
    $_SESSION['message_type'] = "error";
    header("Location: ../../pages/Administrativos/GestionarPacientes.view.php");
    exit();
}
?>
