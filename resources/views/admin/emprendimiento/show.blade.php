@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Detalle del Emprendimiento</h2>

    <div class="card shadow-sm p-4">
        <div class="row mb-2">
            <div class="col-md-6 mb-2">
                <strong>Usuario:</strong>
                {{ $emprendimiento->usuario->datosGenerales->nombre ?? '–' }}
                {{ $emprendimiento->usuario->datosGenerales->apellido_paterno ?? '' }}
                {{ $emprendimiento->usuario->datosGenerales->apellido_materno ?? '' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Teléfono:</strong>
                {{ $emprendimiento->telefono ?? '–' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Nombre del Emprendimiento:</strong>
                {{ $emprendimiento->nombre ?? '–' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Redes Sociales:</strong>
                {{ $emprendimiento->redes ?? '–' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Ubicación:</strong>
                {{ $emprendimiento->ubicacion ?? '–' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Descripción:</strong>
                {{ $emprendimiento->descripcion ?? '–' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Logo:</strong><br>
                @if($emprendimiento->logo)
                    <img src="{{ asset('images/productos/' . $emprendimiento->logo) }}" alt="Logo" width="150">
                @else
                    <em>No disponible</em>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
