<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Mujer es Emprender')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.webp') }}">
  <link rel="shortcut icon" href="{{ asset('images/logo.webp') }}">

  {{-- Bootstrap --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  {{-- Íconos --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  {{-- Estilos personalizados --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  @yield('styles')

  <style>
    /* --- Responsivo logos navbar --- */
    .navbar-brand{
      display:flex; align-items:center; gap:12px; margin:0; min-width:0;
      flex-wrap:nowrap; overflow:hidden;
    }
    .logo-left{  height:100px; width:auto; }
    .logo-right{ height:100px; width:auto; }

    /* ≤ 992px (lg) */
    @media (max-width: 992px){
      .logo-left{  height:120px; }
      .logo-right{ height:80px; }
    }

    /* ≤ 768px (md) */
    @media (max-width: 768px){
      .navbar{ padding-top:.5rem; padding-bottom:.5rem; }
      .logo-left{  height:70px; }
      .logo-right{ height:55px; }
    }

    /* ≤ 576px (sm - teléfonos) */
    @media (max-width: 576px){
      .navbar{ padding-top:.35rem; padding-bottom:.35rem; }
      .navbar-brand{ gap:8px; }
      .logo-left{  height:44px; }
      .logo-right{ height:38px; }
    }

    /* Teléfonos muy chicos (≤ 400px): ocultar segundo logo para evitar overflow */
    @media (max-width: 400px){
      .logo-right{ display:none; }
      .logo-left{  height:44px; }
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

{{-- ========================================= --}}
{{-- Navbar + Header                          --}}
{{-- ========================================= --}}
@unless (View::hasSection('hideNavbar'))
<header>
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm py-3 navbar-purple">
    <div class="container-fluid px-4">

      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logosemujeres.png') }}" alt="Logo Semujeres" class="logo-left">
        <img src="{{ asset('images/emprender-02.png') }}" alt="Logo Mujeres Emprender" class="logo-right">
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Menú principal --}}
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ml-auto align-items-center">
          <li class="nav-item mx-2">
            <a href="{{ route('emprendimientos.catalogo') }}" class="btn-custom-icon">Catálogo</a>
          </li>
          <li class="nav-item mx-2">
            <a href="{{ route('registro.create') }}" class="btn-custom-icon">Inscríbete</a>
          </li>
          <li class="nav-item mx-2">
            <a href="{{ route('login') }}" class="btn-custom-icon">Iniciar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
@endunless

{{-- ========================================= --}}
{{-- Contenido dinámico con Blade              --}}
{{-- ========================================= --}}
<main class="flex-fill">
  @yield('content')
</main>

{{-- ========================================= --}}
{{-- Footer                                    --}}
{{-- ========================================= --}}
<footer class="bg-dark text-light text-center py-4 mt-auto">
  <small class="d-block">&copy; {{ date('Y') }} Secretaría de las Mujeres</small>
</footer>

{{-- ========================================= --}}
{{-- Scripts                                   --}}
{{-- ========================================= --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Scroll suave en anclas
  document.querySelectorAll('.dropdown-item[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
        $('#navMenu').collapse('hide');
      }
    });
  });

  // Animación de dropdown
  $(function () {
    $('.dropdown').on('show.bs.dropdown', function () {
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown(200);
    }).on('hide.bs.dropdown', function () {
      $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
    });
  });
</script>

@yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: '¡Acceso denegado!',
    text: '{{ session('error') }}',
    confirmButtonText: 'Ok, entendido',
    confirmButtonColor: '#d33',
    backdrop: `rgba(123, 0, 0, 0.6)`,
    timer: 5000
  });
</script>
@endif

</body>
</html>
