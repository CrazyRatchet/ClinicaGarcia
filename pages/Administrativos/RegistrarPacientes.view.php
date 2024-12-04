<?php require '../partials/head.php'; ?>
<?php require '../partials/nav.php'; ?>
<style>
    /* Asegura que el body ocupe toda la altura */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      flex: 1;
    }

    /* Estilo de la tarjeta */
    .card {
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Footer al final de la página */
    footer {
      margin-top: auto;
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
    }
  </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container mt-5">
    <h2 class="text-center mb-4">Registro Básico de Paciente</h2>
    <form action="../../controllers/Admin/RegistrarPacientes.php" method="post" id="pacienteForm">
        <!-- Campos para el nombre y cédula del paciente -->
        <!-- Formulario para registrar paciente -->
<div class="form-group">
    <label for="nombre">Nombre:</label>
    <input type="text" class="form-control" id="nombre" name="nombre" required 
        pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios.">
</div>

<div class="form-group">
    <label for="cedula">Cédula:</label>
    <input type="text" class="form-control" id="cedula" name="cedula" 
        required pattern="^\d{1}-\d{3}-\d{3}$|^\d{1}-\d{3}-\d{4}$|^\d{1,2}-\d{4}-\d{4}$" 
        title="Formatos válidos: X-XXX-XXX, X-XXX-XXXX o X-XXXX-XXXX, donde X es un dígito.">
</div>

<!-- Nuevo campo para correo -->
<div class="form-group">
    <label for="correo">Correo electrónico:</label>
    <input type="email" class="form-control" id="correo" name="correo" 
        required title="Ingresa un correo electrónico válido.">
</div>

<div class="text-center">
    <input type="submit" class="btn btn-primary" value="Registrar Paciente">
</div>
</form>
</div>

<?php require '../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Permitir solo letras y espacios en el campo de nombre
        document.getElementById('nombre').addEventListener('keypress', function (e) {
            const char = String.fromCharCode(e.keyCode || e.which);
            if (!/^[a-zA-Z\s]+$/.test(char)) {
                e.preventDefault();
            }
        });

        // Permitir solo números y guiones en el campo de cédula
        document.getElementById('cedula').addEventListener('keypress', function (e) {
            const char = String.fromCharCode(e.keyCode || e.which);
            if (!/^[0-9-]+$/.test(char)) {
                e.preventDefault();
            }
        });

        // Validación adicional del correo (opcional, ya que el atributo `type=email` valida automáticamente)
        document.getElementById('correo').addEventListener('blur', function () {
            const correo = this.value.trim();
            const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (correo && !correoRegex.test(correo)) {
                alert('Por favor, ingresa un correo electrónico válido.');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['message'])): ?>
            const messageType = "<?php echo $_SESSION['message_type']; ?>";
            const message = "<?php echo $_SESSION['message']; ?>";
            Swal.fire({
                icon: messageType,
                title: messageType === 'success' ? 'Éxito' : 'Error',
                text: message,
                confirmButtonText: 'Aceptar'
            });
            <?php 
            // Destruir la sesión del mensaje después de mostrarlo
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
    });
</script>
