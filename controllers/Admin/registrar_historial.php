<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php'; // Asegúrate de incluir la clase correcta

$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Recoger datos del formulario
$paciente_id = $_POST['paciente_id'];
$nombre_completo = $_POST['nombre_completo'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$numero_identificacion = $_POST['numero_identificacion'];
$direccion = $_POST['direccion'];
$numero_telefono = $_POST['numero_telefono'];
$antecedentes_familiares = $_POST['antecedentes_familiares'];
$medicamentos_actuales = $_POST['medicamentos_actuales'];
$alergias = $_POST['alergias'];
$historia_sintomas = $_POST['historia_sintomas'];
$fecha = $_POST['fecha'];

// Registrar historial médico
if ($pacientesModel->agregarHistorialMedico($paciente_id, $nombre_completo, $fecha_nacimiento, $numero_identificacion, $direccion, $numero_telefono,
                                            $antecedentes_familiares, $medicamentos_actuales, $alergias, $historia_sintomas, $fecha)) {
    $_SESSION['message'] = "Historial médico registrado con éxito.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error al registrar el historial médico. Intente nuevamente.";
    $_SESSION['message_type'] = "error";
}

// Redirigir a la gestión de historial médico
header("Location: GestionarHistorialMedico.view.php");
exit();
?>
