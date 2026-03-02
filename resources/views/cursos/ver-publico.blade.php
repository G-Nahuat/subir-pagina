@extends('layouts.app')

@section('title', $curso->nombre)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 bg-white p-4 rounded-3 shadow-lg">
            @php
                // Procesamiento de fechas
                $rangoFechas = explode(' - ', $curso->fecha);
                $fechaInicio = isset($rangoFechas[0]) ? \Carbon\Carbon::parse(trim($rangoFechas[0])) : null;
                $fechaFin = isset($rangoFechas[1]) ? \Carbon\Carbon::parse(trim($rangoFechas[1])) : $fechaInicio;
                $cursoFinalizado = $fechaFin && $fechaFin->isPast();
            @endphp

            <!-- Encabezado con estado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-purple fw-bold mb-0">{{ strip_tags($curso->nombre) }}</h2>
                @if($cursoFinalizado)
                    <span class="badge bg-danger fs-6 py-2 px-3">
                        <i class="fas fa-calendar-times me-1"></i> Finalizado
                    </span>
                @elseif($curso->estado === 'aceptado')
                    <span class="badge bg-success fs-6 py-2 px-3">
                        <i class="fas fa-check-circle me-1"></i> Disponible
                    </span>
                @else
                    <span class="badge bg-warning text-dark fs-6 py-2 px-3">
                        <i class="fas fa-clock me-1"></i> Pendiente
                    </span>
                @endif
            </div>

            <!-- Imagen principal -->
            @if($curso->flyer)
                <div class="text-center mb-4">
                    <img src="{{ asset($curso->flyer) }}" alt="Imagen del curso {{ strip_tags($curso->nombre) }}" 
                         class="img-fluid rounded-3 shadow" style="max-height: 400px; width: 100%; object-fit: cover;">
                </div>
            @endif

            <!-- Tarjetas de información -->
            <div class="row g-4 mb-4">
                <!-- Detalles principales -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-purple fw-bold mb-3">
                                <i class="fas fa-info-circle me-2"></i>Información Básica
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="far fa-calendar-alt text-purple me-2"></i> Fecha:</span>
                                    <span class="fw-medium">
                                        @if($fechaInicio)
                                            {{ $fechaInicio->format('d/m/Y') }}
                                            @if($fechaFin && $fechaFin != $fechaInicio)
                                                - {{ $fechaFin->format('d/m/Y') }}
                                            @endif
                                        @else
                                            Por definir
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-clock text-purple me-2"></i> Horario:</span>
                                    <span class="fw-medium">
                                        @if($curso->hora)
                                            {{ \Carbon\Carbon::parse($curso->hora)->format('h:i A') }}
                                        @else
                                            Por definir
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-hourglass-half text-purple me-2"></i> Duración:</span>
                                    <span class="fw-medium">{{ $curso->duracion ?? 'No especificada' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-chalkboard-teacher text-purple me-2"></i> Modalidad:</span>
                                    <span class="fw-medium">{{ $curso->modalidad ?? 'No especificada' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Detalles de ubicación -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-purple fw-bold mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-building text-purple me-2"></i> Lugar:</span>
                                    <span class="fw-medium">{{ $curso->lugar ?? 'Por definir' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-city text-purple me-2"></i> Ciudad:</span>
                                    <span class="fw-medium">{{ $curso->ciudad ?? 'No especificada' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-user-tie text-purple me-2"></i> Facilitador:</span>
                                    <span class="fw-medium">{{ $curso->facilitador ?? 'Por asignar' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-users text-purple me-2"></i> Grupos:</span>
                                    <span class="fw-medium">{{ $curso->num_grupos ?? '0' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            @if($curso->descripcion)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-purple fw-bold mb-3">
                        <i class="fas fa-align-left me-2"></i>Descripción
                    </h5>
                    <div class="prose">
                        {!! strip_tags($curso->descripcion, '<p><br><ul><ol><li><strong><em><u><h1><h2><h3><h4><h5><h6>') !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Horarios específicos -->
            @if($curso->horarios)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-purple fw-bold mb-3">
                        <i class="fas fa-calendar-alt me-2"></i>Horarios Detallados
                    </h5>
                    <div class="prose">
                        {!! nl2br(e($curso->horarios)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('emprendimientos.catalogo', ['tipo' => ['curso'], 'municipio' => '']) }}" 
   class="btn btn-outline-purple rounded-pill px-4">
    <i class="fas fa-arrow-left me-2"></i> Volver atrás
</a>
                    
                @if(!$cursoFinalizado && $curso->estado === 'aceptado')
                    <a href="{{ route('cursos.inscripcion', $curso->id) }}" class="btn btn-purple rounded-pill px-4">
                        <i class="fas fa-user-plus me-2"></i> Inscribirme
                    </a>
                @else
                    <button class="btn btn-secondary rounded-pill px-4" disabled>
                        <i class="fas fa-ban me-2"></i>
                        {{ $cursoFinalizado ? 'Curso Finalizado' : 'Inscripciones Cerradas' }}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .text-purple { 
        color: #6f42c1 !important; 
    }
    .bg-purple { 
        background-color: #6f42c1 !important; 
    }
    .btn-purple {
        background-color: #6f42c1;
        color: white;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
        transform: translateY(-2px);
    }
    .btn-outline-purple {
        color: #6f42c1;
        border: 2px solid #6f42c1;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-outline-purple:hover {
        background-color: #6f42c1;
        color: white;
    }
    .rounded-3 {
        border-radius: 0.75rem !important;
    }
    .rounded-pill {
        border-radius: 50rem !important;
    }
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .prose {
        line-height: 1.6;
    }
    .prose ul, .prose ol {
        padding-left: 1.5rem;
    }
    .prose li {
        margin-bottom: 0.5rem;
    }
    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15) !important;
    }
</style>
@endsection