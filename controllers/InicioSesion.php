<?php
// Incluir la conexión a la base de datos y la clase Usuarios
include '../db/Database.php';
include '../db/Usuarios.php';

// Iniciar la sesión
session_start();

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Usuarios
$usuario = new Usuarios($db);

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y limpiar los datos del formulario
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contrasenia = trim($_POST['contrasenia']);

    // Verificar que los campos no estén vacíos
    if (empty($nombre_usuario) || empty($contrasenia)) {
        echo '<script>alert("Usuario o contraseña requeridos.");</script>';
        header("Location: ../pages/InicioSesion.view.php");
        exit();
    }

    // Buscar el usuario en la tabla 'usuarios_login'
    $usuarioDatos = $usuario->busquedaUsuarios('usuarios_login', 'nombre_usuario', $nombre_usuario);

    // Verificar si el usuario existe
    if ($usuarioDatos) {
        // Verificar la contraseña
        if (password_verify($contrasenia, $usuarioDatos['contrasenia'])) {
            // Almacenar información del usuario en la sesión
            $_SESSION['usuario'] = $usuarioDatos['nombre_usuario'];
            $_SESSION['rol'] = isset($usuarioDatos['rol']) ? $usuarioDatos['rol'] : null; // Verificar si el rol está disponible
            $_SESSION['loggedin'] = true;

            // Redirigir a la página de inicio
            header("Location: ../index.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo '<script>alert("Usuario o Contraseña incorrecta.");</script>';
            header("Location: ../pages/InicioSesion.view.php");
            exit();
        }
    } else {
        // Usuario no encontrado
        echo '<script>alert("Usuario no encontrado.");</script>';
        header("Location: ../pages/InicioSesion.view.php");
        exit();
    }
}
