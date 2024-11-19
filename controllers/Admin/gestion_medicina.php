<?php
include '../../db/Database.php';
include '../../db/Medicina.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$medicinaModel = new Medicina($db);

// Obtener la acción a realizar
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
    case 'crear':
        $medicinaModel->datos['nombre'] = $_POST['nombre'] ?? null;
        $medicinaModel->datos['descripcion'] = $_POST['descripcion'] ?? null;
        $medicinaModel->datos['costo'] = $_POST['costo'] ?? null;
        $medicinaModel->datos['imagen'] = $_POST['imagen'] ?? null;
        $medicinaModel->datos['cantidad'] = $_POST['cantidad'] ?? null;
        $medicinaModel->datos['sintomas'] = $_POST['sintomas'] ?? []; // Múltiples síntomas seleccionados
    
        if (!empty($medicinaModel->datos['nombre']) && !empty($medicinaModel->datos['descripcion']) && !empty($medicinaModel->datos['costo']) && !empty($medicinaModel->datos['cantidad'])) {
            if ($medicinaModel->crearMedicina()) {
                header("Location: ../../pages/Administrador/medicina.view.php?msg=Medicina registrada exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/medicina.view.php?msg=Error al registrar la medicina.");
                exit();
            }
        } else {
            header("Location: ../../pages/Administrador/medicina.view.php?msg=Todos los campos son obligatorios.");
            exit();
        }
        break;

    case 'eliminar':
        // Obtener el ID de la medicina a eliminar (se espera en GET)
        $medicina_id = $_GET['id'] ?? null;

        if ($medicina_id) {
            if ($medicinaModel->eliminarMedicina($medicina_id)) {
                header("Location: ../../pages/Administrador/medicina.view.php?msg=Medicina eliminada exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/medicina.view.php?msg=Error al eliminar la medicina.");
                exit();
            }
        } else {
            header("Location: ../../pages/Administrador/medicina.view.php?msg=ID de medicina no válido.");
            exit();
        }
        break;

    case 'obtener':
        // Obtener todas las medicinas
        $resultado = $medicinaModel->obtenerMedicinas();
        echo json_encode($resultado ?: []); // Respuesta en formato JSON
        break;

    case 'modificar':
        $medicinaModel->datos['nombre'] = $_POST['nombre'] ?? null;
        $medicinaModel->datos['descripcion'] = $_POST['descripcion'] ?? null;
        $medicinaModel->datos['costo'] = $_POST['costo'] ?? null;
        $medicinaModel->datos['imagen'] = $_POST['imagen'] ?? null;
        $medicinaModel->datos['cantidad'] = $_POST['cantidad'] ?? null;
        $medicinaModel->datos['sintomas'] = $_POST['sintomas'] ?? []; // Múltiples síntomas seleccionados

        if (!empty($medicinaModel->datos['id']) && !empty($medicinaModel->datos['nombre']) && !empty($medicinaModel->datos['descripcion']) && !empty($medicinaModel->datos['costo']) && !empty($medicinaModel->datos['imagen'])) {
            if ($medicinaModel->modificarMedicina()) {
                header("Location: ../../pages/Administrador/medicina.view.php?msg=Medicina modificada exitosamente.");
                exit();
            } else {
                header("Location: ../../pages/Administrador/medicina.view.php?msg=Error al modificar la medicina.");
                exit();
            }
        } else {
            header("Location: ../../pages/Administrador/medicina.view.php?msg=Todos los campos son obligatorios para modificar.");
            exit();
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
        break;
}
?>

