@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-purple mb-4">Editar Temario del Curso</h2>

    <form action="{{ route('admin.cursos.temario.guardar', $curso->id) }}" method="POST" id="temarioForm">
        @csrf
        <table class="table table-bordered" id="temarioTable">
            <thead class="table-light">
                <tr>
                    <th>Tema</th>
                    <th>Duración</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @if($curso->temario)
                    @foreach(json_decode($curso->temario, true) as $fila)
                        <tr>
                            <td><input type="text" name="temario[]" class="form-control" value="{{ $fila['tema'] }}"></td>
                            <td><input type="text" name="duracion[]" class="form-control" value="{{ $fila['duracion'] }}"></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><input type="text" name="temario[]" class="form-control" placeholder="Tema..."></td>
                        <td><input type="text" name="duracion[]" class="form-control" placeholder="Ej. 1 hora"></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
                    </tr>
                @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-outline-primary mb-3" id="addRow">Agregar fila</button>
        <br>
        <button type="submit" class="btn btn-success">Guardar Temario</button>
        <a href="{{ route('admin.cursos.temario.pdf', $curso->id) }}" class="btn btn-secondary ms-2">Descargar en PDF</a>
    </form>
</div>

<script>
document.getElementById('addRow').addEventListener('click', function () {
    const tbody = document.querySelector('#temarioTable tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="temario[]" class="form-control" placeholder="Tema..."></td>
        <td><input type="text" name="duracion[]" class="form-control" placeholder="Ej. 1 hora"></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button></td>
    `;
    tbody.appendChild(tr);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endsection
