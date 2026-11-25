<style>
  .gm-clean-nav {
    padding: 10px 8px;
  }

  .gm-clean-list {
    list-style: none;/*Para que no se vea la forma de lista*/
    margin: 0;
    padding: 0;/*Margen del menu*/
  }

  .gm-clean-list > li + li {
    margin-top: 4px;
  }

  .gm-clean-link {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    border-radius: 6px;
    border-left: 3px solid transparent;
    color: #334155;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease;
  }

  .gm-clean-link i {
    min-width: 22px;
    width: 22px;
    text-align: center;
    font-size: 0.92rem;
    color: #64748b;
    margin-right: 10px;
    flex-shrink: 0;
    transition: color 0.15s ease;
  }

  .gm-clean-link span {
    overflow: hidden;
    text-overflow: ellipsis;
  }

  body.sidebar-collapse .main-sidebar:not(:hover) .gm-clean-link {
    justify-content: center;
    padding: 10px 0;
    border-left-width: 0;
  }

  body.sidebar-collapse .main-sidebar:not(:hover) .gm-clean-link i {
    margin-right: 0;
  }

  body.sidebar-collapse .main-sidebar:not(:hover) .gm-clean-link span,
  body.sidebar-collapse .main-sidebar:not(:hover) .gm-brand-title {
    display: none;
  }

  body.sidebar-collapse .main-sidebar:not(:hover) .gm-brand-header {
    justify-content: center;
    padding-left: 0;
    padding-right: 0;
  }

  .gm-clean-link:hover {
    background-color: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
  }

  .gm-clean-link:hover i {
    color: #12188f;
  }

  .gm-clean-link.is-active {
    background-color: #eef2ff;
    border-left-color: #12188f;
    color: #12188f;
    font-weight: 600;
  }

  .gm-clean-link.is-active i {
    color: #12188f;
  }

  .gm-clean-logout-link {
    color: #475569;
  }

  .gm-clean-logout-link:hover {
    background-color: #fef2f2;
    color: #b91c1c;
  }

  .gm-clean-logout-link:hover i {
    color: #b91c1c;
  }
</style>

<nav class="gm-clean-nav" aria-label="Menú lateral">
  <ul class="gm-clean-list">
    <li>
      <a href="{{ url('/usuarios') }}"
         class="gm-clean-link {{ request()->is('usuarios*', 'registro_usu') ? 'is-active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Usuarios</span>
      </a>
    </li>

    <li>
      <a href="{{ url('/productosre') }}"
         class="gm-clean-link {{ request()->is('productosre', 'productos*') ? 'is-active' : '' }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>Productos</span>
      </a>
    </li>

    <li>
      <a href="{{ url('/inventario') }}"
         class="gm-clean-link {{ request()->is('inventario') ? 'is-active' : '' }}">
        <i class="fas fa-boxes"></i>
        <span>Inventario</span>
      </a>
    </li>

    <li>
      <a href="{{ url('/cotizacion') }}"
         class="gm-clean-link {{ request()->is('cotizacion', 'cotizaciones/crear*') ? 'is-active' : '' }}">
        <i class="fas fa-file-invoice"></i>
        <span>Cotizaciones</span>
      </a>
    </li>

    <li>
      <a href="{{ url('/pedido') }}"
         class="gm-clean-link {{ request()->is('pedido', 'pedidos*') ? 'is-active' : '' }}">
        <i class="fas fa-shopping-cart"></i>
        <span>Pedidos</span>
      </a>
    </li>

    <li>
      <a href="#" class="gm-clean-link gm-clean-logout-link"
         onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
        <i class="fas fa-sign-out-alt"></i>
        <span>Cerrar sesión</span>
      </a>
      <form id="form-logout" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>
  </ul>
</nav>