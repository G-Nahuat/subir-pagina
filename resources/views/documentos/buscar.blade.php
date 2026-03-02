@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h3>Consulta tus documentos emitidos</h3>
    <form method="GET" action="{{ route('documentos.resultados') }}">
        <div class="mb-3">
            <label for="criterio">Correo o teléfono:</label>
            <input type="text" name="criterio" id="criterio" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>
@endsection
