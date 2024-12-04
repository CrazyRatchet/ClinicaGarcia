<?php
include '../../db/Database.php';
include '../../db/Horarios.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$horariosModel = new Horarios($db);

// Obtener parámetros de la solicitud
$doctor_id = $_GET['doctor_id'];
$fecha = $_GET['fecha'];

// Obtener los horarios disponibles
$horariosDisponibles = $horariosModel->obtenerHorariosDisponibles($doctor_id, $fecha);

// Responder con los horarios disponibles en formato JSON
echo json_encode(['horarios' => $horariosDisponibles]);
?>
