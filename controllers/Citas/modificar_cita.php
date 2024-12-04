<?php
session_start();
include '../../db/Database.php';
include '../../db/Citas.php';

$database = new Database();
$db = $database->getConnection();
$citasModel = new Citas($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $id = $_POST['id'];
    $paciente_id = $_POST['paciente_id'];
    $doctor_id = $_POST['doctor_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Validar que no haya citas existentes para el mismo paciente y doctor en la misma fecha y hora
    if ($citasModel->verificarCitaExistente($paciente_id, $doctor_id, $fecha, $hora)) {
        $_SESSION['message'] = "Ya existe una cita para este paciente con el médico en la misma fecha y hora.";
        $_SESSION['message_type'] = "error";
    } else {
        // Intentar modificar la cita
        if ($citasModel->modificarCita($id, $paciente_id, $doctor_id, $fecha, $hora)) {
            $_SESSION['message'] = "Cita modificada con éxito.";
            $_SESSION['message_type'] = "success";
            header("Location: ../../pages/Citas/GestionarCitas.view.php");
            exit();
        } else {
            $_SESSION['message'] = "Error al modificar la cita. Intente nuevamente.";
            $_SESSION['message_type'] = "error";
        }
    }
}

// Redirigir a la página de gestión de citas si hubo un error
header("Location: ../../pages/Citas/GestionarCitas.view.php");
exit();
?>
