@extends('layouts.admin')

@section('content')
<style>
    .text-purple {
        color: #6f42c1;
    }
</style>

<div class="container py-4">
    <h2 class="fw-bold text-center text-purple mb-4">Detalle de la Solicitud de Emprendimiento</h2>

    <div class="card shadow-sm p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Nombre del Emprendimiento:</strong><br>
                    {{ $solicitud->nombre_emprendimiento ?? '—' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Nombre Comercial:</strong><br>
                    {{ $solicitud->nombre_comercial ?? '—' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Teléfono:</strong><br>
                    {{ $solicitud->telefono ?? '—' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Redes Sociales:</strong><br>
                    {{ $solicitud->redes ?? '—' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Ubicación:</strong><br>
                    {{ $solicitud->ubicacion ?? '—' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Estado:</strong><br>
                    {{ ucfirst($solicitud->estado) }}
                </div>
            </div>

            <div class="col-md-12">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Descripción:</strong><br>
                    {{ $solicitud->descripcion ?? '—' }}
                </div>
            </div>

            @if($solicitud->logo)
            <div class="col-md-12 text-center">
                <div class="bg-light p-3 rounded shadow-sm">
                    <strong>Logo del emprendimiento:</strong><br>
                    <img src="{{ asset('storage/emprendimientos_temp/' . $solicitud->logo) }}"
                         alt="Logo del emprendimiento"
                         class="img-fluid mt-2 rounded"
                         style="max-height: 150px;">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
