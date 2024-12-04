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
        $permisos = [
            'permiso_administrador' => !empty($_POST['permiso_administrador']),
            'permiso_medico' => !empty($_POST['permiso_medico']),
            'permiso_administrativos' => !empty($_POST['permiso_administrativos']),
            'permiso_citas' => !empty($_POST['permiso_citas']),
            'permiso_inventario' => !empty($_POST['permiso_inventario']),
        ];

        // Validar que el nombre del rol sea obligatorio
        if (!empty($nombre)) {
            // Preparar los datos para la creación del rol
            $data = array_merge(['nombre_r' => $nombre], $permisos);

            // Llamar al método para crear un nuevo rol
            if ($rolesModel->crearRol($data)) {
                header("Location: ../../pages/Administrador/roles.view.php?msg=Rol registrado exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/roles.view.php?msg=Error al registrar el rol.");
                exit();
            }
        } else {
            // Redirigir con un mensaje de campos obligatorios faltantes
            header("Location: ../../pages/Administrador/roles.view.php?msg=El nombre del rol es obligatorio.");
            exit();
        }

    case 'eliminar':
        // Obtener el ID del rol a eliminar 
        $rol_id = $_GET['id'] ?? null;

        // Verificar que el ID sea válido antes de proceder
        if ($rol_id) {
            if ($rolesModel->eliminarRol($rol_id)) {
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
        // Obtener todos los roles
        $roles = $rolesModel->obtenerRoles();
        echo json_encode($roles ?: []); // Respuesta en formato JSON
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
