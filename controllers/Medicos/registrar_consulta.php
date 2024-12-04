<?php
session_start();
include '../../db/Database.php';
include '../../db/Consultas.php'; 

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();
$consultasModel = new Consultas($db);

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del paciente desde el formulario
    $pacienteId = $_POST['paciente_id'];

    // Completar los datos de la consulta con los valores del formulario
    $consultaData = [
        'paciente_id' => $pacienteId,
        'nombre_completo' => $_POST['nombre_completo'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'numero_identificacion' => $_POST['numero_identificacion'],
        'direccion' => $_POST['direccion'],
        'numero_telefono' => $_POST['numero_telefono'],
        'antecedentes_familiares' => $_POST['antecedentes_familiares'],
        'medicamentos_regulares' => $_POST['medicamentos_regulares'],
        'padecimientos' => $_POST['padecimientos'],
        'alergias' => $_POST['alergias'],
        'sintomas' => $_POST['historia_sintomas'],
        'diagnostico' => $_POST['diagnostico'],
        'fecha_consulta' => $_POST['fecha_consulta']
    ];

    // Validar que los campos obligatorios no estén vacíos
    if (empty($consultaData['numero_identificacion']) || empty($consultaData['direccion']) || 
        empty($consultaData['numero_telefono']) || empty($consultaData['antecedentes_familiares']) || 
        empty($consultaData['medicamentos_regulares']) || empty($consultaData['padecimientos']) || 
        empty($consultaData['alergias']) || empty($consultaData['sintomas']) || 
        empty($consultaData['diagnostico']) || empty($consultaData['fecha_consulta'])) {
        
        $_SESSION['message'] = "Por favor, complete todos los campos obligatorios.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Medicos/RegistrarConsulta.view.php?id=$pacienteId");
        exit();
    }

    // Asignar los datos de consulta al modelo
    $consultasModel->paciente_id = $consultaData['paciente_id'];
    $consultasModel->nombre_completo = $consultaData['nombre_completo'];
    $consultasModel->fecha_nacimiento = $consultaData['fecha_nacimiento'];
    $consultasModel->numero_identificacion = $consultaData['numero_identificacion'];
    $consultasModel->direccion = $consultaData['direccion'];
    $consultasModel->numero_telefono = $consultaData['numero_telefono'];
    $consultasModel->antecedentes_familiares = $consultaData['antecedentes_familiares'];
    $consultasModel->medicamentos_regulares = $consultaData['medicamentos_regulares'];
    $consultasModel->padecimientos = $consultaData['padecimientos'];
    $consultasModel->alergias = $consultaData['alergias'];
    $consultasModel->sintomas = $consultaData['sintomas'];
    $consultasModel->diagnostico = $consultaData['diagnostico'];
    $consultasModel->fecha_consulta = $consultaData['fecha_consulta'];

    // Intentar registrar la consulta
    if ($consultasModel->insertarConsulta()) {
        $_SESSION['message'] = "Consulta registrada exitosamente.";
        $_SESSION['message_type'] = "success";
        header("Location: /ClinicaGarcia/pages/Medicos/Gestionar_consultas.view.php");
        exit();
    } else {
        $_SESSION['message'] = "Error al registrar la consulta. Intente nuevamente.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Medicos/Nueva_consulta.view.php?id=$pacienteId");
        exit();
    }
} else {
    // Redirigir si el acceso no es por POST
    header("Location: /ClinicaGarcia/pages/Medicos/Gestionar_consultas.view.php");
    exit();
}
?>
