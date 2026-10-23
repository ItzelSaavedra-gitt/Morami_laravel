<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Inicio de Sesión</title>

    <link rel="stylesheet"
          href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet"
          href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet"
          href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo">
        <a href="{{ url('/login') }}">
            <b>Inicio de Sesión</b> 
        </a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">

            <p class="login-box-msg">
                Ingresa tus credenciales para acceder
            </p>

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Revisa que hayas escrito el usuario
                    y la contraseña.
                </div>
            @endif

            <form action="{{ route('login.autenticar') }}"
                  method="POST">

                @csrf

                <div class="input-group mb-3">
                    <input
                        type="text"
                        name="usuario"
                        class="form-control"
                        placeholder="Nombre de usuario"
                        value="{{ old('usuario') }}"
                        required
                        autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="contrasenia"
                        class="form-control"
                        placeholder="Contraseña"
                        required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8"></div>

                    <div class="col-4">
                        <button
                            type="submit"
                            class="btn btn-block"
                            style="background-color: #4CAF50;
                                   color: white;">
                            Acceder
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>