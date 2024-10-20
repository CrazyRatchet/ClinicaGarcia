<?php
include '../../db/Database.php';
include '../../db/Roles.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$rolesModel = new Roles($db);

// Obtener la acción a realizar
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'crear':
        // Asignar los valores a las propiedades del rol
        $nombre = $_POST['nombre_r'] ?? null;
        $descripcion = $_POST['descripcion_r'] ?? null;
        $permisosSeleccionados = $_POST['permisos'] ?? [];

        // Validar que todos los campos obligatorios estén completos
        if (!empty($nombre) && !empty($descripcion) && !empty($permisosSeleccionados)) {
            // Preparar los datos para la creación del rol
            $data = [
                'nombre_r' => $nombre,
                'descripcion_r' => $descripcion,
                'permisos' => $permisosSeleccionados // IDs de los permisos relacionados
            ];

            // Llamar al método para crear un nuevo rol con sus permisos relacionados
            if ($rolesModel->crearRol($data)) {
                header("Location: ../../pages/Administrador/roles.view.php?msg=Rol registrado exitosamente con permisos relacionados.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/roles.view.php?msg=Error al registrar el rol.");
                exit();
            }
        } else {
            // Redirigir con un mensaje de campos obligatorios faltantes
            header("Location: ../../pages/Administrador/roles.view.php?msg=Nombre, descripción y al menos un permiso son requeridos.");
            exit();
        }

    case 'eliminar':
        // Obtener el ID del rol a eliminar (se espera en POST)
        $rol_id = $_POST['id'] ?? null;

        // Verificar que el ID sea válido antes de proceder
        if ($rol_id) {
            if ($rolesModel->eliminarRegistro($rol_id)) {
                header("Location: ../../pages/Administrador/roles.view.php?msg=Rol eliminado exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/roles.view.php?msg=Error al eliminar el rol.");
                exit();
            }
        } else {
            header("Location: ../../pages/Administrador/roles.view.php?msg=ID de rol no válido.");
            exit();
        }

    case 'obtener':
        // Método para obtener todos los roles y sus permisos
        $roles = $rolesModel->buscarRolesConPermisos();
        echo json_encode($roles ?: []); // Respuesta en formato JSON
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
