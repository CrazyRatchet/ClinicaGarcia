<?php
session_start();

// Incluir archivos de base de datos y modelo
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Pacientes
$paciente = new Pacientes($db);

// Verificar si se ha solicitado una acción específica
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($paciente->eliminarPaciente($id)) {
        // Devolver un JSON de éxito
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        // Devolver un JSON de error
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
    }
    exit;
}

// Verificar si se realizó una búsqueda por cédula
if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
    $pacientes = $paciente->buscarPacientePorCedula($cedula); // Nueva función en el modelo
} else {
    // Obtener los datos seleccionados de los pacientes
    $pacientes = $paciente->busquedaPacientesSeleccionados();
}

// Verificar si se obtuvieron resultados
if ($pacientes) {
    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($pacientes);
} else {
    // Enviar un error si no se encontraron pacientes
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
