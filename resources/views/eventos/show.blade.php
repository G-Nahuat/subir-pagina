@extends('layouts.app')

@section('title', 'Detalles del Evento')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 bg-white p-4 rounded-3 shadow-lg">
            @php
                $ahora = \Carbon\Carbon::now();
                $fechaEvento = \Carbon\Carbon::parse($evento->fecha);
                $horas = explode('-', $evento->horario);
                $inicio = isset($horas[0]) ? trim($horas[0]) : '12:00 AM';
                $fin = isset($horas[1]) ? trim($horas[1]) : '11:59 PM';
                $inicioEvento = \Carbon\Carbon::parse($evento->fecha . ' ' . $inicio);
                $finEvento = \Carbon\Carbon::parse($evento->fecha . ' ' . $fin);
                $ocurriendoAhora = $ahora->between($inicioEvento, $finEvento) && $fechaEvento->isToday();
                $eventoFinalizado = $finEvento->lt($ahora);
            @endphp

            <!-- Encabezado con estado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-purple fw-bold mb-0">{{ $evento->descripcion }}</h2>
                @if($ocurriendoAhora)
                    <span class="badge bg-success fs-6 py-2 px-3">
                        <i class="fas fa-bullhorn me-1"></i> ¡Ocurriendo ahora!
                    </span>
                @elseif($eventoFinalizado)
                    <span class="badge bg-danger fs-6 py-2 px-3">
                        <i class="fas fa-calendar-times me-1"></i> Finalizado
                    </span>
                @else
                    <span class="badge bg-primary fs-6 py-2 px-3">
                        <i class="fas fa-calendar-check me-1"></i> Próximo
                    </span>
                @endif
            </div>

            <!-- Imagen principal -->
            @if(!empty($evento->fotos))
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/eventos/' . $evento->fotos) }}" alt="Imagen del evento" 
                         class="img-fluid rounded-3 shadow" style="max-height: 400px; width: 100%; object-fit: cover;">
                </div>
            @else
                <div class="text-center mb-4">
                    <img src="{{ asset('images/default-event.jpg') }}" alt="Sin imagen" 
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
                                <i class="fas fa-info-circle me-2"></i>Información del Evento
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="far fa-calendar-alt text-purple me-2"></i> Fecha:</span>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-clock text-purple me-2"></i> Horario:</span>
                                    <span class="fw-medium">{{ $evento->horario }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-tags text-purple me-2"></i> Tipo:</span>
                                    <span class="fw-medium">{{ $evento->tipo }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-building text-purple me-2"></i> Municipio:</span>
                                    <span class="fw-medium">{{ $evento->delegacion }}</span>
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
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-pin text-purple me-2"></i>
                                        <span class="fw-medium">{{ $evento->lugar }}</span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if($evento->latitude && $evento->longitude)
                                        <a href="https://www.google.com/maps?q={{ $evento->latitude }},{{ $evento->longitude }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-purple rounded-pill">
                                            <i class="fas fa-map-marked-alt me-1"></i> Ver en Maps
                                        </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill" 
                                                onclick="copiarDireccion('{{ $evento->lugar }}')">
                                            <i class="fas fa-copy me-1"></i> Copiar dirección
                                        </button>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div id="map" style="height: 200px;" class="rounded-3"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-purple rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i> Volver atrás
                </a>
                
                @if(!$eventoFinalizado && !$ocurriendoAhora)
                    <button class="btn btn-purple rounded-pill px-4">
                        <i class="fas fa-calendar-plus me-2"></i> Participar
                    </button>
                @elseif($ocurriendoAhora)
                @else
                    <button class="btn btn-secondary rounded-pill px-4" disabled>
                        <i class="fas fa-ban me-2"></i> Evento finalizado
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const lat = {{ $evento->latitude ?? 0 }};
        const lng = {{ $evento->longitude ?? 0 }};
        const lugar = @json($evento->lugar ?? 'Ubicación no disponible');

        if (lat && lng) {
            const map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`<strong>${lugar}</strong>`)
                .openPopup();
        } else {
            document.getElementById('map').innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
                    <p>Ubicación no disponible</p>
                </div>`;
        }
    });

    function copiarDireccion(direccion) {
        navigator.clipboard.writeText(direccion)
            .then(() => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Copiado!',
                    text: 'La dirección se copió al portapapeles',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo copiar la dirección',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500
                });
            });
    }
</script>


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
    #map {
        min-height: 200px;
        background-color: #f8f9fa;
    }
</style>
@endsection