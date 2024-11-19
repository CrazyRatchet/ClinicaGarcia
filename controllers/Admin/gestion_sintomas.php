<?php 
include '../../db/Database.php';
include '../../db/Sintomas.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$sintoma = new Sintomas($db);

// Obtener la acción a realizar
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'crear':
        // Asignar los valores a las propiedades del síntoma
        $sintoma->sintoma['nombre'] = $_POST['nombre'] ?? null;
        $sintoma->sintoma['descripcion'] = $_POST['descripcion'] ?? null;

        // Validar que el nombre esté completo
        if (!empty($sintoma->sintoma['nombre'])) {
            // Llamar al método crearSintoma
            if ($sintoma->crearSintoma()) {
                // Redirigir a la misma página con un mensaje de éxito
                header("Location: ../../pages/Administrador/sintomas.view.php?msg=Síntoma registrado exitosamente.");
                exit();  // Asegúrate de hacer un exit después de la redirección
            } else {
                // Redirigir a la misma página con un mensaje de error
                header("Location: ../../pages/Administrador/sintomas.view.php?msg=Error al registrar el síntoma.");
                exit();
            }
        } else {
            // Redirigir con un mensaje de campos obligatorios faltantes
            header("Location: ../../pages/Administrador/sintomas.view.php?msg=Faltan campos obligatorios.");
            exit();
        }

    case 'eliminar':
        $sintoma_id = $_GET['id'] ?? null;

        // Comprobar si el ID es válido antes de eliminar
        if ($sintoma_id) {
            if ($sintoma->eliminarRegistro($sintoma_id)) {
                header("Location: ../../pages/Administrador/sintomas.view.php?msg=Síntoma eliminado exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/sintomas.view.php?msg=Error al eliminar el síntoma.");
                exit();
            }
        } else {
            // Mostrar un mensaje de error si el ID no es válido
            header("Location: ../../pages/Administrador/sintomas.view.php?msg=ID de síntoma no válido.");
            exit();
        }
        
    case 'obtener':
        $resultado = $sintoma->obtenerSintomas();
        echo json_encode($resultado ?: []); // Enviar el resultado en formato JSON
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
