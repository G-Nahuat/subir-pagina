@extends('layouts.app')

@section('content')
<div class="container py-3 py-md-5">
    <div class="row">
        {{-- FILTRO --}}
        <div class="col-12 col-md-3 mb-4">
            <div class="border rounded-4 p-3 shadow-sm">
                <h5 class="text-center fw-bold text-purple mb-3">Filtrar</h5>
                <form method="GET" action="{{ route('emprendimientos.catalogo') }}" id="filtroForm">
                    <!-- Filtro de tipo -->
                    <label class="form-label fw-semibold">Mostrar</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tipo-emprendimiento" name="tipo[]" value="emprendimiento" 
                            {{ in_array('emprendimiento', (array)request('tipo', ['emprendimiento'])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tipo-emprendimiento">Emprendimientos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tipo-curso" name="tipo[]" value="curso" 
                            {{ in_array('curso', (array)request('tipo', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tipo-curso">Cursos/Talleres</label>
                    </div>

                    <!-- Filtros para emprendimientos -->
                    <div class="mt-3" id="filtros-emprendimientos">
                        <label for="municipio" class="form-label fw-semibold">Municipio</label>
                        <select id="municipio" name="municipio" class="form-select form-select-sm rounded-pill mb-3">
                            <option value="">-Todos los municipios-</option>
                            @foreach($municipios as $mun)
                                <option value="{{ $mun }}" {{ request('municipio') == $mun ? 'selected' : '' }}>
                                    {{ $mun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtros para cursos -->
                    <div class="mt-3" id="filtros-cursos">
                        <label class="form-label fw-semibold">Modalidad</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="presencial" name="modalidad[]" value="Presencial" 
                                {{ in_array('Presencial', (array)request('modalidad', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="presencial">Presencial</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="en-linea" name="modalidad[]" value="En línea" 
                                {{ in_array('En línea', (array)request('modalidad', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="en-linea">En línea</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-purple w-100 rounded-pill mb-2 mt-3">Aplicar</button>
                    <a href="{{ route('emprendimientos.catalogo') }}" class="btn btn-outline-purple w-100 rounded-pill">Limpiar</a>
                </form>
            </div>
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="col-12 col-md-9">
            <h2 class="text-purple fw-bold mb-4">
                @if(request('tipo') && count(request('tipo')) === 1)
                    @if(request('tipo')[0] == 'emprendimiento')
                        Catálogo de Emprendimientos
                    @else
                        Cursos y Talleres
                    @endif
                @else
                    Catálogo
                @endif
            </h2>

            {{-- BÚSQUEDA --}}
            <form method="GET" action="{{ route('emprendimientos.catalogo') }}" class="mb-4" onsubmit="return prepararBusqueda()">
                <div class="d-flex align-items-center gap-2">
                    <input type="text" name="buscar" class="form-control buscar-custom" placeholder="Buscar..." value="{{ request('buscar') }}">
                    <button class="btn btn-purple rounded-circle d-flex align-items-center justify-content-center" type="submit" style="width: 42px; height: 42px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <!-- Campos ocultos para mantener los filtros al buscar -->
                @if(request('tipo'))
                    @foreach(request('tipo') as $tipo)
                        <input type="hidden" name="tipo[]" value="{{ $tipo }}">
                    @endforeach
                @endif
                @if(request('municipio'))
                    <input type="hidden" name="municipio" value="{{ request('municipio') }}">
                @endif
                @if(request('modalidad'))
                    @foreach(request('modalidad') as $modalidad)
                        <input type="hidden" name="modalidad[]" value="{{ $modalidad }}">
                    @endforeach
                @endif
            </form>

            {{-- LISTADO COMBINADO - MEJORADO --}}
            <div class="row g-4">
                @if(in_array('emprendimiento', (array)request('tipo', ['emprendimiento'])))
                    @forelse($emprendimientos as $emprendimiento)
                        <div class="col-12 col-sm-6 col-lg-4 d-flex">
                            <div class="card w-100 rounded-4 border d-flex flex-column">
                                {{-- Contenedor de imagen con tamaño fijo --}}
                                <div class="emprendimiento-imagen-container">
                                    @if($emprendimiento->logo)
                                        <img src="{{ asset('storage/images/emprendimientos/' . $emprendimiento->logo) }}"
                                            alt="{{ $emprendimiento->nombre }}"
                                            class="emprendimiento-imagen">
                                    @else
                                        <div class="emprendimiento-imagen-placeholder">
                                            <i class="fas fa-store"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="emprendimiento-info">
                                        <h5 class="fw-bold text-purple mb-2">{{ $emprendimiento->nombre }}</h5>
                                        <p class="text-muted small mb-2 emprendimiento-descripcion">
                                            {{ strip_tags($emprendimiento->descripcion) }}
                                        </p>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-map-marker-alt text-purple me-2"></i> 
                                            {{ $emprendimiento->municipio ?? 'Ubicación no especificada' }}
                                        </small>
                                    </div>
                                    
                                    <div class="mt-auto pt-3">
                                        <a href="{{ route('emprendimientos.perfil', $emprendimiento->id_emprendimiento) }}"
                                            class="btn btn-purple rounded-pill px-4 fw-semibold btn-ver-mas w-100">
                                            Ver más
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        @if(!in_array('curso', (array)request('tipo', [])))
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    No se encontraron emprendimientos.
                                </div>
                            </div>
                        @endif
                    @endforelse
                @endif

                @if(in_array('curso', (array)request('tipo', [])))
                    @forelse($cursos ?? [] as $curso)
                        @php
                            // Determinar si el curso ya finalizó
                            $rangoFechas = explode(' - ', $curso->fecha);
                            $fechaFin = isset($rangoFechas[1]) ? \Carbon\Carbon::parse(trim($rangoFechas[1])) : null;
                            $cursoFinalizado = $fechaFin && $fechaFin->isPast();
                        @endphp

                        <div class="col-12 col-sm-6 col-lg-4 d-flex">
                            <div class="card w-100 rounded-4 border d-flex flex-column curso-card @if($cursoFinalizado) curso-finalizado @endif">
                                {{-- Contenedor de imagen con tamaño fijo --}}
                                <div class="curso-imagen-container">
                                    @if($curso->flyer)
                                        <img src="{{ asset($curso->flyer) }}" 
                                             alt="{{ $curso->nombre }}" 
                                             class="curso-imagen">
                                    @else
                                        <div class="curso-imagen-placeholder">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    @endif
                                    @if($cursoFinalizado)
                                        <div class="curso-finalizado-badge">Finalizado</div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="curso-info">
                                        <h5 class="fw-bold text-purple mb-2">{{ $curso->nombre }}</h5>
                                        <p class="text-muted small mb-2 curso-descripcion">
                                            {{ $curso->descripcion ? strip_tags($curso->descripcion) : 'Sin descripción disponible' }}
                                        </p>
                                        
                                        <div class="curso-detalles">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="far fa-calendar-alt text-purple me-2"></i>
                                                <span>
                                                    @if($curso->fecha)
                                                        {{ $curso->fecha }}
                                                    @else
                                                        Fecha por definir
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-clock text-purple me-2"></i>
                                                <span>
                                                    @if($curso->hora)
                                                        {{ \Carbon\Carbon::parse($curso->hora)->format('h:i A') }}
                                                    @else
                                                        Horario por definir
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-chalkboard-teacher text-purple me-2"></i>
                                                <span>{{ $curso->modalidad ?? 'Modalidad no especificada' }}</span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-map-marker-alt text-purple me-2"></i>
                                                <span>
                                                    @if($curso->lugar)
                                                        {{ $curso->lugar }}, {{ $curso->ciudad }}
                                                    @else
                                                        Lugar por definir
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-auto pt-3">
                                        @if($cursoFinalizado)
                                            <button class="btn btn-outline-secondary rounded-pill w-100" disabled>
                                                Curso Finalizado
                                            </button>
                                        @else
                                            <a href="{{ route('cursos.ver', $curso->id) }}" 
                                               class="btn btn-purple rounded-pill w-100">
                                                Ver más información
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        @if(!in_array('emprendimiento', (array)request('tipo', ['emprendimiento'])))
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    No se encontraron cursos.
                                </div>
                            </div>
                        @endif
                    @endforelse
                @endif

                @if(empty($emprendimientos) && empty($cursos ?? []))
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No se encontraron resultados.
                        </div>
                    </div>
                @endif
            </div>

            {{-- PAGINACIÓN --}}
            <div class="d-flex justify-content-center mt-4">
                @if(in_array('emprendimiento', (array)request('tipo', ['emprendimiento'])) && !in_array('curso', (array)request('tipo', [])))
                    {{ $emprendimientos->appends(request()->query())->links() }}
                @elseif(in_array('curso', (array)request('tipo', [])) && isset($cursos))
                    {{ $cursos->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* ESTILOS GENERALES */
    body {
        background-color: #fff !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .text-purple { color: #4b2a85 !important; }
    .bg-purple { background-color: #4b2a85 !important; }
    
    /* TARJETAS */
    .card {
        border: 2px solid #4b2a85 !important;
        border-radius: 1rem !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(111, 66, 193, 0.15);
    }
    
    .curso-finalizado {
        opacity: 0.85;
        border-color: #6c757d !important;
    }
    
    /* CONTENEDORES DE IMAGEN */
    .curso-imagen-container,
    .emprendimiento-imagen-container {
        height: 200px;
        width: 100%;
        overflow: hidden;
        position: relative;
        border-top-left-radius: 0.9rem;
        border-top-right-radius: 0.9rem;
    }
    
    .curso-imagen,
    .emprendimiento-imagen {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .card:hover .curso-imagen,
    .card:hover .emprendimiento-imagen {
        transform: scale(1.05);
    }
    
    .curso-imagen-placeholder,
    .emprendimiento-imagen-placeholder {
        width: 100%;
        height: 100%;
        background-color: #4b2a85;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }
    
    /* BADGE PARA CURSOS FINALIZADOS */
    .curso-finalizado-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #dc3545;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: bold;
    }
    
    /* CONTENIDO DE LAS TARJETAS */
    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 1.25rem;
    }
    
    .curso-info h5,
    .emprendimiento-info h5 {
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
    }
    
    .curso-descripcion,
    .emprendimiento-descripcion {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    .curso-detalles {
        font-size: 0.85rem;
    }
    
    .curso-detalles i,
    .emprendimiento-info i {
        width: 1.25rem;
        text-align: center;
    }
    
    /* BOTONES */
    .btn-purple {
        background-color: #4b2a85;
        color: white;
        border: none;
        font-weight: 500;
    }
    
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
    }
    
    .btn-outline-purple {
        color: #4b2a85;
        border: 1px solid #4b2a85;
    }
    
    .btn-outline-purple:hover {
        background-color: #4b2a85;
        color: white;
    }
    
    /* PAGINACIÓN */
    .pagination .page-link {
        color: #4b2a85;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4b2a85;
        border-color: #4b2a85;
    }
    
    /* FORMULARIOS */
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .form-check-label {
        color: #495057;
        font-weight: 500;
    }
    
    .form-check-input:checked {
        background-color: #4b2a85;
        border-color: #4b2a85;
    }
    
    .buscar-custom {
        border: 2px solid #4b2a85;
        border-radius: 50rem;
        padding: 0.5rem 1.2rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .buscar-custom:focus {
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        border-color: #4b2a85;
    }
    
    /* RESPONSIVIDAD */
    @media (max-width: 767.98px) {
        .container {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .curso-imagen-container,
        .emprendimiento-imagen-container {
            height: 150px;
        }
        
        .curso-imagen-placeholder,
        .emprendimiento-imagen-placeholder {
            font-size: 2rem;
        }
        
        .curso-info h5,
        .emprendimiento-info h5 {
            font-size: 1rem;
        }
        
        .curso-descripcion,
        .emprendimiento-descripcion {
            font-size: 0.8rem;
        }
        
        .curso-detalles {
            font-size: 0.8rem;
        }
        
        .btn-ver-mas {
            font-size: 0.8rem;
            padding: 0.4rem;
        }
    }
</style>

<script>
    // Mostrar/ocultar filtros según lo seleccionado
    document.addEventListener('DOMContentLoaded', function() {
        function toggleFilters() {
            const showEmprendimientos = document.getElementById('tipo-emprendimiento').checked;
            const showCursos = document.getElementById('tipo-curso').checked;
            
            document.getElementById('filtros-emprendimientos').style.display = 
                showEmprendimientos ? 'block' : 'none';
            document.getElementById('filtros-cursos').style.display = 
                showCursos ? 'block' : 'none';
        }

        document.getElementById('tipo-emprendimiento').addEventListener('change', toggleFilters);
        document.getElementById('tipo-curso').addEventListener('change', toggleFilters);
        
        // Inicializar estado
        toggleFilters();
    });

    // Función para preparar la búsqueda manteniendo los filtros
    function prepararBusqueda() {
        // Obtener los checkboxes seleccionados
        const tipos = [];
        if (document.getElementById('tipo-emprendimiento').checked) {
            tipos.push('emprendimiento');
        }
        if (document.getElementById('tipo-curso').checked) {
            tipos.push('curso');
        }

        // Agregar campos ocultos al formulario de búsqueda
        const form = document.querySelector('form[onsubmit="return prepararBusqueda()"]');
        
        // Limpiar campos ocultos previos
        const hiddenInputs = form.querySelectorAll('input[type="hidden"]');
        hiddenInputs.forEach(input => input.remove());
        
        // Agregar los tipos seleccionados
        tipos.forEach(tipo => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'tipo[]';
            input.value = tipo;
            form.appendChild(input);
        });

        // Agregar otros filtros si existen
        const municipio = document.getElementById('municipio').value;
        if (municipio) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'municipio';
            input.value = municipio;
            form.appendChild(input);
        }

        // Agregar modalidades seleccionadas
        const modalidades = [];
        if (document.getElementById('presencial').checked) {
            modalidades.push('Presencial');
        }
        if (document.getElementById('en-linea').checked) {
            modalidades.push('En línea');
        }
        
        modalidades.forEach(modalidad => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'modalidad[]';
            input.value = modalidad;
            form.appendChild(input);
        });

        return true;
    }
</script>
@endsection