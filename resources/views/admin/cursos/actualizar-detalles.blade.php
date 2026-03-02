@extends('layouts.admin')

@section('content')
<style>
    :root {
        --color-purple: #726d7bff;
        --color-purple-dark: #5a0b9d;
        --color-purple-light: #f8f1ff;
        --color-success: #6a0dad;
        --color-warning: #9c27b0;
        --color-danger: #d81b60;
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
    .btn-outline-purple {
        border-color: var(--color-purple);
        color: var(--color-purple);
    }
    .btn-outline-purple:hover {
        background-color: var(--color-purple);
        color: white;
    }
    .table th {
        background-color: var(--color-purple-light);
    }
    .badge-purple {
        background-color: var(--color-purple);
        color: white;
    }
    .list-group-item.active {
        background-color: var(--color-purple);
        border-color: var(--color-purple);
    }
    .card-shadow {
        box-shadow: 0 0.5rem 1rem rgba(106, 13, 173, 0.15);
    }
    .border-purple {
        border-color: var(--color-purple) !important;
    }
    
    /* Botones con nueva paleta */
    .btn-success {
        background-color: var(--color-success);
        border-color: var(--color-success);
    }
    .btn-success:hover {
        background-color: var(--color-purple-dark);
        border-color: var(--color-purple-dark);
    }
    .btn-outline-success {
        border-color: var(--color-success);
        color: var(--color-success);
    }
    .btn-outline-success:hover {
        background-color: var(--color-success);
        color: white;
    }
    .btn-warning {
        background-color: var(--color-warning);
        border-color: var(--color-warning);
        color: white;
    }
    .btn-outline-warning {
        border-color: var(--color-warning);
        color: var(--color-warning);
    }
    .btn-outline-warning:hover {
        background-color: var(--color-warning);
        color: white;
    }
    .btn-outline-danger {
        border-color: var(--color-danger);
        color: var(--color-danger);
    }
    .btn-outline-danger:hover {
        background-color: var(--color-danger);
        color: white;
    }
    
    /* Barra de búsqueda */
    .search-container {
        position: relative;
        margin-bottom: 1rem;
    }
    .search-container i {
        position: absolute;
        left: 10px;
        top: 10px;
        color: #6c757d;
    }
    .search-input {
        padding-left: 35px;
        border-radius: 20px;
        border: 1px solid #ced4da;
    }
    
    /* Estilos específicos para el formulario */
    .form-section {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-section h5 {
        color: var(--color-purple-dark);
        border-bottom: 2px solid var(--color-purple-light);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        color: var(--color-purple-dark);
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        border: 1px solid #e0e0e0;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--color-purple-light);
        box-shadow: 0 0 0 0.25rem rgba(90, 11, 157, 0.15);
    }
    
    /* Encabezado con imagen */
    .header-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    
    .header-card img {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }
    
    .header-content {
        padding: 1.5rem;
        background-color: white;
    }
    
    .header-content h2 {
        color: var(--color-purple-dark);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    /* Botones de acción */
    .action-buttons {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
</style>

{{-- Encabezado con imagen --}}
<div class="header-card">
    @if($curso->flyer)
        <img src="{{ asset($curso->flyer) }}" alt="Flyer del curso">
    @else
        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
            <span class="text-muted">Sin imagen</span>
        </div>
    @endif
    <div class="header-content">
        <h2>{{ $curso->nombre }}</h2>
        <p class="text-muted mb-0">
            {!! $curso->descripcion ?? 'Sin descripción disponible.' !!}
        </p>
    </div>
</div>

{{-- Formulario de edición completo --}}
<form id="cursoForm" method="POST" action="{{ route('admin.cursos.guardarActualizacionDetalles', $curso->id) }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        {{-- Columna izquierda - Información General --}}
        <div class="col-md-6">
            <div class="form-section">
                <h5><i class="fas fa-info-circle me-2"></i> Información General</h5>
                
                {{-- Nombre del Curso --}}
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Curso *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" 
                           value="{{ old('nombre', $curso->nombre) }}" required>
                </div>
                
                {{-- Fecha --}}
                <div class="mb-3">
                    <label class="form-label">Fecha *</label>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="date" name="fecha_inicio" class="form-control"
                                   value="{{ old('fecha_inicio', $curso->fecha_inicio ?? (isset(explode(' - ', $curso->fecha)[0]) ? explode(' - ', $curso->fecha)[0] : '')) }}" required>
                            <small class="text-muted">Fecha de inicio</small>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="fecha_fin" class="form-control"
                                   value="{{ old('fecha_fin', $curso->fecha_fin ?? (isset(explode(' - ', $curso->fecha)[1]) ? explode(' - ', $curso->fecha)[1] : '')) }}" required>
                            <small class="text-muted">Fecha de fin</small>
                        </div>
                    </div>
                </div>

                {{-- Hora --}}
                <div class="mb-3">
                    <label class="form-label">Hora *</label>
                    <input type="text" name="hora" class="form-control" 
                           value="{{ old('hora', $curso->hora) }}" placeholder="Ej: 10:00 - 14:00" required>
                </div>
                
                {{-- Modalidad --}}
                <div class="mb-3">
                    <label class="form-label">Modalidad *</label>
                    <select name="modalidad" class="form-select" required>
                        <option value="Presencial" {{ (old('modalidad', $curso->modalidad) == 'Presencial') ? 'selected' : '' }}>Presencial</option>
                        <option value="En línea" {{ (old('modalidad', $curso->modalidad) == 'En línea') ? 'selected' : '' }}>En línea</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h5><i class="fas fa-map-marker-alt me-2"></i> Ubicación</h5>
                
                {{-- Lugar --}}
                <div class="mb-3">
                    <label class="form-label">Lugar *</label>
                    <input type="text" name="lugar" class="form-control" 
                           value="{{ old('lugar', $curso->lugar) }}" required>
                </div>

                {{-- Ciudad --}}
                <div class="mb-3">
                    <label class="form-label">Ciudad *</label>
                    <input type="text" name="ciudad" class="form-control" 
                           value="{{ old('ciudad', $curso->ciudad) }}" required>
                </div>
                
                {{-- Horarios --}}
                <div class="mb-3">
                    <label class="form-label">Horarios Detallados</label>
                    <textarea name="horarios" class="form-control" rows="3">{{ old('horarios', $curso->horarios) }}</textarea>
                    <small class="text-muted">Ej: Lunes y Miércoles de 16:00 a 18:00</small>
                </div>
            </div>
        </div>

        {{-- Columna derecha - Detalles Adicionales --}}
        <div class="col-md-6">
            <div class="form-section">
                <h5><i class="fas fa-cog me-2"></i> Configuración</h5>
                
                {{-- Estado --}}
                <div class="mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="pendiente" {{ (old('estado', $curso->estado) == 'pendiente') ? 'selected' : '' }}>Pendiente</option>
                        <option value="aceptado" {{ (old('estado', $curso->estado) == 'aceptado') ? 'selected' : '' }}>Aceptado</option>
                    </select>
                </div>

                {{-- Tipo --}}
                <div class="mb-3">
                    <label class="form-label">Tipo de Certificación *</label>
                    <select name="tipo" class="form-select" required>
                        <option value="Constancia" {{ (old('tipo', $curso->tipo) == 'Constancia') ? 'selected' : '' }}>Constancia</option>
                        <option value="Reconocimiento" {{ (old('tipo', $curso->tipo) == 'Reconocimiento') ? 'selected' : '' }}>Reconocimiento</option>
                    </select>
                </div>

                {{-- Facilitador --}}
                <div class="mb-3">
                    <label class="form-label">Facilitador</label>
                    <input type="text" name="facilitador" class="form-control" 
                           value="{{ old('facilitador', $curso->facilitador ?? '') }}">
                </div>
                
                {{-- Duración --}}
                <div class="mb-3">
                    <label class="form-label">Duración (horas) *</label>
                    <input type="number" name="duracion" class="form-control" min="1"
                           value="{{ old('duracion', $curso->duracion) }}" required>
                </div>

                {{-- Número de Grupos --}}
                <div class="mb-3">
                    <label class="form-label">Número de Grupos *</label>
                    <input type="number" name="num_grupos" class="form-control" min="1"
                           value="{{ old('num_grupos', $curso->num_grupos ?? 1) }}" required>
                </div>
            </div>
            
            <div class="form-section">
                <h5><i class="fas fa-file-alt me-2"></i> Archivos</h5>
                
                {{-- Flyer --}}
                <div class="mb-3">
                    <label class="form-label">Flyer (Imagen)</label>
                    @if($curso->flyer)
                        <div class="mb-2">
                            <a href="{{ asset($curso->flyer) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> Ver imagen actual
                            </a>
                        </div>
                    @endif
                    <input type="file" name="flyer" class="form-control" accept="image/*">
                    <small class="text-muted">Formatos: JPG, PNG. Tamaño máximo: 2MB</small>
                </div>

                {{-- Temario --}}
                <div class="mb-3">
                    <label class="form-label">Temario (PDF)</label>
                    @if($curso->temario)
                        <div class="mb-2">
                            <a href="{{ asset($curso->temario) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> Ver temario actual
                            </a>
                        </div>
                    @endif
                    <input type="file" name="temario" class="form-control" accept="application/pdf">
                    <small class="text-muted">Formato: PDF. Tamaño máximo: 5MB</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    <div class="form-section">
        <h5><i class="fas fa-align-left me-2"></i> Descripción del Curso</h5>
        <textarea name="descripcion" class="form-control summernote" rows="5">{{ old('descripcion', $curso->descripcion) }}</textarea>
    </div>

    {{-- Botones de acción --}}
    <div class="action-buttons">
        <button type="submit" class="btn btn-purple" id="submitBtn">
            <i class="fas fa-save me-1"></i> Guardar Cambios
        </button>
        <a href="{{ route('admin.cursos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-times me-1"></i> Cancelar
        </a>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Inicializar Summernote
    if (typeof inicializarSummernote === 'function') {
        inicializarSummernote();
    }
    
    // Validación de fechas
    const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
    const fechaFin = document.querySelector('input[name="fecha_fin"]');
    
    if (fechaInicio && fechaFin) {
        fechaInicio.addEventListener('change', function() {
            if (this.value && fechaFin.value && this.value > fechaFin.value) {
                fechaFin.value = this.value;
            }
        });
        
        fechaFin.addEventListener('change', function() {
            if (this.value && fechaInicio.value && this.value < fechaInicio.value) {
                Swal.fire({
                    title: 'Error',
                    text: 'La fecha de fin no puede ser anterior a la fecha de inicio',
                    icon: 'error',
                    confirmButtonColor: 'var(--color-purple)'
                });
                this.value = fechaInicio.value;
            }
        });
    }
    
    // Validación de archivos
    const flyerInput = document.querySelector('input[name="flyer"]');
    if (flyerInput) {
        flyerInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) { // 2MB
                Swal.fire({
                    title: 'Archivo demasiado grande',
                    text: 'El flyer no debe exceder los 2MB',
                    icon: 'error',
                    confirmButtonColor: 'var(--color-purple)'
                });
                this.value = '';
            }
        });
    }
    
    const temarioInput = document.querySelector('input[name="temario"]');
    if (temarioInput) {
        temarioInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.type !== 'application/pdf') {
                    Swal.fire({
                        title: 'Formato incorrecto',
                        text: 'El temario debe ser un archivo PDF',
                        icon: 'error',
                        confirmButtonColor: 'var(--color-purple)'
                    });
                    this.value = '';
                } else if (file.size > 5 * 1024 * 1024) { // 5MB
                    Swal.fire({
                        title: 'Archivo demasiado grande',
                        text: 'El temario no debe exceder los 5MB',
                        icon: 'error',
                        confirmButtonColor: 'var(--color-purple)'
                    });
                    this.value = '';
                }
            }
        });
    }
    
    // Interceptar envío del formulario para mostrar confirmación
    const form = document.getElementById('cursoForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario antes de mostrar confirmación
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Mostrar alerta de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas actualizar la información del curso?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--color-purple)',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si confirma, enviar el formulario
                    form.submit();
                }
            });
        });
    }
    
    // Mostrar alerta de éxito si hay un mensaje de sesión
    @if(session('success'))
    Swal.fire({
        title: '¡Actualización exitosa!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: 'var(--color-purple)'
    });
    @endif
    
    // Mostrar alerta de error si hay errores de validación
    @if($errors->any())
    Swal.fire({
        title: 'Error de validación',
        text: 'Por favor, revisa los campos marcados en rojo',
        icon: 'error',
        confirmButtonColor: 'var(--color-purple)'
    });
    @endif
});
</script>
@endsection