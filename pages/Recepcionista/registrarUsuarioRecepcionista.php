<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario Recepcionista</title>

    <link rel="stylesheet" href="../../css/main.min.css">
    <link rel="stylesheet" href="../../libs/bootstrap-icons/font/bootstrap-icons.css">
    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header con título -->
    <header class="bg-primario text-white text-center py-4">
        
        <div class="container">
            <h1>Registrar Usuario Recepcionista</h1>
            <p>Completa el siguiente formulario para registrar un nuevo usuario recepcionista</p>
        </div>
    </header>

    <!-- Contenedor del formulario -->
    <div class="container flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="w-100" style="max-width: 500px;">
            <!-- Mostrar alertas -->
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-' . $_SESSION['mensaje']['tipo'] . ' alert-dismissible fade show mt-4" role="alert">';
                echo $_SESSION['mensaje']['texto'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
                unset($_SESSION['mensaje']); // Limpiamos el mensaje después de mostrarlo
            }
            ?>

            <br>
            <!-- Formulario para registrar el usuario recepcionista -->
            <form action="../../controllers/Recepcionista/procesar_registroUsuarioRecepcionista.php" method="post">

                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula:</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                    <div id="cedulaFeedback" class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="contrasena" id="contrasena" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primario w-100" id="submitBtn">Registrarse</button>
                </div>
            </form>
        </div>
    </div>

    <br>
    <!-- Footer -->
    <footer class="bg-primario text-white text-center py-3 mt-auto">
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
    </footer>

    <script>
        $(document).ready(function () {
            function validarCedula() {
                var cedula = $('#cedula').val().trim();
                if (cedula) {
                    $.ajax({
                        type: 'POST',
                        url: '../../ajax/validar_cedulaRecepcionista.php',
                        data: { cedula: cedula },
                        dataType: 'json',
                        success: function (response) {
                            if (response.existe) {
                                $('#cedula').removeClass('is-valid').addClass('is-invalid');
                                $('#cedulaFeedback').text('Un usuario recepcionista se encuentra registrado con la cédula ingresada. Por favor, registre uno que no esté registrado.');
                                $('#submitBtn').prop('disabled', true);
                            } else {
                                $('#cedula').removeClass('is-invalid').addClass('is-valid');
                                $('#cedulaFeedback').text('');
                                $('#submitBtn').prop('disabled', false);
                            }
                        },
                        error: function () {
                            $('#cedula').removeClass('is-valid').addClass('is-invalid');
                            $('#cedulaFeedback').text('Error al verificar la cédula.');
                            $('#submitBtn').prop('disabled', true);
                        }
                    });
                } else {
                    $('#cedula').removeClass('is-valid is-invalid');
                    $('#cedulaFeedback').text('');
                    $('#submitBtn').prop('disabled', false);
                }
            }

            $('#cedula').on('blur', function () {
                if ($(this).val().trim() !== '') {
                    validarCedula();
                } else {
                    $(this).removeClass('is-valid is-invalid');
                    $('#cedulaFeedback').text('');
                    $('#submitBtn').prop('disabled', false);
                }
            });

            $('#cedula').on('input', function () {
                $(this).removeClass('is-valid is-invalid');
                $('#cedulaFeedback').text('');
                $('#submitBtn').prop('disabled', false);
            });

            $('form').on('submit', function (e) {
                e.preventDefault();
                validarCedula();
                if (!$('#cedula').hasClass('is-invalid')) {
                    this.submit();
                }
            });
        });
    </script>

</body>

</html>
