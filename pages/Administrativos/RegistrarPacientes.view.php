<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Registro Básico de Paciente</h2>
    <form action="../../controllers/Admin/RegistrarPacientes.php" method="post" id="pacienteForm">
        <!-- Campos para el nombre y cédula del paciente -->
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
        </div>

        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" id="cedula" name="cedula" required pattern="^\d{1,2}-\d{4}-\d{4}$" title="Formato: X-XXXX-XXXX, donde X es un dígito.">
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Registrar Paciente">
        </div>
    </form>
</div>

<?php require '../partials/footer.php'; ?>
