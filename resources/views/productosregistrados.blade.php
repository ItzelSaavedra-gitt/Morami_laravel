<!DOCTYPE html>
<html lang='es'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Grupo Morami| Productos registrados </title>
  <!-- Google Font: Source Sans Pro -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'>
  <link rel='stylesheet' href='{{ asset('plugins/fontawesome-free/css/all.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/daterangepicker/daterangepicker.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/select2/css/select2.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}'>
  <link rel='stylesheet' href='{{ asset('plugins/dropzone/min/dropzone.min.css') }}'>
  <!-- Theme style -->
  <link rel='stylesheet' href='{{ asset('dist/css/adminlte.min.css') }}'>
</head>

<body class='hold-transition sidebar-mini'>
  <div class='wrapper'>
    <nav class='main-header navbar navbar-expand navbar-white navbar-light'>
      <ul class='navbar-nav'>
        <li class='nav-item'>
          <a class='nav-link' data-widget='pushmenu' href='#' role='button'><i class='fas fa-bars'></i></a>
        </li>
        <li class='nav-item d-none d-sm-inline-block'>
          <a href='{{ url("/panel") }}' class='nav-link'>Inicio</a>
        </li>
      </ul>
    </nav>

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

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{ !empty($descontinuados) ? 'Productos Descontinuados' : 'Productos Registrados' }}</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">

          {{-- Mensajes que manda el controlador --}}
          @if(session('ok'))
          <div class="alert alert-success">{{ session('ok') }}</div>
          @endif
          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          <div class="card">
            <div class="card-header">
              <a href="{{ route('productos.vista') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Registrar Producto
              </a>

              @if(!empty($descontinuados))
              <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Ver activos
              </a>
              @else
              <a href="{{ route('productos.descontinuados') }}" class="btn btn-secondary">
                <i class="fas fa-archive"></i> Ver descontinuados
              </a>
              @endif

              <a href="{{ route('productos.pdf') }}" target="_blank" class="btn btn-danger float-right">
                Generar PDF
              </a>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-striped text-nowrap">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Color</th>
                    <th>Tipo</th>
                    <th>Formato</th>
                    <th>Piezas</th>
                    <th>Unidad de Medida</th>
                    <th>Fecha de caducidad</th>
                    <th>Precio Unitario</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($resProducto as $dato)
                  <tr>
                    <td>{{ $dato->nombre_pro }}</td>
                    <td>{{ $dato->color_pro }}</td>
                    <td>{{ $dato->tipo_pro }}</td>
                    <td>{{ $dato->formato_pro }}</td>
                    <td>{{ $dato->CantidadPiezas_pro }}</td>
                    <td>{{ $dato->unidadMedida }}</td>
                    <td>{{ $dato->fechaCaducidad }}</td>
                    <td>${{ number_format((float) $dato->precioUnitario_pro, 2) }}</td>
                    <td>
                      <a href="{{ route('productos.show', $dato->id_pro_pk) }}"
                        class="btn btn-sm btn-primary" title="Editar">
                        <i class="fas fa-edit"></i>
                      </a>

                      @if(!empty($descontinuados))
                      <form action="{{ route('productos.reactivar', $dato->id_pro_pk) }}" method="POST"
                        class="d-inline"
                        onsubmit="return confirm('¿Reactivar este producto?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success" title="Reactivar">
                          <i class="fas fa-undo"></i>
                        </button>
                      </form>
                      @else
                      <form action="{{ route('productos.destroy', $dato->id_pro_pk) }}" method="POST"
                        class="d-inline"
                        onsubmit="return confirm('¿Enviar este producto a descontinuados?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Descontinuar">
                          <i class="fas fa-archive"></i>
                        </button>
                      </form>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                      @if(!empty($descontinuados))
                      No hay productos descontinuados.
                      @else
                      Aún no hay productos. Usa "Registrar Producto" para agregar el primero.
                      @endif
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <div class="card-footer"></div>
          </div>

        </div>
      </section>
    </div>

    <aside class='control-sidebar control-sidebar-dark'></aside>
  </div>
  <script src='{{ asset('plugins/jquery/jquery.min.js') }}'></script>
  <script src='{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}'></script>
  <script src='{{ asset('plugins/select2/js/select2.full.min.js') }}'></script>
  <script src='{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}'></script>
  <script src='{{ asset('plugins/moment/moment.min.js') }}'></script>
  <script src='{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}'></script>
  <script src='{{ asset('plugins/daterangepicker/daterangepicker.js') }}'></script>
  <script src='{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}'></script>
  <script src='{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}'></script>
  <script src='{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}'></script>
  <script src='{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}'></script>
  <script src='{{ asset('plugins/dropzone/min/dropzone.min.js') }}'></script>
  <script src='{{ asset('dist/js/adminlte.min.js') }}'></script>
  <script src='{{ asset('dist/js/demo.js') }}'></script>

</body>

</html>