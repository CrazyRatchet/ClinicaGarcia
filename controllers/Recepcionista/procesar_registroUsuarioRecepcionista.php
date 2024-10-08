<?php
echo '<head>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
echo '</head>';
include '../config/Database.php';
include '../includes/RecepcionistasCredenciales.php';

$database = new Database();
$db = $database->getConnection();

$recepcionistascredenciales= new RecepcionistasCredenciales($db);

$recepcionistascredenciales->cedula=$_POST['cedula'];
$recepcionistascredenciales->usuario=$_POST['usuario'];
$recepcionistascredenciales->contrasena=$_POST['contrasena'];


if ($recepcionistascredenciales->registrar()) {
    echo '<div class="alert alert-success mt-4" role="alert">';
    echo 'Usuario recepcionista registrado exitosamente.';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger mt-4" role="alert">';
    echo 'Error al registrar el usuario recepcionista';
    echo '</div>';
}

$tiempo_espera = 5;
$url_destino = 'registrarUsuarioRecepcionista.php';
echo "<meta http-equiv='refresh' content='$tiempo_espera;url=$url_destino'>";
?>