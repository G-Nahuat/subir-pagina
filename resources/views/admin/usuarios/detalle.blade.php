@extends('layouts.admin')

@section('hideNavbar')
@endsection

@section('content')

<style>
    .text-purplee {
        color: #000000ff; 
    }
</style>

<div class="container py-4">

    <h2 class="fw-bold mb-4 text-center text-purplee">Detalles de la Solicitud</h2>

    <div class="card shadow border-0 rounded-4 p-4">
        <h4 class="fw-semibold text-purple border-bottom pb-2 mb-4">Datos Generales</h4>

        <div class="row g-3">
            {{-- Nombre --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Nombre:</strong>
                    <div>{{ $registro->nombre }} {{ $registro->apellido_paterno }} {{ $registro->apellido_materno }}</div>
                </div>
            </div>

            {{-- Edad --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Edad:</strong>
                    <div>{{ $registro->edad ?? 'No especificada' }}</div>
                </div>
            </div>

            {{-- CURP --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">CURP:</strong>
                    <div>{{ $registro->curp }}</div>
                </div>
            </div>

            {{-- Municipio --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Municipio:</strong>
                    <div>{{ $registro->municipio->municipio ?? 'Sin municipio' }}</div>
                </div>
            </div>

            {{-- Teléfono --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Teléfono:</strong>
                    <div>{{ $registro->telefono }}</div>
                </div>
            </div>

            {{-- Grado de estudios --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Grado de estudios:</strong>
                    <div>{{ $registro->gradoEstudios->nombre ?? 'Sin grado' }}</div>
                </div>
            </div>

            {{-- Correo --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Correo:</strong>
                    <div>{{ $registro->email }}</div>
                </div>
            </div>

            {{-- Comprobante INE --}}
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <strong class="text-purple">Comprobante INE:</strong>
                    <div>
                        @php
                            $ineArray = json_decode($registro->ine, true);
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
