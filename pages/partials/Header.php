<header>
    <!--Barra de navegación-->
    <nav class="navbar bg-primario fixed-top">

      <div class="container-fluid">
        <a class="navbar-brand text-light" href="index.php">
          <!--Logo-->
          <img src="assets/logo.png" alt="Clínica García" width="60" height="60">
          <!--Nombre-->
          Clínica García</a>

        <!--Botón de nav-->
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end bg-gris" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

          <!--Header de Nav-->
          <div class="offcanvas-header">
            <h5 class="offcanvas-title text-primario" id="offcanvasNavbarLabel">Apartados</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body">

            <!--Inicio-->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active text-on" aria-current="page" href="index.php">Inicio</a>
              </li>

              <!--Gestión de Personal-->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-on" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Gestión de Personal
                </a>

                <!--Registrar Personal-->
                <ul class="dropdown-menu bg-light">
                  <li><a class="dropdown-item text-on" href="#">Registrar Personal</a></li>

                  <li>
                    <hr class="dropdown-divider">
                  </li>

                  <!--Asignar permisos-->
                  <li><a class="dropdown-item text-on" href="#">Asignar permisos</a></li>

                  <li>
                    <hr class="dropdown-divider">
                  </li>

                  <!--Gestionar datos del personal-->
                  <li><a class="dropdown-item text-on" href="#">Gestionar datos del personal</a></li>

                </ul>
              </li>

              <!--Gesrtionar horarios y turnos-->
              <li class="nav-item">
                <a class="nav-link active text-on" aria-current="page" href="#">Gestionar horarios y turnos</a>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>