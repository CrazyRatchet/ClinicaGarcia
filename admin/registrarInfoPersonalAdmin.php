<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Clínica García - Registrar información de usuarios</title>

    <!-- CSS-->
    <link href="../cssAdmin/menu_principalAdmin.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body>

    <div class="container text-center mt-5">

        <a href="logoutAdmin.php" class="logout-btn" title="Cerrar sesión">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
        </a>

        <h1 class="mb-4">Bienvenido al Sistema de Gestión de Clínica García</h1>
        <div class="d-grid gap-3" style="max-width: 400px; margin: auto;">

            <div class="mb-3">
                <a href="../medico/registrarInfoMedico.php" class="btn btn-primary btn-lg w-100">Registrar información de usuario médico</a>
            </div>

            <div class="mb-3">
                <a href="../recepcionista/registrarInfoRecepcionista.php" class="btn btn-secondary btn-lg w-100">Registrar información de usuario recepcionista</a>
            </div>

        </div>
    </div>

    <footer>
        <p>&copy; 2024 Clínica García. Todos los derechos reservados.</p>
    </footer>

    <!-- JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>