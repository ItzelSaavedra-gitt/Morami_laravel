<!DOCTYPE html>
<html lang='es'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Grupo Morami | Registro usuarios </title>
  <!-- Google Font: Source Sans Pro -->
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'>
  <!-- Font Awesome -->
  <link rel='stylesheet' href='plugins/fontawesome-free/css/all.min.css'>
  <!-- daterange picker -->
  <link rel='stylesheet' href='plugins/daterangepicker/daterangepicker.css'>
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel='stylesheet' href='plugins/icheck-bootstrap/icheck-bootstrap.min.css'>
  <!-- Bootstrap Color Picker -->
  <link rel='stylesheet' href='plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'>
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel='stylesheet' href='plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'>
  <!-- Select2 -->
  <link rel='stylesheet' href='plugins/select2/css/select2.min.css'>
  <link rel='stylesheet' href='plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'>
  <!-- Bootstrap4 Duallistbox -->
  <link rel='stylesheet' href='plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'>
  <!-- BS Stepper -->
  <link rel='stylesheet' href='plugins/bs-stepper/css/bs-stepper.min.css'>
  <!-- dropzonejs -->
  <link rel='stylesheet' href='plugins/dropzone/min/dropzone.min.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='dist/css/adminlte.min.css'>
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
              <h1>Gestión de Inventario</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label> Tipo Producto</label>
                    <select class="form-control">
                      <option>Todo</option>
                      <option>Loseta</option>
                      <option>Decorados</option>
                      <option>Pega azulejo</option>
                    </select>
                  </div>
                </div>
              </div>

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Nombre producto</th>
                    <th>Tipo producto</th>
                    <th>Color</th>
                    <th>Cantidad</th>
                    <th>Formato de medida</th>
                    <th>Unidad de medida</th>
                    <th>Fecha de caducidad</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Loseta Carrara</td>
                    <td>Porcelanato Brillante</td>
                    <td>Blanco Veteado</td>
                    <td>4</td>
                    <td>30x60</td>
                    <td>Caja</td>
                    <td>..........</td>
                  </tr>
                  <tr>
                    <td>Crest</td>
                    <td>Pega azulejo</td>
                    <td>Blanco</td>
                    <td>3</td>
                    <td>60x60</td>
                    <td>Bulto</td>
                    <td>23/04/26</td>
                  </tr>
                  <tr>
                    <td>Decorado</td>
                    <td>Marmol</td>
                    <td>Gris Grafito</td>
                    <td>2</td>
                    <td>60x1.20</td>
                    <td>Pieza</td>
                    <td>.........</td>
                  </tr>
                </tbody>
              </table>

              <div class="mt-3">
                <button onclick="history.back()" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                  Regresar
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
      </div>
      <strong>Copyright &copy; 2025-2026 <a href="#">Grupo Morami</a>.</strong> All rights reserved.
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>
  <script src='plugins/jquery/jquery.min.js'></script>
  <script src='plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
  <script src='plugins/select2/js/select2.full.min.js'></script>
  <script src='plugins/moment/moment.min.js'></script>
  <script src='dist/js/adminlte.min.js'></script>
</body>

</html>