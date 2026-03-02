@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h4>Resultados para: {{ $criterio }}</h4>

    @if($documentos->isEmpty())
        <div class="alert alert-warning">No se encontraron documentos con ese dato.</div>
    @else
        <ul class="list-group">
            @foreach($documentos as $doc)
                <li class="list-group-item">
                    <strong>{{ $doc->tipo_documento }}</strong> del curso
                    <em>{{ $doc->curso_nombre }}</em> ({{ $doc->fecha }})<br>
                    Emitido a: {{ $doc->nombre_participante }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
