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

// Función para redirigir al formulario después de 5 segundos
function redirigir()
{
    echo '<script>
        setTimeout(function() {
            window.location.href = "../../pages/Administrador/registrar.view.php";
        }, 5000);
    </script>';
}

// Validar teléfono
if (!validarTelefono($_POST['telefono'])) {
    echo '<script>alert("Formato de teléfono incorrecto.");</script>';
    redirigir();
    exit;
}

// Validar correo
if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
    echo '<script>alert("Correo inválido.");</script>';
    redirigir();
    exit;
}

// Validar la contraseña
if (strlen($_POST['contrasenia']) < 6) {
    echo '<script>alert("La contraseña debe tener al menos 6 caracteres.");</script>';
    redirigir();
    exit;
}

// Asignar los datos validados al array asociativo
$usuario->datos['nombre'] = $_POST['nombre'];
$usuario->datos['apellido'] = $_POST['apellido'];
$usuario->datos['cedula'] = $_POST['cedula'];
$usuario->datos['direccion'] = $_POST['direccion'];
$usuario->datos['correo'] = $_POST['correo'];
$usuario->datos['telefono'] = $_POST['telefono'];
$usuario->datos['rol_id'] = $_POST['rol']; // Cambiado de rol a rol_id

// Asignar datos de login
$usuario->datos_login['nombre_usuario'] = $_POST['nombre_usuario'];
$usuario->datos_login['contrasenia'] = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);

// Registrar el usuario
if ($usuario->crearUsuario()) { // Cambiado de registrar() a crearUsuario()
    echo '<script>alert("Usuario registrado correctamente.");</script>';
} else {
    echo '<script>alert("Error al registrar el usuario.");</script>';
}

// Redirigir a la vista después de 5 segundos
redirigir();
