<?php
include '../../db/Database.php';
include '../../db/Recetas.php';

// Verificar que se ha enviado la cédula
if (!isset($_GET['cedula']) || empty($_GET['cedula'])) {
    echo json_encode(['error' => 'Cédula no proporcionada']);
    exit;
}

$cedula = htmlspecialchars($_GET['cedula']);

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$recetasModel = new Recetas($db);

// Buscar recetas por cédula
$recetas = $recetasModel->buscarPorCedula($cedula);

// Respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($recetas);
?>
