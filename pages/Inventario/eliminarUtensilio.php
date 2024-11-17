<?php
require_once '../../db/Database.php';
require_once '../../db/Inventario.php';

$inventario = new Inventario();

// Verificar si se ha recibido el ID del utensilio por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Llamar al método para eliminar el utensilio
    $eliminado = $inventario->eliminarUtensilio($id);

    if ($eliminado) {
        echo "<script>alert('Utensilio eliminado correctamente'); window.location.href = 'listarUtensilio.view.php';</script>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al eliminar el utensilio.</div>";
    }
} else {
    header("Location: listarUtensilio.view.php");
    exit;
}
?>
