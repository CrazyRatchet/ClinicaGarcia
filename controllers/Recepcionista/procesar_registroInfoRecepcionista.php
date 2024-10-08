<?php
echo '<head>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
echo '</head>';
include '../config/Database.php';
include '../includes/RecepcionistasInfo.php';

$database = new Database();
$db = $database->getConnection();

$recepcionistasinfo = new RecepcionistasInfo($db);

$recepcionistasinfo->cedula=$_POST['cedula'];
$recepcionistasinfo->nombre=$_POST['nombre'];
$recepcionistasinfo->apellido=$_POST['apellido'];
$recepcionistasinfo->telefono=$_POST['telefono'];
$recepcionistasinfo->correo=$_POST['correo'];
$recepcionistasinfo->direccion=$_POST['direccion'];


if ($recepcionistasinfo->registrar()) {
    echo '<div class="alert alert-success mt-4" role="alert">';
    echo 'Información del usuario recepcionista registrada exitosamente.';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger mt-4" role="alert">';
    echo 'Error al registrar la información de usuario recepcionista';
    echo '</div>';
}

$tiempo_espera = 5;
$url_destino = 'registrarInfoRecepcionista.php';
echo "<meta http-equiv='refresh' content='$tiempo_espera;url=$url_destino'>";
?>