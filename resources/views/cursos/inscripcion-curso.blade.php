@extends('layouts.app')

@section('title', 'Inscripción al curso')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #5a2a83;
            --color-primary-light: #7a4b9e;
            --color-primary-dark: #4a226c;
            --color-secondary: #f8f9fa;
            --color-accent: #e9e2f1;
            --color-text: #333333;
            --color-border: #dee2e6;
        }
        
        .card-inscripcion {
            border-radius: 8px;
            border: 1px solid var(--color-border);
            box-shadow: 0 4px 12px rgba(90, 42, 131, 0.08);
            overflow: hidden;
            background-color: white;
        }
        
        .card-header-inscripcion {
            background-color: var(--color-primary);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--color-primary-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-control, .form-select {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid var(--color-border);
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--color-primary-light);
            box-shadow: 0 0 0 0.2rem rgba(90, 42, 131, 0.15);
        }
        
        .input-group-text {
            background-color: var(--color-accent);
            color: var(--color-primary);
            border: 1px solid var(--color-border);
            border-right: none;
        }
        
        .btn-inscribir {
            background-color: var(--color-primary);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.2s;
            color: white;
            border-radius: 6px;
        }
        
        .btn-inscribir:hover {
            background-color: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(90, 42, 131, 0.2);
        }
        
        .btn-volver {
            border-color: var(--color-primary-light);
            color: var(--color-primary);
            border-radius: 6px;
        }
        
        .btn-volver:hover {
            background-color: var(--color-accent);
            border-color: var(--color-primary);
            color: var(--color-primary-dark);
        }
        
        .seccion-tutor {
            background-color: var(--color-accent);
            border-left: 3px solid var(--color-primary-light);
        }
        
        .alert-success {
            border-left: 4px solid var(--color-primary);
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
        }
        
        .texto-destacado {
            color: var(--color-primary);
        }
    </style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Tarjeta principal -->
            <div class="card card-inscripcion">
                <!-- Encabezado -->
                <div class="card-header-inscripcion">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="h4 mb-1">Inscripción al curso</h2>
                            <p class="mb-0 opacity-75">{{ $curso->nombre }}</p>
                        </div>
                    </div>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="formInscripcion" action="{{ route('cursos.inscripcion.guardar', $curso->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="id_curso" value="{{ $curso->id }}">

                        <div class="mb-4">
                            <label for="nombre_participante" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="nombre_participante" name="nombre_participante" required>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa tu nombre completo
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="edad" class="form-label">Edad <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-cake-candles"></i></span>
                                <input type="number" class="form-control" id="edad" name="edad" required min="1">
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa tu edad
                            </div>
                        </div>

                        <!-- Sección dinámica -->
                        <div id="mayorEdad"></div>

                        <!-- Sección para menores -->
                        <div id="menor" class="p-3 rounded mb-4 seccion-tutor" style="display: none;">
                            <h5 class="mb-3"><i class="fas fa-user-shield me-2"></i>Datos del tutor (para menores de edad)</h5>
                            <div class="mb-3">
                                <label for="nombre_tutor" class="form-label">Nombre del tutor <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    <input type="text" class="form-control" id="nombre_tutor" name="nombre_tutor">
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa el nombre del tutor
                                </div>
                            </div>
                        </div>

                        <!-- Campos comunes -->
                        <div class="mb-4">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa un número de teléfono válido
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="correo" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa un correo electrónico válido
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Recibirás la confirmación aquí
                            </small>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-3 pt-3">
                            <a href="{{ route('cursos.ver', $curso->id) }}" class="btn btn-volver btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al curso
                            </a>
                            <button type="submit" class="btn btn-inscribir">
                                <i class="fas fa-paper-plane me-2"></i>Enviar inscripción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Mensaje final -->
            <div class="text-center mt-4 texto-destacado">
                <i class="fas fa-graduation-cap me-2"></i> ¡Esperamos que disfrutes esta experiencia de aprendizaje!
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Validación de Bootstrap
        (function () {
            'use strict'
            
            var forms = document.querySelectorAll('.needs-validation')
            
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        const edadInput = document.getElementById('edad');
        const menorDiv = document.getElementById('menor');
        const mayorEdadDiv = document.getElementById('mayorEdad');
        const form = document.getElementById('formInscripcion');
        const telefonoInput = document.getElementById('telefono').parentElement.parentElement;
        const correoInput = document.getElementById('correo').parentElement.parentElement;
        const nombreTutorInput = document.getElementById('nombre_tutor');
        const nombreParticipanteInput = document.getElementById('nombre_participante');

        // Mover los campos según la edad
        function actualizarCampos() {
            const edad = parseInt(edadInput.value);
            
            if (edad < 18 && edad > 0) {
                // Mostrar sección de tutor y mover campos
                menorDiv.style.display = 'block';
                menorDiv.querySelector('.mb-3:last-child').after(telefonoInput);
                menorDiv.querySelector('.mb-3:last-child').after(correoInput);
                
                // Hacer requerido el tutor
                nombreTutorInput.required = true;
            } else {
                // Ocultar sección de tutor y mover campos a sección normal
                menorDiv.style.display = 'none';
                mayorEdadDiv.append(telefonoInput);
                mayorEdadDiv.append(correoInput);
                
                // No requerir tutor
                nombreTutorInput.required = false;
            }
        }

        // Inicializar campos al cargar
        document.addEventListener('DOMContentLoaded', function() {
            // Mover campos iniciales a mayorEdad
            mayorEdadDiv.append(telefonoInput);
            mayorEdadDiv.append(correoInput);
            
            // Configurar evento para edad
            edadInput.addEventListener('input', actualizarCampos);
        });

        // Validación antes de enviar
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const edad = parseInt(edadInput.value);
            
            // Validar campos requeridos
            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                
                // Enfocar el primer campo inválido
                const invalidFields = form.querySelectorAll(':invalid');
                if (invalidFields.length > 0) {
                    invalidFields[0].focus();
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incompletos',
                        text: 'Por favor completa todos los campos requeridos',
                        confirmButtonColor: '#5a2a83',
                    });
                }
                return;
            }

            // Mostrar confirmación
            const datosConfirmacion = edad < 18 && edad > 0 ?
                `<div style="text-align: left;">
                    <p><strong>Participante:</strong> ${nombreParticipanteInput.value} (${edad} años)</p>
                    <p><strong>Tutor:</strong> ${nombreTutorInput.value}</p>
                    <p><strong>Teléfono:</strong> ${telefonoInput.querySelector('input').value}</p>
                    <p><strong>Correo:</strong> ${correoInput.querySelector('input').value}</p>
                </div>` :
                `<div style="text-align: left;">
                    <p><strong>Participante:</strong> ${nombreParticipanteInput.value} (${edad} años)</p>
                    <p><strong>Teléfono:</strong> ${telefonoInput.querySelector('input').value}</p>
                    <p><strong>Correo:</strong> ${correoInput.querySelector('input').value}</p>
                </div>`;

            Swal.fire({
                title: '¿Confirmar inscripción?',
                html: datosConfirmacion,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5a2a83',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirmar inscripción',
                cancelButtonText: 'Cancelar',
                background: '#faf9ff'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Selecciones de elementos
const edadInput = document.getElementById('edad');
const menorDiv = document.getElementById('menor');
const nombreTutorInput = document.getElementById('nombre_tutor');
const form = document.getElementById('formInscripcion');
const nombreParticipanteInput = document.getElementById('nombre_participante');
const telefonoInput = document.getElementById('telefono').querySelector('input');
const correoInput = document.getElementById('correo').querySelector('input');

// Función para mostrar/ocultar sección de tutor
function actualizarCampos() {
    const edad = parseInt(edadInput.value);

    if (edad < 18 && edad > 0) {
        menorDiv.style.display = 'block';
        nombreTutorInput.required = true;
    } else {
        menorDiv.style.display = 'none';
        nombreTutorInput.required = false;
    }
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', function() {
    actualizarCampos();
    edadInput.addEventListener('input', actualizarCampos);
});

// Validación y confirmación con SweetAlert
form.addEventListener('submit', function(event) {
    event.preventDefault();

    if (!form.checkValidity()) {
        event.stopPropagation();
        form.classList.add('was-validated');

        const invalidFields = form.querySelectorAll(':invalid');
        if (invalidFields.length > 0) invalidFields[0].focus();

        Swal.fire({
            icon: 'error',
            title: 'Datos incompletos',
            text: 'Por favor completa todos los campos requeridos',
            confirmButtonColor: '#5a2a83',
        });
        return;
    }

    const edad = parseInt(edadInput.value);
    const datosConfirmacion = edad < 18 ?
        `<div style="text-align: left;">
            <p><strong>Participante:</strong> ${nombreParticipanteInput.value} (${edad} años)</p>
            <p><strong>Tutor:</strong> ${nombreTutorInput.value}</p>
            <p><strong>Teléfono:</strong> ${telefonoInput.value}</p>
            <p><strong>Correo:</strong> ${correoInput.value}</p>
        </div>` :
        `<div style="text-align: left;">
            <p><strong>Participante:</strong> ${nombreParticipanteInput.value} (${edad} años)</p>
            <p><strong>Teléfono:</strong> ${telefonoInput.value}</p>
            <p><strong>Correo:</strong> ${correoInput.value}</p>
        </div>`;

    Swal.fire({
        title: '¿Confirmar inscripción?',
        html: datosConfirmacion,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#5a2a83',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Confirmar inscripción',
        cancelButtonText: 'Cancelar',
        background: '#faf9ff'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

    </script>
@endsection