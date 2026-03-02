@extends('layouts.admin')

@section('title', 'Lista de Usuarios Registrados')

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

    .text-purple {
        color: #000000ff;
    }
</style>

<div class="container py-4">
    <h2 class="fw-bold text-center text-purple mb-4">
        <i data-lucide="users" class="lucide me-2"></i> Lista de Usuarias Registradas
    </h2>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive shadow rounded-3">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-center">
                            <th><i data-lucide="mail" class="lucide me-1"></i> Correo</th>
                            <th><i data-lucide="user" class="lucide me-1"></i> Nombre</th>
                            <th><i data-lucide="badge-check" class="lucide me-1"></i> CURP</th>
                            <th><i data-lucide="calendar" class="lucide me-1"></i> Registrado</th>
                            <th><i data-lucide="eye" class="lucide me-1"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr class="text-center">
                                <td>{{ $u->datosGenerales->email ?? '—' }}</td>
                                <td>
                                    {{ $u->datosGenerales->nombre ?? '' }}
                                    {{ $u->datosGenerales->apellido_paterno ?? '' }}
                                    {{ $u->datosGenerales->apellido_materno ?? '' }}
                                </td>
                                <td>{{ $u->datosGenerales->curp ?? '—' }}</td>
                                <td>{{ $u->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.usuarios.show', $u->id_users) }}" class="btn btn-sm btn-outline-purple">
                                        <i data-lucide="eye" class="lucide me-1" style="height: 16px"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
