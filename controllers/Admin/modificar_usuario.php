<?php
// Incluir los archivos necesarios para conexión y modelos
include '../../db/Database.php';
include '../../db/Usuarios.php';
include '../../db/Especialidades.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar el modelo de usuario
$usuarioModel = new Usuarios($db);

// Obtener los datos enviados desde el formulario
$idUsuario = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$cedula = $_POST['cedula'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$rol_id = $_POST['rol'];
$especialidadesSeleccionadas = $_POST['especialidades'] ?? [];

// Validar que el ID de usuario fue proporcionado
if (!$idUsuario) {
    echo "Error: No se especificó el ID del usuario.";
    exit();
}

// Actualizar los datos del usuario
$query = "UPDATE usuario SET 
            nombre = :nombre,
            apellido = :apellido,
            cedula = :cedula,
            direccion = :direccion,
            correo = :correo,
            telefono = :telefono,
            rol_id = :rol_id
          WHERE id_u = :id";

$stmt = $db->prepare($query);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':apellido', $apellido);
$stmt->bindParam(':cedula', $cedula);
$stmt->bindParam(':direccion', $direccion);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':rol_id', $rol_id);
$stmt->bindParam(':id', $idUsuario);

// Ejecutar la consulta de actualización
if ($stmt->execute()) {
    // Primero, eliminar las especialidades antiguas del usuario
    $queryEliminarEspecialidades = "DELETE FROM especialidad_usuario WHERE id_usuario = :usuario_id";
    $stmtEliminar = $db->prepare($queryEliminarEspecialidades);
    $stmtEliminar->bindParam(':usuario_id', $idUsuario);
    $stmtEliminar->execute();

    // Agregar las especialidades nuevas seleccionadas
    foreach ($especialidadesSeleccionadas as $especialidad_id) {
        $usuarioModel->agregarEspecialidad($idUsuario, $especialidad_id);
    }

    // Redireccionar a una página de éxito (puedes ajustar esta URL según la estructura de tu proyecto)
    header("Location: ../../pages/Administrador/gestion_usuarios.view.php?mensaje=usuario_modificado");
    exit();
} else {
    // En caso de error en la actualización, mostrar mensaje de error
    echo "Error: No se pudo actualizar el usuario.";
    exit();
}
?>
