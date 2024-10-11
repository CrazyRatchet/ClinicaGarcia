<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  // Ruta específica a verificar
  $ruta_especifica = '/ClinicaGarcia/pages/InicioSesion.view.php';

  // Obtener la ruta actual (sin el dominio)
  $current_path = $_SERVER['REQUEST_URI'];

  // Determinar si agregar ../ adicional en base a la ruta actual
  $prefix = ($current_path !== $ruta_especifica) ? '../../' : '../';
  ?>

  <!-- Agregar el prefijo condicionalmente -->
  <link rel="stylesheet" href="<?php echo $prefix; ?>css/main.min.css">
  <link rel="stylesheet" href="<?php echo $prefix; ?>libs/bootstrap-icons/font/bootstrap-icons.css">
  <script src="<?php echo $prefix; ?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>

  <title>Clinica García</title>
</head>

<body>
<?php
session_start();
?>