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
    <h2 class="fw-bold mb-4 text-center text-purple">Solicitudes de Emprendimientos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($solicitudes->isEmpty())
        <div class="alert alert-info">No hay solicitudes de emprendimientos pendientes.</div>
    @else
        <div class="card shadow border-0 rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-purple">
                        <tr>
                            <th>Nombre del Emprendimiento</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->nombre_emprendimiento }}</td>
                            <td>
                                {{ $solicitud->usuario->datosGenerales->nombre ?? 'Sin nombre' }}
                                {{ $solicitud->usuario->datosGenerales->apellido_paterno ?? '' }}
                                {{ $solicitud->usuario->datosGenerales->apellido_materno ?? '' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.emprendimientos.solicitud.ver', $solicitud->id_temp) }}"
                                   class="btn btn-sm btn-outline-purple me-1">
                                    <i class="bi bi-eye"></i> Ver
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.emprendimientos.solicitud.aceptar', $solicitud->id_temp) }}"
                                      class="d-inline form-aceptar">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check-circle"></i> Aceptar
                                    </button>
                                </form>

                                <form action="{{ url('admin/emprendimientos/solicitud/' . $solicitud->id_temp . '/rechazar') }}"
                                      method="POST"
                                      class="d-inline form-rechazar">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x-circle"></i> Rechazar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
