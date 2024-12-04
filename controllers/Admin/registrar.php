<?php
session_start();
include '../../db/Database.php';
include '../../db/Usuarios.php'; 

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();
$usuarioModel = new Usuarios($db);

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar el formato de teléfono
    if (!preg_match('/^\d{4}-\d{4}$/', $_POST['telefono'])) {
        $_SESSION['message'] = "Formato de teléfono incorrecto.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrador/registrar.view.php");
        exit();
    }

    // Validar el correo
    if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Correo inválido.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrador/registrar.view.php");
        exit();
    }

    // Validar la contraseña
    if (strlen($_POST['contrasenia']) < 6) {
        $_SESSION['message'] = "La contraseña debe tener al menos 6 caracteres.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrador/registrar.view.php");
        exit();
    }

    // Asignar los datos validados al array asociativo
    $usuarioData = [
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'cedula' => $_POST['cedula'],
        'direccion' => $_POST['direccion'],
        'correo' => $_POST['correo'],
        'telefono' => $_POST['telefono'],
        'rol_id' => $_POST['rol'], // Cambiado de rol a rol_id
        'nombre_usuario' => $_POST['nombre_usuario'],
        'contrasenia' => password_hash($_POST['contrasenia'], PASSWORD_DEFAULT)
    ];

    // Asignar los datos de usuario al modelo
    $usuarioModel->datos = $usuarioData;

    // Intentar registrar el usuario
    if ($usuarioModel->crearUsuario()) {
        $_SESSION['message'] = "Usuario registrado correctamente.";
        $_SESSION['message_type'] = "success";
        header("Location: /ClinicaGarcia/pages/Administrador/registrar.view.php");
        exit();
    } else {
        $_SESSION['message'] = "Error al registrar el usuario. Intente nuevamente.";
        $_SESSION['message_type'] = "error";
        header("Location: /ClinicaGarcia/pages/Administrador/registrar.view.php");
        exit();
    }
} else {
    // Redirigir si el acceso no es por POST
    header("Location: /ClinicaGarcia/pages/Administrador/registrar.view.php");
    exit();
}

