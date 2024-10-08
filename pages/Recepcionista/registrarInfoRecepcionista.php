<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Información de Usuario Recepcionista</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../cssAdmin/registrarAdmin.css" rel="stylesheet" type="text/css">
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<body>
    <div class="container-fluid bg-light p-5">
        <h1 class="text-center mb-4">Registrar Información de Usuario Recepcionista</h1>
        <div class="row justify-content-center">
            <form class="col-md-6" action="procesar_registroInfoRecepcionista.php" method="post">

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
                    <input type="submit" value="Registrarse" class="btn btn-primary w-50" id="submitBtn">
                </div>

            </form>
        </div>
    </div>

    <footer class="text-white text-center p-3 mt-5">
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>

    </footer>

    <script>
        $(document).ready(function() {
            function validarCedula() {
                var cedula = $('#cedula').val().trim();
                if (cedula) {
                    $.ajax({
                        type: 'POST',
                        url: '../ajax/validar_cedulaRecepcionista.php',
                        data: {
                            cedula: cedula
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.existe) {
                                $('#cedula').removeClass('is-invalid').addClass('is-valid');
                                $('#cedulaFeedback').text('');
                            } else {
                                $('#cedula').removeClass('is-valid').addClass('is-invalid');
                                $('#cedulaFeedback').text('No se ha encontrado un recepcionista registrado en el sistema con la cédula ingresada.');
                            }
                            actualizarEstadoBoton();
                        },
                        error: function() {
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
                var hayErrores = $('cedula').hasClass('is-invalid');
                $('#submitBtn').prop('disabled', hayErrores);
            }

            // Manejo de eventos para el campo cédula
            $('#cedula').on('blur', validarCedula);
            $('#cedula').on('input', function() {
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