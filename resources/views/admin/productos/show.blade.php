@extends('layouts.admin')

@section('title', 'Detalle del Usuario')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-center text-purple mb-4">Detalle del Usuario</h2>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div><strong>ID:</strong> {{ $user->id_users }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Registrado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Email:</strong> {{ $user->datosGenerales->email ?? '–' }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>CURP:</strong> {{ $user->datosGenerales->curp ?? '–' }}</div>
                </div>
                <div class="col-md-12">
                    <div><strong>Nombre:</strong>
                        {{ $user->datosGenerales->nombre ?? '' }}
                        {{ $user->datosGenerales->apellido_paterno ?? '' }}
                        {{ $user->datosGenerales->apellido_materno ?? '' }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div><strong>Teléfono:</strong> {{ $user->datosGenerales->telefono ?? '–' }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Entidad:</strong> {{ $user->datosGenerales->estado->nombre ?? '–' }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Municipio:</strong> {{ $user->datosGenerales->municipio->municipio ?? '–' }}</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Nivel de Estudios:</strong> {{ $user->datosGenerales->gradoEstudios->nombre ?? '–' }}</div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-purple">
                    <i class="bi bi-arrow-left"></i> Volver a la lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
