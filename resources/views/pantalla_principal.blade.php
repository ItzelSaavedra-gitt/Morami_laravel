<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Grupo Morami</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
      body {
        background: linear-gradient(135deg, #243B64);
        height: 100vh;
        margin: 0;
      }

      .titulo {
        background: #F8F9FA;
        color: red;
        font-weight: bold;
        font-size: 70px;
        text-align: center;
        width: 100%;
        padding: 25px 0;
        margin: 0;
      }

      .logo {
        width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      }

      .btn-login {
        background: #dcdcdc;
        border-radius: 30px;
        font-size: 20px;
        padding: 10px 20px;
        font-weight: bold;
      }

      .btn-login:hover {
        background: #c0c0c0;
      }

      .card-login {
        height: 100vh;
        display: flex;
        flex-direction: column;
      }

      .contenido {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
      }
    </style>
  </head>
  <body>
    <div class="card-login">
      <div class="titulo">GRUPO MORAMI</div>

      <div class="contenido">
        <img src="dist/img/icono_MORAMI-2.jpeg" class="logo" style="opacity: 0.9" alt="Logo" />

        <a href="login.php" class="btn btn-login"> <i class="fas fa-sign-in-alt"></i> Iniciar sesión </a>
      </div>
    </div>
  </body>
</html>
