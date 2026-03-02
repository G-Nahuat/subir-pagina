@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Formulario de Contacto</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contacto.enviar') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="correo">Correo</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" rows="5" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
@endsection
