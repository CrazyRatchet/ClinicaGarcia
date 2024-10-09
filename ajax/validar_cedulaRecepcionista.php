<?php
include '../db/Database.php';
include '../db/RecepcionistasCredenciales.php';

$database = new Database();
$db = $database->getConnection();

$recepcionistascredenciales = new RecepcionistasCredenciales($db);

if (isset($_POST['cedula'])) {
    $recepcionistascredenciales->cedula = $_POST['cedula'];
    $resultado = $recepcionistascredenciales->buscar();

    echo json_encode(['existe' => !empty($resultado)]);
} else {
    echo json_encode(['error' => 'No se proporcionó una cédula']);
}
?>