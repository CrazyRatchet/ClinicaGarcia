<?php require 'partials/head.php'; ?>
<?php require 'partials/nav.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clinica García</title>

  <style>
    /* Asegura que el body ocupe toda la altura */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }

    /* Estilos para centrar el formulario */
    .container-form {
      display: flex;
      justify-content: center;
      align-items: center;
      flex: 1;
    }

    form {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    /* Estilos para el footer */
    footer {
      margin-top: auto;
      padding: 20px 0;
      background-color: #f8f9fa;
      text-align: center;
    }
  </style>
</head>

<body>
  <!-- Formulario centrado -->
  <div class="container-form">
    <form method="POST" action="../controllers/InicioSesion.php">
      <div class="mb-3">
        <label for="nombre_usuario" class="form-label">Usuario:</label>
        <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" required>
      </div>

      <div class="mb-3">
        <label for="contrasenia" class="form-label">Contraseña:</label>
        <div class="input-group">
          <input type="password" class="form-control" name="contrasenia" id="contrasenia" required>
          <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn btn-primario w-100">Ingresar</button>
    </form>
  </div>



  <?php require 'partials/footer.php' ?>

</body>
</html>
