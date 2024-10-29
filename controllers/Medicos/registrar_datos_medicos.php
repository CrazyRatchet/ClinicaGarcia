<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pacienteId = $_POST['id'];
    $pacientesModel->datos_paciente = [
        'edad' => $_POST['edad'],
        'peso' => $_POST['peso'],
        'tipo_sangre' => $_POST['tipo_sangre'],
        'altura' => $_POST['altura'],
        'alergias' => $_POST['alergias'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
    ];

    // Llamar al método para completar los datos del paciente
    if ($pacientesModel->completarDatosPaciente($pacienteId)) {
        echo "Datos médicos registrados exitosamente.";
    } else {
        echo "Error al registrar los datos médicos.";
    }
}
?>
