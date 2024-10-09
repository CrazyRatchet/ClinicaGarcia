<?php
session_start(); // Siempre debe ir al principio del archivo
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>

    <link rel="stylesheet" href="../../css/main.min.css">
    <link rel="stylesheet" href="../../libs/bootstrap-icons/font/bootstrap-icons.css">
    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header con bienvenida -->
    <header class="bg-primario text-white text-center py-4">
        <div class="container">
            <h1>Registro de Administrador</h1>
            <p>Completa el siguiente formulario para registrar un nuevo administrador</p>
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
            <form action="../../controllers/Admin/procesar_registroAdmin.php" method="post">

                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula:</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                    <div id="cedulaFeedback" class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
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
        $(document).ready(function() {
            // Validar solo letras y espacios en nombre y apellido
            $('#nombre, #apellido').on('keypress', function(e) {
                var charCode = e.which ? e.which : e.keyCode;
                if (!(charCode >= 65 && charCode <= 90) && !(charCode >= 97 && charCode <= 122) && charCode !== 32) {
                    e.preventDefault();
                }
            });

            // Validar solo números y letras en el campo de teléfono
            $('#telefono').on('keypress', function(e) {
                var charCode = e.which ? e.which : e.keyCode;
                if (!(charCode >= 48 && charCode <= 57) && !(charCode >= 65 && charCode <= 90) && !(charCode >= 97 && charCode <= 122)) {
                    e.preventDefault();
                }
            });

            // Validación de cédula
            function validarCedula() {
                var cedula = $('#cedula').val().trim();
                if (cedula) {
                    $.ajax({
                        type: 'POST',
                        url: '../../ajax/validar_cedulaAdmin.php',
                        data: {
                            cedula: cedula
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.existe) {
                                $('#cedula').removeClass('is-valid').addClass('is-invalid');
                                $('#cedulaFeedback').text('Un usuario administrador se encuentra registrado con la cédula ingresada. Por favor, registre uno que no esté registrado.');
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
