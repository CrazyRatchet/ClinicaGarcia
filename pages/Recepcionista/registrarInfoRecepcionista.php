<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Información de Usuario Recepcionista</title>

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
            <h1>Registrar Información de Recepcionista</h1>
            <p>Completa el siguiente formulario para registrar un nuevo recepcionista</p>
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
            <!-- Formulario para registrar la información del recepcionista -->
            <form action="../../controllers/Recepcionista/procesar_registroInfoRecepcionista.php" method="post">

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
                                $('#cedula').removeClass('is-invalid').addClass('is-valid');
                                $('#cedulaFeedback').text('');
                            } else {
                                $('#cedula').removeClass('is-valid').addClass('is-invalid');
                                $('#cedulaFeedback').text('No se ha encontrado un recepcionista registrado en el sistema con la cédula ingresada.');
                            }
                            actualizarEstadoBoton();
                        },
                        error: function () {
                            $('#cedula').removeClass('is-valid').addClass('is-invalid');
                            $('#cedulaFeedback').text('Error al verificar la cédula.');
                            actualizarEstadoBoton();
                        }
                    });
                } else {
                    $('#cedula').removeClass('is-valid is-invalid');
                    $('#cedulaFeedback').text('');
                    actualizarEstadoBoton();
                }
            }

            // Función para actualizar el estado del botón de envío
            function actualizarEstadoBoton() {
                var hayErrores = $('#cedula').hasClass('is-invalid');
                $('#submitBtn').prop('disabled', hayErrores);
            }

            // Manejo de eventos para el campo cédula
            $('#cedula').on('blur', validarCedula);
            $('#cedula').on('input', function () {
                $(this).removeClass('is-valid is-invalid');
                $('#cedulaFeedback').text('');
                actualizarEstadoBoton();
            });

            // Inicialización
            actualizarEstadoBoton();
        });
    </script>

</body>

</html>
