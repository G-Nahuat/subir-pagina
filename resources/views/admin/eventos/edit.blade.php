@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5 animate__animated animate__fadeIn">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
        <h2 class="fw-bold text-purple mb-4">
            <i class="fas fa-calendar-edit me-2 text-gradient"></i>Editar Evento
        </h2>

        <form id="form-editar-evento" action="{{ route('admin.eventos.update', $evento->id_evento) }}" method="POST" enctype="multipart/form-data" class="animate__animated animate__fadeInUp">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Descripción</label>
                    <input type="text" name="descripcion" class="form-control form-control-lg shadow-sm" value="{{ $evento->descripcion }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Lugar</label>
                    <input type="text" name="lugar" class="form-control form-control-lg shadow-sm" value="{{ $evento->lugar }}" required>
                </div>

                @php
                    $horas = explode('-', $evento->horario);
                    $hora_inicio = isset($horas[0]) ? date('H:i', strtotime(trim($horas[0]))) : '';
                    $hora_fin = isset($horas[1]) ? date('H:i', strtotime(trim($horas[1]))) : '';
                @endphp

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fecha</label>
                    <input type="date" name="fecha" class="form-control form-control-lg shadow-sm" value="{{ $evento->fecha }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Hora de inicio</label>
                    <input type="time" name="hora_inicio" class="form-control form-control-lg shadow-sm" value="{{ $hora_inicio }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Hora de fin</label>
                    <input type="time" name="hora_fin" class="form-control form-control-lg shadow-sm" value="{{ $hora_fin }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Municipio</label>
                    <select name="delegacion" class="form-select form-select-lg select2 shadow-sm">
                        @foreach(['Benito Juárez', 'Solidaridad', 'Othón P. Blanco', 'Cozumel', 'Isla Mujeres', 'Felipe Carrillo Puerto', 'Lázaro Cárdenas', 'José María Morelos', 'Bacalar', 'Puerto Morelos', 'Tulum'] as $muni)
                            <option value="{{ $muni }}" {{ $evento->delegacion === $muni ? 'selected' : '' }}>{{ $muni }}</option>
                        @endforeach
                        @if(!in_array($evento->delegacion, ['Benito Juárez', 'Solidaridad', 'Othón P. Blanco', 'Cozumel', 'Isla Mujeres', 'Felipe Carrillo Puerto', 'Lázaro Cárdenas', 'José María Morelos', 'Bacalar', 'Puerto Morelos', 'Tulum']))
                            <option value="{{ $evento->delegacion }}" selected>{{ $evento->delegacion }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo</label>
                    <select name="tipo" class="form-select form-select-lg select2 shadow-sm">
                        @foreach(['Exposición', 'Venta'] as $tipo)
                            <option value="{{ $tipo }}" {{ $evento->tipo === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                        @if(!in_array($evento->tipo, ['Exposición', 'Venta']))
                            <option value="{{ $evento->tipo }}" selected>{{ $evento->tipo }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Foto promocional (opcional)</label><br>
                    @if($evento->fotos)
                        <img src="{{ asset('storage/eventos/' . $evento->fotos) }}" width="150" class="rounded shadow-sm mb-2"><br>
                    @endif
                    <input type="file" name="fotos" class="form-control form-control-lg shadow-sm">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold mb-2">Ubicación</label>
                    <div id="map" style="height: 400px; border-radius: 0.5rem; overflow: hidden;"></div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ $evento->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $evento->longitude }}">
                </div>
            </div>

            <div class="mt-5 text-end">
                <button id="confirmarCambios" type="button" class="btn btn-success btn-lg px-5 py-2 rounded-pill fw-semibold shadow animate__animated animate__pulse animate__infinite">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Select2 + Animate.css -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('confirmarCambios').addEventListener('click', function () {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Este cambio actualizará los datos del evento.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-editar-evento').submit();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('map').setView([{{ $evento->latitude ?? 18.5036 }}, {{ $evento->longitude ?? -88.3054 }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const marker = L.marker([{{ $evento->latitude ?? 18.5036 }}, {{ $evento->longitude ?? -88.3054 }}]).addTo(map);

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });

        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Selecciona una opción'
        });
    });
</script>
@endsection
