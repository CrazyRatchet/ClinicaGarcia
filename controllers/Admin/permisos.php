<?php
include '../../db/Database.php';
include '../../db/Permisos.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$permisosModel = new Permisos($db);

// Obtener la acción a realizar
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'crear':
        // Asignar los valores a las propiedades del permiso
        $nombre = $_POST['nombre_p'] ?? null;
        $descripcion = $_POST['descripcion_p'] ?? null;
        $serviciosSeleccionados = $_POST['servicios'] ?? [];

        // Validar que todos los campos obligatorios estén completos
        if (!empty($nombre) && !empty($descripcion) && !empty($serviciosSeleccionados)) {
            // Preparar los datos para la creación del permiso
            $data = [
                'nombre_p' => $nombre,
                'descripcion_p' => $descripcion,
                'servicios' => $serviciosSeleccionados // IDs de los servicios relacionados
            ];

            // Llamar al método para crear un nuevo permiso con sus servicios relacionados
            if ($permisosModel->crearPermiso($data)) {
                header("Location: ../../pages/Administrador/permisos.view.php?msg=Permiso registrado exitosamente con servicios relacionados.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/permisos.view.php?msg=Error al registrar el permiso.");
                exit();
            }
        } else {
            // Redirigir con un mensaje de campos obligatorios faltantes
            header("Location: ../../pages/Administrador/permisos.view.php?msg=Nombre, descripción y al menos un servicio son requeridos.");
            exit();
        }
    case 'eliminar':
        // Obtener el ID del permiso a eliminar (se espera en POST)
        $permiso_id = $_POST['id'] ?? null;

        // Verificar que el ID sea válido antes de proceder
        if ($permiso_id) {
            if ($permisosModel->eliminarRegistro($permiso_id)) {
                header("Location: ../../pages/Administrador/permisos.view.php?msg=Permiso eliminado exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/permisos.view.php?msg=Error al eliminar el permiso.");
                exit();
            }
        } else {
            header("Location: ../../pages/Administrador/permisos.view.php?msg=ID de permiso no válido.");
            exit();
        }


    case 'obtener':
        // Método para obtener todos los permisos y sus servicios
        $permisos = $permisosModel->buscarPermisosConServicios();
        echo json_encode($permisos ?: []); // Respuesta en formato JSON
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
