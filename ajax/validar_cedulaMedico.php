<?php
include '../db/Database.php';
include '../db/MedicosCredenciales.php';

$database = new Database();
$db = $database->getConnection();

$medicoscredenciales = new MedicosCredenciales($db);

if (isset($_POST['cedula'])) {
    $medicoscredenciales->cedula = $_POST['cedula'];
    $resultado = $medicoscredenciales->buscar();

    echo json_encode(['existe' => !empty($resultado)]);
} else {
    echo json_encode(['error' => 'No se proporcionó una cédula']);
}
?>