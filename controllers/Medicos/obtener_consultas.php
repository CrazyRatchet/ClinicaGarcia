<?php
session_start();
include '../../db/Database.php';
include '../../db/Consultas.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$consultasModel = new Consultas($db);

// Obtener el ID del paciente desde la URL
$pacienteId = isset($_GET['id']) ? $_GET['id'] : die('Error: paciente ID no proporcionado');

// Obtener las consultas para el paciente
$consultas = $consultasModel->obtenerConsultasPorPaciente($pacienteId);

echo json_encode($consultas);
?>
