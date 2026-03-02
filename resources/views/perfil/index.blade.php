@extends('layouts.app')
@section('hideNavbar', '')

@section('content')
@section('styles')
<style>
   /* Estilos generales */
  body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  /* Barra superior */
  .barra-superior {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 10px 20px;
  }
  
  /* Barra morada debajo del header */
  .barra-morada {
    height: 4px;
    margin-bottom: 20px;
  }
  
  /* Panel izquierdo - Perfil */
  .panel-perfil {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    text-align: center; /* Centrar contenido del perfil */
  }
  
  /* Título del perfil centrado */
  .titulo-perfil {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }
  
  /* Foto de perfil */
  .foto-perfil {
    width: 120px;
    height: 120px;
    border: 3px solid #7C3AED;
    object-fit: cover;
    margin: 0 auto; /* Centrar imagen */
  }
  
  /* Botones de navegación - ahora grises */
  .btn-navegacion {
    background-color: #6c757d; /* Gris */
    color: white;
    border-radius: 20px;
    padding: 8px 16px;
    margin-right: 8px;
    margin-bottom: 8px;
    border: none;
    font-size: 14px;
    transition: all 0.3s;
  }
  
  .btn-navegacion:hover, .btn-navegacion.active {
    background-color: #7C3AED; /* Gris más oscuro al pasar el mouse */
    transform: translateY(-2px);
  }
  
  /* Tarjetas de cursos */
  .tarjeta-curso {
    background-color: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }
  
  /* Botón "Ya estás inscrita" */
  .btn-inscrita {
    background-color: #6c757d; /* Gris */
    color: white;
    border-radius: 20px;
    padding: 8px 20px;
    border: none;
    font-size: 14px;
  }
  
  /* Efecto hover para cambiar foto */
  .cambiar-foto {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s;
    cursor: pointer;
  }
  
  .position-relative:hover .cambiar-foto {
    opacity: 1;
  }
  
  /* Ajustes para los textos */
  .texto-pequeno {
    font-size: 0.9rem;
    color: #555;
  }
  
  /* Estilos para pestañas */
  .nav-tabs .nav-link {
    color: #6c757d; /* Gris */
    font-weight: 500;
  }
  
  .nav-tabs .nav-link.active {
    color: #495057; /* Gris más oscuro */
    font-weight: bold;
    border-bottom: 3px solid #6c757d; /* Gris */
    background-color: transparent;
  }
  
  /* Contenido de pestañas */
  .tab-content {
    padding: 20px 0;
  }
  .btn-emprendimiento {
  color: #6c757d !important;
  font-weight: bold;
  text-decoration: none;
  border-bottom: none !important;  /* Elimina línea inferior */
  border: none !important;
  padding: 8px 0;
  display: block;
  width: 100%;
  text-align: center;
}

.btn-emprendimiento:hover {
  color: #7C3AED !important;
}
</style>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Barra superior -->
<div class="barra-superior d-flex justify-content-between align-items-center">
  <div class="logos d-flex align-items-center gap-4">
    <img src="{{ asset('images/QuintanaRooLogo.png') }}" alt="Qroo" style="height:50px;">
    <img src="{{ asset('images/logosemujeres-01.png') }}" alt="Semujeres" style="height:50px;">
  </div>
  <div>
    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
      @csrf
      <button id="logoutButton" type="submit" class="btn-navegacion">
        <i class="fas fa-sign-out-alt me-1"></i> Salir
      </button>
    </form>
  </div>
</div>

<!-- Barra morada -->
<div class="barra-morada"></div>

