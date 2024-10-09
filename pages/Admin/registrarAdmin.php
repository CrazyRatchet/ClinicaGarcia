<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>

    <link rel="stylesheet" href="../../css/main.min.css">
    <link rel="stylesheet" href="../../libs/bootstrap-icons/font/bootstrap-icons.css">
    <script src="../../libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<body>
    <div class="container-fluid bg-light p-5">
        <h1 class="text-center mb-4">Registrar Usuario Administrador</h1>
        <div class="row justify-content-center">
            <!--../admin/procesar_registroAdmin.php-->
            <form class="col-md-6" action="../../controllers/Admin/procesar_registroAdmin.php" method="post">

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