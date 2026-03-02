@extends('layouts.admin')

@section('content')

<style>
    .text-purplee {
        color: #000000ff;
    }
</style>
<div class="container py-4">
    

    <a href="{{ url('/admin/usuarios') }}" class="btn btn-outline-purple mb-3">
        <i class="bi bi-arrow-left me-1"></i> Regresar
    </a>

    <h2 class="text-center fw-bold text-purplee mb-4">Detalle de la Usuaria</h2>

    <div class="card shadow border-0 rounded-4 p-4">
        <div class="row g-3">


            <div class="col-md-4">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Edad:</strong>
                    <div>{{ $user->datosGenerales->edad ?? 'No especificada' }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Registrado:</strong>
                    <div>{{ $user->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            {{-- Nombre completo --}}
            <div class="col-12">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Nombre completo:</strong>
                    <div>
                        {{ $user->datosGenerales->nombre ?? '' }}
                        {{ $user->datosGenerales->apellido_paterno ?? '' }}
                        {{ $user->datosGenerales->apellido_materno ?? '' }}
                    </div>
                </div>
            </div>

            {{-- Contacto --}}
            <div class="col-md-6">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Email:</strong>
                    <div>{{ $user->datosGenerales->email ?? '–' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Teléfono:</strong>
                    <div>{{ $user->datosGenerales->telefono ?? '–' }}</div>
                </div>
            </div>

            {{-- Identidad --}}
            <div class="col-md-6">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">CURP:</strong>
                    <div>{{ $user->datosGenerales->curp ?? '–' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Municipio:</strong>
                    <div>{{ $user->datosGenerales->municipio->municipio ?? '–' }}</div>
                </div>
            </div>

            {{-- Escolaridad --}}
            <div class="col-md-6">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Nivel de Estudios:</strong>
                    <div>{{ $user->datosGenerales->gradoEstudios->nombre ?? '–' }}</div>
                </div>
            </div>

            {{-- INE --}}
            <div class="col-md-6">
                <div class="p-3 bg-light  rounded border">
                    <strong class="text-purple">Comprobante INE:</strong>
                    <div>
                        @php
                            $ineArray = json_decode($user->datosGenerales->ine ?? '', true);
                        @endphp
                        @if (!empty($ineArray) && is_array($ineArray))
                            <a href="{{ asset($ineArray[0]) }}" target="_blank">Ver documento</a>
                        @else
                            No disponible
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection