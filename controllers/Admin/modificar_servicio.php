<?php
include '../../db/Database.php';
include '../../db/Servicios.php';

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
$servicio = new Servicios($db);

// Verificar si la acción es modificar
if ($_POST['action'] === 'modificar') {
    // Obtener el ID del servicio
    $servicio_id = $_POST['id'] ?? null;

    if (!$servicio_id) {
        header('Location: ../../pages/Administrador/servicios.view.php?msg=ID de servicio inválido.');
        exit();
    }

    // Asignar los valores a las propiedades del servicio
    $servicio->servicio['id'] = $servicio_id;
    $servicio->servicio['nombre_s'] = $_POST['nombre_s'] ?? null;
    $servicio->servicio['descripcion_s'] = $_POST['descripcion_s'] ?? null;
    $servicio->servicio['equipamiento_s'] = $_POST['equipamiento_s'] ?? null;
    $servicio->servicio['costo_s'] = $_POST['costo_s'] ?? null;

    // Llamar al método actualizarServicio
    if ($servicio->actualizarServicio()) {
        header("Location: ../../pages/Administrador/servicios.view.php?msg=Servicio actualizado exitosamente.");
        exit();
    } else {
        header("Location: ../../pages/Administrador/servicios.view.php?msg=Error al actualizar el servicio.");
        exit();
    }
} else {
    header("Location: ../../pages/Administrador/servicios.view.php?msg=Acción no válida.");
    exit();
}
