<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Inicio de Sesión | Grupo Morami</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet"
          href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet"
          href="dist/css/adminlte.min.css">

    <style>
        :root {
            --morami-primary: #054270;
            --morami-accent: #0E0570;
            --morami-accent-hover: #C0BBFC;
            --morami-surface: rgba(255, 255, 255, 0.95);
            --morami-text: #000000;
        }

        * {
            box-sizing: border-box;
        }

        body.login-page {
            position: relative;
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--morami-primary-dark) 0%, var(--morami-primary) 58%, var(--morami-accent) 140%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .morami-bg-layer {
            position: fixed;
            inset: 0;
            background-image: var(--morami-bg-image);
            background-size: cover;
            background-position: center;
            filter: blur(8px) brightness(0.65);
            transform: scale(1.06);
            z-index: 0;
            pointer-events: none;
        }

        .morami-bg-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(12, 16, 92, 0.80) 0%,
                rgba(18, 24, 143, 0.68) 60%,
                rgba(168, 216, 255, 0.32) 100%
            );
            z-index: 1;
            pointer-events: none;
        }

        .login-box {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 410px;
            padding: 16px;
            margin: 0;
        }


        .login-logo a {
            color: #ffffff;
            font-size: 1.65rem;
            letter-spacing: 0.02em;
            text-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
            text-decoration: none;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .morami-logo-img {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--morami-highlight);
            box-shadow: 0 8px 24px rgba(156, 155, 155, 0.38);
        }

        .morami-login-card {
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 18px;
            background: var(--morami-surface);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 22px 50px rgba(0, 0, 0, 0.35);
            overflow: hidden;
        }

        .morami-login-card .login-card-body {
            background: transparent;
            border-radius: 18px;
            padding: 32px 28px;
            color: var(--morami-text);
        }

        .login-box-msg {
            padding: 0 0 20px;
            font-size: 0.92rem;
            color: var(--morami-muted);
        }

        .morami-login-card .input-group .form-control {
            height: 46px;
            border-radius: 10px 0 0 10px;
            border: 1px solid #d1d5db;
            border-right: none;
            font-size: 0.92rem;
            color: var(--morami-text);
            background-color: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .morami-login-card .input-group .form-control:focus {
            border-color: var(--morami-primary);
            box-shadow: none;
        }

        .morami-login-card .input-group-text {
            border-radius: 0 10px 10px 0;
            border: 1px solid #d1d5db;
            border-left: none;
            background-color: #f9fafb;
            color: var(--morami-primary);
            padding: 0 14px;
            transition: border-color 0.2s ease, color 0.2s ease;
        }

        .morami-login-card .input-group:focus-within .input-group-text {
            border-color: var(--morami-primary);
            color: var(--morami-accent);
        }

        .morami-btn-login {
            height: 44px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--morami-primary) 0%, var(--morami-accent) 140%);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            box-shadow: 0 8px 20px rgba(12, 16, 92, 0.28);
            transition: transform 0.15s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .morami-btn-login:hover {
            color: #ffffff;
            filter: brightness(1.06);
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(12, 16, 92, 0.35);
        }

        .morami-btn-login:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 10px;
            font-size: 0.86rem;
        }
    </style>
</head>

<body class="hold-transition login-page">
<div class="morami-bg-layer"></div>
<div class="morami-bg-overlay"></div>

<div class="login-box">

    <div class="login-logo">
        <a href="{{ url('/login') }}">
            <img src="dist/img/iconoMorami.png" alt="Logo Grupo Morami" class="morami-logo-img">
            <b>Inicio de Sesión</b>
        </a>
    </div>

    <div class="card morami-login-card">
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
                    <div class="col-7"></div>

                    <div class="col-5">
                        <button
                            type="submit"
                            class="btn btn-block morami-btn-login">
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