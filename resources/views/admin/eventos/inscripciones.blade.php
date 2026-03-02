@extends('layouts.admin')

@section('content')
<style>
    .table thead th {
        background-color: #6f42c1;
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

<div class="container py-4">
    <h2 class="fw-bold text-purple mb-4">
        <i data-lucide="users" class="lucide me-2"></i> Inscripciones a Eventos
    </h2>

    @if($inscripciones->isEmpty())
        <div class="alert alert-info shadow-sm rounded-3">
            <i class="bi bi-info-circle-fill me-2"></i> No hay inscripciones registradas.
        </div>
    @else
        <div class="table-responsive shadow rounded-3">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th><i data-lucide="user" class="lucide me-1"></i> Nombre</th>
                        <th><i data-lucide="badge-check" class="lucide me-1"></i> CURP</th>
                        <th><i data-lucide="phone" class="lucide me-1"></i> Teléfono</th>
                        <th><i data-lucide="mail" class="lucide me-1"></i> Email</th>
                        <th><i data-lucide="calendar" class="lucide me-1"></i> Evento</th>
                        <th><i data-lucide="clock" class="lucide me-1"></i> Inscrito el</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscripciones as $i)
                        <tr>
                            <td>{{ $i->nombre_completo }}</td>
                            <td>{{ $i->curp }}</td>
                            <td>{{ $i->telefono }}</td>
                            <td>{{ $i->email }}</td>
                            <td>
                                <span class="badge-evento">
                                    {{ $i->evento->descripcion ?? '–' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($i->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
