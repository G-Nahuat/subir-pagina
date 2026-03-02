@extends('layouts.admin')

@section('content')

<style>
    .text-purple {
        color: #000000ff;
    }

    .table-purple th {
        background-color: #726d7bff;
        color: white;
    }

    .btn-outline-purple {
        color: #6f42c1;
        border-color: #6f42c1;
    }

    .btn-outline-purple:hover {
        background-color: #6f42c1;
        color: white;
    }
</style>

<div class="container py-4">
    <h2 class="fw-bold text-center text-purple mb-4">Lista de Productos Registrados</h2>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-purple">
                        <tr>
                            <th>Usuario</th>
                            <th>Emprendimiento</th>
                            <th>Nombre del Producto</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td>{{ $producto->usuario->datosGenerales->nombre ?? '—' }}</td>
                                <td>{{ $producto->emprendimiento->nombre ?? '—' }}</td>
                                <td>{{ $producto->nombreproducto }}</td>
                                <td>{{ Str::limit($producto->descripcion, 40) }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($producto->estado) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">No hay productos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
