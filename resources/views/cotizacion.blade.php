<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Grupo Morami | Cotizaciones</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('/panel') }}" class="nav-link">Inicio</a>
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
              <h1>Cotizaciones</h1>
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
              <a href="{{ route('cotizaciones.vista') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva Cotización
              </a>
            </div>

            <div class="card-body">
              <div class="mb-3">
                <form action="{{ url('/cotizacion') }}" method="get" class="form-inline">
                  <input class="form-control mr-sm-2" type="search" name="q"
                    value="{{ $busqueda ?? '' }}" placeholder="Buscar..." aria-label="Search">
                  <button class="btn btn-outline-primary" type="submit">Buscar</button>
                  @if(!empty($busqueda))
                  <a href="{{ url('/cotizacion') }}" class="btn btn-link">Ver todas</a>
                  @endif
                </form>
              </div>

              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Vendedor</th>
                      <th>Vencimiento</th>
                      <th class="text-right">Total</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($resCotizacion as $fila)
                    <tr>
                      <td>{{ $fila->id_cot_pk }}</td>
                      <td>{{ $fila->fecha_cot }}</td>
                      <td>{{ $fila->cliente_cot }}</td>
                      <td>{{ $fila->vendedor_cot }}</td>
                      <td>{{ $fila->fechaVencimiento_cot }}</td>
                      <td class="text-right">$ {{ number_format($fila->total_cot, 2) }}</td>
                      <td class="text-center text-nowrap">
                        <a href="{{ route('cotizaciones.show', $fila->id_cot_pk) }}"
                          class="btn btn-sm btn-primary" title="Editar">
                          <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('cotizaciones.destroy', $fila->id_cot_pk) }}" method="POST"
                          class="d-inline"
                          onsubmit="return confirm('¿Eliminar esta cotización?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center text-muted py-4">
                        @if(!empty($busqueda))
                        No se encontraron cotizaciones para "{{ $busqueda }}".
                        @else
                        Aún no hay cotizaciones registradas.
                        @endif
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <button onclick="history.back()" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                Regresar
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
      </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
  <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
  <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('dist/js/demo.js') }}"></script>

</body>

</html>