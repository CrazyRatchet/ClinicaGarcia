<?php
session_start();
include '../../db/Database.php';
include '../../db/Citas.php';
include '../../db/Horarios.php';
require '../../vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$citasModel = new Citas($db);
$horariosModel = new Horarios($db);

// Verificar que se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $paciente_id = $_POST['paciente_id'];
    $doctor_id = $_POST['doctor_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $paciente_email = $_POST['paciente_email'];  // Obtener el correo del paciente

    // Verificar que la hora seleccionada esté dentro del horario del médico
    $horariosDisponibles = $horariosModel->obtenerHorariosDisponibles($doctor_id, $fecha);

    if (!in_array($hora, $horariosDisponibles)) {
        $_SESSION['message'] = "La hora seleccionada no está disponible para el médico en esa fecha.";
        $_SESSION['message_type'] = "error";
        header("Location: ../../pages/Citas/AgendarCitas.view.php"); 
        exit();
    }

    // Validar que no haya citas existentes para el mismo paciente y doctor en la misma fecha y hora
    if ($citasModel->verificarCitaExistente($paciente_id, $doctor_id, $fecha, $hora)) {
        $_SESSION['message'] = "Ya existe una cita para este paciente con el médico en la misma fecha y hora.";
        $_SESSION['message_type'] = "error";
        header("Location: ../../pages/Citas/AgendarCitas.view.php"); 
        exit();
    }

    // Intentar agendar la cita
    if ($citasModel->agendarCita($paciente_id, $doctor_id, $fecha, $hora)) {
        // Si la cita se agendó correctamente, enviar correo de confirmación
        enviarCorreoConfirmacion($paciente_email, $fecha, $hora);

        $_SESSION['message'] = "Cita agendada con éxito.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error al agendar la cita.";
        $_SESSION['message_type'] = "error";
    }

    header("Location: ../../pages/Citas/AgendarCitas.view.php");
}

/**
 * Función para enviar correo de confirmación
 */
function enviarCorreoConfirmacion($paciente_email, $fecha, $hora) {
    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Cambia por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'sistemabibliotecau@gmail.com';  // Cambia por tu correo
        $mail->Password = 'epbr kzvp fdom ipsi';  // Cambia por tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatario
        $mail->setFrom('sistemabibliotecau@gmail.com', 'Clinica Garcia');  // Cambia por tu correo
        $mail->addAddress($paciente_email);  // El correo del paciente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'CONFIRMACION CITA';
        $mail->Body    = "Hola,<br><br>Su cita medica ha sido agendada para el dia <strong>$fecha</strong> a las <strong>$hora</strong>.<br>¡Nos vemos pronto!";

        // Enviar el correo
        $mail->send();
    } catch (Exception $e) {
        // Si hay un error al enviar el correo
        error_log("Error al enviar el correo: " . $mail->ErrorInfo);
    }
}
?>
