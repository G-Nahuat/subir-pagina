@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-purple">Perfil del Vendedor</h1>

        <p class="text-muted">Conoce su emprendimiento y productos destacados</p>

        {{-- Mostrar el nombre del vendedor --}}
        @if($vendedor)
            <h4 class="text-purple fw-semibold">
                Vendedor: {{ $vendedor->nombre }} {{ $vendedor->apellido_paterno }} {{ $vendedor->apellido_materno }}
            </h4>
            <p class="text-muted">{{ $vendedor->email }}</p>
        @endif

        {{-- Botón para regresar al catálogo --}}
        <a href="{{ route('emprendimientos.catalogo') }}" class="btn btn-outline-purple mt-3">
            ← Volver al catálogo
        </a>

        <hr>
    </div>

    {{-- Emprendimientos --}}
    <h3 class="mb-4 text-purple">Emprendimiento</h3>
    <div class="row">
        @foreach($emprendimientos as $e)
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                           @if($e->logo)
                                <img src="{{ asset('storage/images/emprendimientos/' . $e->logo) }}" 
                                    class="img-fluid rounded-start-4 h-100" 
                                    style="object-fit: cover; min-height: 200px;" 
                                    alt="Logo del emprendimiento">
                            @else
                                <div class="bg-purple text-white text-center d-flex align-items-center justify-content-center rounded-start-4" style="min-height: 200px;">
                                    <strong>Sin Imagen</strong>
                                </div>
                            @endif

                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="card-title text-purple">{{ $e->nombre }}</h4>
                                <p class="card-text text-muted">{{ $e->descripcion }}</p>
                                <div class="text-muted small">
                                    <p class="mb-0"><strong>Teléfono:</strong> {{ $e->telefono ?? 'No disponible' }}</p>
                                    <p class="mb-0">
                                        <strong>Municipio:</strong>
                                        {{ optional($e->datosGenerales->municipio)->municipio ?? 'No asignado' }}
                                    </p>
                                    <p class="mb-0"><strong>Ubicación:</strong> {{ $e->ubicacion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Productos --}}
    <h3 class="mt-5 mb-4 text-purple">Productos</h3>
    <div class="row">
        @forelse($productos as $p)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-purple">{{ $p->nombreproducto }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ $p->descripcion }}</p>
                        <div class="text-end">
                           {{-- Mostrar el precio si existe --}}
                    @if(!is_null($p->precio))
                        <p class="text-end fw-bold text-purple mb-2">Precio: ${{ number_format($p->precio, 2) }}</p>
                    @endif
                
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No hay productos registrados por este vendedor.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Estilos para el morado personalizado --}}
<style>
    .text-purple {
        color: #6f42c1 !important;
    }
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    .btn-outline-purple {
        color: #6f42c1;
        border-color: #6f42c1;
        transition: all 0.3s ease;
    }
    .btn-outline-purple:hover {
        background-color: #6f42c1;
        color: white;
        border-color: #6f42c1;
    }
</style>
@endsection