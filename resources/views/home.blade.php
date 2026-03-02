@extends('layouts.app')

@section('title', 'Mujer es Emprender')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&display=swap" rel="stylesheet">

<style>

  body {
    background: url('{{ asset("images/fondo22(1)(1).png") }}') fixed;
    background-size: cover;
    background-position: center;
    position: relative;
    }
  .activity-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    border: none;
  }

  .activity-image-container {
    position: relative;
    width: 100%;
    padding-top: 30%;
    overflow: hidden;
  }

  .activity-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .activity-body {
    padding: 10px;
  }

  .activity-title {
    font-weight: 600;
    color: #24123a;
    margin-bottom: 5px;
  }

  .activity-date {
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 8px;
  }

  .activity-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
  }

  .view-all-btn {
    color: #4b2a85;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
  }

  .section-title {
    font-weight: 700;
    color: #24123a;
    margin-bottom: 15px;
  }

  /* Card general con altura fija responsiva */
.activity-card {
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  margin-bottom: 20px;
  border: none;
  display: flex;
  flex-direction: column;
  height: 350px; /* altura fija para todos */
}

/* Contenedor de imagen */
.activity-image-container {
  position: relative;
  width: 100%;
  height: 50%; /* la mitad de la card */
  overflow: hidden;
}

.activity-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Cuerpo de la card ocupa el resto */
.activity-body {
  padding: 10px;
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between; /* título arriba, footer abajo */
}

/* Títulos y fechas con tamaño controlado */
.activity-title {
  font-weight: 600;
  color: #24123a;
  margin-bottom: 5px;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2; /* máximo 2 líneas */
  -webkit-box-orient: vertical;
}

.activity-date {
  color: #6c757d;
  font-size: 0.85rem;
  margin-bottom: 8px;
}

.activity-footer small {
  font-size: 0.85rem;
}

/* Badges */
.badge-estado {
  position: absolute;
  top: 10px;
  left: 10px;
  font-weight: 600;
  padding: 0.4em 0.7em;
  border-radius: 0.5rem;
  color: #fff;
}

