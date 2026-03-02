@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-purple mb-4">Inscripciones a Cursos</h2>

    @if($inscripciones->isEmpty())
        <div class="alert alert-info">
            No hay inscripciones registradas.
        </div>
    @else
        <div class="table-responsive shadow rounded p-3 bg-white">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Curso</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha de Inscripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscripciones as $i => $ins)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $ins->curso_nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($ins->curso_fecha)->format('d/m/Y') }}</td>
                            <td>{{ $ins->nombre }} {{ $ins->apellidos }}</td>
                            <td>{{ $ins->email }}</td>
                            <td>{{ $ins->telefono ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($ins->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
