<?php
include '../../db/Database.php';
include '../../db/Recetas.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$recetasModel = new Recetas($db);

// Obtener todas las recetas
$recetas = $recetasModel->obtenerTodas();

// Respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($recetas);
?>
