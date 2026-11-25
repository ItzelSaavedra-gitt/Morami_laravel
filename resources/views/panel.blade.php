<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Grupo Morami | Panel</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <style>
    :root {
      --morami-navy: #12188f;
      --morami-navy-dark: #0b0f5c;
      --morami-red: #c91414;
      --morami-bg: #f1f5f9;
      --morami-card-border: #e2e8f0;
    }

    .brand-link .brand-image {
      max-height: 36px;
      width: 36px;
      object-fit: cover;
      opacity: 1 !important;
    }

    .content-wrapper {
      background-color: var(--morami-bg);
    }

    .morami-welcome-title {
      font-size: 1.55rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
      letter-spacing: -0.01em;
    }

    .small-box {
      border-radius: 14px;
      border: none;
      box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
      overflow: hidden;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .small-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 30px rgba(15, 23, 42, 0.13);
    }

    .small-box .inner {
      padding: 18px 20px;
    }

    .small-box .inner h3 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .small-box .inner p {
      font-size: 0.92rem;
      font-weight: 500;
      margin-bottom: 0;
    }

    .small-box>.small-box-footer {
      background: rgba(0, 0, 0, 0.14);
      padding: 8px 12px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .card {
      border: 1px solid var(--morami-card-border);
      border-radius: 14px;
      box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
      overflow: hidden;
    }

    .card-header {
      background-color: #ffffff;
      border-bottom: 1px solid var(--morami-card-border);
      padding: 14px 20px;
    }

    .card-body {
      background-color: #ffffff;
      padding: 20px;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">

    <!-- Barra superior -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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

    <!-- Contenido -->
    <div class="content-wrapper">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="morami-welcome-title">
                Bienvenido, <span class="morami-user-highlight">{{ session('usuario_nombre', 'Administrador') }}! </span>
              </h1>
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
    const estatus = @json($estatus);

    const colores = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8',
      '#6f42c1', '#fd7e14', '#20c997', '#6c757d', '#e83e8c'
    ];

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
          legend: {
            position: 'bottom'
          },
          tooltips: {
            callbacks: {
              label: function(item, data) {
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
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              precision: 0
            }
          }]
        }
      }
    });
  </script>
</body>

</html>