<?php
// Incluir la conexión a la base de datos y el modelo de roles y permisos
include '../../db/Database.php';
include '../../db/Roles.php';
include '../../db/Permisos.php';

$database = new Database();
$db = $database->getConnection();
$rolesModel = new Roles($db);
$permisosModel = new Permisos($db);

// Verificar la acción que se está realizando
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modificar') {
    $rolId = $_POST['id'] ?? null;
    $nombre = $_POST['nombre_r'] ?? null;
    $descripcion = $_POST['descripcion_r'] ?? null;
    $permisosSeleccionados = array_filter($_POST['permisos'], function ($value) {
        return !empty($value);
    });

    if ($rolId && $nombre && $descripcion) {
        // Modificar los detalles del rol
        if ($rolesModel->modificarRol($rolId, $nombre, $descripcion)) {
            // Eliminar relaciones antiguas y agregar las nuevas relaciones de permisos
            $rolesModel->eliminarPermisosPorRol($rolId);
            foreach ($permisosSeleccionados as $permisoId) {
                $query = "INSERT INTO rol_permiso (rol_id, permiso_id) VALUES (:rol_id, :permiso_id)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':rol_id', $rolId);
                $stmt->bindParam(':permiso_id', $permisoId);
                $stmt->execute();
            }
            header("Location: ../../pages/Administrador/roles.view.php?msg=Rol modificado exitosamente.");
            exit();
        } else {
            header("Location: ../../pages/Administrador/roles.view.php?msg=Error al modificar el rol.");
            exit();
        }
    } else {
        header("Location: ../../pages/Administrador/roles.view.php?msg=Faltan campos obligatorios.");
        exit();
    }
}

// Obtener detalles del rol para la vista de modificación
if (isset($_GET['id'])) {
    $rolId = $_GET['id'];
    $query = "SELECT * FROM rol WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $rolId);
    $stmt->execute();
    $rol = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rol) {
        header("Location: ../../pages/Administrador/roles.view.php?msg=Rol no encontrado.");
        exit();
    }

    // Obtener los permisos seleccionados
    $permisosSeleccionados = [];
    $query = "SELECT permiso_id FROM rol_permiso WHERE rol_id = :rol_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':rol_id', $rolId);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $permisosSeleccionados[] = $row['permiso_id'];
    }
}
