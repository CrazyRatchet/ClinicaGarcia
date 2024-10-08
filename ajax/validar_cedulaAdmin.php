<?php
include '../config/Database.php';
include '../includes/Administrador.php';

$database = new Database();
$db = $database->getConnection();

$administrador = new Administrador($db);

if (isset($_POST['cedula'])) {
    $administrador->cedula = $_POST['cedula'];
    $resultado = $administrador->buscar();

    echo json_encode(['existe' => !empty($resultado)]);
} else {
    echo json_encode(['error' => 'No se proporcionó una cédula']);
}
?>
