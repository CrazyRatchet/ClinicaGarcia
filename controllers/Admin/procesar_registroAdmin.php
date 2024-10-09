<?php
echo '<head>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
echo '</head>';
include '../../db/Database.php';
include '../../db/Administrador.php';

$database = new Database();
$db = $database->getConnection();

$administrador = new Administrador($db);

$administrador->cedula=$_POST['cedula'];
$administrador->nombre=$_POST['nombre'];
$administrador->apellido=$_POST['apellido'];
$administrador->telefono=$_POST['telefono'];
$administrador->correo=$_POST['correo'];
$administrador->direccion=$_POST['direccion'];
$administrador->usuario=$_POST['usuario'];
$administrador->contrasena=$_POST['contrasena'];


if ($administrador->registrar()) {
    echo '<div class="alert alert-success mt-4" role="alert">';
    echo 'Usuario administrador registrado exitosamente.';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger mt-4" role="alert">';
    echo 'Error al registrar el usuario administrador';
    echo '</div>';
}

$tiempo_espera = 5;
$url_destino = '../../pages/Admin/iniciarSesionAdmin.php';
echo "<meta http-equiv='refresh' content='$tiempo_espera;url=$url_destino'>";
?>