<?php
include '../../db/Database.php';
include '../../db/Especialidades.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$especialidad = new Especialidades($db);

// Verificar si la acción es modificar
if ($_POST['action'] === 'modificar') {
    // Obtener el ID de la especialidad
    $especialidad_id = $_POST['id'] ?? null;

    if (!$especialidad_id) {
        header('Location: ../../pages/Administrador/especialidades.view.php?msg=ID de especialidad inválido.');
        exit();
    }

    // Asignar los valores a las propiedades de la especialidad
    $especialidad->especialidad['id'] = $especialidad_id;
    $especialidad->especialidad['nombre'] = $_POST['nombre'] ?? null;
    $especialidad->especialidad['descripcion'] = $_POST['descripcion'] ?? null;

    // Llamar al método actualizarEspecialidad
    if ($especialidad->actualizarEspecialidad()) {
        header("Location: ../../pages/Administrador/especialidades.view.php?msg=Especialidad actualizada exitosamente.");
        exit();
    } else {
        header("Location: ../../pages/Administrador/especialidades.view.php?msg=Error al actualizar la especialidad.");
        exit();
    }
} else {
    header("Location: ../../pages/Administrador/especialidades.view.php?msg=Acción no válida.");
    exit();
}
