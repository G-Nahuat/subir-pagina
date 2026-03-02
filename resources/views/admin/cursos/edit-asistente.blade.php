@extends('layouts.admin')

@section('content')
<style>
    :root {
        --color-purple: #6a0dad;
        --color-purple-dark: #5a0b9d;
        --color-purple-light: #f8f1ff;
        --color-primary: #6a0dad; /* Morado como color primario */
    }
    
    .bg-purple {
        background-color: var(--color-purple);
    }
    .btn-purple {
        background-color: var(--color-purple);
        color: white;
    }
    .btn-purple:hover {
        background-color: var(--color-purple-dark);
        color: white;
    }
    .border-purple {
        border-color: var(--color-purple) !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--color-purple);
        box-shadow: 0 0 0 0.25rem rgba(106, 13, 173, 0.25);
    }
    .form-check-input:checked {
        background-color: var(--color-purple);
        border-color: var(--color-purple);
    }
    .card-shadow {
        box-shadow: 0 0.5rem 1rem rgba(106, 13, 173, 0.15);
    }
    .header-title {
        border-left: 4px solid var(--color-purple);
        padding-left: 10px;
    }
</style>

<div class="container mt-4">
    <div class="card card-shadow border-purple">
        <div class="card-header bg-purple text-white">
            <h3 class="mb-0 header-title">
                Editar participante: <strong>{{ $asistente->nombre }}</strong>
            </h3>
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('admin.asistentes.update', $asistente->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nombre completo *</label>
                        <input type="text" name="nombre" 
                               class="form-control"
                               value="{{ old('nombre', $asistente->nombre) }}"
                               required>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Edad *</label>
                        <input type="number" name="edad" 
                               class="form-control"
                               value="{{ old('edad', $asistente->edad) }}"
                               min="1" required>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono"
                               class="form-control"
                               value="{{ old('telefono', $asistente->telefono) }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="correo"
                               class="form-control"
                               value="{{ old('correo', $asistente->correo) }}">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nombre del tutor (si es menor de edad)</label>
                        <input type="text" name="nombre_tutor"
                               class="form-control"
                               value="{{ old('nombre_tutor', $asistente->tutor_nombre) }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Grupo</label>
                        <input type="text" name="grupo" 
                               class="form-control"
                               value="{{ old('grupo', $asistente->grupo) }}">
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="asistio" name="asistio" value="1"
                                   {{ old('asistio', $asistente->asistio) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="asistio">
                                Asistió al curso
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <a href="{{ route('admin.cursos.show', session('last_curso_id')) }}"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Volver al curso
                        </a>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-purple">
                            <i class="fas fa-save me-2"></i> Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validación de edad para mostrar campos de tutor
document.addEventListener('DOMContentLoaded', function() {
    const edadInput = document.querySelector('input[name="edad"]');
    const tutorFields = document.querySelector('input[name="nombre_tutor"]').closest('.col-md-6');
    
    function checkEdad() {
        const edad = parseInt(edadInput.value);
        if (edad < 18) {
            tutorFields.style.display = 'block';
            document.querySelector('input[name="nombre_tutor"]').required = true;
        } else {
            tutorFields.style.display = 'none';
            document.querySelector('input[name="nombre_tutor"]').required = false;
        }
    }
    
    // Verificar al cargar
    checkEdad();
    
    // Verificar al cambiar
    edadInput.addEventListener('input', checkEdad);
});
</script>

@endsection