<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario Médico</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../cssMedico/registrarUsuarioMedico.css" rel="stylesheet" type="text/css">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="main-content">
        <div class="container-fluid bg-light">
            <h1 class="text-center mb-4">Registrar Usuario Médico</h1>
            <div class="row justify-content-center">
                <form class="col-md-6" action="../../controllers/Medico/procesar_registroUsuarioMedico.php" method="post">
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
                        <input type="submit" value="Registrarse" class="btn btn-primary w-50" id="submitBtn">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-white text-center">
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
    </footer>

    <script>
        $(document).ready(function() {
            function validarCedula() {
                var cedula = $('#cedula').val().trim();
                if (cedula) {
                    $.ajax({
                        type: 'POST',
                        url: '../../ajax/validar_cedulaMedico.php',
                        data: {
                            cedula: cedula
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.existe) {
                                $('#cedula').removeClass('is-valid').addClass('is-invalid');
                                $('#cedulaFeedback').text('Un usuario médico se encuentra registrado con la cédula ingresada. Por favor, registre uno que no esté registrado.');
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

            $('#cedula').on('blur', function() {
                if ($(this).val().trim() !== '') {
                    validarCedula();
                } else {
                    $(this).removeClass('is-valid is-invalid');
                    $('#cedulaFeedback').text('');
                    $('#submitBtn').prop('disabled', false);
                }
            });

            $('#cedula').on('input', function() {
                $(this).removeClass('is-valid is-invalid');
                $('#cedulaFeedback').text('');
                $('#submitBtn').prop('disabled', false);
            });

            $('#cedula').on('keypress', function(e) {
                var keyCode = e.which || e.keyCode;
                if (!/[0-9-]/.test(String.fromCharCode(keyCode)) && keyCode !== 8) {
                    e.preventDefault();
                }
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
