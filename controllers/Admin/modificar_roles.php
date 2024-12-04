<?php
include '../../db/Database.php';
include '../../db/Roles.php';

$database = new Database();
$db = $database->getConnection();
$rolesModel = new Roles($db);

// Obtener los datos del formulario
$rolId = $_POST['id'];
$nombreRol = $_POST['nombre_r'];

// Recibir los valores de los permisos (si están marcados, serán 1, sino serán 0)
$permisoAdministrador = isset($_POST['permiso_administrador']) ? 1 : 0;
$permisoMedico = isset($_POST['permiso_medico']) ? 1 : 0;
$permisoAdministrativos = isset($_POST['permiso_administrativos']) ? 1 : 0;
$permisoCitas = isset($_POST['permiso_citas']) ? 1 : 0;
$permisoInventario = isset($_POST['permiso_inventario']) ? 1 : 0;

try {
    // Actualizar el rol en la base de datos
    $query = "UPDATE rol SET 
        nombre_r = :nombre_r,
        permiso_administrador = :permiso_administrador,
        permiso_medico = :permiso_medico,
        permiso_administrativos = :permiso_administrativos,
        permiso_citas = :permiso_citas,
        permiso_inventario = :permiso_inventario
        WHERE id = :id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nombre_r', $nombreRol);
    $stmt->bindParam(':permiso_administrador', $permisoAdministrador);
    $stmt->bindParam(':permiso_medico', $permisoMedico);
    $stmt->bindParam(':permiso_administrativos', $permisoAdministrativos);
    $stmt->bindParam(':permiso_citas', $permisoCitas);
    $stmt->bindParam(':permiso_inventario', $permisoInventario);
    $stmt->bindParam(':id', $rolId);
    $stmt->execute();

    echo "Rol actualizado con éxito.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
