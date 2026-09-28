<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grupo Morami| Registro de cotizaciones </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
                    <a href="../../index3.html" class="nav-link">Home</a>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">3 Notificaciones</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-box mr-2"></i> Tienes productos en bajo stock
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 3 pedidos pendientes
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> Haz registrado nuevos productos
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Ver todas las Notificationes</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
          <img
            src="dist/img/Icono_MORAMI.jpeg"
            alt="GM Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: 0.8" />
          <span class="brand-text font-weight-light">Grupo Morami</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
              <a href="#" class="d-block">Administrador</a>
            </div>
          </div>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="index.php?menu=usuarios&opc=registro" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuarios</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?menu=productos&opc=registro" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Productos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?menu=inventario&opc=registro" class="nav-link">
                <i class="nav-icon fas fa-boxes"></i>
                <p>Inventario</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?menu=cotizaciones&opc=registro" class="nav-link">
                <i class="nav-icon fas fa-file-invoice"></i>
                <p>Cotizaciones</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?menu=pedidos&opc=registro" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>Pedidos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pedidos.html" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Configuraciones generales</p>
              </a>
            </li>
          </ul>

          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
    </div>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Registro de nuevas cotizaciones</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Registro de nuevas cotizaciones</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- CARD BODY -->
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Fecha de solicitud</label>
                                    <div class="input-group date" id="fechaCaducidadPicker" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#fechaCaducidadPicker" name="caducidad" />
                                        <div class="input-group-append" data-target="#fechaCaducidadPicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nombre del cliente</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre">
                                </div>

                                <div class="form-group">
                                    <label> Apellido paterno </label>
                                    <input type="text" class="form-control" name="apellidoP" placeholder="Ingresa apellido paterno">
                                </div>

                                <div class="form-group">
                                    <label> Apellido materno </label>
                                    <input type="text" class="form-control" name=" apellidoM" placeholder="Ingresa apellido materno">
                                </div>

                                <div class="form-group">
                                    <label>Nombre del producto</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="Ingresa el nombre de algún producto">
                                </div>

                                <div class="form-group">
                                    <label>Tipo de producto</label>
                                    <select class="form-control" name="material">
                                        <option value="">Seleccione un tipo</option>
                                        <option value="loseta">Loseta</option>
                                        <option value="pegamento">Pega azulejo</option>
                                        <option value="decorado">Decorado</option>
                                    </select>
                                </div>

                                <td>
                                    <button type="button" class="bg-gradient-warning btn-sm">Agregar producto</button>
                                </td>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Unidad de medida</label>
                                    <select class="form-control" name="medida" id="unidadMedida">
                                        <option value="">Seleccione una opción</option>
                                        <option value="cajas">Cajas</option>
                                        <option value="bulto">Bultos</option>
                                        <option value="pz">Piezas</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Color del material</label>
                                    <select class="form-control" name="colores">
                                        <option value="">Seleccione una opción</option>
                                        <option value="color1">Negro</option>
                                        <option value="color2">Blanco</option>
                                        <option value="color3">Beige</option>
                                        <option value="color4">Cafe</option>
                                        <option value="color5">Gris</option>
                                        <option value="color6">Azul</option>
                                        <option value="color7">Verde</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" min="1" max="1000" step="1" value="1">
                                </div>

                                <div class="form-group">
                                    <label>Stock disponible </label>
                                    <input type="text" class="form-control" name="stock" value="0">
                                </div>


                                <div class="form-group" id="formatoMedida" style="display: none;">
                                    <label>Formato de medida</label>
                                    <select class="form-control" name="formato">
                                        <option value="">Seleccione un formato</option>
                                        <option value="30x60">30 x 60</option>
                                        <option value="60x60">60 x 60</option>
                                        <option value="60x120">60 x 1.20</option>
                                    </select>
                                </div>

                                <div class="form-group" id="fechaCaducidad" style="display: none;">
                                    <label>Fecha de caducidad</label>
                                    <div class="input-group date" id="fechaCaducidadPicker1" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#fechaCaducidadPicker" name="caducidad" />
                                        <div class="input-group-append" data-target="#fechaCaducidadPicker" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Precio unitario</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control" name="precio" id="precio" placeholder="ingrese el precio en este formato 0.00">
                                    </div>
                                </div>

                            </div>
                        </div><br>

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre producto</th>
                                            <th>Tipo de material</th>
                                            <th>Unidad de medida</th>
                                            <th>Cantidad</th>
                                            <th>Precio unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Loseta Verona</td>
                                            <td>Loseta</td>
                                            <td>Cajas</td>
                                            <td>10</td>
                                            <td>$250.00</td>
                                            <td>$2500.00</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Crest</td>
                                            <td>Pega azulejo</td>
                                            <td>Bultos</td>
                                            <td>12</td>
                                            <td>$200.00</td>
                                            <td>$2400.00</td>
                                        </tr>
                                    </tbody>
                                </table><br>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Total: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control" name="total" placeholder="ingrese el monto total en este formato 0.00">
                                </div>
                            </div>

                        </div>

                        <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-success">Registrar</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-cancel">Cancelar</button>
                            <button type="button" class="bg-gradient-warning btn-sm">Inicio</button>
                        </td>

                        <div class="modal fade" id="modal-success">
                            <div class="modal-dialog">
                                <div class="modal-content bg-success">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Registro exitoso</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>La cotización se registró correctamente</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                            Cerrar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modal-cancel">
                            <div class="modal-dialog">
                                <div class="modal-content bg-danger">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Registro cancelado</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>La cotización fue cancelada</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">
                                            Cerrar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Control Sidebar -->
                        <aside class="control-sidebar control-sidebar-dark">
                            <!-- Control sidebar content goes here -->
                        </aside>
                        <!-- /.control-sidebar -->
                    </div>
                    <!-- ./wrapper -->

                    <!-- jQuery -->
                    <script src="plugins/jquery/jquery.min.js"></script>
                    <!-- Bootstrap 4 -->
                    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <!-- Select2 -->
                    <script src="plugins/select2/js/select2.full.min.js"></script>
                    <!-- Bootstrap4 Duallistbox -->
                    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
                    <!-- InputMask -->
                    <script src="plugins/moment/moment.min.js"></script>
                    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
                    <!-- date-range-picker -->
                    <script src="plugins/daterangepicker/daterangepicker.js"></script>
                    <!-- bootstrap color picker -->
                    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
                    <!-- Tempusdominus Bootstrap 4 -->
                    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
                    <!-- Bootstrap Switch -->
                    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
                    <!-- BS-Stepper -->
                    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
                    <!-- dropzonejs -->
                    <script src="plugins/dropzone/min/dropzone.min.js"></script>
                    <!-- AdminLTE App -->
                    <script src="dist/js/adminlte.min.js"></script>
                    <!-- AdminLTE for demo purposes -->
                    <script src="dist/js/demo.js"></script>

                    <script>
                        $(function() {
                            $('#fechaCaducidadPicker').datetimepicker({
                                format: 'L' // formato de fecha (día/mes/año)
                            });
                        });
                    </script>

                    <script>
                        document.getElementById("unidadMedida").addEventListener("change", function() {
                            var valor = this.value;

                            var formato = document.getElementById("formatoMedida");
                            var fecha = document.getElementById("fechaCaducidad");

                            formato.style.display = "none";
                            fecha.style.display = "none";

                            if (valor === "cajas") {
                                formato.style.display = "block";
                            } else if (valor === "bulto") {
                                fecha.style.display = "block";
                            }
                        });
                    </script>
                </div>
            </section>
    </div>
</body>
</html>