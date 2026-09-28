<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Grupo Morami| Registro usuarios </title>
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
        <a href='../../index3.html' class='nav-link'>Home</a>
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

  <aside class='main-sidebar sidebar-dark-primary elevation-4'>
    <a href='C:\laragon\www\Team_Proyecto_Morami\Views\panel.php' class='brand-link'>
      <img src='dist/img/Icono_MORAMI.jpeg' alt='GM Logo' class='brand-image img-circle elevation-3' style='opacity: .8'>
      <span class='brand-text font-weight-light'>Grupo Morami</span>
    </a>

    <div class='sidebar'>
      <div class='user-panel mt-3 pb-3 mb-3 d-flex'>
        <div class='image'>
          <img src='dist/img/user2-160x160.jpg' class='img-circle elevation-2' alt='User Image'>
        </div>
        <div class='info'>
          <a href='#' class='d-block'>Administrador</a>
        </div>
      </div>
  
      <nav class="mt-2"> 
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"> 
          <li class='nav-item'>
            <a href='index.php?menu=usuarios&opc=registro' class='nav-link'>
              <i class='nav-icon fas fa-users'></i>
              <p>Usuarios </p>
            </a>
          </li>
          <li class='nav-item'>
            <a href='index.php?menu=productos&opc=registro' class='nav-link active'>
              <i class='nav-icon fas fa-tachometer-alt'></i>
              <p>Productos </p>
            </a>
          </li>
          <li class='nav-item'>
            <a href='index.php?menu=inventario&opc=registro' class='nav-link'>
              <i class='nav-icon fas fa-boxes'></i>
              <p> Inventario</p>
            </a>
          </li>
          <li class='nav-item'>
            <a href='index.php?menu=cotizaciones&opc=registro' class='nav-link'>
              <i class='nav-icon fas fa-file-invoice'></i>
              <p> Cotizaciones</p>
            </a>
          </li>
          <li class='nav-item'>
            <a href='index.php?menu=pedidos&opc=registro' class='nav-link'>
              <i class='nav-icon fas fa-shopping-cart'></i>
              <p> Pedidos </p>
            </a>
          </li>
          <li class='nav-item'>
            <a href='pedidos.html' class='nav-link'>
              <i class='nav-icon fas fa-cog'></i>
              <p>Configuraciones generales</p>
            </a>
          </li>
        </ul> 
      </nav> 
    </div>
  </aside>
  
  <div class="content-wrapper"> 
    <section class="content"> 
      <div class="card"> 
        <div class="card-header"> 
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 160px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div> 
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>id</th>
                <th>Nombre </th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Usuario</th>
                <th>Contraseña</th>
              </tr>
            </thead>
            <tbody>

                @foreach($res2Usuario as $dato)
                  <tr>
                    <td>{{ $dato->id_usu_pk}}</td>
                    <td>{{ $dato->nombre}}</td>
                    <td>{{ $dato->apellidoPaterno}}</td>
                    <td>{{ $dato->apellidoMaterno}}</td>
                    <td> {{ $dato->usuario}}</td>
                    <td> {{ $dato->contrasenia}}</td>
                  </tr>
                @endforeach

            </tbody>
          </table>
        </div>
      </div> 
      
      <div style="padding: 20px;"> 
        <button style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
          Registrar Usuario
        </button>

        <button style="padding: 10px 20px; cursor: pointer;">
            <i class="fas fa-home" style="color: #FFD700; font-size: 20px;"></i>
            Inicio
        </button>
      </div>
    </section> 
  </div> 

  <aside class='control-sidebar control-sidebar-dark'></aside>
</div> <script src='plugins/jquery/jquery.min.js'></script>
<script src='plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<script src='plugins/select2/js/select2.full.min.js'></script>
<script src='plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'></script>
<script src='plugins/moment/moment.min.js'></script>
<script src='plugins/inputmask/jquery.inputmask.min.js'></script>
<script src='plugins/daterangepicker/daterangepicker.js'></script>
<script src='plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'></script>
<script src='plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'></script>
<script src='plugins/bootstrap-switch/js/bootstrap-switch.min.js'></script>
<script src='plugins/bs-stepper/js/bs-stepper.min.js'></script>
<script src='plugins/dropzone/min/dropzone.min.js'></script>
<script src='dist/js/adminlte.min.js'></script>
<script src='dist/js/demo.js'></script>

</body>
</html>