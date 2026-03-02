@extends('layouts.admin')

@section('styles')
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    <!-- Custom CSS -->
<style>
    .card-form {
        border-radius: 15px;
        border: none;
        box-shadow: 0 6px 15px rgba(106, 17, 203, 0.1);
        overflow: hidden;
    }
    .form-header {
        background: linear-gradient(135deg, #726d7bff 0%, #726d7bff 100%);
        color: white;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: #000000ff;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #d8b4fe;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #9333ea;
        box-shadow: 0 0 0 0.25rem rgba(147, 51, 234, 0.25);
        transform: translateY(-2px);
    }
    .btn-submit {
        background: linear-gradient(135deg, #7e22ce 0%, #9333ea 100%);
        border: none;
        padding: 10px 30px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        color: white;
    }
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(147, 51, 234, 0.3);
        background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
    }
    .section-title {
        color: #000000ff;
        font-weight: 700;
        margin: 1.5rem 0;
        position: relative;
        padding-left: 15px;
    }
    .section-title:before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 70%;
        width: 4px;
        background: #9333ea;
        border-radius: 10px;
    }
    .file-upload-label {
        display: block;
        padding: 30px 15px;
        border: 2px dashed #d8b4fe;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background-color: #faf5ff;
    }
    .file-upload-label:hover {
        border-color: #9333ea;
        background: rgba(147, 51, 234, 0.05);
    }
    .file-upload-label i {
        font-size: 2rem;
        color: #9333ea;
        margin-bottom: 10px;
    }
    .alert-purple {
        background-color: #f3e8ff;
        border-color: #d8b4fe;
        color: #581c87;
    }
    .invalid-feedback {
        color: #9333ea;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="card card-form">
        <div class="form-header">
            <h2 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Nuevo Curso/Taller</h2>
        </div>

        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.cursos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h5 class="section-title">Información Básica</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre del curso/taller</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" value="{{ old('fecha_inicio') }}" required>
                        @error('fecha_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha de fin</label>
                        <input type="date" name="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" value="{{ old('fecha_fin') }}" required>
                        @error('fecha_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="section-title">Detalles del Evento</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Hora</label>
                        <input type="time" name="hora" class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora') }}" required>
                        @error('hora')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Lugar</label>
                        <input type="text" name="lugar" class="form-control @error('lugar') is-invalid @enderror" value="{{ old('lugar') }}" required>
                        @error('lugar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ciudad</label>
                        <select name="ciudad" class="form-select @error('ciudad') is-invalid @enderror" required>
                            <option value="">Selecciona ciudad</option>
                            <option value="Chetumal" @if(old('ciudad') == 'Chetumal') selected @endif>Chetumal</option>
                            <option value="Cancún" @if(old('ciudad') == 'Cancún') selected @endif>Cancún</option>
                            <option value="Playa del Carmen" @if(old('ciudad') == 'Playa del Carmen') selected @endif>Playa del Carmen</option>
                            <option value="Felipe Carrillo Puerto" @if(old('ciudad') == 'Felipe Carrillo Puerto') selected @endif>Felipe Carrillo Puerto</option>
                            <option value="Isla Mujeres" @if(old('ciudad') == 'Isla Mujeres') selected @endif>Isla Mujeres</option>
                            <option value="Tulum" @if(old('ciudad') == 'Tulum') selected @endif>Tulum</option>
                            <option value="Bacalar" @if(old('ciudad') == 'Bacalar') selected @endif>Bacalar</option>
                            <option value="Puerto Morelos" @if(old('ciudad') == 'Puerto Morelos') selected @endif>Puerto Morelos</option>
                            <option value="Cozumel" @if(old('ciudad') == 'Cozumel') selected @endif>Cozumel</option>
                            <option value="Kantunilkín" @if(old('ciudad') == 'Kantunilkín') selected @endif>Kantunilkín</option>
                            <option value="Calderitas" @if(old('ciudad') == 'Calderitas') selected @endif>Calderitas</option>
                            <option value="Ucum" @if(old('ciudad') == 'Ucum') selected @endif>Ucum</option>
                        </select>
                        @error('ciudad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="section-title">Información Adicional</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                            <option value="">Selecciona</option>
                            <option value="Constancia" @if(old('tipo') == 'Constancia') selected @endif>Constancia</option>
                        
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Facilitador(a)</label>
                        <input type="text" name="facilitador" class="form-control @error('facilitador') is-invalid @enderror" value="{{ old('facilitador') }}">
                        @error('facilitador')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Duración (horas)</label>
                        <input type="number" name="duracion" class="form-control @error('duracion') is-invalid @enderror" value="{{ old('duracion') }}">
                        @error('duracion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="section-title">Configuración</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Modalidad</label>
                        <select name="modalidad" class="form-select @error('modalidad') is-invalid @enderror" required>
                            <option value="">Selecciona</option>
                            <option value="presencial" @if(old('modalidad') == 'presencial') selected @endif>Presencial</option>
                            <option value="en línea" @if(old('modalidad') == 'en línea') selected @endif>En línea</option>
                       
                        </select>
                        @error('modalidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                            <option value="pendiente" @if(old('estado') == 'pendiente') selected @endif>Pendiente</option>
                            <option value="aceptado" @if(old('estado') == 'aceptado') selected @endif>Aceptado</option>
                          
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Número de grupos</label>
                        <input type="number" name="num_grupos" class="form-control @error('num_grupos') is-invalid @enderror" min="1" value="{{ old('num_grupos', 1) }}" required>
                        @error('num_grupos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="section-title">Horarios y Documentos</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Horarios de los grupos</label>
                        <textarea name="horarios" class="form-control @error('horarios') is-invalid @enderror" rows="3" placeholder="Ej: Grupo 1: 10:00-12:00 | Grupo 2: 12:00-14:00">{{ old('horarios') }}</textarea>
                        @error('horarios')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Temario (PDF)</label>
                        <label for="temario" class="file-upload-label">
                            <i class="fas fa-file-pdf"></i>
                            <span class="d-block">Seleccionar archivo PDF</span>
                            <small class="text-muted">Tamaño máximo: 5MB</small>
                        </label>
                        <input type="file" name="temario" id="temario" class="d-none" accept=".pdf">
                        @error('temario')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Flyer promocional</label>
                        <label for="flyer" class="file-upload-label">
                            <i class="fas fa-image"></i>
                            <span class="d-block">Seleccionar imagen</span>
                            <small class="text-muted">Formatos: JPG, PNG</small>
                        </label>
                        <input type="file" name="flyer" id="flyer" class="d-none" accept="image/*">
                        @error('flyer')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="section-title">Descripción del Curso</h5>
                <div class="mb-4">
                    <label class="form-label">Descripción/Contenido</label>
                    <textarea name="descripcion" class="form-control summernote @error('descripcion') is-invalid @enderror" rows="4">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-submit rounded-pill">
                        <i class="fas fa-save me-2"></i>Guardar curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Summernote
            $('.summernote').summernote({
                height: 250,
                lang: 'es-ES',
                placeholder: 'Escribe la descripción detallada del curso/taller...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });

            // Mostrar nombre de archivo seleccionado
            document.getElementById('temario').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
                const label = this.previousElementSibling;
                label.querySelector('span').textContent = fileName;
            });

            document.getElementById('flyer').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
                const label = this.previousElementSibling;
                label.querySelector('span').textContent = fileName;
            });

            // Validación de fechas
            const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
            const fechaFin = document.querySelector('input[name="fecha_fin"]');

            fechaInicio.addEventListener('change', function() {
                if (fechaFin.value && this.value > fechaFin.value) {
                    fechaFin.value = this.value;
                }
                fechaFin.min = this.value;
            });

            fechaFin.addEventListener('change', function() {
                if (this.value < fechaInicio.value) {
                    this.value = fechaInicio.value;
                }
            });
        });
    </script>
@endsection