<div class="container-fluid">
  <div class="row">
    <!-- Columna izquierda - Perfil -->
    <div class="col-md-3">
      <div class="panel-perfil">
        <h3 class="fw-bold mb-4">Perfil</h3>
        <div class="text-center">
          <div class="mb-3 position-relative d-inline-block">
            @if($datos->avatar)
              <img src="{{ asset('storage/' . $datos->avatar) }}" class="foto-perfil rounded-circle">
            @else
              <div class="foto-perfil rounded-circle d-flex justify-content-center align-items-center bg-danger text-white fs-2">
                <i class="fas fa-user"></i>
              </div>
            @endif
            <div class="cambiar-foto" onclick="document.getElementById('avatarInput').click();">
              <i class="fas fa-camera"></i>
            </div>
            <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;">
          </div>
          <h4 class="fw-bold mb-1">{{ $datos->nombre ?? '—' }} {{ $datos->apellido_paterno ?? '' }} {{ $datos->apellido_materno ?? '' }}</h4>
          <p class="texto-pequeno mb-1"><strong>CURP:</strong> {{ $datos->curp ?? 'No disponible' }}</p>
          <p class="texto-pequeno mb-1"><strong>Email:</strong> {{ $datos->email ?? 'No disponible' }}</p>
          <p class="texto-pequeno"><strong>Teléfono:</strong> {{ $datos->telefono ?? 'No disponible' }}</p>
        </div>
        <div class="mt-3">
  <a href="{{ route('perfil.seccion') }}" class="btn-emprendimiento">
    <i class="fas fa-lightbulb me-1"></i>Participa en nuestro programa de emprendimientos
  </a>
</div>
      </div>
    </div>

    <!-- Columna derecha - Contenido -->
    <div class="col-md-9">
      <div class="mb-4">
        <!-- Botones de navegación -->
        <div class="d-flex flex-wrap">
          <button class="btn-navegacion" onclick="mostrarSeccion('mis-actividades')">Mis Actividades</button>
          <button class="btn-navegacion" onclick="mostrarSeccion('constancias')">Mis constancias</button>
          <button class="btn-navegacion active" onclick="mostrarSeccion('actividades-disponibles')">Actividades disponibles</button>
        </div>
      </div>

      <!-- Sección de Mis Actividades -->
      <div id="seccion-mis-actividades" style="display: none;">
        <ul class="nav nav-tabs mb-4" id="misActividadesTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="mis-cursos-tab" data-bs-toggle="tab" data-bs-target="#mis-cursos" type="button" role="tab">
              Mis Cursos ({{ $misCursos ? $misCursos->count() : 0 }})
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="mis-eventos-tab" data-bs-toggle="tab" data-bs-target="#mis-eventos" type="button" role="tab">
              Mis Eventos ({{ $misEventos ? $misEventos->count() : 0 }})
            </button>
          </li>
        </ul>

        <div class="tab-content" id="misActividadesTabContent">
         <!-- Pestaña de Mis Cursos -->
<div class="tab-pane fade show active" id="mis-cursos" role="tabpanel">
  @forelse($misCursos as $inscrito)
    @php
      $fechas = explode(' - ', $inscrito->curso->fecha);
      $fechaInicio = isset($fechas[0]) ? \Carbon\Carbon::parse($fechas[0])->format('d/m/Y') : 'Sin fecha';
      $fechaFin = isset($fechas[1]) ? \Carbon\Carbon::parse($fechas[1])->format('d/m/Y') : null;
    @endphp

    <div class="tarjeta-curso">
      <div class="row align-items-center">
        <div class="col-md-4 text-center">
          <img src="{{ asset($inscrito->curso->flyer) }}" class="img-fluid rounded" style="max-height: 150px;">
        </div>
        <div class="col-md-8">
          <h5 class="fw-bold mb-2">{{ $inscrito->curso->nombre }}</h5>
          <!-- Línea añadida para mostrar la modalidad -->
          <p class="texto-pequeno mb-1"><strong>Modalidad:</strong> 
            <span class="badge {{ $inscrito->curso->modalidad == 'En línea' ? 'bg-primary' : 'bg-success' }}">
              {{ $inscrito->curso->modalidad == 'En línea' ? 'En línea' : 'Presencial' }}
            </span>
          </p>
          <p class="texto-pequeno mb-1"><strong>Fecha:</strong> {{ $fechaInicio }} @if($fechaFin) al {{ $fechaFin }} @endif</p>
          <p class="texto-pequeno mb-1"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($inscrito->curso->hora)->format('h:i A') }}</p>
          <p class="texto-pequeno mb-1"><strong>Lugar:</strong> {{ $inscrito->curso->lugar }} | <strong>Ciudad:</strong> {{ $inscrito->curso->ciudad }}</p>
          <p class="texto-pequeno mb-1">{{ $inscrito->curso->descripcion }}</p>
          <p class="texto-pequeno"><strong>Constancia emitida:</strong> {{ $inscrito->constancia_emitida ? 'Sí' : 'No' }}</p>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">Aún no estás inscrita en ningún curso.</div>
  @endforelse
