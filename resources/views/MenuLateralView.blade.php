<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a href="{{ url('/usuarios') }}"
            class="nav-link {{ request()->is('usuarios*', 'registro_usu') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Usuarios</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ url('/productosre') }}"
            class="nav-link {{ request()->is('productosre', 'productos*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Productos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ url('/inventario') }}"
            class="nav-link {{ request()->is('inventario') ? 'active' : '' }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p>Inventario</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ url('/cotizacion') }}"
            class="nav-link {{ request()->is('cotizacion', 'registro_cotizaciones') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>Cotizaciones</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ url('/pedido') }}"
            class="nav-link {{ request()->is('pedido', 'pedidos*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Pedidos</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Cerrar sesión</p>
        </a>
        <form id="form-logout" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>