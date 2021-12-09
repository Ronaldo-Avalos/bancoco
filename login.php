<?php include 'lib_php/conection.php';?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Acceso</title>
    <link rel="stylesheet" href="css/style_login.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
  </head>
  <body>
    


   <!-- FALTA AGREGAR CAPTCHA DE AUTENTIFICACION DE USUARIO-->



    <!-- Nav -->
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand logo-image" href="../index.php"><img src="images/logo.svg" alt="alternative"></a> 

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php #contacto">Tengo un problema</a>
                    </li>
                </ul>
                <span class="nav-item">
                    <a  class="btn-solid-sm" href="index.php">Regresar</a>
                </span>
            </div> 
        </div>
    </nav> <!--Fin de Nav -->
    <div class="center">
      <h1>Inicia Sesión</h1>
      <form action="lib_php/auth_user.php" method="post">
        <div class="txt_field">
          <input type="text" name="usuario" autocomplete="off" required>
          <span></span>
          <label>Usuario</label>
        </div>
        <div class="txt_field">
          <input type="password" name="contrasena" required>
          <span></span>
          <label>Contraseña</label>
        </div>

        <input type="submit" value="Entrar" class="btn-solid-sm">

        <div class="signup_link">
          No tienes cuenta? <a href="index.php">Registrate</a>
        </div>
      </form>
    </div>

  </body>
</html>
