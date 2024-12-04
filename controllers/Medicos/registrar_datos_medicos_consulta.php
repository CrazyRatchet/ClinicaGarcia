<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pacienteId = $_POST['id'];

    // Completar los datos del paciente con los valores del formulario
    $pacientesModel->datos_paciente = [
        'sexo' => $_POST['sexo'],
        'edad' => $_POST['edad'],
        'peso' => $_POST['peso'],
        'altura' => $_POST['altura'],
        'tipo_sangre' => $_POST['tipo_sangre'],
        'alergias' => $_POST['alergias'],
        'medicamentos_regulares' => $_POST['medicamentos_regulares'],
        'padecimientos' => $_POST['padecimientos'],
        'fecha_datos' => date('Y-m-d'), // Fecha actual
        'fecha_nacimiento' => $_POST['fecha_nacimiento']
    ];

    // Validar que los campos obligatorios no estén vacíos
    if (empty($_POST['edad']) || empty($_POST['peso']) || empty($_POST['altura']) || empty($_POST['fecha_nacimiento'])) {
        $_SESSION['message'] = "Por favor, complete todos los campos obligatorios.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Medicos/Gestionar_consultas.view.php?id=$pacienteId");
        exit();
    }

    // Intentar completar los datos del paciente
    if ($pacientesModel->completarDatosPaciente($pacienteId)) {
        $_SESSION['message'] = "Datos médicos actualizados exitosamente.";
        $_SESSION['message_type'] = "success";
        header("Location: /ClinicaGarcia/pages/Medicos/Gestionar_consultas.view.php");
        exit();
    } else {
        $_SESSION['message'] = "Error al actualizar los datos médicos. Intente nuevamente.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Medicos/Gestionar_consultas.view.php?id=$pacienteId");
        exit();
    }
} else {
    // Redirigir si el acceso no es por POST
    header("Location: /ClinicaGarcia/pages/Medicos/Gestionar_consultas.view.php");
    exit();
}
?>
