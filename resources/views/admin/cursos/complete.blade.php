@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Completar campos faltantes de: {{ $curso->nombre }}</h2>

    <form method="POST" action="{{ route('admin.cursos.update', $curso->id) }}">
        @csrf
        @method('PUT')

        @foreach($faltantes as $field)
            <div class="mb-3">
                <label class="form-label">{{ ucfirst($field) }}</label>
                <input type="text" name="{{ $field }}" class="form-control" value="{{ old($field) }}">
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Guardar Campos Faltantes</button>
        <a href="{{ route('admin.cursos.show', $curso->id) }}" class="btn btn-secondary ms-2">Volver</a>
    </form>
</div>
@endsection
