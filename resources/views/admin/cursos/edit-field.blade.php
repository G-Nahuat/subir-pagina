@extends('layouts.admin')

@section('content')
<div class="container mt-5">
  @php
    $nombresCampos = [
        'duracion' => 'Duración',
        'descripcion' => 'Descripción',
        'facilitador' => 'Facilitador',
        'tipo' => 'Tipo',
        'ciudad' => 'Ciudad',
        'lugar' => 'Lugar',
        'hora' => 'Hora',
        'fecha' => 'Fecha',
        'estado' => 'Estado',
        'temario' => 'Temario',
        'flyer' => 'Flyer',
        'num_grupos' => 'Número de Grupos',
    ];
  @endphp

  <h2 class="mb-4">
    Editar campo: <strong>{{ $nombresCampos[$field] ?? ucfirst($field) }}</strong> del curso <em>{{ $curso->nombre }}</em>
  </h2>

  <form method="POST"
        action="{{ route('admin.cursos.updateField', ['curso'=>$curso->id,'field'=>$field]) }}"
        enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label class="form-label">
        {{ $nombresCampos[$field] ?? ucfirst($field) }}
      </label>

      @if(in_array($field, ['temario','flyer']))
        {{-- File upload --}}
        <input type="file"
               name="value"
               class="form-control"
               @if($field=='temario') accept="application/pdf" @else accept="image/*" @endif>

      @elseif($field == 'descripcion')
        {{-- Summernote --}}
        <textarea name="value" class="form-control summernote">{{ old('value', $curso->$field) }}</textarea>

      @elseif($field == 'tipo')
        <select name="value" class="form-select">
          <option value="">Selecciona</option>
          <option value="Constancia" {{ $curso->tipo == 'Constancia' ? 'selected' : '' }}>Constancia</option>
          <option value="Reconocimiento" {{ $curso->tipo == 'Reconocimiento' ? 'selected' : '' }}>Reconocimiento</option>
        </select>

      @elseif($field == 'estado')
        <select name="value" class="form-select">
          <option value="pendiente" {{ $curso->estado=='pendiente'?'selected':'' }}>Pendiente</option>
          <option value="aceptado"  {{ $curso->estado=='aceptado'?'selected':'' }}>Aceptado</option>
        </select>

      @elseif($field == 'fecha')
        @php
          $fecha_inicio = '';
          $fecha_fin = '';
          if (!empty($curso->fecha) && str_contains($curso->fecha, ' - ')) {
              [$inicio, $fin] = explode(' - ', $curso->fecha);
              $fecha_inicio = trim($inicio);
              $fecha_fin = trim($fin);
          }
        @endphp

        <div class="row">
          <div class="col-md-6 mb-2">
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" class="form-control"
                   value="{{ old('fecha_inicio', $fecha_inicio) }}">
          </div>
          <div class="col-md-6 mb-2">
            <label for="fecha_fin">Fecha de fin</label>
            <input type="date" name="fecha_fin" class="form-control"
                   value="{{ old('fecha_fin', $fecha_fin) }}">
          </div>
        </div>

      @elseif($field == 'num_grupos')
        <input type="number" name="value" class="form-control" min="1"
               value="{{ old('value', $curso->num_grupos ?? 1) }}">

      @else
        <input type="text" name="value" class="form-control"
               value="{{ old('value',$curso->$field) }}">
      @endif

      @error('value')
        <div class="text-danger mt-1">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('admin.cursos.detalle',$curso->id) }}" class="btn btn-secondary ms-2">Cancelar</a>
  </form>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    if (typeof inicializarSummernote === 'function') {
      inicializarSummernote();
    }
  });
</script>
@endsection
