<?php
session_start();
include '../../db/Database.php';
include '../../db/Administrador.php';

if (!isset($_POST['usuario'], $_POST['contrasena'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'Por favor, complete todos los campos'
    ];
    header('Location: iniciarSesionAdmin.php');
    exit();
}

try {
    // Crear conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear instancia de Administrador
    $administrador = new Administrador($db);
    $administrador->usuario = $_POST['usuario'];

    // Autenticar usuario
    $resultado = $administrador->autenticar();

    if ($resultado) {
        // Verificar la contraseña
        if (password_verify($_POST['contrasena'], $resultado['contrasena'])) {
            // Iniciar sesión
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['usuario'] = $administrador->usuario;
            $_SESSION['id'] = $resultado['usuario'];
            
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Inicio de sesión exitoso. Bienvenido!'
            ];
            
            header("Location: ../../pages/Admin/menu_principalAdmin.php");
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Usuario o contraseña incorrectos. Por favor, intente nuevamente.'
            ];
            header('Location: iniciarSesionAdmin.php');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Usuario o contraseña incorrectos. Por favor, intente nuevamente.'
        ];
        header('Location: iniciarSesionAdmin.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'Error en el sistema: ' . $e->getMessage()
    ];
    header('Location: iniciarSesionAdmin.php');
    exit();
}
?>
