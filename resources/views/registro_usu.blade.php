@php $usuario = $usuario ?? null; @endphp
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Grupo Morami| Registro usuarios</title>

  <!-- Google Font: Source Sans Pro -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" />
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" />
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" />
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}" />
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}" />
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}" />
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('/panel') }}" class="nav-link">Inicio</a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <style>
      .main-header.navbar {
        min-height: 56px;
        height: 56px;
        box-sizing: border-box;
      }

      .main-sidebar .brand-link {
        min-height: 56px;
        height: 56px;
        box-sizing: border-box;
      }

      .gm-aside-shell {
        border-right: 1px solid #e2e8f0;
        box-shadow: 4px 0 20px rgba(15, 23, 42, 0.04);
      }

      .gm-brand-header {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .gm-brand-logo {
        width: 36px;
        height: 36px;
        margin-top: 0;
        margin-right: 0;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(18, 24, 143, 0.15);
        /*Sombra del logo*/
        opacity: 2;
      }

      .gm-brand-title {
        font-size: 1rem;
        font-weight: 700;
        color: #0636a7;
        letter-spacing: -0.01em;
      }
    </style>

    <!-- Menú lateral -->
    <aside class="main-sidebar sidebar-light-primary gm-aside-shell">
      <a class="brand-link gm-brand-header">
        <img src="{{ asset('dist/img/iconoMorami.png') }}" alt="GM Logo"
          class="brand-image gm-brand-logo" />
        <span class="brand-text gm-brand-title">Grupo Morami</span>
      </a>

      <div class="sidebar gm-aside-body">
        @include('MenuLateralView')
      </div>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{ $usuario ? 'Editar usuario' : 'Registrar usuario' }}</h1>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          {{-- Un solo formulario para crear y editar --}}
          <form method="POST"
            action="{{ $usuario ? route('usuarios.update', $usuario->id_usu_pk) : route('usuarios.store') }}">
            @csrf
            @if($usuario)
            @method('PUT')
            @endif

            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" id="nombre" class="form-control" name="nombre"
                        value="{{ old('nombre', $usuario->nombre ?? '') }}"
                        placeholder="Ingresa el nombre" required>
                    </div>
                    <div class="form-group">
                      <label for="apellido_paterno">Apellido Paterno</label>
                      <input type="text" id="apellido_paterno" class="form-control" name="apellido_paterno"
                        value="{{ old('apellido_paterno', $usuario->apellidoPaterno ?? '') }}"
                        placeholder="Ingresa el apellido paterno" required>
                    </div>
                    <div class="form-group">
                      <label for="apellido_materno">Apellido Materno</label>
                      <input type="text" id="apellido_materno" class="form-control" name="apellido_materno"
                        value="{{ old('apellido_materno', $usuario->apellidoMaterno ?? '') }}"
                        placeholder="Ingresa el apellido materno">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="usuario">Nombre de usuario</label>
                      <input type="text" id="usuario" class="form-control" name="usuario"
                        value="{{ old('usuario', $usuario->usuario ?? '') }}"
                        placeholder="Ingresa el usuario" required>
                    </div>
                    <div class="form-group">
                      <label for="password">Contraseña</label>
                      <input type="password" id="password" class="form-control" name="password"
                        placeholder=""
                        {{ $usuario ? '' : 'required' }}>
                    </div>
                    <div class="form-group">
                      <label for="id_rol">Rol</label>
                      <select id="id_rol" name="id_rol" class="form-control" required>
                        <option value="">Seleccione un rol</option>
                        <option value="1" {{ old('id_rol', $usuario->id_rol ?? '') == 1 ? 'selected' : '' }}>Administrador</option>
                        <option value="2" {{ old('id_rol', $usuario->id_rol ?? '') == 2 ? 'selected' : '' }}>Asesor de ventas</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-success">
                  <i class="fas fa-save"></i> {{ $usuario ? 'Guardar cambios' : 'Registrar usuario' }}
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-default">Cancelar</a>
              </div>
            </div>
          </form>

        </div>
      </section>
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
  <!-- InputMask -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <!-- date-range-picker -->
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- bootstrap color picker -->
  <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <!-- Bootstrap Switch -->
  <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
  <!-- BS-Stepper -->
  <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
  <!-- dropzonejs -->
  <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>
</body>

</html>