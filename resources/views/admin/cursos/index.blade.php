@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4" style="color: #000000ff; font-weight: 700;">Lista de CURSOS/TALLERES Registrados</h2>

    <div class="text-end mt-3">
        <a href="{{ route('admin.cursos.create') }}" class="btn" style="background-color: #7c3aed; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
            <i class="fas fa-plus-circle me-1"></i>Agregar Curso/Taller
        </a>
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('admin.cursos.index') }}" class="row g-2 mb-3 mt-3">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text" style="background-color: #ede9fe; color: #5b21b6; border-color: #ddd6fe;">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o ciudad..." value="{{ request('search') }}" style="border-color: #ddd6fe;">
            </div>
        </div>
        <div class="col-md-3">
            <select name="tipo" class="form-control" style="border-color: #ddd6fe;">
                <option value="">Todos los tipos</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="order_by" class="form-control" style="border-color: #ddd6fe;">
                <option value="desc" {{ request('order_by') == 'desc' ? 'selected' : '' }}>Más recientes</option>
                <option value="asc" {{ request('order_by') == 'asc' ? 'selected' : '' }}>Más antiguos</option>
            </select>
        </div>
        <div class="col-md-2 text-end">
            <button type="submit" class="btn w-100" style="background-color: #7c3aed; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
                <i class="fas fa-filter me-1"></i>Filtrar
            </button>
        </div>
    </form>

    <div class="card mt-3" style="border: 1px solid #ddd6fe; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div class="card-body table-responsive">
            <table class="table table-hover text-center align-middle">
                <thead style="background-color: #ede9fe; color: #4c1d95;">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Ciudad</th>
                        <th>Lugar</th>
                        <th>Estado</th>
                        <th>Tipo</th>
                        <th>Flyer</th>
                        <th>Total Inscritos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr style="transition: background-color 0.3s;">
                            <td style="color: #6d28d9; font-weight: 600;">{{ $curso->id }}</td>
                            <td>{{ Str::limit($curso->nombre, 40) }}</td>
                            <td>
                                @php
                                    $fechas = explode(' - ', $curso->fecha);
                                @endphp
                                {{ \Carbon\Carbon::parse(trim($fechas[0]))->format('d/m/Y') }}
                                @if(isset($fechas[1]))
                                    - {{ \Carbon\Carbon::parse(trim($fechas[1]))->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>{{ $curso->ciudad }}</td>
                            <td>{{ $curso->lugar }}</td>
                            <td>
                                @if($curso->estado === 'aceptado')
                                    <span class="badge" style="background-color: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; border-radius: 50px; padding: 4px 12px; font-weight: 500;">
                                        <i class="fas fa-check-circle me-1"></i>Aceptado
                                    </span>
                                @else
                                    <span class="badge" style="background-color: #fef9c3; color: #92400e; border: 1px solid #fef08a; border-radius: 50px; padding: 4px 12px; font-weight: 500;">
                                        <i class="fas fa-clock me-1"></i>Pendiente
                                    </span>
                                @endif
                            </td>
                            <td>{{ $curso->tipo }}</td>
                            <td>
                                @if($curso->flyer)
                                    <a href="{{ asset($curso->flyer) }}" target="_blank" style="display: inline-block; padding: 4px; border: 1px solid #ddd6fe; border-radius: 4px;">
                                        <img src="{{ asset($curso->flyer) }}" style="height: 50px; width: auto;" alt="Flyer" class="rounded">
                                    </a>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="
                                    @if(($curso->asistentes_count ?? 0) == 0)
                                        background-color: #f3f4f6; color: #1f2937; border: 1px solid #e5e7eb;
                                    @elseif(($curso->asistentes_count ?? 0) < 10)
                                        background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;
                                    @else
                                        background-color: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe;
                                    @endif
                                    padding: 4px 12px; border-radius: 50px; font-weight: 500; box-shadow: 0 1px 2px rgba(0,0,0,0.1);
                                ">
                                    <i class="fas fa-users me-1"></i>{{ $curso->asistentes_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.cursos.show', $curso->id) }}" class="btn btn-sm" style="background-color: #7c3aed; color: white; border: none; padding: 4px 12px; border-radius: 6px;">
                                        <i class="fas fa-eye me-1"></i>Ver
                                    </a>
                                    <a href="{{ route('admin.cursos.actualizardetalles', $curso->id) }}" class="btn btn-sm" style="border: 1px solid #7c3aed; color: #7c3aed; background-color: transparent; padding: 4px 12px; border-radius: 6px;">
                                        <i class="fas fa-list me-1"></i>Detalles
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x mb-2" style="color: #a78bfa;"></i>
                                <p style="color: #7c3aed;">No hay cursos registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estilos generales para la tabla */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #4c1d95;
    }
    
    .table th {
        vertical-align: middle;
        padding: 12px;
        font-weight: 600;
    }
    
    .table td {
        vertical-align: middle;
        padding: 12px;
    }
    
    /* Efecto hover para filas */
    .table-hover tbody tr:hover {
        background-color: rgba(124, 58, 237, 0.05);
    }
    
    /* Botón morado */
    .btn-purple {
        background-color: #7c3aed;
        color: white;
        border: none;
        transition: all 0.3s;
    }
    
    .btn-purple:hover {
        background-color: #6d28d9;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
    }
    
    /* Botón outline morado */
    .btn-outline-purple {
        border: 1px solid #7c3aed;
        color: #7c3aed;
        background-color: transparent;
        transition: all 0.3s;
    }
    
    .btn-outline-purple:hover {
        background-color: #7c3aed;
        color: white;
    }
    
    /* Input focus */
    .form-control:focus {
        border-color: #a78bfa;
        box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25);
    }
    
    /* Card styles */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    /* Badge styles */
    .badge {
        display: inline-flex;
        align-items: center;
        font-weight: 500;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
        
        .table th, .table td {
            padding: 8px;
            font-size: 14px;
        }
    }
</style>
@endpush