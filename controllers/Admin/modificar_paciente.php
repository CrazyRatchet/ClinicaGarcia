<?php
session_start();
include '../../db/Database.php';
include '../../db/Pacientes.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$paciente = new Pacientes($db);

// Obtener datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);

    // Validación simple
    if (!empty($nombre) && !empty($cedula)) {
        if ($paciente->modificarPaciente($id, $nombre, $cedula)) {
            echo '<script>alert("Paciente modificado correctamente.");</script>';
            echo '<script>window.location.href = "../../pages/Administrativos/GestionarPacientes.view.php";</script>';
        } else {
            echo '<script>alert("Error al modificar el paciente.");</script>';
        }
    } else {
        echo '<script>alert("Por favor, complete todos los campos obligatorios.");</script>';
    }
}
?>
