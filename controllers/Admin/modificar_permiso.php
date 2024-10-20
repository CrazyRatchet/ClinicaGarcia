<?php
// Incluir la conexión a la base de datos y el modelo de permisos
include '../../db/Database.php';
include '../../db/Permisos.php';

$database = new Database();
$db = $database->getConnection();
$permisosModel = new Permisos($db);

// Verificar la acción que se está realizando
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modificar') {
    $permisoId = $_POST['id'] ?? null;
    $nombre = $_POST['nombre_p'] ?? null;
    $descripcion = $_POST['descripcion_p'] ?? null;
    $serviciosSeleccionados = array_filter($_POST['servicios'], function ($value) {
        return !empty($value);
    });


    if ($permisoId && $nombre && $descripcion) {
        // Modificar los detalles del permiso
        if ($permisosModel->modificarPermiso($permisoId, $nombre, $descripcion)) {
            // Eliminar relaciones antiguas y agregar las nuevas relaciones de servicios
            $permisosModel->eliminarServiciosPorPermiso($permisoId);
            foreach ($serviciosSeleccionados as $servicioId) {
                $query = "INSERT INTO servicio_permiso (permiso_id, servicio_id) VALUES (:permiso_id, :servicio_id)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':permiso_id', $permisoId);
                $stmt->bindParam(':servicio_id', $servicioId);
                $stmt->execute();
            }
            header("Location: ../../pages/Administrador/permisos.view.php?msg=Permiso modificado exitosamente.");
            exit();
        } else {
            header("Location: ../../pages/Administrador/permisos.view.php?msg=Error al modificar el permiso.");
            exit();
        }
    } else {
        header("Location: ../../pages/Administrador/permisos.view.php?msg=Faltan campos obligatorios.");
        exit();
    }
}

// Obtener detalles del permiso para la vista de modificación
if (isset($_GET['id'])) {
    $permisoId = $_GET['id'];
    $query = "SELECT * FROM permiso WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $permisoId);
    $stmt->execute();
    $permiso = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$permiso) {
        header("Location: ../../pages/Administrador/permisos.view.php?msg=Permiso no encontrado.");
        exit();
    }

    // Obtener los servicios seleccionados
    $serviciosSeleccionados = [];
    $query = "SELECT servicio_id FROM servicio_permiso WHERE permiso_id = :permiso_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':permiso_id', $permisoId);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $serviciosSeleccionados[] = $row['servicio_id'];
    }
}
