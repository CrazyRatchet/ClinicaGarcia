<?php
session_start();
include '../../db/Database.php';
include '../../db/Citas.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$citasModel = new Citas($db);

// Verificar que se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $paciente_id = $_POST['paciente_id'];
    $doctor_id = $_POST['doctor_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Validar que no haya citas existentes para el mismo paciente y doctor en la misma fecha y hora
    if ($citasModel->verificarCitaExistente($paciente_id, $doctor_id, $fecha, $hora)) {
        $_SESSION['message'] = "Ya existe una cita para este paciente con el médico en la misma fecha y hora.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/AgendarCitas.view.php"); // Redirigir a la página del formulario
        exit();
    }

    // Intentar agendar la cita
    if ($citasModel->agendarCita($paciente_id, $doctor_id, $fecha, $hora)) {
        $_SESSION['message'] = "Cita agendada con éxito.";
        $_SESSION['message_type'] = "success";
        // Redirigir a la página de gestión de citas si la cita fue exitosa
        header("Location: /ClinicaGarcia/pages/Citas/GestionarCitas.view.php");
        exit();
    } else {
        $_SESSION['message'] = "Error al agendar la cita. Intente nuevamente.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/AgendarCitas.view.php"); // Redirigir a la página del formulario
        exit();
    }
} else {
    // Redirigir si el acceso no es por POST
    header("Location: /ClinicaGarcia/pages/AgendarCitas.view.php");
    exit();
}
?>
