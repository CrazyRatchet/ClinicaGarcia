<?php
session_start();
include '../../db/Database.php';
include '../../db/MedicosCredenciales.php';

if (!isset($_POST['usuario'], $_POST['contrasena'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'Por favor, complete todos los campos'
    ];
    header('Location: ../../pages/Medico/iniciarSesionMedico.php');
    exit();
}

try {
    // Crear conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear instancia de Administrador
    $medicoscredenciales = new MedicosCredenciales($db);
    $medicoscredenciales->usuario = $_POST['usuario'];

    // Autenticar usuario
    $resultado = $medicoscredenciales->autenticar();

    if ($resultado) {
        // Verificar la contraseña
        if (password_verify($_POST['contrasena'], $resultado['contrasena'])) {
            // Iniciar sesión
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['usuario'] = $medicoscredenciales->usuario;
            $_SESSION['id'] = $resultado['usuario'];
            
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Inicio de sesión exitoso. Bienvenido!'
            ];
            
            header("Location: ../../pages/Medico/menu_principalMedico.php");
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Usuario o contraseña incorrectos. Por favor, intente nuevamente.'
            ];
            header('Location: ../../pages/Medico/iniciarSesionMedico.php');
            exit();
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'danger',
            'texto' => 'Usuario o contraseña incorrectos. Por favor, intente nuevamente.'
        ];
        header('Location: ../../pages/Medico/iniciarSesionMedico.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['mensaje'] = [
        'tipo' => 'danger',
        'texto' => 'Error en el sistema: ' . $e->getMessage()
    ];
    header('Location: ../../pages/Medico/iniciarSesionMedico.php');
    exit();
}
?>
