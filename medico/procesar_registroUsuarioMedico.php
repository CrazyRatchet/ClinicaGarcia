<?php
echo '<head>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
echo '</head>';
include '../config/Database.php';
include '../includes/MedicosCredenciales.php';

$database = new Database();
$db = $database->getConnection();

$medicoscredenciales= new MedicosCredenciales($db);

$medicoscredenciales->cedula=$_POST['cedula'];
$medicoscredenciales->usuario=$_POST['usuario'];
$medicoscredenciales->contrasena=$_POST['contrasena'];


if ($medicoscredenciales->registrar()) {
    echo '<div class="alert alert-success mt-4" role="alert">';
    echo 'Usuario médico registrado exitosamente.';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger mt-4" role="alert">';
    echo 'Error al registrar el usuario médico';
    echo '</div>';
}

$tiempo_espera = 5;
$url_destino = 'registrarUsuarioMedico.php';
echo "<meta http-equiv='refresh' content='$tiempo_espera;url=$url_destino'>";
?>