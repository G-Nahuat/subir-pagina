@extends('layouts.admin')

@section('content')

<style>
    .form-label {
        font-weight: 600;
        color: #5a5a5a;
    }

    .btn-morado {
        background-color: #6f42c1;
        color: white;
        font-weight: 600;
        border-radius: 0.6rem;
        padding: 8px 20px;
        transition: all 0.2s ease-in-out;
    }

    .btn-morado:hover {
        background-color: #5e35b1;
        transform: scale(1.03);
    }

    .form-control, .form-select {
        border-radius: 0.65rem;
    }

    #map {
        border-radius: 0.8rem;
        overflow: hidden;
        border: 1px solid #ccc;
    }
</style>

<div class="container mt-5">
    <h2 class="fw-bold text-purple mb-4"><i data-lucide="calendar-plus" class="lucide me-2"></i>Registrar Nuevo Evento</h2>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <form id="formEvento" action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="lugar" class="form-label">Lugar</label>
                    <input type="text" name="lugar" id="lugar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="hora_inicio" class="form-label">Hora de inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="hora_fin" class="form-label">Hora de fin</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="delegacion" class="form-label">Municipio</label>
                    <select name="delegacion" id="delegacion" class="form-select select2" required>
                        <option value="">Selecciona una opción</option>
                        @foreach(['Benito Juárez', 'Solidaridad', 'Othón P. Blanco', 'Cozumel', 'Isla Mujeres', 'Felipe Carrillo Puerto', 'Lázaro Cárdenas', 'José María Morelos', 'Bacalar', 'Puerto Morelos', 'Tulum'] as $muni)
                            <option value="{{ $muni }}">{{ $muni }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Evento</label>
                    <select name="tipo" id="tipo" class="form-select select2" required>
                        <option value="">Selecciona tipo</option>
                        <option value="Exposición">Exposición</option>
                        <option value="Venta">Venta</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Promocional (opcional)</label>
                    <input type="file" name="fotos" id="fotos" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Selecciona la ubicación en el mapa:</label>
                    <div id="map" style="height: 400px;"></div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>

                <div class="text-end mt-4">
                    <button type="button" class="btn btn-morado me-2" id="btnGuardar">
                        <i data-lucide="save"></i> Guardar Evento
                    </button>
                    <a href="{{ route('admin.eventos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- jQuery (necesario para Select2 y SweetAlert) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Leaflet + Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Mapa Leaflet
    var map = L.map('map').setView([18.5036, -88.3054], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var chetumalBounds = L.latLngBounds(
        [18.4500, -88.3500],
        [18.5500, -88.2500]
    );

    var marker;

    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false,
        bounds: chetumalBounds
    }).on('markgeocode', function(e) {
        var center = e.geocode.center;
        map.setView(center, 16);

        if (marker) {
            marker.setLatLng(center);
        } else {
            marker = L.marker(center).addTo(map);
        }

        document.getElementById('latitude').value = center.lat;
        document.getElementById('longitude').value = center.lng;
    }).addTo(map);

    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    // Lucide
    lucide.createIcons();

    // Select2
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Selecciona una opción'
        });
    });
console.log("Botón presionado");

    // Validación de campos con alertas
    document.getElementById('btnGuardar').addEventListener('click', function () {
        const descripcion = document.getElementById('descripcion').value.trim();
        const lugar = document.getElementById('lugar').value.trim();
        const fecha = document.getElementById('fecha').value;
        const horaInicio = document.getElementById('hora_inicio').value;
        const horaFin = document.getElementById('hora_fin').value;
        const delegacion = document.getElementById('delegacion').value;
        const tipo = document.getElementById('tipo').value;

        if (!descripcion || !lugar || !fecha || !horaInicio || !horaFin || !delegacion || !tipo) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, completa todos los campos requeridos antes de guardar.',
                confirmButtonColor: '#6f42c1'
            });
            return;
        }

        Swal.fire({
            title: '¿Deseas guardar este evento?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#6f42c1',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEvento').submit();
            }
        });
    });
</script>
@endsection
