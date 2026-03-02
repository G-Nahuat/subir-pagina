@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h2 class="fw-bold text-success mb-3">¡Registro confirmado con éxito!</h2>
    <p class="lead">Tu correo ha sido verificado correctamente.</p>
    <p>Tu información será revisada por el equipo de SEMUJERES.</p>
    <p>Recibirás una notificación en un plazo de <strong>1 a 5 días hábiles</strong> si tu cuenta ha sido aprobada.</p>

    <a href="{{ route('login') }}" class="btn btn-purple mt-4">Iniciar sesión</a>
</div>
@endsection
