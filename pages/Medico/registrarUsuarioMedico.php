<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta información del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario Médico</title>
    
    <!-- Enlace a la hoja de estilos principal y bibliotecas de iconos -->
    <link rel="stylesheet" href="../../css/main.min.css">
    <link rel="stylesheet" href="../../libs/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Enlace a la biblioteca de Bootstrap para funcionalidades de JavaScript -->
    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header con bienvenida -->
    <header class="bg-primario text-white text-center py-4">
        <div class="container">
            <h1>Registrar Usuario Médico</h1>
            <p>Completa el formulario para registrar un nuevo usuario médico</p>
        </div>
    </header>

    <!-- Contenedor del formulario -->
    <div class="container flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="w-100" style="max-width: 500px;">
            <!-- Formulario de registro -->
            <form action="../../controllers/Medico/procesar_registroUsuarioMedico.php" method="post">

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
                    <div class="input-group">
                        <input type="password" class="form-control" name="contrasena" id="contrasena" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">Mostrar</button>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primario w-100" id="submitBtn">Registrarse</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primario text-white text-center py-3 mt-auto">
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
    </footer>

    <script>
        $(document).ready(function() {
            // Validar la cédula con AJAX
            function validarCedula() {
                var cedula = $('#cedula').val().trim();
                if (cedula) {
                    $.ajax({
                        type: 'POST',
                        url: '../../ajax/validar_cedulaMedico.php',
                        data: { cedula: cedula },
                        dataType: 'json',
                        success: function(response) {
                            if (response.existe) {
                                $('#cedula').removeClass('is-valid').addClass('is-invalid');
                                $('#cedulaFeedback').text('Un usuario con esta cédula ya está registrado.');
                                $('#submitBtn').prop('disabled', true);
                            } else {
                                $('#cedula').removeClass('is-invalid').addClass('is-valid');
                                $('#cedulaFeedback').text('');
                                $('#submitBtn').prop('disabled', false);
                            }
                        },
                        error: function() {
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

            $('#cedula').on('blur', validarCedula);
            $('#cedula').on('input', function() {
                $(this).removeClass('is-valid is-invalid');
                $('#cedulaFeedback').text('');
                $('#submitBtn').prop('disabled', false);
            });

            $('#togglePassword').on('click', function() {
                var passwordInput = $('#contrasena');
                var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                $(this).text(type === 'password' ? 'Mostrar' : 'Ocultar');
            });

            $('form').on('submit', function(e) {
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
