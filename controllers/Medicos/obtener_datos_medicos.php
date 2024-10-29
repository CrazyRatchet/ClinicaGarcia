<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$pacientesModel = new Pacientes($db);

// Verificar si se ha pasado un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $datosMedicos = $pacientesModel->obtenerDatosMedicos($id); // Método que debes implementar en tu modelo

    // Retornar los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($datosMedicos);
} else {
    echo json_encode(null); // Si no se pasa un ID, retornar null
}
