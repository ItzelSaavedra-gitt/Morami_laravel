<!DOCTYPE html>
<html lang='es'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Grupo Morami| Pedidos</title>
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
          <a href='{{ url("/panel") }}' class='nav-link'>Home</a>
        </li>
      </ul>

      <ul class='navbar-nav ml-auto'>
        <li class='nav-item dropdown'>
          <a class='nav-link' data-toggle='dropdown' href='#'>
            <i class='far fa-bell'></i>
            <span class='badge badge-warning navbar-badge'>3</span>
          </a>
          <div class='dropdown-menu dropdown-menu-lg dropdown-menu-right'>
            <span class='dropdown-item dropdown-header'>3 Notificaciones</span>
            <div class='dropdown-divider'></div>
            <a href='#' class='dropdown-item'>
              <i class='fas fa-box mr-2'></i> Tienes productos en bajo stock
              <span class='float-right text-muted text-sm'>3 mins</span>
            </a>
            <div class='dropdown-divider'></div>
            <a href='#' class='dropdown-item'>
              <i class='fas fa-users mr-2'></i> 3 pedidos pendientes
              <span class='float-right text-muted text-sm'>12 hours</span>
            </a>
            <div class='dropdown-divider'></div>
            <a href='#' class='dropdown-item'>
              <i class='fas fa-file mr-2'></i> Haz registrado nuevos productos
              <span class='float-right text-muted text-sm'>2 days</span>
            </a>
            <div class='dropdown-divider'></div>
            <a href='#' class='dropdown-item dropdown-footer'>Ver todas las Notificationes</a>
          </div>
        </li>
        <li class='nav-item'>
          <a class='nav-link' data-widget='fullscreen' href='#' role='button'>
            <i class='fas fa-expand-arrows-alt'></i>
          </a>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="{{ url('/panel') }}" class="brand-link">
        <img
          src="{{ asset('dist/img/Icono_MORAMI.jpeg') }}"
          alt="GM Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Grupo Morami</span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" />
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ session('usuario_nombre', 'Administrador') }}</a>
          </div>
        </div>

        @include('MenuLateralView')

      </div>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Pedidos</h1>
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
            <div class="card-body">

              <a href="{{ route('pedidos.vista') }}" class="btn btn-success mb-4">
                <i class="fas fa-plus"></i> Registrar nuevo pedido
              </a>

              <form action="{{ route('pedidos.search') }}" method="GET" id="formFiltros">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Filtrar por fecha de solicitud</label>
                      <select class="form-control" name="fecha" onchange="document.getElementById('formFiltros').submit()">
                        <option value="">Todo</option>
                        @foreach($fechas as $f)
                        <option value="{{ $f }}" {{ ($filtroFecha ?? '') == $f ? 'selected' : '' }}>{{ date('d/m/y', strtotime($f)) }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Filtrar por estatus</label>
                      <select class="form-control" name="estatus" onchange="document.getElementById('formFiltros').submit()">
                        <option value="">Todo</option>
                        <option value="Pendiente" {{ ($filtroEstatus ?? '') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Entregado" {{ ($filtroEstatus ?? '') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                      </select>
                    </div>
                  </div>
                </div>
              </form>

              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Cliente</th>
                      <th>Fecha de solicitud</th>
                      <th>Total</th>
                      <th>Estatus</th>
                      <th>Detalle</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($resPedido as $dato)
                    <tr>
                      <td>{{ trim($dato->nombreCliente_ped . ' ' . $dato->apellidoP_ped . ' ' . $dato->apellidoM_ped) }}</td>
                      <td>{{ date('d/m/y', strtotime($dato->fecha_ped)) }}</td>
                      <td>${{ number_format((float) $dato->total_ped, 2) }}</td>
                      <td>
                        @if($dato->estatus_ped == 'Entregado')
                        <span class="badge badge-success">Entregado</span>
                        @elseif($dato->estatus_ped == 'Pendiente')
                        <span class="badge badge-warning">Pendiente</span>
                        @else
                        <span class="badge badge-secondary">{{ $dato->estatus_ped }}</span>
                        @endif
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning btn-sm btn-detalle"
                          data-id="{{ $dato->id_ped_pk }}" data-toggle="modal" data-target="#modalDetalle">
                          Mostrar detalles
                        </button>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center text-muted py-4">
                        No hay pedidos para mostrar.
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

            </div>
          </div>

          <div class="pb-4">
            <a href="{{ url('/panel') }}" class="btn btn-default">
              <i class="fas fa-home" style="color: #FFD700;"></i> Inicio
            </a>
          </div>

        </div>
      </section>
    </div>

    <!-- Ventana "Mostrar detalles" -->
    <div class="modal fade" id="modalDetalle" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Detalle del pedido</h4>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body" id="detalleCuerpo">Cargando...</div>
          <div class="modal-footer justify-content-between">
            <form method="POST" id="formEliminar" onsubmit="return confirm('¿Eliminar este pedido y sus productos?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</button>
            </form>
            <div>
              <a href="#" id="btnEditar" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
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

  <script>
    // Direcciones base; __ID__ se reemplaza por el id del pedido
    var urlDetalle = "{{ route('pedidos.edit', '__ID__') }}";
    var urlEditar = "{{ route('pedidos.show', '__ID__') }}";
    var urlEliminar = "{{ route('pedidos.destroy', '__ID__') }}";

    function esc(t) {
      return String(t === null || t === undefined ? '' : t)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function dinero(n) {
      return '$' + Number(n || 0).toLocaleString('es-MX', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }

    function fecha(f) {
      if (!f) {
        return '-';
      }
      var p = String(f).substring(0, 10).split('-');
      return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : f;
    }

    $(document).on('click', '.btn-detalle', function() {
      var id = $(this).data('id');
      $('#detalleCuerpo').text('Cargando...');
      $('#btnEditar').attr('href', urlEditar.replace('__ID__', id));
      $('#formEliminar').attr('action', urlEliminar.replace('__ID__', id));

      fetch(urlDetalle.replace('__ID__', id), {
          headers: {
            'Accept': 'application/json'
          }
        })
        .then(function(r) {
          return r.json();
        })
        .then(function(d) {
          var p = d.pedido,
            filas = '',
            subtotal = 0;
          if (!p) {
            $('#detalleCuerpo').text('No se encontró el pedido.');
            return;
          }

          (d.detalles || []).forEach(function(x, i) {
            subtotal += Number(x.subtotal_det || 0);
            filas += '<tr><td>' + (i + 1) + '</td><td>' + esc(x.nombreProducto_det) + '</td><td>' + esc(x.tipo_det) +
              '</td><td>' + esc(x.unidadMedida_det) + '</td><td>' + esc(x.cantidad_det) +
              '</td><td>' + dinero(x.precioUnitario_det) + '</td><td>' + dinero(x.subtotal_det) + '</td></tr>';
          });
          if (filas === '') {
            filas = '<tr><td colspan="7" class="text-center text-muted">Sin productos registrados</td></tr>';
          }

          var cliente = [p.nombreCliente_ped, p.apellidoP_ped, p.apellidoM_ped].filter(Boolean).join(' ');
          $('#detalleCuerpo').html(
            '<div class="row mb-3">' +
            '<div class="col-md-6"><b>Cliente:</b> ' + esc(cliente) + '<br><b>Teléfono:</b> ' + esc(p.telefono_ped) +
            '<br><b>Dirección:</b> ' + esc(p.direccion_ped) + ', ' + esc(p.municipio_ped) + '</div>' +
            '<div class="col-md-6"><b>Vendedor:</b> ' + esc(p.vendedor_ped) + '<br><b>Fecha de solicitud:</b> ' + fecha(p.fecha_ped) +
            '<br><b>Fecha de entrega:</b> ' + fecha(p.fechaEntrega_ped) + '<br><b>Estatus:</b> ' + esc(p.estatus_ped) + '</div>' +
            '</div>' +
            '<div class="table-responsive"><table class="table table-sm table-striped"><thead><tr>' +
            '<th>No</th><th>Producto</th><th>Tipo</th><th>Unidad</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th>' +
            '</tr></thead><tbody>' + filas + '</tbody></table></div>' +
            '<table class="table table-sm w-50 ml-auto">' +
            '<tr><th>Subtotal:</th><td class="text-right">' + dinero(subtotal) + '</td></tr>' +
            '<tr><th>Fletes:</th><td class="text-right">' + dinero(p.fletes_ped) + '</td></tr>' +
            '<tr><th>Total:</th><td class="text-right"><b>' + dinero(p.total_ped) + '</b></td></tr>' +
            '</table>'
          );
        })
        .catch(function() {
          $('#detalleCuerpo').text('No se pudo cargar el detalle.');
        });
    });
  </script>
</body>

</html>