<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Panel Admin')</title>

  {{-- Bootstrap 5 --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  {{-- CSS Summernote --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <style>
    :root {
      --color-primary: #8B5FBF;
      --color-primary-light: #B399D4;
      --color-primary-lighter: #E6E0F0;
      --color-primary-dark: #6A3D9A;
      --color-text: #4A4A4A;
      --color-text-light: #7A7A7A;
      --color-bg: #F9F6FC;
      --color-white: #FFFFFF;
      --color-border: #E1D8EB;
    }

    /* ==== Reset y tipografía ==== */
    body {
      margin: 0;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--color-bg);
      color: var(--color-text);
      line-height: 1.6;
    }

    /* ==== Sidebar Moderna y Ligera ==== */
    .sidebar {
      position: fixed; 
      top: 0; 
      left: 0;
      width: 260px; 
      height: 100vh;
      background: var(--color-white);
      color: var(--color-text);
      padding-top: 1.5rem; 
      z-index: 1000;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
      border-right: 1px solid var(--color-border);
      transition: all 0.3s ease;
    }
    
    .sidebar-collapsed {
      width: 80px;
      overflow: hidden;
    }
    
    .sidebar-collapsed .profile div,
    .sidebar-collapsed .profile small,
    .sidebar-collapsed .nav-link span,
    .sidebar-collapsed .logout-btn-text {
      display: none !important;
    }
    
    .sidebar-collapsed .nav-link {
      justify-content: center;
    }
    
    .sidebar-collapsed .nav-link i {
      margin-right: 0;
    }
    
    .sidebar-collapsed .has-submenu .nav-link:after {
      display: none;
    }
    
    .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 999;
      display: none;
    }
    
    .sidebar-close {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--color-text);
      display: none;
      z-index: 1001;
    }
    
    .sidebar .profile {
      text-align: center; 
      margin-bottom: 2rem;
      padding: 0 1.5rem;
      transition: all 0.3s ease;
    }
    
    .sidebar .profile img {
      width: 80px; 
      height: 80px;
      border: 3px solid var(--color-primary-lighter);
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }
    
    .sidebar .profile img:hover {
      border-color: var(--color-primary-light);
      transform: scale(1.05);
    }
    
    .sidebar .profile div {
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 0.25rem;
      color: var(--color-primary-dark);
    }
    
    .sidebar .profile small {
      display: block;
      font-size: 0.85rem;
      color: var(--color-text-light);
      margin-bottom: 1.5rem;
    }
    
    /* Logos en sidebar */
    .sidebar-logos {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      padding: 0 1.5rem 1.5rem;
      border-bottom: 1px solid var(--color-border);
      margin-bottom: 1.5rem;
    }
    
    /* Menú principal */
    .sidebar .nav {
      padding: 0 1rem;
    }
    
    .sidebar .nav-item {
      margin-bottom: 0.25rem;
      position: relative;
    }
    
    .sidebar .nav-link {
      display: flex;
      align-items: center;
      padding: 0.65rem 1rem;
      color: var(--color-text) !important;
      text-decoration: none;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: var(--color-primary-lighter);
      color: var(--color-primary-dark) !important;
    }
    
    .sidebar .nav-link.active {
      font-weight: 600;
    }
    
    .sidebar .nav-link i {
      margin-right: 12px;
      font-size: 1.1rem;
      width: 24px;
      text-align: center;
      color: var(--color-primary);
    }
    
    .sidebar .nav-link:hover i,
    .sidebar .nav-link.active i {
      color: var(--color-primary-dark);
    }
    
    /* Submenús */
    .sidebar .submenu {
      padding-left: 2rem;
      margin-top: 0.25rem;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-out;
    }
    
    .sidebar .submenu.show {
      max-height: 500px;
      transition: max-height 0.5s ease-in;
    }
    
    .sidebar .submenu .nav-link {
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
      background: transparent !important;
      position: relative;
      color: var(--color-text-light) !important;
    }
    
    .sidebar .submenu .nav-link:hover,
    .sidebar .submenu .nav-link.active {
      color: var(--color-primary-dark) !important;
      background: transparent !important;
    }
    
    .sidebar .submenu .nav-link:before {
      content: "";
      position: absolute;
      left: 0.5rem;
      top: 50%;
      transform: translateY(-50%);
      width: 6px;
      height: 6px;
      background: var(--color-primary-light);
      border-radius: 50%;
      opacity: 0.6;
    }
    
    .sidebar .submenu .nav-link:hover:before,
    .sidebar .submenu .nav-link.active:before {
      opacity: 1;
      background: var(--color-primary-dark);
    }
    
    /* Flecha de submenú */
    .sidebar .has-submenu .nav-link:after {
      content: "\F282";
      font-family: "bootstrap-icons";
      margin-left: auto;
      transition: transform 0.3s ease;
      font-size: 0.8rem;
      color: var(--color-primary-light);
    }
    
    .sidebar .has-submenu .nav-link.collapsed:after {
      transform: rotate(-90deg);
    }
    
    /* ==== Área principal ==== */
    .main {
      position: fixed;
      top: 0; 
      left: 260px;
      width: calc(100% - 260px);
      height: 100vh;
      padding: 2rem;
      overflow-y: auto;
      background: var(--color-bg);
      transition: all 0.3s ease;
    }
    
    .main-expanded {
      left: 80px;
      width: calc(100% - 80px);
    }
    
    /* Header del main */
    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--color-border);
    }
    
    .main-header h2 {
      color: var(--color-primary-dark);
      font-weight: 600;
      margin: 0;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
    }
    
    /* Logos en header */
    .header-logos {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    /* Dropdown de notificaciones */
    .notification-dropdown {
      width: 350px;
      border: none;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      border: 1px solid var(--color-border);
      padding: 0;
    }
    
    .notification-header {
      background: var(--color-white);
      color: var(--color-primary-dark);
      padding: 1rem 1.5rem;
      border-bottom: 1px solid var(--color-border);
    }
    
    .notification-header h5 {
      font-weight: 600;
      margin: 0;
      display: flex;
      align-items: center;
    }
    
    .notification-header h5 i {
      margin-right: 0.5rem;
    }
    
    .notification-body {
      padding: 0;
      max-height: 400px;
      overflow-y: auto;
      background: var(--color-bg);
    }
    
    .notification-empty {
      padding: 2rem 1.5rem;
      text-align: center;
      color: var(--color-text-light);
    }
    
    .notification-empty i {
      font-size: 2rem;
      color: var(--color-primary-light);
      margin-bottom: 1rem;
      display: block;
    }
    
    /* Botones */
    .btn-purple {
      background-color: var(--color-primary);
      color: var(--color-white);
      border: none;
      border-radius: 8px;
      padding: 0.5rem 1.5rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-purple:hover {
      background-color: var(--color-primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 2px 6px rgba(138, 95, 191, 0.2);
    }
    
    .btn-outline-purple {
      border: 1px solid var(--color-primary);
      color: var(--color-primary);
      background-color: transparent;
      border-radius: 8px;
    }
    
    .btn-outline-purple:hover {
      background-color: var(--color-primary);
      color: var(--color-white);
    }
    
    /* Tablas */
    .table {
      color: var(--color-text);
      background-color: var(--color-white);
      border-radius: 8px;
      overflow: hidden;
    }
    
    .table th {
      background-color: var(--color-primary-lighter);
      color: var(--color-primary-dark);
    }
    
    .table-container {
      overflow-x: auto;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .sidebar-close {
        display: block;
      }
      
      .main {
        left: 0;
        width: 100%;
      }
      
      .main-expanded {
        left: 0;
        width: 100%;
      }
      
      .header-logos {
        display: none;
      }
    }
  </style>
</head>
<body>
{{-- Overlay para móvil --}}
<div class="sidebar-overlay"></div>

{{-- ===== Sidebar ===== --}}
<div class="sidebar">
  <button class="sidebar-close">&times;</button>
  
  {{-- Logos en el sidebar --}}
  <div class="sidebar-logos">
    <img src="{{ asset('images/QuintanaRooLogo.png') }}" alt="Qroo" style="height:50px;">
    <img src="{{ asset('images/logosemujeres-01.png') }}" alt="Semujeres" style="height:50px;">
  </div>
  
  <ul class="nav flex-column">
    {{-- Inicio --}}
    <li class="nav-item">
      <a href="/admin" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
        <i class="bi bi-house"></i> <span>Inicio</span>
      </a>
    </li>

    {{-- Usuarios --}}
    <li class="nav-item has-submenu">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#submenu-usuarios">
        <i class="bi bi-people"></i> <span>Usuarios</span>
      </a>
      <div class="submenu collapse" id="submenu-usuarios">
        <a href="/admin/usuarios" class="nav-link {{ request()->is('admin/usuarios') && !request()->is('admin/usuarios*') && !request()->is('admin/solicitudes-usuarios*') ? 'active' : '' }}">
          <i class="bi bi-list-ul"></i> <span>Lista de Usuarios</span>
        </a>
        <a href="/admin/solicitudes-usuarios" class="nav-link {{ request()->is('admin/solicitudes-usuarios*') ? 'active' : '' }}">
          <i class="bi bi-clipboard-check"></i> <span>Solicitudes de Usuarias</span>
        </a>
      </div>
    </li>

    {{-- Cursos --}}
    <li class="nav-item has-submenu">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#submenu-cursos">
        <i class="bi bi-book"></i> <span>Cursos</span>
      </a>
      <div class="submenu collapse" id="submenu-cursos">
         <a href="{{ route('admin.cursos.index') }}" class="nav-link {{ request()->is('admin/cursos') && !request()->is('admin/cursos/crear*') ? 'active' : '' }}">
          <i class="bi bi-list-task"></i> <span>Lista de Cursos</span>
        </a>
      </div>
    </li>

    {{-- Eventos --}}
    <li class="nav-item has-submenu">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#submenu-eventos">
        <i class="bi bi-calendar-event"></i> <span>Eventos</span>
      </a>
      <div class="submenu collapse" id="submenu-eventos">
        <a href="/admin/eventos" class="nav-link {{ request()->is('admin/eventos') && !request()->is('admin/inscripciones-eventos*') ? 'active' : '' }}">
          <i class="bi bi-calendar-check"></i> <span>Lista de Eventos</span>
        </a>
        <a href="/admin/inscripciones-eventos" class="nav-link {{ request()->is('admin/inscripciones-eventos*') ? 'active' : '' }}">
          <i class="bi bi-ticket-perforated"></i> <span>Inscripciones</span>
        </a>
      </div>
    </li>

    {{-- Productos --}}
    <li class="nav-item has-submenu">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#submenu-productos">
        <i class="bi bi-box-seam"></i> <span>Productos</span>
      </a>
      <div class="submenu collapse" id="submenu-productos">
        <a href="/admin/productos" class="nav-link {{ request()->is('admin/productos') && !request()->is('admin/solicitudes-productos*') ? 'active' : '' }}">
          <i class="bi bi-boxes"></i> <span>Lista de Productos</span>
        </a>
        <a href="/admin/solicitudes-productos" class="nav-link {{ request()->is('admin/solicitudes-productos*') ? 'active' : '' }}">
          <i class="bi bi-hourglass-split"></i> <span>Solicitudes</span>
        </a>
      </div>
    </li>

    {{-- Emprendimientos --}}
    <li class="nav-item has-submenu">
      <a class="nav-link collapsed" data-bs-toggle="collapse" href="#submenu-emprendimientos">
        <i class="bi bi-shop"></i> <span>Emprendimientos</span>
      </a>
      <div class="submenu collapse" id="submenu-emprendimientos">
        <a href="/admin/emprendimientos" class="nav-link {{ request()->is('admin/emprendimientos') && !request()->is('admin/emprendimiento/solicitudes*') ? 'active' : '' }}">
          <i class="bi bi-building"></i> <span>Lista</span>
        </a>
        <a href="{{ route('admin.emprendimientos.solicitudes') }}"
   class="nav-link {{ request()->routeIs('admin.emprendimientos.solicitudes') ? 'active' : '' }}">
  <i class="bi bi-hourglass-top"></i> <span>Solicitudes</span>
</a>
      </div>
    </li>
  </ul>

  {{-- Botón cerrar sesión --}}
  <div class="px-3 mt-auto mb-4">
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="button" id="logout-btn" class="btn btn-outline-purple w-100 d-flex align-items-center justify-content-center">
        <i class="bi bi-box-arrow-left"></i>
        <span class="logout-btn-text ms-2">Cerrar Sesión</span>
      </button>
    </form>
  </div>
</div>

{{-- ===== Main Content ===== --}}
<div class="main">
  {{-- Header con título y notificaciones --}}
  <div class="main-header">
    <div class="d-flex align-items-center">
    </div>
    
    {{-- Dropdown de notificaciones --}}
    <div class="d-flex align-items-center">
      <div class="dropdown me-3">
        <div class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationsDropdown">    
        </div>
      </div>

    </div>
  </div>

  {{-- Contenido principal --}}
  <div id="vista-contenido">
    @yield('content')
  </div>
</div>

{{-- ==== Scripts Globales ==== --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<script>
  // Función para alternar sidebar en móvil
  function toggleSidebarMobile() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    sidebar.classList.toggle('active');
    overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
  }

  // Función para alternar sidebar en escritorio
  function toggleSidebarDesktop() {
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('.main');
    
    sidebar.classList.toggle('sidebar-collapsed');
    main.classList.toggle('main-expanded');
    
    // Guardar preferencia en localStorage
    const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
    localStorage.setItem('sidebarCollapsed', isCollapsed);
  }

  // Función para cargar datos de productos
  function cargarProductos() {
    const tbody = document.getElementById('products-table-body');
    tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
      </div>
    </td></tr>`;
    
    fetch('/admin/productos/data')
      .then(response => {
        if (!response.ok) throw new Error('Error en la respuesta');
        return response.json();
      })
      .then(data => {
        tbody.innerHTML = '';
        
        if (data.length === 0) {
          tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-muted">No hay productos registrados</td></tr>`;
          return;
        }
        
        data.forEach(producto => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td>${producto.id}</td>
            <td>${producto.usuario}</td>
            <td>${producto.emprendimiento || '—'}</td>
            <td>${producto.nombre}</td>
            <td>${producto.descripcion.substring(0, 30)}${producto.descripcion.length > 30 ? '...' : ''}</td>
            <td>${formatCurrency(producto.precio)}</td>
            <td>
              <span class="badge bg-${producto.estado === 'Activo' ? 'success' : 'danger'}">
                ${producto.estado}
              </span>
            </td>
            <td>
              <button class="btn btn-sm btn-outline-primary me-1 edit-product" data-id="${producto.id}">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger delete-product" data-id="${producto.id}">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          `;
          tbody.appendChild(tr);
        });
        
        // Agregar event listeners a los botones
        document.querySelectorAll('.edit-product').forEach(btn => {
          btn.addEventListener('click', () => editarProducto(btn.dataset.id));
        });
        
        document.querySelectorAll('.delete-product').forEach(btn => {
          btn.addEventListener('click', () => eliminarProducto(btn.dataset.id));
        });
      })
      .catch(error => {
        console.error('Error al cargar productos:', error);
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-danger">Error al cargar los productos</td></tr>`;
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar los productos',
          confirmButtonColor: 'var(--color-primary)'
        });
      });
  }

  // Formatear moneda
  function formatCurrency(amount) {
    return new Intl.NumberFormat('es-MX', {
      style: 'currency',
      currency: 'MXN'
    }).format(amount);
  }

  // Función para editar producto
  function editarProducto(id) {
    Swal.fire({
      title: 'Editar Producto',
      text: `¿Deseas editar el producto con ID ${id}?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: 'var(--color-primary)',
      cancelButtonColor: 'var(--color-text-light)',
      confirmButtonText: 'Sí, editar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Aquí iría la lógica para editar el producto
        console.log(`Editando producto ${id}`);
      }
    });
  }

  // Función para eliminar producto
  function eliminarProducto(id) {
    Swal.fire({
      title: '¿Eliminar Producto?',
      text: `¿Estás seguro de eliminar el producto con ID ${id}? Esta acción no se puede deshacer.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: 'var(--color-primary)',
      cancelButtonColor: 'var(--color-text-light)',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Simular eliminación
        fetch(`/admin/productos/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
          }
        })
        .then(response => {
          if (!response.ok) throw new Error('Error al eliminar');
          return response.json();
        })
        .then(data => {
          Swal.fire({
            icon: 'success',
            title: 'Producto eliminado',
            text: 'El producto ha sido eliminado correctamente',
            confirmButtonColor: 'var(--color-primary)'
          });
          cargarProductos();
        })
        .catch(error => {
          console.error('Error al eliminar producto:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo eliminar el producto',
            confirmButtonColor: 'var(--color-primary)'
          });
        });
      }
    });
  }

  // Cargar preferencia del sidebar al cargar la página
  document.addEventListener('DOMContentLoaded', () => {
    // Restaurar estado contraído en escritorio
    if (window.innerWidth >= 992) {
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (isCollapsed) {
        document.querySelector('.sidebar').classList.add('sidebar-collapsed');
        document.querySelector('.main').classList.add('main-expanded');
      }
    }

    document.querySelector('.sidebar-close').addEventListener('click', toggleSidebarMobile);
    document.querySelector('.sidebar-overlay').addEventListener('click', toggleSidebarMobile);

    // Botón para refrescar productos
    if (document.getElementById('refresh-products')) {
      document.getElementById('refresh-products').addEventListener('click', cargarProductos);
    }

    // Cargar productos al iniciar si estamos en la página de productos
    if (window.location.pathname.includes('productos')) {
      cargarProductos();
    }

    // Cerrar otros submenús cuando se abre uno nuevo
    document.querySelectorAll('.has-submenu .nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        if (this.getAttribute('data-bs-toggle') === 'collapse') {
          const submenuId = this.getAttribute('href');
          const isCollapsed = this.classList.contains('collapsed');
          
          document.querySelectorAll('.submenu.show').forEach(openSubmenu => {
            if (openSubmenu.id !== submenuId.replace('#', '')) {
              const parentLink = document.querySelector(`[href="#${openSubmenu.id}"]`);
              if (parentLink) {
                parentLink.classList.add('collapsed');
                openSubmenu.classList.remove('show');
              }
            }
          });
          
          if (!isCollapsed) {
            this.classList.add('collapsed');
          }
        }
      });
    });
  });

  // Manejar cambios de tamaño de pantalla
  window.addEventListener('resize', () => {
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('.main');
    const overlay = document.querySelector('.sidebar-overlay');
    
    if (window.innerWidth >= 992) {
      // Escritorio - asegurar que el overlay no esté visible
      overlay.style.display = 'none';
      
      // Restaurar estado contraído si estaba así antes
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (isCollapsed) {
        sidebar.classList.add('sidebar-collapsed');
        main.classList.add('main-expanded');
      } else {
        sidebar.classList.remove('sidebar-collapsed');
        main.classList.remove('main-expanded');
      }
    } else {
      // Móvil - asegurar que el sidebar esté cerrado
      sidebar.classList.remove('active');
      overlay.style.display = 'none';
    }
  });

  function cargarSeccion(seccion) {
    const cont = document.getElementById('vista-contenido');
    cont.innerHTML = `<div class="text-center my-5">
                      <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                      </div>
                    </div>`;

    fetch(`/admin/contenido/${seccion}`)
      .then(r => r.ok ? r.text() : Promise.reject())
      .then(html => {
        cont.innerHTML = html;

        // Inicializar funciones específicas de cada sección
        if (typeof inicializarAlertasYEliminar === "function") inicializarAlertasYEliminar();
        if (typeof inicializarSweetAlertAceptar === "function") inicializarSweetAlertAceptar();
        if (typeof inicializarSweetAlertRechazar === "function") inicializarSweetAlertRechazar();
        if (typeof inicializarSweetAlertEliminarSolicitud === "function") inicializarSweetAlertEliminarSolicitud();
        if (typeof inicializarSummernote === "function") inicializarSummernote();
      })
      .catch(() => cont.innerHTML = `<div class="alert alert-danger">No se pudo cargar "${seccion}".</div>`);
  }

  // Event listeners para los enlaces del sidebar
  document.querySelectorAll('[data-section]').forEach(el => {
    el.addEventListener('click', e => {
      e.preventDefault();
      cargarSeccion(el.getAttribute('data-section'));
      
      // Marcar como activo
      document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
      el.classList.add('active');
    });
  });

  // Confirmación para cerrar sesión
  document.getElementById('logout-btn').addEventListener('click', () => {
    Swal.fire({
      title: '¿Deseas cerrar sesión?',
      text: 'Tu sesión actual se cerrará.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: 'var(--color-primary)',
      cancelButtonColor: 'var(--color-text-light)',
      confirmButtonText: 'Sí, cerrar sesión',
      cancelButtonText: 'Cancelar'
    }).then(res => res.isConfirmed && document.getElementById('logout-form').submit());
  });

  // Función para inicializar SweetAlert de aceptación
  function inicializarSweetAlertAceptar() {
    document.querySelectorAll(".boton-aceptar").forEach(boton =>
      boton.addEventListener("click", () => {
        Swal.fire({
          title: '¿Estás seguro de aceptar este producto?',
          text: "Esta acción aprobará el producto.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: 'var(--color-primary)',
          cancelButtonColor: 'var(--color-text-light)',
          confirmButtonText: 'Sí, aceptar',
          cancelButtonText: 'Cancelar'
        }).then(r => r.isConfirmed && boton.closest("form").submit());
      })
    );
  }

  // Función para inicializar SweetAlert de rechazo
  function inicializarSweetAlertRechazar() {
    document.querySelectorAll(".boton-rechazar").forEach(boton => {
      boton.addEventListener("click", () => {
        const action = boton.getAttribute("data-action");

        Swal.fire({
          title: '¿Rechazar este producto?',
          text: "Se eliminará la solicitud y se notificará al usuario.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'var(--color-primary)',
          cancelButtonColor: 'var(--color-text-light)',
          confirmButtonText: 'Sí, continuar',
          cancelButtonText: 'Cancelar'
        }).then(result => {
          if (result.isConfirmed) {
            const card = document.getElementById('cardRechazo');
            const form = document.getElementById('formRechazo');
            form.setAttribute('action', action);
            document.getElementById('razon').value = '';
            card.style.display = 'block';
            document.getElementById('razon').focus();
          }
        });
      });
    });
  }

  // Función para cerrar el modal de rechazo
  function cerrarCardRechazo() {
    const card = document.getElementById('cardRechazo');
    card.style.display = 'none';
  }
  
  // Función para inicializar Summernote
  function inicializarSummernote() {
    $('.summernote').summernote({
      height: 250,
      lang: 'es-ES',
      placeholder: 'Escribe la descripción del curso/taller...',
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture']],
        ['view', ['codeview']]
      ]
    });
  }

  // Función para inicializar alertas y eliminación
  function inicializarAlertasYEliminar() {
    // Mostrar alerta si existe el div con datos
    const alerta = document.getElementById('mensaje-alerta');
    if (alerta) {
      Swal.fire({
        icon: alerta.dataset.tipo,
        title: alerta.dataset.titulo,
        text: alerta.dataset.texto,
        confirmButtonColor: 'var(--color-primary)'
      });
    }

    // Confirmación SweetAlert antes de eliminar
    document.querySelectorAll('.form-eliminar').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: '¿Eliminar este emprendimiento?',
          text: 'Esta acción no se puede deshacer.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'var(--color-primary)',
          cancelButtonColor: 'var(--color-text-light)',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  }

  // Función para inicializar SweetAlert de eliminación de solicitud
  function inicializarSweetAlertEliminarSolicitud() {
    document.querySelectorAll('.form-rechazar').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: '¿Rechazar este emprendimiento?',
          text: 'Esta acción eliminará la solicitud.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: 'var(--color-primary)',
          cancelButtonColor: 'var(--color-text-light)',
          confirmButtonText: 'Sí, rechazar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  }

  // Inicializar funciones al cargar la página
  document.addEventListener("DOMContentLoaded", () => {
    inicializarSweetAlertAceptar();
    inicializarSweetAlertRechazar();
    
   
        
      

    // Cerrar otros submenús cuando se abre uno nuevo
    document.querySelectorAll('.has-submenu .nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        // Si el enlace tiene un submenú y no es un enlace directo
        if (this.getAttribute('data-bs-toggle') === 'collapse') {
          const submenuId = this.getAttribute('href');
          const isCollapsed = this.classList.contains('collapsed');
          
          // Cerrar todos los submenús excepto el actual
          document.querySelectorAll('.submenu.show').forEach(openSubmenu => {
            if (openSubmenu.id !== submenuId.replace('#', '')) {
              const parentLink = document.querySelector(`[href="#${openSubmenu.id}"]`);
              if (parentLink) {
                parentLink.classList.add('collapsed');
                openSubmenu.classList.remove('show');
              }
            }
          });
          
          // Alternar el estado del submenú actual
          if (!isCollapsed) {
            this.classList.add('collapsed');
          }
        }
      });
    });
  });
</script>

{{-- Card para rechazo --}}
<div id="cardRechazo" class="position-fixed top-50 start-50 translate-middle bg-white shadow rounded p-4 border" style="z-index: 2000; display: none; width: 90%; max-width: 400px; border-color: var(--color-border) !important;">
  <form method="POST" id="formRechazo">
    @csrf
    <h5 class="mb-3" style="color: var(--color-primary-dark);">Motivo del rechazo</h5>
    <div class="mb-3">
      <label for="razon" class="form-label">Razón</label>
      <textarea name="razon" id="razon" class="form-control" rows="3" required style="border-color: var(--color-border);"></textarea>
    </div>
    <div class="text-end">
      <button type="button" class="btn btn-outline-secondary me-2" onclick="cerrarCardRechazo()">Cancelar</button>
      <button type="submit" class="btn btn-purple">Rechazar producto</button>
    </div>
  </form>
</div>
@yield('scripts')
</body>
</html>