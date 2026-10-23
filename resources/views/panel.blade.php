<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Grupo Morami | Panel</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  </head>

  <body class="hold-transition sidebar-mini">
    <div class="wrapper">

      <!-- Barra superior -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/panel') }}" class="nav-link">Home</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        </ul>
      </nav>

      <!-- Menú lateral -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ url('/panel') }}" class="brand-link">
          <img src="{{ asset('dist/img/Icono_MORAMI.jpeg') }}" alt="GM Logo"
               class="brand-image img-circle elevation-3" style="opacity: 0.8" />
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

      <!-- Contenido -->
      <div class="content-wrapper">

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Dashboard</h1>
              </div>
            </div>
          </div>
        </section>

        <section class="content">
          <div class="container-fluid">

            {{-- Tarjetas --}}
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $totalUsuarios }}</h3>
                    <p>Usuarios Registrados</p>
                  </div>
                  <div class="icon"><i class="fas fa-users"></i></div>
                  <a href="{{ url('/usuarios') }}" class="small-box-footer">Ver más</a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $totalCotizaciones }}</h3>
                    <p>Cotizaciones Realizadas</p>
                  </div>
                  <div class="icon"><i class="fas fa-file-invoice"></i></div>
                  <a href="{{ url('/cotizacion') }}" class="small-box-footer">Ver más</a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $totalPendientes }}</h3>
                    <p>Pedidos Pendientes</p>
                  </div>
                  <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                  <a href="{{ url('/pedido') }}" class="small-box-footer">Ver más</a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $totalProductos }}</h3>
                    <p>Productos Registrados</p>
                  </div>
                  <div class="icon"><i class="fas fa-boxes"></i></div>
                  <a href="{{ url('/productosre') }}" class="small-box-footer">Ver más</a>
                </div>
              </div>
            </div>

            {{-- Gráficas --}}
            <div class="row">
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Productos en existencia por categoría</h3>
                  </div>
                  <div class="card-body">
                    @if(count($existencia) > 0)
                      <canvas id="graficaExistencia" style="min-height: 300px; height: 300px; max-height: 300px;"></canvas>
                    @else
                      <p class="text-muted text-center py-5 mb-0">No hay productos en existencia.</p>
                    @endif
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Pedidos por estatus</h3>
                  </div>
                  <div class="card-body">
                    <canvas id="graficaPedidos" style="min-height: 300px; height: 300px; max-height: 300px;"></canvas>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>
      </div>

      <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    <script>
      // Datos que manda panelController (salen de la base de datos)
      const existencia = @json($existencia);
      const estatus    = @json($estatus);

      const colores = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8',
                       '#6f42c1', '#fd7e14', '#20c997', '#6c757d', '#e83e8c'];

      // Dona: productos en existencia por categoría
      if (existencia.length > 0) {
        new Chart(document.getElementById('graficaExistencia'), {
          type: 'doughnut',
          data: {
            labels: existencia.map(e => e.categoria),
            datasets: [{
              data: existencia.map(e => e.total),
              backgroundColor: existencia.map((e, i) => colores[i % colores.length])
            }]
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: { position: 'bottom' },
            tooltips: {
              callbacks: {
                label: function (item, data) {
                  return data.labels[item.index] + ': ' + data.datasets[0].data[item.index] + ' piezas';
                }
              }
            }
          }
        });
      }

      // Barras: pedidos por estatus
      new Chart(document.getElementById('graficaPedidos'), {
        type: 'bar',
        data: {
          labels: ['Pendientes', 'En proceso', 'Entregados'],
          datasets: [{
            label: 'Pedidos',
            data: [estatus.Pendiente, estatus.Proceso, estatus.Completado],
            backgroundColor: ['#ffc107', '#17a2b8', '#28a745']
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          legend: { display: false },
          scales: { yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }] }
        }
      });
    </script>
  </body>
</html>