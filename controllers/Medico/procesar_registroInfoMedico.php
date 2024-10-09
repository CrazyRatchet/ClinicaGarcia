<?php
echo '<head>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';
echo '</head>';
include '../../db/Database.php';
include '../../db/MedicosInfo.php';

$database = new Database();
$db = $database->getConnection();

$medicosinfo = new MedicosInfo($db);

$medicosinfo->cedula=$_POST['cedula'];
$medicosinfo->nombre=$_POST['nombre'];
$medicosinfo->apellido=$_POST['apellido'];

// Obtener el nombre de la especialidad
$especialidad_id = $_POST['especialidad'];
$stmt = $db->prepare("SELECT nombre FROM especialidades WHERE id = :id");
$stmt->bindParam(":id", $especialidad_id);
$stmt->execute();
$medicosinfo->especialidad = $stmt->fetchColumn(); // Obtener el nombre de la especialidad

$medicosinfo->telefono=$_POST['telefono'];
$medicosinfo->correo=$_POST['correo'];
$medicosinfo->direccion=$_POST['direccion'];


if ($medicosinfo->registrar()) {
    echo '<div class="alert alert-success mt-4" role="alert">';
    echo 'Información del usuario médico registrada exitosamente.';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger mt-4" role="alert">';
    echo 'Error al registrar la información de usuario médico';
    echo '</div>';
}

$tiempo_espera = 5;
$url_destino = '../../pages/Medico/registrarInfoMedico.php';
echo "<meta http-equiv='refresh' content='$tiempo_espera;url=$url_destino'>";
?>