</div>

          <!-- Pestaña de Mis Eventos -->
          <div class="tab-pane fade" id="mis-eventos" role="tabpanel">
            @forelse($misEventos as $inscripcion)
              @php
                $evento = $inscripcion->evento;
                $fecha = \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y');
              @endphp

              @if($evento)
                <div class="tarjeta-curso">
                  <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                      <img src="{{ asset($evento->flyer) }}" class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                    <div class="col-md-8">
                      <h5 class="fw-bold mb-2">{{ $evento->nombre }}</h5>
                      <p class="texto-pequeno mb-1"><strong>Fecha:</strong> {{ $fecha }}</p>
                      <p class="texto-pequeno mb-1"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($evento->hora)->format('h:i A') }}</p>
                      <p class="texto-pequeno mb-1"><strong>Lugar:</strong> {{ $evento->lugar }} | <strong>Ciudad:</strong> {{ $evento->ciudad }}</p>
                      <p class="texto-pequeno">{{ $evento->descripcion }}</p>
                    </div>
                  </div>
                </div>
              @endif
            @empty
              <div class="alert alert-info">Aún no estás inscrita en ningún evento.</div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Sección de Actividades Disponibles -->
      <div id="seccion-actividades-disponibles">
        <ul class="nav nav-tabs mb-4" id="actividadesDisponiblesTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="cursos-disponibles-tab" data-bs-toggle="tab" data-bs-target="#cursos-disponibles" type="button" role="tab">
              Cursos Disponibles ({{ $cursos->count() }})
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="eventos-disponibles-tab" data-bs-toggle="tab" data-bs-target="#eventos-disponibles" type="button" role="tab">
              Eventos Disponibles ({{ $eventos->count() }})
            </button>
          </li>
        </ul>

        <div class="tab-content" id="actividadesDisponiblesTabContent">
          <!-- Pestaña de Cursos Disponibles -->
          <div class="tab-pane fade show active" id="cursos-disponibles" role="tabpanel">
  @forelse($cursos as $curso)
    @php
      $fechas = explode(' - ', $curso->fecha);
      $fechaInicio = isset($fechas[0]) ? \Carbon\Carbon::parse($fechas[0])->format('d/m/Y') : 'Sin fecha';
      $fechaFin = isset($fechas[1]) ? \Carbon\Carbon::parse($fechas[1])->format('d/m/Y') : null;
      $inscrito = $misCursos->contains('id_curso', $curso->id);
    @endphp

    <div class="tarjeta-curso">
      <div class="row align-items-center">
        <div class="col-md-4 text-center">
          <img src="{{ asset($curso->flyer) }}" class="img-fluid rounded" style="max-height: 150px;">
        </div>
        <div class="col-md-8">
          <h5 class="fw-bold mb-2">{{ $curso->nombre }}</h5>
          <!-- Agrega esta línea para mostrar la modalidad -->
          <p class="texto-pequeno mb-1"><strong>Modalidad:</strong> 
            <span class="badge {{ $curso->modalidad == 'En línea' ? 'bg-primary' : 'bg-success' }}">
              {{ $curso->modalidad == 'En línea' ? 'En línea' : 'Presencial' }}
            </span>
          </p>
          <p class="texto-pequeno mb-1"><strong>Fecha:</strong> {{ $fechaInicio }} @if($fechaFin) al {{ $fechaFin }} @endif</p>
          <p class="texto-pequeno mb-1"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($curso->hora)->format('h:i A') }}</p>
          <p class="texto-pequeno mb-1"><strong>Lugar:</strong> {{ $curso->lugar }} | <strong>Ciudad:</strong> {{ $curso->ciudad }}</p>
          <p class="texto-pequeno mb-2">{{ $curso->descripcion }}</p>

          @if($inscrito)
            <button class="btn-inscrita" disabled>Ya estás inscrita</button>
          @else
            <form method="POST" action="{{ route('inscripcion.curso', $curso->id) }}">
              @csrf
              <button type="submit" class="btn-navegacion">Inscribirme al curso</button>
            </form>
          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">No hay cursos disponibles por el momento.</div>
  @endforelse
