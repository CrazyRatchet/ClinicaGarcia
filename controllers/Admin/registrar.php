<?php
// Include de conexión y clase Usuarios
include '../../db/Database.php';
include '../../db/Usuarios.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Crear una instancia de la clase Usuarios
$usuario = new Usuarios($db);

// Función para validar el formato de teléfono
function validarTelefono($telefono)
{
    return preg_match('/^\d{4}-\d{4}$/', $telefono);
}

// Validar teléfono
if (!validarTelefono($_POST['telefono'])) {
    echo 'Formato de teléfono incorrecto.';
    echo '<script>';
    redirigir();
}

// Validar correo
if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
    echo 'Correo inválido.';
    echo '<script>';
    redirigir();
}

// Validar rol del usuario (puedes agregar más validaciones si es necesario)
$roles_permitidos = ['administrador', 'usuario', 'medico'];
if (!in_array($_POST['rol'], $roles_permitidos)) {
    echo 'Rol de usuario inválido.';
    echo '<script>';
    redirigir();
}

// Validar la contraseña (puedes agregar más reglas de seguridad)
if (strlen($_POST['contrasenia']) < 6) {
    echo 'La contraseña debe tener al menos 6 caracteres.';
    echo '<script>';
    redirigir();
}

// Asignar los datos validados al array asociativo
$usuario->datos['nombre'] = $_POST['nombre'];
$usuario->datos['apellido'] = $_POST['apellido'];
$usuario->datos['cedula'] = $_POST['cedula'];
$usuario->datos['direccion'] = $_POST['direccion'];
$usuario->datos['correo'] = $_POST['correo'];
$usuario->datos['telefono'] = $_POST['telefono'];
$usuario->datos['rol'] = $_POST['rol'];
$usuario->datos['especialidad'] = $_POST['especialidad'];

$usuario->datos_login['nombre_usuario'] = $_POST['nombre_usuario'];
$usuario->datos_login['contrasenia'] = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);

// Verificar si el usuario ya existe
$registro_existente = $usuario->busquedaUsuarios("usuarios", "cedula", $usuario->datos['cedula']);
$usuario_existente = $usuario->busquedaUsuarios("usuarios_login", "nombre_usuario", $usuario->datos_login['nombre_usuario']);

echo '<script>';
if ($registro_existente || $usuario_existente) {
    echo 'alert("El usuario ya existe en el sistema.");';
    redirigir();
} else {
    // Intentar registrar el usuario
    if ($usuario->registrarUsuarios()) {
        echo 'alert("Usuario registrado exitosamente.");';
    } else {
        echo 'alert("Error al intentar registrar el usuario.");';
    }
    redirigir();
}

// Redirección al formulario después de 5 segundos
function redirigir()
{
    echo 'setTimeout(function() {
        window.location.href = "../../pages/Administrador/registrar.view.php";
      }, 5000);';
    echo '</script>';
}
require "../../pages/Administrador/registrar.view.php";
