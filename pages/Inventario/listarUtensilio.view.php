<?php
include '../../db/Database.php';

// Crear una instancia de la clase Database
$database = new Database();
$conn = $database->getConnection();

if (!$conn) {
    die("Error al conectar con la base de datos");
}

// Inicializar la variable de búsqueda
$searchTerm = '';

// Verificar si se ha enviado un término de búsqueda
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
}

// Realizar la consulta para listar utensilios (insensible a mayúsculas y minúsculas)
$query = "SELECT * FROM utensilio WHERE UPPER(nombre) LIKE UPPER(:searchTerm)";
$stmt = $conn->prepare($query);

// Verifica si la consulta se prepara correctamente
if ($stmt === false) {
    die("Error al preparar la consulta");
}

// Vincular el parámetro de búsqueda
$stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');

// Ejecutar la consulta
$stmt->execute();

// Obtener resultados
$utensilios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
require_once '../../db/Database.php'; 
require_once '../../db/Inventario.php';
require '../partials/head.php';
require '../partials/nav.php';
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Mostrar Utensilios</h2>

    <!-- Formulario de búsqueda -->
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar utensilios..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    
    <?php if (count($utensilios) > 0): ?>
        <div class="row justify-content-center">
            <?php foreach ($utensilios as $utensilio): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <?php if (!empty($utensilio['imagen'])): ?>
                                <!-- Mostrar imagen si existe -->
                                <img src="../../assets/<?php echo htmlspecialchars($utensilio['imagen']); ?>" 
                                     alt="Imagen de <?php echo htmlspecialchars($utensilio['nombre']); ?>" 
                                     class="img-fluid mb-3" style="max-height: 150px;">
                            <?php else: ?>
                                <!-- Mostrar ícono por defecto si no hay imagen -->
                                <i class="bi bi-card-list display-4 mb-3"></i>
                            <?php endif; ?>

                            <h5 class="card-title"><?php echo htmlspecialchars($utensilio['nombre']); ?></h5>
                            <p class="card-text">Descripción: <?php echo htmlspecialchars($utensilio['descripcion']); ?></p>
                            <p class="card-text">Costo: $<?php echo number_format($utensilio['costo'], 2); ?></p>
                            
                            <a href="editarUtensilio.view.php?id=<?php echo $utensilio['id']; ?>" 
                               class="btn btn-primary me-2">Editar</a>
                            <a href="eliminarUtensilio.php?id=<?php echo $utensilio['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este utensilio?')">Eliminar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Mostrar alerta si no hay utensilios registrados -->
        <div class="alert alert-warning text-center">No se encontraron utensilios en la base de datos.</div>
    <?php endif; ?>

    <!-- Botón para registrar nuevo utensilio -->
    <div class="text-center">
        <a href="registrarUtensilios.view.php" class="btn btn-primary mb-3">Registrar Nuevo Utensilio</a>
    </div>
</div>

<?php require '../partials/footer.php'; ?>