</div>

          <!-- Pestaña de Eventos Disponibles -->
          <div class="tab-pane fade" id="eventos-disponibles" role="tabpanel">
            @forelse($eventos as $evento)
              @php
                $yaInscrito = $misEventos->contains(function ($ins) use ($evento) {
                    return $ins->evento && $ins->evento->id_evento == $evento->id_evento;
                });
                $fecha = \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y');
              @endphp

              <div class="tarjeta-curso">
                <div class="row align-items-center">
                  <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/eventos/' . $evento->fotos) }}" class="img-fluid rounded" style="max-height: 150px;">
                  </div>

                  <div class="col-md-8">
                    <h5 class="fw-bold mb-2">{{ $evento->nombre }}</h5>
                    <p class="texto-pequeno mb-1"><strong>Fecha:</strong> {{ $fecha }}</p>
                    <p class="texto-pequeno mb-1"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($evento->hora)->format('h:i A') }}</p>
                    <p class="texto-pequeno mb-1"><strong>Lugar:</strong> {{ $evento->lugar }} | <strong>Ciudad:</strong> {{ $evento->ciudad }}</p>
                    <p class="texto-pequeno mb-2">{{ $evento->descripcion }}</p>

                    @if($yaInscrito)
                      <button class="btn-inscrita" disabled>Ya estás inscrita</button>
                    @else
                      <form method="POST" action="{{ route('inscripcion.evento', $evento->id_evento) }}">
                        @csrf
                        <button type="submit" class="btn-navegacion">Inscribirme al evento</button>
                      </form>
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <div class="alert alert-info">No hay eventos disponibles por el momento.</div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Sección de Mis Cursos -->
      <div id="seccion-mis-cursos" style="display: none;">
        @forelse($misCursos as $inscrito)
          @php
            $fechas = explode(' - ', $inscrito->curso->fecha);
            $fechaInicio = isset($fechas[0]) ? \Carbon\Carbon::parse($fechas[0])->format('d/m/Y') : 'Sin fecha';
            $fechaFin = isset($fechas[1]) ? \Carbon\Carbon::parse($fechas[1])->format('d/m/Y') : null;
          @endphp

          <div class="tarjeta-curso">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h5 class="fw-bold mb-2">{{ $inscrito->curso->nombre }}</h5>
                <p class="texto-pequeno mb-1"><strong>Fecha:</strong> {{ $fechaInicio }} @if($fechaFin) al {{ $fechaFin }} @endif</p>
                <p class="texto-pequeno mb-1"><strong>Horario:</strong> {{ \Carbon\Carbon::parse($inscrito->curso->hora)->format('h:i A') }}</p>
                <p class="texto-pequeno mb-1"><strong>Lugar:</strong> {{ $inscrito->curso->lugar }} | <strong>Ciudad:</strong> {{ $inscrito->curso->ciudad }}</p>
                <p class="texto-pequeno mb-1"><strong>Constancia emitida:</strong> {{ $inscrito->constancia_emitida ? 'Sí' : 'No' }}</p>
              </div>
            </div>
          </div>
        @empty
          <div class="alert alert-info">Aún no estás inscrita en ningún curso.</div>
        @endforelse
      </div>

      <!-- Sección de Constancias -->
      <div id="seccion-constancias" style="display: none;">
        @forelse($constancias as $constancia)
          @php
            $curso = $constancia->curso;
            $fechas = explode(' - ', $curso->fecha);
            $fechaInicio = isset($fechas[0]) ? \Carbon\Carbon::parse($fechas[0])->format('d/m/Y') : 'Sin fecha';
            $fechaFin = isset($fechas[1]) ? \Carbon\Carbon::parse($fechas[1])->format('d/m/Y') : null;
            $enlaceSeguro = URL::signedRoute('constancia.usuario.descargar', ['id' => $constancia->id]);
          @endphp

          <div class="tarjeta-curso">
            <h5 class="fw-bold mb-2">{{ $curso->nombre }}</h5>
            <p class="texto-pequeno mb-1"><strong>Fecha:</strong> {{ $fechaInicio }} @if($fechaFin) al {{ $fechaFin }} @endif</p>
            <p class="texto-pequeno mb-1"><strong>Lugar:</strong> {{ $curso->lugar }}</p>
            <p class="texto-pequeno mb-2"><strong>Facilitador:</strong> {{ $curso->facilitador ?? 'No disponible' }}</p>
            <a href="{{ $enlaceSeguro }}" class="btn-navegacion">Descargar constancia</a>
          </div>
        @empty
          <div class="alert alert-info">Aún no tienes constancias disponibles.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<!-- Modal de cropper -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Recortar imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imagePreview" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="cropAndUpload">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
