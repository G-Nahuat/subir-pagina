@extends('layouts.admin')

@section('content')

<!-- Estilos -->
<style>
    .btn-morado {
        background-color: #6f42c1;
        color: #fff;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 0.75rem;
        border: none;
        transition: all 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-morado:hover {
        background-color: #5e35b1;
        transform: scale(1.05);
    }

    .evento-info-label {
        font-weight: 600;
        color: #000000ff;
    }

    .evento-info-text {
        font-weight: 500;
        color: #333;
    }

    .evento-detalle-card {
        border-radius: 1rem;
        background: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        animation: fadeIn 0.6s ease-in-out;
    }

    .img-preview {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        max-width: 500px; /* Tamaño aumentado */
        width: 100%;
        height: auto;
        display: block;
        margin: 1rem auto;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .lucide {
        width: 18px;
        height: 18px;
        stroke-width: 2;
        vertical-align: text-bottom;
    }
</style>

<div class="container my-5">
    <h2 class="text-center fw-bold text-purple mb-4 animate__animated animate__fadeInDown">
        <i data-lucide="calendar-days" class="lucide me-1"></i> Detalle del Evento
    </h2>

    <div class="evento-detalle-card">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><span class="evento-info-label"><i data-lucide="calendar"></i> Fecha:</span> <span class="evento-info-text">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</span></p>
            </div>
            <div class="col-md-6">
                <p><span class="evento-info-label"><i data-lucide="map-pin"></i> Lugar:</span> <span class="evento-info-text">{{ $evento->lugar }}</span></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><span class="evento-info-label"><i data-lucide="file-text"></i> Descripción:</span> <span class="evento-info-text">{{ $evento->descripcion }}</span></p>
            </div>
            <div class="col-md-6">
                <p><span class="evento-info-label"><i data-lucide="clock"></i> Horario:</span> <span class="evento-info-text">{{ $evento->horario }}</span></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><span class="evento-info-label"><i data-lucide="compass"></i> Municipio:</span> <span class="evento-info-text">{{ $evento->delegacion }}</span></p>
            </div>
            <div class="col-md-6">
                <p><span class="evento-info-label"><i data-lucide="bookmark"></i> Tipo:</span> <span class="evento-info-text">{{ $evento->tipo }}</span></p>
            </div>
        </div>

        <div class="mb-4">
            <p class="evento-info-label"><i data-lucide="image"></i> Foto Promocional:</p>
            @if($evento->fotos)
                <img src="{{ asset('storage/eventos/' . $evento->fotos) }}" alt="Foto del evento" class="img-preview mt-2">
            @else
                <p class="text-muted">No hay imagen disponible.</p>
            @endif
        </div>

        <div class="d-flex justify-content-end gap-3 mt-4">
            <a href="{{ route('admin.eventos.edit', $evento->id_evento) }}" class="btn btn-morado">
                <i data-lucide="pencil-line"></i> Editar
            </a>

            <form action="{{ route('admin.eventos.destroy', $evento->id_evento) }}" method="POST" id="formEliminar">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-semibold" onclick="confirmarEliminacion()">
                    <i data-lucide="trash-2"></i> Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    function confirmarEliminacion() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el evento de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEliminar').submit();
            }
        });
    }
</script>
@endsection
