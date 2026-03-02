@extends('layouts.admin')

@section('content')

<style>
    .text-purple {
        color: #000000ff;
    }

    .btn-outline-purple {
        color: #6f42c1;
        border-color: #6f42c1;
    }

    .btn-outline-purple:hover {
        background-color: #6f42c1;
        color: white;
    }

    .table-purple th {
        background-color: #726d7bff;
        color: white;
    }
</style>

<div class="container py-4">
    <h2 class="fw-bold mb-4 text-center text-purple">Solicitudes de Productos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($solicitudes->isEmpty())
        <div class="alert alert-info">No hay solicitudes de productos pendientes.</div>
    @else
        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-purple">
                            <tr>
                                <th>Nombre Producto</th>
                                <th>Emprendedora</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Fotos</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudes as $s)
                                <tr>
                                    <td class="fw-semibold">{{ $s->nombreproducto }}</td>
                                    <td>{{ $s->usuario->datosGenerales->nombre ?? 'Sin nombre' }}</td>
                                    <td>{{ $s->descripcion }}</td>
                                    <td>${{ number_format($s->precio, 2) }}</td>
                                    <td>
                                        @php
                                            $fotoArray = $s->fotosproduct;
                                            if (is_string($fotoArray)) {
                                                $fotoArray = json_decode($fotoArray, true);
                                                if (is_string($fotoArray)) {
                                                    $fotoArray = json_decode($fotoArray, true);
                                                }
                                            }
                                        @endphp

                                        @if(is_array($fotoArray) && count($fotoArray) > 0)
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                @foreach($fotoArray as $foto)
                                                    <img src="{{ asset('storage/temp_products/' . $foto) }}" alt="foto"
                                                        width="60" height="60" class="rounded border"
                                                        style="object-fit: cover;">
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">Sin imágenes</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('admin.productos.aceptar', $s->id_temp) }}" class="d-inline form-aceptar">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success me-1 boton-aceptar">
                                                <i class="bi bi-check-circle me-1"></i> Aceptar
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.productos.rechazar', $s->id_temp) }}" class="d-inline form-rechazar">
                                            @csrf
                                            <button type="button"
                                                class="btn btn-sm btn-danger boton-rechazar"
                                                data-action="{{ route('admin.productos.rechazar', $s->id_temp) }}">
                                                <i class="bi bi-x-circle me-1"></i> Rechazar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