// Mostrar sección activa
function mostrarSeccion(seccion) {
  // Ocultar todas las secciones
  document.querySelectorAll('[id^="seccion-"]').forEach(sec => {
    sec.style.display = 'none';
  });
  
  // Mostrar la sección seleccionada
  document.getElementById('seccion-' + seccion).style.display = 'block';
  
  // Actualizar botones activos
  document.querySelectorAll('.btn-navegacion').forEach(btn => {
    btn.classList.remove('active');
  });
  event.target.classList.add('active');
}

// Inicializar mostrando actividades disponibles
document.addEventListener('DOMContentLoaded', function() {
  mostrarSeccion('actividades-disponibles');
});

// Configuración del cropper
let cropper;
const avatarInput = document.getElementById('avatarInput');
const imagePreview = document.getElementById('imagePreview');
const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

avatarInput.addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    if (cropper) {
      cropper.destroy();
    }
    
    const reader = new FileReader();
    reader.onload = function(event) {
      imagePreview.src = event.target.result;
      cropperModal.show();
      
      setTimeout(() => {
        cropper = new Cropper(imagePreview, {
          aspectRatio: 1,
          viewMode: 1,
          autoCropArea: 1,
          movable: false,
          zoomable: false,
          rotatable: false,
          scalable: false
        });
      }, 300);
    };
    reader.readAsDataURL(file);
  }
});

document.getElementById('cropAndUpload').addEventListener('click', function() {
  if (!cropper) return;
  
  cropper.getCroppedCanvas({
    width: 300,
    height: 300
  }).toBlob(function(blob) {
    const formData = new FormData();
    formData.append('avatar', blob, 'avatar.png');
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('perfil.avatar') }}', {
      method: 'POST',
      body: formData
    }).then(response => {
      if (response.ok) {
        location.reload();
      } else {
        Swal.fire('Error', 'No se pudo subir la imagen.', 'error');
      }
    });
  });
  
  cropperModal.hide();
});

// Confirmación para cerrar sesión
document.getElementById('logoutButton').addEventListener('click', function(e) {
  e.preventDefault();
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Se cerrará tu sesión actual.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#6a1b9a',
    cancelButtonColor: '#e10d0d',
    confirmButtonText: 'Sí, cerrar sesión',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('logoutForm').submit();
    }
  });
});

// Inicializar tabs de Bootstrap
var triggerTabList = [].slice.call(document.querySelectorAll('#misActividadesTab a, #actividadesDisponiblesTab a'))
triggerTabList.forEach(function (triggerEl) {
  var tabTrigger = new bootstrap.Tab(triggerEl)

  triggerEl.addEventListener('click', function (event) {
    event.preventDefault()
    tabTrigger.show()
  })
})
</script>

@if(session('mostrar_bienvenida'))
<script>
document.addEventListener('DOMContentLoaded', function() {
  Swal.fire({
    html: `
      <div style="text-align:center; padding: 20px;">
        <img src="{{ asset('images/logosemujeres-01.png') }}" 
             alt="Logo" 
             style="max-width:120px; height:auto; margin-bottom:15px;">
        <h4 class="fw-bold mb-2" style="color:#6f42c1;">Mujer Es Emprender</h4>
        <h5 class="fw-bold mb-3" style="color:#7C3AED;">¡Bienvenid@ {{ $datos->nombre ?? '' }}!</h5>
        <p style="color:#555; font-size:15px; line-height:1.4; margin-bottom:0;">
          Nos alegra contar contigo en esta plataforma.<br>
          Explora, participa y aprovecha todas las oportunidades que tenemos para ti.
        </p>
      </div>
    `,
    background: '#fff',
    confirmButtonText: 'Comenzar',
    confirmButtonColor: '#7C3AED',
    width: '380px',
    customClass: {
      popup: 'rounded-4 shadow-sm border-0'
    }
  });
});
</script>
@endif

@endsection