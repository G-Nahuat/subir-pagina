@extends('layouts.admin')

@section('content')
<style>
    :root {
        --color-purple: #726d7bff;
        --color-purple-dark: #5a0b9d;
        --color-purple-light: #f8f1ff;
        --color-success: #6a0dad; /* Cambiado a morado */
        --color-warning: #9c27b0; /* Morado más claro para advertencias */
        --color-danger: #d81b60; /* Rosa morado para acciones peligrosas */
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
</style>

{{-- Resumen de Totales --}}
@php
    $totalesPorGrupo = [];

    foreach ($asistentes as $a) {
        $grupo = $a->grupo;
        if (!isset($totalesPorGrupo[$grupo])) {
            $totalesPorGrupo[$grupo] = 0;
        }
        $totalesPorGrupo[$grupo]++;
    }

    $totalGeneral = array_sum($totalesPorGrupo);
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="card card-shadow border-purple mb-4">
            <div class="card-header bg-purple text-white">
                <h5 class="mb-0">Resumen de Inscritos</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Total general:</strong>
                        <span class="badge bg-purple rounded-pill">{{ $totalGeneral }}</span>
                    </li>
                    @foreach($totalesPorGrupo as $grupo => $total)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Grupo {{ $grupo }}:</strong>
                        <span class="badge bg-purple rounded-pill">{{ $total }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-shadow border-purple mb-4">
            <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <button id="btn-agregar-participante" class="btn btn-purple">
                        <i class="fas fa-user-plus me-1"></i> Agregar Participante
                    </button>
                    
                    <div class="dropdown">
                        <button class="btn btn-outline-purple dropdown-toggle" type="button" id="dropdownConstancias" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-archive me-1"></i> Imprimir Constancias
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownConstancias">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.constancias.zip', $curso->id) }}">
                                    <i class="fas fa-file-archive me-1"></i> ZIP (varios PDFs)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.constancias.pdf', $curso->id) }}" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i> Un solo PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('admin.constancias.generador') }}" class="btn btn-outline-purple">
                        <i class="fas fa-magic me-1"></i> Reconocimiento manual
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Card para agregar participante --}}
<div id="card-agregar-participante" class="card card-shadow border-purple position-fixed top-50 start-50 translate-middle" style="display: none; z-index: 1050; width: 90%; max-width: 700px;">
    <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Agregar Nuevo Participante</h5>
        <button type="button" class="btn-close btn-close-white" onclick="ocultarAgregarParticipante()"></button>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.asistencia.agregar') }}">
            @csrf
            <input type="hidden" name="id_curso" value="{{ $curso->id }}">
            
            <div class="row g-3 mb-3">
                <div class="col-md-2">
                    <label for="edad" class="form-label">Edad *</label>
                    <input type="number" name="edad" id="edad" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="nombre" class="form-label">Nombre completo *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" name="correo" id="correo" class="form-control">
                </div>
            </div>

            @if($curso->num_grupos > 1)
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="grupo" class="form-label">Grupo *</label>
                    <select name="grupo" id="grupo" class="form-select" required>
                        @for($i = 1; $i <= $curso->num_grupos; $i++)
                            <option value="{{ $i }}">Grupo {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            @else
                <input type="hidden" name="grupo" value="1">
            @endif

            <div class="row g-3 mb-3" id="tutorFields" style="display: none;">
                <div class="col-md-4">
                    <label for="nombre_tutor" class="form-label">Nombre del tutor *</label>
                    <input type="text" name="nombre_tutor" id="nombre_tutor" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="telefono_tutor" class="form-label">Teléfono del tutor *</label>
                    <input type="text" name="telefono_tutor" id="telefono_tutor" class="form-control">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" onclick="ocultarAgregarParticipante()">Cancelar</button>
                <button type="submit" class="btn btn-purple">Registrar Participante</button>
            </div>
        </form>
    </div>
</div>

{{-- Lista de Asistencia por Días --}}
@php
use Carbon\Carbon;
use Carbon\CarbonPeriod;

$inicio = null;
$fin = null;
$periodo = [];

if (!empty($curso->fecha) && str_contains($curso->fecha, ' - ')) {
    [$fechaInicio, $fechaFin] = explode(' - ', $curso->fecha);

    try {
        $inicio = Carbon::createFromFormat('Y-m-d', trim($fechaInicio));
        $fin = Carbon::createFromFormat('Y-m-d', trim($fechaFin));
        $periodo = CarbonPeriod::create($inicio, $fin);
    } catch (\Exception $e) {
        $periodo = [];
    }
}
@endphp

<div class="card card-shadow border-purple mb-4">
    <div class="card-header bg-purple text-white">
        <h5 class="mb-0">Lista de Asistencia por Días (Grupo <span id="grupo-label">1</span>)</h5>
    </div>
    <div class="card-body">
        @if($curso->num_grupos > 1)
        <div class="mb-3">
            <label class="form-label d-block">Filtrar por grupo:</label>
            <div class="btn-group flex-wrap" role="group">
                @for($i = 1; $i <= $curso->num_grupos; $i++)
                    <button type="button"
                            class="btn btn-outline-purple grupo-btn"
                            onclick="filtrarGrupo({{ $i }})">
                        Grupo {{ $i }}
                    </button>
                @endfor
            </div>
        </div>
        @endif
        <input type="hidden" id="grupoActual" name="grupo_actual" value="1">

        @if(count($periodo))
        <form method="POST" action="{{ route('admin.asistencia.guardarDias') }}">
            @csrf
            <input type="hidden" name="id_curso" value="{{ $curso->id }}">
            
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            @foreach ($periodo as $dia)
                                <th class="text-center">{{ $dia->format('d/m') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asistentes as $asistente)
                        <tr class="fila-grupo grupo-{{ $asistente->grupo }}">
                            <td>{{ $asistente->nombre }}</td>
                            @foreach ($periodo as $dia)
                                <td class="text-center">
                                    <input type="checkbox" 
                                           name="asistencia[{{ $asistente->id }}][{{ $dia->format('Y-m-d') }}]"
                                           class="form-check-input"
                                           {{ isset($asistente->diasAsistidos) && $asistente->diasAsistidos->contains('fecha', $dia->format('Y-m-d')) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <button type="submit" class="btn btn-purple">
                    <i class="fas fa-save me-1"></i> Guardar Asistencia
                </button>
                
                <div class="d-flex gap-2">
                    <a id="btn-exportar-excel" href="#" class="btn btn-outline-success">
                        <i class="fas fa-file-excel me-1"></i> Excel
                    </a>
                    <a id="btn-exportar-pdf" href="#" class="btn btn-outline-danger">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>
                </div>
            </div>
        </form>
        @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i> No se pudo leer correctamente el rango de fechas. Verifica que el formato sea: <code>YYYY-MM-DD - YYYY-MM-DD</code>
        </div>
        @endif
    </div>
</div>

{{-- Lista de Asistentes --}}
<div class="card card-shadow border-purple">
    <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0">Lista de Asistentes</h5>
        <div class="search-container mt-2 mt-md-0" style="width: 100%; max-width: 300px;">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="form-control search-input" placeholder="Buscar participante...">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover" id="tablaAsistentes">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Grupo</th>
                        <th>Asistió</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asistentes as $asistente)
                        <tr class="grupo-{{ $asistente->grupo }}">
                            <td>{{ $asistente->nombre }}</td>
                            <td>{{ $asistente->edad }}</td>
                            <td>{{ $asistente->telefono ?? 'N/A' }}</td>
                            <td>{{ $asistente->correo ?? 'N/A' }}</td>
                            <td>Grupo {{ $asistente->grupo }}</td>
                            <td>
                                @if($asistente->asistio)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    @if(! $asistente->asistio)
                                    <button class="btn btn-sm btn-outline-success" onclick="mostrarConfirmacion('{{ $asistente->nombre }}', '{{ route('admin.asistencia.marcar', $asistente->id) }}')">
                                        <i class="fas fa-check me-1"></i> Asistencia
                                    </button>
                                    @elseif($curso->estado === 'aceptado')
                                    <a href="{{ route('admin.constancia.generar', $asistente->id) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fas fa-file-pdf me-1"></i> Constancia
                                    </a>
                                    @else
                                        <span class="text-muted">Curso no aceptado</span>
                                    @endif

                                    <a href="{{ route('admin.asistentes.edit', $asistente->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Card de confirmación de asistencia --}}
<div id="cardConfirmacion" class="card card-shadow position-fixed top-50 start-50 translate-middle" style="display:none; z-index:1051; width: 90%; max-width: 400px;">
    <div class="card-header bg-purple text-white">
        <h5 class="mb-0">Confirmar asistencia</h5>
    </div>
    <div class="card-body">
        <p>¿Estás seguro de marcar como asistente a <strong id="nombreConfirmacion"></strong>?</p>
        <form id="formConfirmacion" method="POST" action="">
            @csrf
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" onclick="ocultarCard()">Cancelar</button>
                <button type="submit" class="btn btn-purple">Confirmar</button>
            </div>
        </form>
    </div>
</div>

{{-- Overlay para las cards --}}
<div id="overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="display: none; z-index: 1040;"></div>

{{-- Scripts --}}
<script>
// Mostrar/ocultar card de agregar participante
function mostrarAgregarParticipante() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('card-agregar-participante').style.display = 'block';
}

function ocultarAgregarParticipante() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('card-agregar-participante').style.display = 'none';
}

// Configurar botón de agregar participante
document.getElementById('btn-agregar-participante').addEventListener('click', mostrarAgregarParticipante);

// Mostrar campos de tutor si es menor de edad
const edadInput = document.getElementById('edad');
const tutorFields = document.getElementById('tutorFields');

edadInput.addEventListener('input', function() {
    const esMenor = parseInt(this.value) < 18;
    tutorFields.style.display = esMenor ? 'flex' : 'none';
    
    // Hacer campos obligatorios o no
    document.getElementById('nombre_tutor').required = esMenor;
    document.getElementById('telefono_tutor').required = esMenor;
});

// Filtrar por grupo
function filtrarGrupo(grupoSeleccionado) {
    const filas = document.querySelectorAll('.fila-grupo');
    filas.forEach(fila => {
        if (fila.classList.contains(`grupo-${grupoSeleccionado}`)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });

    document.getElementById('grupo-label').textContent = grupoSeleccionado;
    document.querySelectorAll('.grupo-btn').forEach(btn => btn.classList.remove('active'));
    const btnActivo = document.querySelector(`.grupo-btn[onclick="filtrarGrupo(${grupoSeleccionado})"]`);
    if (btnActivo) btnActivo.classList.add('active');
    document.getElementById('grupoActual').value = grupoSeleccionado;
    actualizarEnlacesExportacion(grupoSeleccionado);
}

function actualizarEnlacesExportacion(grupoSeleccionado) {
    const idCurso = {{ $curso->id }};
    const baseExcel = "{{ url('/admin/asistencia/exportar-excel') }}";
    document.getElementById('btn-exportar-excel').href = `${baseExcel}/${idCurso}/${grupoSeleccionado}`;
}

// Configurar exportación a PDF
document.getElementById('btn-exportar-pdf').addEventListener('click', function(e) {
    e.preventDefault();
    const grupo = document.getElementById('grupoActual').value;
    const cursoId = {{ $curso->id }};
    const url = `/admin/asistencia/exportar-pdf/${cursoId}/${grupo}`;
    window.open(url, '_blank');
});

// Confirmación de asistencia
function mostrarConfirmacion(nombre, url) {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('nombreConfirmacion').textContent = nombre;
    document.getElementById('formConfirmacion').action = url;
    document.getElementById('cardConfirmacion').style.display = 'block';
}

function ocultarCard() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('cardConfirmacion').style.display = 'none';
}

// Búsqueda en la tabla de asistentes
document.getElementById('searchInput').addEventListener('keyup', function() {
    const input = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tablaAsistentes tbody tr');
    
    rows.forEach(row => {
        const nombre = row.cells[0].textContent.toLowerCase();
        const grupo = row.cells[4].textContent.toLowerCase();
        const textoCompleto = nombre + ' ' + grupo;
        
        if (textoCompleto.includes(input)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    filtrarGrupo(1);
    actualizarEnlacesExportacion(1);
    
    // Activar el primer botón de grupo
    const primerGrupoBtn = document.querySelector('.grupo-btn');
    if (primerGrupoBtn) primerGrupoBtn.classList.add('active');
});
</script>

@endsection