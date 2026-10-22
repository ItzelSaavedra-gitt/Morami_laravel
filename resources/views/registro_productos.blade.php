<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grupo Morami| Registro de nuevos productos </title>

    <!-- Google Font: Source Sans Pro -->
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
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
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
        <a href="#" class="brand-link">
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
                    <a href="#" class="d-block">Administrador</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ url('/usuarios') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/productosre') }}" class="nav-link active">
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
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ !empty($producto) ? 'Editar producto' : 'Registro de nuevos productos' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/productosre') }}">Productos</a></li>
                            <li class="breadcrumb-item active">{{ !empty($producto) ? 'Editar' : 'Nuevo' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

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

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Datos del producto</h3>
                    </div>

                    <form method="post" action="{{ !empty($producto) ? route('productos.update', $producto->id_pro_pk) : route('productos.store') }}">
                        @csrf
                        @if(!empty($producto))
                            @method('PUT')
                        @endif

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre del producto</label>
                                        <input type="text" class="form-control" name="nombre"
                                               value="{{ old('nombre', $producto->nombre_pro ?? '') }}"
                                               placeholder="Ingresa el nombre de algún producto">
                                    </div>

                        <div class="form-group">
                            <label>Tipo de producto</label>
                            <select class="form-control" name="material">
                                <option value="">Seleccione un tipo</option>
                                @php $actual = old('material', $producto->tipo_pro ?? ''); @endphp
                                @foreach(array_unique(array_filter(array_merge(['Loseta', 'Pegazulejo', 'Decorado'], [$actual]))) as $op)
                                    <option value="{{ $op }}" {{ $actual == $op ? 'selected' : '' }}>{{ $op }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Unidad de medida</label>
                            <select class="form-control" name="medida" id="unidadMedida">
                                <option value="">Seleccione una opción</option>
                                @php $actual = old('medida', $producto->unidadMedida ?? ''); @endphp
                                @foreach(array_unique(array_filter(array_merge(['Caja', 'Bulto', 'Pieza'], [$actual]))) as $op)
                                    <option value="{{ $op }}" {{ $actual == $op ? 'selected' : '' }}>{{ $op }}</option>
                                @endforeach
                            </select>
                        </div>
                                </div>

                                <div class="col-md-6">
                        <div class="form-group">
                            <label>Color del material</label>
                            <select class="form-control" name="colores">
                                <option value="">Sin color / seleccione</option>
                                @php $actual = old('colores', $producto->color_pro ?? ''); @endphp
                                @foreach(array_unique(array_filter(array_merge(['Negro', 'Blanco', 'Beige', 'Café', 'Gris', 'Azul', 'Verde', 'Terracota', 'Dorado'], [$actual]))) as $op)
                                    <option value="{{ $op }}" {{ $actual == $op ? 'selected' : '' }}>{{ $op }}</option>
                                @endforeach
                            </select>
                        </div>

                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" class="form-control" name="cantidad" min="1" max="1000" step="1"
                                               value="{{ old('cantidad', $producto->CantidadPiezas_pro ?? 1) }}">
                                    </div>

                                    <div class="form-group" id="formatoMedida">
                                        <label>Formato</label>
                                        <input type="text" class="form-control" name="formato" list="formatos" maxlength="20"
                                               value="{{ old('formato', $producto->formato_pro ?? '') }}"
                                               placeholder="Ej. 60x60, 33x33, 20kg">
                                        <datalist id="formatos">
                                            <option value="20x20"><option value="20x60"><option value="25x40"><option value="33x33">
                                            <option value="45x45"><option value="60x60"><option value="60x120"><option value="20kg">
                                        </datalist>
                                    </div>

                                    <div class="form-group" id="fechaCaducidad" style="display: none;">
                                        <label>Fecha de caducidad</label>
                                        <div class="input-group date" id="fechaCaducidadPicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#fechaCaducidadPicker" name="caducidad"
                                                   value="{{ old('caducidad', !empty($producto->fechaCaducidad) ? date('d/m/Y', strtotime($producto->fechaCaducidad)) : '') }}" />
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
                                            <input type="text" class="form-control" name="precio" id="precio"
                                                   value="{{ old('precio', $producto->precioUnitario_pro ?? '') }}"
                                                   placeholder="ingrese el precio en este formato 0.00">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">{{ !empty($producto) ? 'Actualizar' : 'Registrar' }}</button>
                            <a href="{{ url('/productosre') }}" class="btn btn-danger">Cancelar</a>
                            <a href="{{ url('/panel') }}" class="btn btn-default"><i class="fas fa-home" style="color: #FFD700;"></i> Inicio</a>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>

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

    <script>
        $(function () {
            $('#fechaCaducidadPicker').datetimepicker({
                format: 'DD/MM/YYYY' // día/mes/año
            });

            // La fecha de caducidad solo se muestra cuando la unidad es "Bulto"
            function mostrarCampos() {
                var valor = document.getElementById("unidadMedida").value;
                document.getElementById("fechaCaducidad").style.display = (valor === "Bulto") ? "block" : "none";
            }

            document.getElementById("unidadMedida").addEventListener("change", mostrarCampos);
            mostrarCampos();
        });
    </script>
</body>
</html>