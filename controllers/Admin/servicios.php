<?php 
include '../../db/Database.php';
include '../../db/Servicios.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$servicio = new Servicios($db);

// Obtener la acción a realizar
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'crear':
        // Asignar los valores a las propiedades del servicio
        $servicio->servicio['nombre_s'] = $_POST['nombre_s'] ?? null;
        $servicio->servicio['descripcion_s'] = $_POST['descripcion_s'] ?? null;
        $servicio->servicio['equipamiento_s'] = $_POST['equipamiento_s'] ?? null;
        $servicio->servicio['costo_s'] = $_POST['costo_s'] ?? null;

        // Validar que todos los campos obligatorios estén completos
        if (!empty($servicio->servicio['nombre_s']) && !empty($servicio->servicio['descripcion_s']) && !empty($servicio->servicio['costo_s'])) {
            // Llamar al método crearServicio
            if ($servicio->crearServicio()) {
                // Redirigir a la misma página con un mensaje de éxito
                header("Location: ../../pages/Administrador/servicios.view.php?msg=Servicio registrado exitosamente.");
                exit();  // Asegúrate de hacer un exit después de la redirección
            } else {
                // Redirigir a la misma página con un mensaje de error
                header("Location: ../../pages/Administrador/servicios.view.php?msg=Error al registrar el servicio.");
                exit();
            }
        } else {
            // Redirigir con un mensaje de campos obligatorios faltantes
            header("Location: ../../pages/Administrador/servicios.view.php?msg=Faltan campos obligatorios.");
            exit();
        }

    case 'eliminar':
        $servicio_id = $_GET['id'] ?? null;

        // Comprobar si el ID es válido antes de eliminar
        if ($servicio_id) {
            if ($servicio->eliminarRegistro($servicio_id)) {
                header("Location: ../../pages/Administrador/servicios.view.php?msg=Servicio eliminado exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/servicios.view.php?msg=Error al eliminar el servicio.");
                exit();
            }
        } else {
            // Mostrar un mensaje de error si el ID no es válido
            header("Location: ../../pages/Administrador/servicios.view.php?msg=ID de servicio no válido.");
            exit();
        }
        
    case 'obtener':
        $resultado = $servicio->obtenerServicios();
        echo json_encode($resultado ?: []); // Enviar el resultado en formato JSON
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