.badge-estado.en-curso { background-color: #28a745; }
.badge-estado.proximo { background-color: #0d6efd; }
.badge-estado.finalizado { background-color: #6c757d; }

/* Responsive: en móviles reducimos un poco la altura */
@media (max-width: 767px) {
  .activity-card {
    height: 300px;
  }
}

</style>

{{-- HERO --}}
<section class="py-5" style="">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <h1 class="mb-3" style="font-family:Montserrat,system-ui; font-weight:800; font-size:clamp(28px,4.2vw,44px); color:#24123a;">
          Impulsa tu negocio y<br>desarrolla tus habilidades
        </h1>
        <p class="lead mb-4" style="color:#514865;">
          Plataforma para mujeres emprendedoras y artesanas
        </p>
        <a href="{{ route('registro.create') }}" class="btn btn-lg px-4 py-2" style="background:#4b2a85; color:#fff; border-radius:999px;">
          Regístrate y sé parte de nuestros Programas
        </a>
      </div>
      <div class="col-lg-5 mt-4 mt-lg-0 text-center">
        <img src="{{ asset('images/IMG_3155.jpg') }}" alt="Hero" class="img-fluid" style="max-height:360px; object-fit:contain;">
      </div>
    </div>
  </div>
</section>

{{-- CONTENIDO PRINCIPAL --}}
<section class="py-4">
  <div class="container">
   {{-- CURSOS --}}
<div class="mb-5">
  <h2 class="section-title">Cursos para el autoempleo</h2>

  <div class="swiper mySwiperCursos">
    <div class="swiper-wrapper">
      @php
$hoy = \Carbon\Carbon::now();

$cursosOrdenados = ($cursos ?? collect())->sortBy(function($curso) use ($hoy) {

    if (empty($curso->fecha)) {
        return 1; // mandar al final si no tiene fecha
    }

    $r = explode(' - ', $curso->fecha);

    try {
        $fi = isset($r[0]) ? \Carbon\Carbon::parse(trim($r[0])) : null;
        $ff = isset($r[1]) ? \Carbon\Carbon::parse(trim($r[1])) : $fi;
    } catch (\Exception $e) {
        return 1; // si falla el formato, lo manda al final
    }

    if ($ff && $ff < $hoy) {
        return 1; // curso pasado
    }

    return 0; // curso vigente o futuro
});
@endphp

      @foreach($cursosOrdenados as $curso)
      @php
        $r = explode(' - ', $curso->fecha ?? '');
        $fi = isset($r[0]) ? \Carbon\Carbon::parse(trim($r[0])) : null;
        $ff = isset($r[1]) ? \Carbon\Carbon::parse(trim($r[1])) : $fi;

        if($fi && $ff) {
          if($hoy < $fi) {
            $estado = 'Proximo';
          } elseif($hoy >= $fi && $hoy <= $ff) {
            $estado = 'En curso';
          } else {
            $estado = 'Finalizado';
          }
        } else {
          $estado = '';
        }
      @endphp

      <div class="swiper-slide">
        <a href="{{ route('cursos.ver', $curso->id) }}" class="card activity-card h-100 text-decoration-none {{ $estado=='Finalizado' ? 'card-finalizado' : ($estado=='En curso' ? 'card-curso' : 'card-proximo') }}">
          <div class="activity-image-container">
            <img src="{{ $curso->flyer ? asset($curso->flyer) : asset('images/default-course.webp') }}" class="activity-image">
            @if($estado)
            <span class="badge badge-estado {{ strtolower(str_replace(' ', '-', $estado)) }}">
              {{ $estado }}
            </span>
            @endif
          </div>
          <div class="activity-body">
            <h5 class="activity-title">{{ $curso->nombre }}</h5>
            <p class="activity-date">
              {{ $fi? $fi->format('d/m/Y') : '' }}{{ $ff? ' - '.$ff->format('d/m/Y'):'' }}
            </p>
            <div class="activity-footer">
              <small>{{ $curso->ciudad ?? 'Online' }}</small>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- ESTILOS DE CARDS POR ESTADO --}}
<style>
.card-curso {
  border: 2px solid #28a745;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
}

.card-proximo {
  border: 2px solid #0d6efd;
  box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
}

.card-finalizado {
  border: 2px solid #6c757d;
  opacity: 0.6;
  color: #6c757d;
  box-shadow: none;
}

.badge-estado {
  position: absolute;
  top: 10px;
  left: 10px;
  font-weight: 600;
  padding: 0.4em 0.7em;
  border-radius: 0.5rem;
  color: #fff;
}

.badge-estado.en-curso { background-color: #28a745; }
.badge-estado.proximo { background-color: #0d6efd; }
.badge-estado.finalizado { background-color: #6c757d; }
</style>

{{-- Swiper JS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const swiperCursos = new Swiper(".mySwiperCursos", {
  slidesPerView: 3,
  spaceBetween: 20,
  slidesPerGroup: 1,
  freeMode: true,
  grabCursor: true,
  loop: true, 
  speed: 15000, 
  autoplay: {
    delay: 0, 
    disableOnInteraction: false,
  },
  pagination: false,
  navigation: false,
  breakpoints: {
    992: { slidesPerView: 3 },
    768: { slidesPerView: 2 },
    0: { slidesPerView: 1 },
  }
  });
});
</script>

{{-- EVENTOS --}}
<div class="mb-5">
  <h2 class="section-title">Eventos</h2>

  <div class="swiper mySwiperEventos">
    <div class="swiper-wrapper">
      @php
        $hoy = \Carbon\Carbon::now();

        // Separar por estado
        $enCurso = collect();
        $proximos = collect();
        $finalizados = collect();

        foreach($eventos ?? collect() as $evento){
          $fechaEvento = \Carbon\Carbon::parse($evento->fecha);
          if($fechaEvento->isToday()){
            $enCurso->push($evento);
          } elseif($fechaEvento->isFuture()){
            $proximos->push($evento);
          } else {
            $finalizados->push($evento);
          }
        }

        // Unir en el orden deseado
        $eventosOrdenados = $enCurso->merge($proximos)->merge($finalizados);
      @endphp

      @foreach($eventosOrdenados as $evento)
      @php
        $fechaEvento = \Carbon\Carbon::parse($evento->fecha);
        if($fechaEvento->isFuture()) {
          $estado = 'Próximo';
        } elseif($fechaEvento->isToday()) {
          $estado = 'En curso';
        } else {
          $estado = 'Finalizado';
        }
      @endphp

      <div class="swiper-slide">
        <a href="{{ route('evento.detalle', $evento->id_evento) }}" class="card activity-card h-100 text-decoration-none {{ $estado=='Finalizado' ? 'card-finalizado' : ($estado=='En curso' ? 'card-curso' : 'card-proximo') }}">
          <div class="activity-image-container">
            <img src="{{ $evento->fotos ? asset('storage/eventos/'.$evento->fotos) : asset('images/default-event.jpg') }}" class="activity-image">
            @if($estado)
            <span class="badge badge-estado {{ strtolower(str_replace(' ', '-', $estado)) }}">
              {{ $estado }}
            </span>
            @endif
          </div>
          <div class="activity-body">
            <h5 class="activity-title">{{ $evento->descripcion }}</h5>
            <p class="activity-date">
              {{ $fechaEvento->translatedFormat('d \\de F \\de Y') }}
            </p>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- ESTILOS PARA EVENTOS --}}
<style>
.card-curso {
  border: 2px solid #28a745;
  box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
}

.card-proximo {
  border: 2px solid #0d6efd;
  box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
}

.card-finalizado {
  border: 2px solid #6c757d;
  opacity: 0.6;
  color: #6c757d;
  box-shadow: none;
}

.badge-estado {
  position: absolute;
  top: 10px;
  left: 10px;
  font-weight: 600;
  padding: 0.4em 0.7em;
  border-radius: 0.5rem;
  color: #fff;
}

.badge-estado.en-curso { background-color: #28a745; }
.badge-estado.proximo { background-color: #0d6efd; }
.badge-estado.finalizado { background-color: #6c757d; }
</style>

{{-- Swiper JS para Eventos --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const swiperEventos = new Swiper(".mySwiperEventos", {
  slidesPerView: 3,
  spaceBetween: 20,
  slidesPerGroup: 1,
  freeMode: true,
  grabCursor: true,
  loop: true, 
  speed: 12000, 
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
  },
  pagination: false,
  navigation: false,
  breakpoints: {
    992: { slidesPerView: 3 },
    768: { slidesPerView: 2 },
    0: { slidesPerView: 1 },
  }
});
});
</script>

    {{-- EMPRENDIMIENTOS --}}
    <div class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="section-title">Emprendimientos</h2>
        <a href="{{ route('emprendimientos.catalogo') }}" class="view-all-btn">Ver todos</a>
      </div>

      <div class="row">
        @forelse(($emprendimientos ?? collect())->take(3) as $e)
        <div class="col-md-4 mb-4">
          <a href="{{ route('emprendimientos.perfil', $e->id_emprendimiento) }}" class="card activity-card h-100 text-decoration-none">
            <div class="activity-image-container">
              @if($e->logo)
              <img src="{{ asset('storage/images/emprendimientos/' . $e->logo) }}" alt="{{ $e->emprendimiento }}" class="activity-image">
              @else
              <img src="{{ asset('images/placeholder-product.webp') }}" alt="Sin imagen" class="activity-image">
              @endif
            </div>
            <div class="activity-body">
              <h5 class="activity-title">{{ $e->emprendimiento }}</h5>
            </div>
          </a>
        </div>
        @empty
        @for($i=0;$i<3;$i++)
          <div class="col-md-4 mb-4">
          <div class="card activity-card h-100">
            <div class="activity-image-container">
              <img src="{{ asset('images/placeholder-product.webp') }}" alt="Proximamente" class="activity-image">
            </div>
            <div class="activity-body">
              <h5 class="activity-title">Próximamente</h5>
            </div>
          </div>
      </div>
      @endfor
      @endforelse
    </div>
  </div>

  {{-- HISTORIAS DE ÉXITO --}}
  <div class="mb-5">
    <h2 class="section-title">Historias de éxito</h2>

    <div class="row">
      @php $historias = ($testimonios ?? collect())->take(3); @endphp
      @forelse($historias as $h)
      <div class="col-md-4 mb-4">
        <div class="card success-story-card h-100">
          <div class="card-body text-center p-4">

            {{-- Mensaje del testimonio --}}
            <p class="success-story-message">
              "{{ Str::limit($h->mensaje, 150) }}"
            </p>

            {{-- Información de la persona --}}
            <div class="mt-3">
              <h6 class="success-story-name mb-1">{{ $h->nombre }}</h6>
              <p class="success-story-role text-muted small">Emprendedora</p>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <div class="alert alert-info">Aún no hay historias registradas</div>
      </div>
      @endforelse
    </div>
  </div>
  </div>
</section>
{{-- FOOTER --}}
<footer class="bg-dark text-light pt-5">
  <div class="container">
    <div class="row text-start">

      <div class="col-md-3 mb-4">
        <h5 class="text-white font-weight-bold">Nuestra Dirección</h5>
        <p class="mb-1 text-white">
          Oficinas Centrales de<br>
          SEMUJERES
        </p>
        <p class="small text-white mb-2">
          <strong>Av. Juárez entre Othón P. Blanco y Álvaro Obregón</strong><br>
          C.P. 77000, Chetumal, Q. Roo<br>
          <i class="fas fa-phone-alt"></i> +52 (983) 129 3071<br>
          <i class="fas fa-envelope"></i> emprender.semujeres@qroo.gob.mx
        </p>
      </div>

      <div class="col-md-3 mb-4">
        <h5 class="text-white font-weight-bold">Síguenos</h5>
        <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
        <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="https://www.youtube.com/channel/UCGce5AQn-rVH0cANvpiSVkQ/videos" class="text-light"><i class="fab fa-youtube fa-lg"></i></a>
      </div>

      <div class="col-md-3 mb-4">
        <h5 class="text-white font-weight-bold">Inscríbete Ahora</h5>
        <p class="small text-white">Recibe las últimas noticias y novedades sobre Mujeres Emprendedoras.</p>
        <a href="{{ route('registro.create') }}" class="btn-custom-icon">Inscríbete
        </a>
      </div>

      <div class="col-md-3 mb-4" id="mapa-footer">
        <h5 class="text-white font-weight-bold">Ubicación</h5>
        <div class="embed-responsive embed-responsive-16by9 rounded shadow-sm mb-2">
          <iframe
            class="embed-responsive-item"
            src="https://maps.google.com/maps?q=Av+Ju%C3%A1rez+49%2C+Centro%2C+77000+Chetumal%2C+Q.R.&t=&z=16&ie=UTF8&iwloc=&output=embed"
            allowfullscreen
            loading="lazy"
            style="border:0;">
          </iframe>
        </div>
        <p class="small text-white mb-0">
          Av. Juárez entre Av. Othón P. Blanco y Av. Álvaro Obregón
        </p>
      </div>

    </div>
  </div>
</footer>

@endsection