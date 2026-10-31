<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grupo Morami | {{ !empty($cotizacion) ? 'Editar cotización' : 'Registro de nuevas cotizaciones' }}</title>

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
                        <a href="#" class="dropdown-item dropdown-footer">Ver todas las Notificaciones</a>
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

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1>{{ !empty($cotizacion) ? 'Editar cotización' : 'Registro de nuevas cotizaciones' }}</h1>
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

                    <form id="formCotizacion" method="post"
                        action="{{ !empty($cotizacion) ? route('cotizaciones.update', $cotizacion->id_cot_pk) : route('cotizaciones.store') }}">
                        @csrf
                        @if(!empty($cotizacion))
                        @method('PUT')
                        @endif

                        {{-- Aquí viaja la lista de productos (la arma el JavaScript de abajo) --}}
                        <input type="hidden" name="productos_json" id="productos_json"
                            value="{{ old('productos_json', json_encode($productos ?? [])) }}">

                        {{-- Catálogo de productos registrados (solo lectura, no se envía) --}}
                        <input type="hidden" id="catalogo_json" value="{{ json_encode($catalogo ?? []) }}">

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">{{ !empty($cotizacion) ? 'Actualizar' : 'Registrar' }}</button>
                            <a href="{{ url('/cotizacion') }}" class="btn btn-danger">Cancelar</a>
                        </div>

                        <!-- ===== Datos del cliente ===== -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos del Cliente</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre del cliente</label>
                                            <input type="text" class="form-control" name="nombre" maxlength="100"
                                                value="{{ old('nombre', $cliente['nombre'] ?? '') }}"
                                                placeholder="Ingresa el nombre">
                                        </div>
                                        <div class="form-group">
                                            <label>Apellido paterno</label>
                                            <input type="text" class="form-control" name="apellido_paterno" maxlength="100"
                                                value="{{ old('apellido_paterno', $cliente['paterno'] ?? '') }}"
                                                placeholder="Ingresa apellido paterno">
                                        </div>
                                        <div class="form-group">
                                            <label>Apellido materno</label>
                                            <input type="text" class="form-control" name="apellido_materno" maxlength="100"
                                                value="{{ old('apellido_materno', $cliente['materno'] ?? '') }}"
                                                placeholder="Ingresa apellido materno">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de solicitud</label>
                                            <div class="input-group date" id="fechaSolicitudPicker" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#fechaSolicitudPicker" name="fecha" autocomplete="off"
                                                    value="{{ old('fecha', !empty($cotizacion->fecha_cot) ? date('d/m/Y', strtotime($cotizacion->fecha_cot)) : '') }}">
                                                <div class="input-group-append" data-target="#fechaSolicitudPicker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== Productos ===== -->
                        <div class="card card-warning" id="seccionProductos">
                            <div class="card-header">
                                <h3 class="card-title">Agregar Productos a Cotización</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre del producto</label>
                                            <input type="text" class="form-control" id="p_nombre" maxlength="100"
                                                list="listaProductos" autocomplete="off"
                                                placeholder="Ingresa el nombre de algún producto">
                                            <datalist id="listaProductos">
                                                @foreach(($catalogo ?? []) as $pc)
                                                <option value="{{ $pc['nombre'] }}">{{ trim($pc['color'] . ' ' . $pc['formato']) }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo de producto</label>
                                            <select class="form-control" id="p_tipo">
                                                <option value="">Seleccione un tipo</option>
                                                <option value="Loseta">Loseta</option>
                                                <option value="Pegazulejo">Pegazulejo</option>
                                                <option value="Decorado">Decorado</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Unidad de medida</label>
                                            <select class="form-control" id="p_unidad">
                                                <option value="">Seleccione una opción</option>
                                                <option value="Caja">Caja</option>
                                                <option value="Bulto">Bulto</option>
                                                <option value="Pieza">Pieza</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Color</label>
                                            <select class="form-control" id="p_color">
                                                <option value="">Seleccione una opción</option>
                                                @foreach(['Negro', 'Blanco', 'Beige', 'Café', 'Gris', 'Azul', 'Verde', 'Terracota', 'Dorado'] as $col)
                                                <option value="{{ $col }}">{{ $col }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Cantidad</label>
                                            <input type="number" class="form-control" id="p_cantidad" min="1" max="1000" step="1" value="1">
                                        </div>
                                        <div class="form-group">
                                            <label>Precio unitario</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" id="p_precio" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-warning" id="btnAgregar">
                                    <i class="fas fa-plus"></i> Agregar producto
                                </button>
                                <span class="text-danger ml-2" id="errorProducto"></span>

                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Producto</th>
                                                <th>Tipo</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                                <th class="text-center">Quitar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaProductos"></tbody>
                                    </table>
                                </div>

                                <h4 class="text-right mt-3">Total Cotización: <b id="totalCotizacion">$0.00</b></h4>
                            </div>
                        </div>

                    </form>
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
        $(function() {
            // Calendario de la fecha de solicitud (dd/mm/aaaa)
            $('#fechaSolicitudPicker').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            // ---- Lista de productos de la cotización ----
            var productos = [];
            try {
                productos = JSON.parse($('#productos_json').val() || '[]');
            } catch (e) {
                productos = [];
            }
            if (!Array.isArray(productos)) productos = [];

            function dinero(n) {
                return '$' + Number(n).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function celda(texto, clase) {
                var td = document.createElement('td');
                td.textContent = texto;
                if (clase) td.className = clase;
                return td;
            }

            function render() {
                var tbody = document.getElementById('tablaProductos');
                tbody.innerHTML = '';
                var total = 0;

                if (productos.length === 0) {
                    var vacio = document.createElement('tr');
                    var td = celda('Aún no has agregado productos.', 'text-center text-muted py-3');
                    td.colSpan = 8;
                    vacio.appendChild(td);
                    tbody.appendChild(vacio);
                }

                productos.forEach(function(p, i) {
                    var subtotal = Math.round(p.cantidad * p.precio * 100) / 100;
                    total += subtotal;

                    var tr = document.createElement('tr');
                    tr.appendChild(celda(i + 1));

                    var tdProd = celda(p.nombre);
                    if (p.color) {
                        var small = document.createElement('small');
                        small.className = 'text-muted';
                        small.textContent = ' (' + p.color + ')';
                        tdProd.appendChild(small);
                    }
                    tr.appendChild(tdProd);

                    tr.appendChild(celda(p.tipo));
                    tr.appendChild(celda(p.unidad));
                    tr.appendChild(celda(p.cantidad));
                    tr.appendChild(celda(dinero(p.precio)));
                    tr.appendChild(celda(dinero(subtotal)));

                    var tdQuitar = document.createElement('td');
                    tdQuitar.className = 'text-center';
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.title = 'Quitar';
                    btn.innerHTML = '<i class="fas fa-trash"></i>';
                    btn.addEventListener('click', function() {
                        productos.splice(i, 1);
                        render();
                    });
                    tdQuitar.appendChild(btn);
                    tr.appendChild(tdQuitar);

                    tbody.appendChild(tr);
                });

                document.getElementById('totalCotizacion').textContent = dinero(total);
                document.getElementById('productos_json').value = JSON.stringify(productos);
            }

            // ---- Catálogo de productos registrados (autocompletar) ----
            var catalogo = [];
            try {
                catalogo = JSON.parse($('#catalogo_json').val() || '[]');
            } catch (e) {
                catalogo = [];
            }
            if (!Array.isArray(catalogo)) catalogo = [];
            var idSeleccionado = null;

            // Si el usuario sigue escribiendo, ya no es el producto elegido de la lista
            $('#p_nombre').on('input', function() {
                idSeleccionado = null;
            });

            // Al elegir un producto del catálogo se llenan tipo, unidad, color y precio
            $('#p_nombre').on('change', function() {
                var n = $(this).val().trim().toLowerCase();
                var coincide = catalogo.filter(function(c) {
                    return String(c.nombre).toLowerCase() === n;
                });

                if (coincide.length === 1) {
                    var c = coincide[0];
                    idSeleccionado = c.id;
                    $('#p_tipo').val(c.tipo || '');
                    $('#p_unidad').val(c.unidad || '');
                    $('#p_color').val(c.color || '');
                    $('#p_precio').val(Number(c.precio || 0).toFixed(2));
                }
            });

            function agregarProducto() {
                var nombre = $('#p_nombre').val().trim();
                var tipo = $('#p_tipo').val();
                var unidad = $('#p_unidad').val();
                var color = $('#p_color').val();
                var cantidad = parseInt($('#p_cantidad').val(), 10);
                var precio = parseFloat(String($('#p_precio').val()).replace(',', '.'));
                var error = '';

                if (nombre === '') error = 'Escribe el nombre del producto.';
                else if (!tipo) error = 'Selecciona el tipo de producto.';
                else if (!unidad) error = 'Selecciona la unidad de medida.';
                else if (isNaN(cantidad) || cantidad < 1) error = 'La cantidad debe ser al menos 1.';
                else if (isNaN(precio) || precio < 0) error = 'Ingresa un precio válido (0.00).';

                $('#errorProducto').text(error);
                if (error) return;

                productos.push({
                    id_pro: idSeleccionado,
                    nombre: nombre,
                    color: color,
                    tipo: tipo,
                    unidad: unidad,
                    cantidad: cantidad,
                    precio: Math.round(precio * 100) / 100
                });

                // Limpia los campos para el siguiente producto
                $('#p_nombre').val('');
                $('#p_tipo, #p_unidad, #p_color').val('');
                $('#p_cantidad').val(1);
                $('#p_precio').val('');
                idSeleccionado = null;
                $('#p_nombre').focus();

                render();
            }

            $('#btnAgregar').on('click', agregarProducto);

            // Enter dentro de los campos del producto agrega el producto (no envía el formulario)
            $('#seccionProductos input').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    agregarProducto();
                }
            });

            render();
        });
    </script>
</body>

</html>