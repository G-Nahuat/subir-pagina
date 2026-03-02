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
    <h2 class="fw-bold mb-4 text-center text-purple">Lista de Emprendimientos</h2>

    <div class="card shadow border-0 rounded-4 p-4">
        {{-- Alertas ocultas para SweetAlert --}}
        @if(session('eliminado'))
            <div id="mensaje-alerta" data-tipo="success" data-titulo="¡Eliminado!" data-texto="El emprendimiento fue eliminado correctamente."></div>
        @endif

        @if(session('creado'))
            <div id="mensaje-alerta" data-tipo="success" data-titulo="¡Registrado!" data-texto="El emprendimiento fue registrado exitosamente."></div>
        @endif

        @if(session('actualizado'))
            <div id="mensaje-alerta" data-tipo="success" data-titulo="¡Actualizado!" data-texto="El emprendimiento fue actualizado correctamente."></div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-purple">
                    <tr>
                        <th>Nombre del Emprendimiento</th>
                        <th>Nombre del Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emprendimientos as $emprendimiento)
                        <tr>
                            <td>{{ $emprendimiento->emprendimiento ?? 'Sin nombre' }}</td>
                            <td>
                                {{ $emprendimiento->usuario->datosGenerales->nombre ?? 'Sin nombre' }}
                                {{ $emprendimiento->usuario->datosGenerales->apellido_paterno ?? '' }}
                                {{ $emprendimiento->usuario->datosGenerales->apellido_materno ?? '' }}
                            </td>
                            <td>
                                <a href="{{ url('admin/emprendimientos/' . $emprendimiento->id_emprendimiento) }}"
                                   class="btn btn-sm btn-outline-purple me-1">
                                    <i class="bi bi-eye"></i> Ver
                                </a>

                                <form action="{{ url('admin/emprendimientos/' . $emprendimiento->id_emprendimiento) }}"
                                      method="POST"
                                      class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
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
@endsection