<!DOCTYPE html>
<html lang='es'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Grupo Morami| Registro usuarios </title>
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
  <style>
    /* ===== Diseño de la pantalla de usuarios ===== */
    :root {
      --gm-blue: #0636a7;
      --gm-blue-dark: #052b86;
      --gm-blue-soft: #e8eefc;
      --gm-ink: #1e293b;
      --gm-muted: #64748b;
      --gm-line: #e2e8f0;
      --gm-teal: #0f766e;
      --gm-teal-soft: #e0f3f0;
    }

    .content-wrapper { background: #f4f6fb; }

    /* Tarjeta */
    .gm-card {
      border: 1px solid var(--gm-line);
      border-radius: 10px;
      box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
      overflow: hidden;
    }

    /* Encabezado de la tarjeta: título a la izquierda, buscador a la derecha */
    .gm-card-header {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 10px 16px;
      padding: 16px 20px;
      background: #fff;
      border-bottom: 1px solid var(--gm-line);
    }
    .gm-card-header .card-title {
      float: none;
      margin: 0;
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--gm-ink);
    }
    .gm-card-header .card-title i { color: var(--gm-blue); margin-right: 8px; }
    .gm-card-header .card-tools { float: none; margin: 0; }

    /* Buscador */
    .gm-search .form-control {
      height: 38px;
      border: 1px solid var(--gm-line);
      border-radius: 8px 0 0 8px;
      color: var(--gm-ink);
    }
    .gm-search .form-control:focus {
      border-color: var(--gm-blue);
      box-shadow: 0 0 0 3px rgba(6, 54, 167, 0.15);
    }
    .gm-search .btn {
      height: 38px;
      border: 1px solid var(--gm-line);
      border-left: 0;
      border-radius: 0 8px 8px 0;
      background: #fff;
      color: var(--gm-blue);
    }
    .gm-search .btn:hover { background: var(--gm-blue); color: #fff; }

    /* Tabla */
    .gm-table { margin: 0; }
    .gm-table thead th {
      padding: 12px 20px;
      border-top: 0;
      border-bottom: 1px solid var(--gm-line);
      background: #f8fafc;
      color: var(--gm-muted);
      font-size: .85rem;
      font-weight: 600;
    }
    .gm-table tbody td {
      padding: 12px 20px;
      vertical-align: middle;
      border-top: 1px solid #eef2f7;
      color: var(--gm-ink);
    }
    .gm-table tbody tr:first-child td { border-top: 0; }
    .gm-table.table-hover tbody tr:hover { background: #f8faff; }
    .gm-muted { color: var(--gm-muted); }

    /* Nombre con avatar de iniciales */
    .gm-person { display: flex; align-items: center; gap: 12px; font-weight: 600; }
    .gm-avatar {
      flex: 0 0 36px;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      background: var(--gm-blue-soft);
      color: var(--gm-blue);
      font-size: .85rem;
      font-weight: 700;
    }

    /* Rol como etiqueta */
    .gm-badge {
      display: inline-block;
      padding: 3px 12px;
      border-radius: 999px;
      font-size: .82rem;
      font-weight: 600;
    }
    .gm-badge-admin  { background: var(--gm-blue-soft); color: var(--gm-blue); }
    .gm-badge-asesor { background: var(--gm-teal-soft); color: var(--gm-teal); }

    /* Botones de acción de cada fila */
    .gm-btn { border-radius: 8px; font-weight: 600; }
    .btn-outline-primary.gm-btn { color: var(--gm-blue); border-color: #c7d4f3; }
    .btn-outline-primary.gm-btn:hover { background: var(--gm-blue); border-color: var(--gm-blue); color: #fff; }
    .btn-outline-danger.gm-btn { color: #b42318; border-color: #f1c7c3; }
    .btn-outline-danger.gm-btn:hover { background: #b42318; border-color: #b42318; color: #fff; }

    /* Lista vacía */
    .gm-empty { padding: 44px 20px !important; }
    .gm-empty i { display: block; margin-bottom: 10px; font-size: 1.8rem; color: var(--gm-blue); opacity: .7; }

    /* Pie de la tarjeta */
    .gm-card-footer {
      padding: 12px 20px;
      background: #f8fafc;
      border-top: 1px solid var(--gm-line);
      color: var(--gm-muted);
      font-size: .88rem;
    }

    /* Pestañas por rol */
    .gm-tabs {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      padding: 10px 20px;
      background: #fff;
      border-bottom: 1px solid var(--gm-line);
    }
    .gm-tab {
      padding: 6px 14px;
      border-radius: 999px;
      color: var(--gm-muted);
      font-size: .88rem;
      font-weight: 600;
    }
    .gm-tab span {
      margin-left: 6px;
      padding: 1px 8px;
      border-radius: 999px;
      background: #eef1f5;
      font-size: .78rem;
    }
    .gm-tab:hover { background: #f1f5f9; color: var(--gm-ink); text-decoration: none; }
    .gm-tab.active { background: var(--gm-blue-soft); color: var(--gm-blue); }
    .gm-tab.active span { background: #fff; }

    /* Barra superior: botones de acción a la izquierda */
    .gm-topbar {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: flex-start;
      gap: 10px 16px;
      margin-bottom: 16px;
    }
    .gm-actions { display: flex; flex-wrap: wrap; gap: 8px; }
    .gm-topbar .btn { border-radius: 8px; font-weight: 600; padding: 8px 18px; }
    .gm-btn-primary { background: var(--gm-blue); border-color: var(--gm-blue); color: #fff; }
    .gm-btn-primary:hover { background: var(--gm-blue-dark); border-color: var(--gm-blue-dark); color: #fff; }
  </style>
</head>

<body class='hold-transition sidebar-mini'>
  <div class='wrapper'>

    <nav class='main-header navbar navbar-expand navbar-white navbar-light'>
      <ul class='navbar-nav'>
        <li class='nav-item'>
          <a class='nav-link' data-widget='pushmenu' href='#' role='button'><i class='fas fa-bars'></i></a>
        </li>
        <li class='nav-item d-none d-sm-inline-block'>
          <a href="{{ url('/panel') }}" class='nav-link'>Inicio</a>
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
        box-shadow: 0 2px 6px rgba(18, 24, 143, 0.15);/*Sombra del logo*/
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
      <section class="content">
        <div class="container-fluid pt-3 pb-4">

          @php
            // Por defecto solo se listan los asesores de ventas (rol 2)
            $rolFiltro = request('rol', '2');
            if (!in_array($rolFiltro, ['1', '2', 'todos'], true)) { $rolFiltro = '2'; }
            $lista      = $rolFiltro === 'todos' ? $res2Usuario : $res2Usuario->where('id_rol', (int) $rolFiltro);
            $nAsesores  = $res2Usuario->where('id_rol', 2)->count();
            $nAdmins    = $res2Usuario->where('id_rol', 1)->count();
            $nTodos     = $res2Usuario->count();
            $rutaBase   = !empty($busqueda) ? 'usuarios.search' : 'usuarios.index';
          @endphp

          {{-- Mensajes que manda el controlador --}}
          @if(session('ok'))
          <div class="alert alert-success">{{ session('ok') }}</div>
          @endif
          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          {{-- Barra superior: acciones --}}
          <div class="gm-topbar">
            <div class="gm-actions">
              <a href="{{ route('usuarios.vista') }}" class="btn gm-btn-primary">
                <i class="fas fa-user-plus"></i> Registrar usuario
              </a>
              <a href="{{ route('usuarios.descontinuados') }}" class="btn btn-outline-secondary">
                <i class="fas fa-archive"></i> Usuarios inactivos
              </a>
            </div>
          </div>

          <div class="card gm-card">
            <div class="card-header gm-card-header">
              <h1 class="card-title"><i class="fas fa-users"></i>Usuarios registrados</h1>
              <form action="{{ route('usuarios.search') }}" method="GET" class="card-tools gm-search">
                <div class="input-group" style="width: 300px; max-width: 100%;">
                  <input type="text" name="q" value="{{ $busqueda ?? '' }}"
                    class="form-control" placeholder="Buscar por nombre o usuario">
                  <input type="hidden" name="rol" value="{{ $rolFiltro }}">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>

            <div class="gm-tabs">
              <a href="{{ route($rutaBase, array_filter(['q' => $busqueda ?? null, 'rol' => '2'])) }}"
                class="gm-tab {{ $rolFiltro === '2' ? 'active' : '' }}">Asesores de ventas <span>{{ $nAsesores }}</span></a>
              <a href="{{ route($rutaBase, array_filter(['q' => $busqueda ?? null, 'rol' => '1'])) }}"
                class="gm-tab {{ $rolFiltro === '1' ? 'active' : '' }}">Administradores <span>{{ $nAdmins }}</span></a>
              <a href="{{ route($rutaBase, array_filter(['q' => $busqueda ?? null, 'rol' => 'todos'])) }}"
                class="gm-tab {{ $rolFiltro === 'todos' ? 'active' : '' }}">Todos <span>{{ $nTodos }}</span></a>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap gm-table">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th style="width: 180px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($lista as $dato)
                  <tr>
                    <td>
                      <div class="gm-person">
                        <span class="gm-avatar">{{ mb_strtoupper(mb_substr((string) $dato->nombre, 0, 1)) }}{{ mb_strtoupper(mb_substr((string) $dato->apellidoPaterno, 0, 1)) }}</span>
                        {{ $dato->nombre }}
                      </div>
                    </td>
                    <td>{{ $dato->apellidoPaterno }}</td>
                    <td>{{ $dato->apellidoMaterno }}</td>
                    <td class="gm-muted">{{ $dato->usuario }}</td>
                    <td>
                      <span class="gm-badge {{ $dato->id_rol == 1 ? 'gm-badge-admin' : 'gm-badge-asesor' }}">
                        {{ $dato->id_rol == 1 ? 'Administrador' : 'Asesor de ventas' }}
                      </span>
                    </td>
                    <td>
                      <a href="{{ route('usuarios.show', $dato->id_usu_pk) }}"
                        class="btn btn-sm btn-outline-primary gm-btn">
                        <i class="fas fa-edit"></i> Editar
                      </a>
                      <form action="{{ route('usuarios.destroy', $dato->id_usu_pk) }}" method="POST"
                        class="d-inline form-baja" data-usuario="{{ $dato->usuario }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger gm-btn">
                          <i class="fas fa-user-slash"></i> Dar de baja
                        </button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted gm-empty">
                      <i class="fas fa-users"></i>
                      @if(!empty($busqueda))
                      No se encontraron usuarios para "{{ $busqueda }}" en esta pestaña.
                      <a href="{{ route('usuarios.index', ['rol' => 'todos']) }}">Ver todos</a>
                      @else
                      No hay usuarios en esta pestaña.
                      @endif
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="card-footer gm-card-footer">
              {{ $lista->count() }} {{ $lista->count() == 1 ? 'usuario' : 'usuarios' }} en esta lista
            </div>
          </div>

        </div>
      </section>
    </div>

    <aside class='control-sidebar control-sidebar-dark'></aside>
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
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script>
    // Confirmación para dar de baja
    document.querySelectorAll('.form-baja').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: '¿Seguro que quieres dar de baja a este usuario?',
          text: 'Usuario: ' + form.dataset.usuario,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí',
          cancelButtonText: 'No',
          confirmButtonColor: '#dc3545',
          reverseButtons: true
        }).then(function (r) { if (r.isConfirmed) form.submit(); });
      });
    });
  </script>

</body>

</html>