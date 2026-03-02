@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Inscripción a Curso</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('inscripcion.publica.enviar') }}">
        @csrf

        <div class="mb-3">
            <label for="id_curso" class="form-label">Curso</label>
            <select name="id_curso" id="id_curso" class="form-control" required>
                <option value="">Selecciona un curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}"
                        data-temario="{{ $curso->temario }}"
                        data-grupos="{{ $curso->num_grupos }}"
                        data-horarios="{{ $curso->horarios }}">
                        {{ $curso->nombre }} - {{ \Carbon\Carbon::parse($curso->fecha)->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Información del curso seleccionada -->
        <div id="infoCurso" class="alert alert-info d-none">
            <p><strong>Temario:</strong> <span id="cursoTemario"></span></p>
            <p><strong>Número de grupos:</strong> <span id="cursoGrupos"></span></p>
            <p><strong>Horarios:</strong> <span id="cursoHorarios"></span></p>
        </div>

        <div class="mb-3">
            <label for="edad" class="form-label">Edad del participante</label>
            <input type="number" name="edad" id="edad" class="form-control" required min="1">
        </div>

        <div class="mb-3">
            <label for="nombre_participante" class="form-label">Nombre completo del participante</label>
            <input type="text" name="nombre_participante" id="nombre_participante" class="form-control" required>
        </div>

        <!-- Mayor de edad -->
        <div id="mayorEdadCampos" style="display: none;">
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control">
            </div>
        </div>

        <!-- Menor de edad -->
        <div id="menorEdadCampos" style="display: none;">
            <div class="mb-3">
                <label for="nombre_tutor" class="form-label">Nombre del tutor</label>
                <input type="text" name="nombre_tutor" id="nombre_tutor" class="form-control">
            </div>
            <div class="mb-3">
                <label for="contacto_tutor" class="form-label">Contacto del tutor</label>
                <input type="text" name="contacto_tutor" id="contacto_tutor" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enviar inscripción</button>
    </form>
</div>

<script>
    document.getElementById('edad').addEventListener('input', function () {
        const edad = parseInt(this.value);
        const mayor = document.getElementById('mayorEdadCampos');
        const menor = document.getElementById('menorEdadCampos');

        if (!isNaN(edad)) {
            if (edad < 18) {
                menor.style.display = 'block';
                mayor.style.display = 'none';
            } else {
                mayor.style.display = 'block';
                menor.style.display = 'none';
            }
        } else {
            mayor.style.display = 'none';
            menor.style.display = 'none';
        }
    });

    document.getElementById('id_curso').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const temario = selected.getAttribute('data-temario');
        const grupos = selected.getAttribute('data-grupos');
        const horarios = selected.getAttribute('data-horarios');

        if (temario || grupos || horarios) {
            document.getElementById('cursoTemario').textContent = temario || 'No disponible';
            document.getElementById('cursoGrupos').textContent = grupos || 'No especificado';
            document.getElementById('cursoHorarios').textContent = horarios || 'No especificado';
            document.getElementById('infoCurso').classList.remove('d-none');
        } else {
            document.getElementById('infoCurso').classList.add('d-none');
        }
    });
</script>
@endsection
