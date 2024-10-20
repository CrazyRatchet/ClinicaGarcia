<?php
session_start();

// Incluir archivos de base de datos y modelo
include '../../db/Database.php';
include '../../db/Usuarios.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Usuarios
$usuario = new Usuarios($db);

// Verificar si se ha solicitado una acción específica
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($usuario->eliminarUsuario($id)) {
        // Devolver un JSON de éxito
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        // Devolver un JSON de error
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
    }
    exit;
}

// Obtener los datos seleccionados de los usuarios
$usuarios = $usuario->busquedaUsuariosSeleccionados();

// Verificar si se obtuvieron resultados
if ($usuarios) {
    // Devolver los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($usuarios);
} else {
    // Enviar un error si no se encontraron usuarios
    header('Content-Type: application/json');
    echo json_encode([]);
}
