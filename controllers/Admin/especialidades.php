<?php 
include '../../db/Database.php';
include '../../db/Especialidades.php'; // Asegúrate de que el nombre del archivo y la clase coincidan

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$especialidad = new Especialidades($db); // Instanciamos la clase Especialidades

// Obtener la acción a realizar
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'crear':
        // Asignar los valores a las propiedades de la especialidad
        $especialidad->especialidad['nombre'] = $_POST['nombre'] ?? null;
        $especialidad->especialidad['descripcion'] = $_POST['descripcion'] ?? null;

        // Validar que todos los campos obligatorios estén completos
        if (!empty($especialidad->especialidad['nombre']) && !empty($especialidad->especialidad['descripcion'])) {
            // Llamar al método crearEspecialidad
            if ($especialidad->crearEspecialidad()) {
                // Redirigir a la misma página con un mensaje de éxito
                header("Location: ../../pages/Administrador/especialidades.view.php?msg=Especialidad registrada exitosamente.");
                exit();  // Asegúrate de hacer un exit después de la redirección
            } else {
                // Redirigir a la misma página con un mensaje de error
                header("Location: ../../pages/Administrador/especialidades.view.php?msg=Error al registrar la especialidad.");
                exit();
            }
        } else {
            // Redirigir con un mensaje de campos obligatorios faltantes
            header("Location: ../../pages/Administrador/especialidades.view.php?msg=Faltan campos obligatorios.");
            exit();
        }

    case 'eliminar':
        $especialidad_id = $_GET['id'] ?? null;

        // Comprobar si el ID es válido antes de eliminar
        if ($especialidad_id) {
            if ($especialidad->eliminarRegistro($especialidad_id)) {
                header("Location: ../../pages/Administrador/especialidades.view.php?msg=Especialidad eliminada exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/especialidades.view.php?msg=Error al eliminar la especialidad.");
                exit();
            }
        } else {
            // Mostrar un mensaje de error si el ID no es válido
            header("Location: ../../pages/Administrador/especialidades.view.php?msg=ID de especialidad no válido.");
            exit();
        }

    case 'obtener':
        $resultado = $especialidad->obtenerEspecialidades();
        echo json_encode($resultado ?: []); // Enviar el resultado en formato JSON
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
