@extends('layouts.admin')

@section('content')
<style>
    .table thead th {
        background-color: #726d7bff;
        color: white;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .badge-evento {
        background-color: #e9d8fd;
        color: #5a189a;
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 4px 10px;
    }

    .icon-cell {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .text-purple {
        color: #000000ff;
    }
</style>

<div class="py-4 px-4">
    <h2 class="fw-bold text-center text-purple mb-4">
        <i data-lucide="clipboard-list" class="lucide me-2"></i> Solicitudes de Registro
    </h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-3">{{ session('error') }}</div>
    @endif

    @if($solicitudes->isEmpty())
        <div class="alert alert-info shadow-sm rounded-3">
            <i class="bi bi-info-circle-fill me-2"></i> No hay solicitudes pendientes.
        </div>
    @else
        <div class="table-responsive shadow rounded-3">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th><i data-lucide="user" class="lucide me-1"></i> Nombre</th>
                        <th><i data-lucide="mail" class="lucide me-1"></i> Correo</th>
                        <th><i data-lucide="calendar" class="lucide me-1"></i> Fecha</th>
                        <th class="text-center"><i data-lucide="settings" class="lucide me-1"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $s)
                        @if($s->usuario->registroTemporal)
                        <tr>
                            <td>{{ $s->usuario->registroTemporal->nombre }}</td>
                            <td>{{ $s->usuario->registroTemporal->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($s->fecha_solicitud)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.usuarios.solicitudes.show', $s->id_users) }}" class="btn btn-sm btn-info me-1">
                                    <i data-lucide="eye" class="lucide me-1" style="height: 16px"></i> Ver
                                </a>

                               <form method="POST" action="{{ route('admin.solicitudes.usuarios.aprobar', $s->id_users) }}" class="d-inline">
    @csrf
    <button class="btn btn-sm btn-success me-1">
        <i data-lucide="check" class="lucide me-1" style="height: 16px"></i> Aceptar
    </button>
</form>


                                <form method="POST" action="{{ route('admin.usuarios.solicitudes.reject', $s->id_users) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro que deseas rechazar esta solicitud?')">
                                        <i data-lucide="x" class="lucide me-1" style="height: 16px"></i> Rechazar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
