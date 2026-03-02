@extends('layouts.admin')

@section('content')

<!-- Estilos personalizados -->
<style>
    .btn-morado {
        background-color: #6f42c1;
        color: #fff;
        font-weight: 600;
        border-radius: 0.65rem;
        padding: 8px 20px;
        transition: all 0.3s ease-in-out;
    }

    .btn-morado:hover {
        background-color: #5e35b1;
        transform: scale(1.05);
    }

    .table thead th {
        background-color: #f5f5fa;
        color: #5a5a5a;
        font-weight: 600;
    }

    .icon-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .form-control,
    .form-select {
        border-radius: 0.65rem;
    }

    .filter-section {
        border: 1px solid #eee;
        background-color: #f9f9fc;
        padding: 1rem;
        border-radius: 1rem;
        margin-bottom: 1rem;
    }

    .lucide {
        width: 18px;
        height: 18px;
        stroke-width: 2;
        vertical-align: middle;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-purple">
            <i data-lucide="list" class="lucide me-1"></i> Lista de Eventos Registrados
        </h2>

        <a href="{{ route('admin.eventos.create') }}" class="btn btn-morado">
            <i data-lucide="plus-circle"></i> Agregar Evento
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.eventos.index') }}" class="row filter-section g-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Buscar descripción..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="tipo" class="form-select">
                <option value="">Todos los tipos</option>
                @foreach($tipos ?? [] as $tipo)
                    <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="order_by" class="form-select">
                <option value="desc" {{ request('order_by') == 'desc' ? 'selected' : '' }}>Más recientes</option>
                <option value="asc" {{ request('order_by') == 'asc' ? 'selected' : '' }}>Más antiguos</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">
                <i data-lucide="filter"></i> Filtrar
            </button>
        </div>
    </form>

    {{-- Tabla de eventos --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle text-center mb-0">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Lugar</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Municipio</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventos as $evento)
                        <tr>
                            <td>{{ Str::limit($evento->descripcion, 30) }}</td>
                            <td>{{ $evento->lugar }}</td>
                            <td>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $evento->horario }}</td>
                            <td>{{ $evento->delegacion }}</td>
                            <td>{{ $evento->tipo }}</td>
                            <td>
                                <a href="{{ route('admin.eventos.show', $evento->id_evento) }}" class="btn btn-outline-primary btn-sm icon-btn">
                                    <i data-lucide="eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">No hay eventos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
