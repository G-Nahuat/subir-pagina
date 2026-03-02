@extends('layouts.app')

@section('hideNavbar')
@endsection

@section('content')
<div class="container py-4">
  <div class="row">
    {{-- información del evento --}}
    <div class="col-md-7">
      <h2>{{ $evento->descripcion }}</h2>
      <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
      <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</p>
      <p><strong>Horario:</strong> {{ $evento->horario }}</p>
      <p><strong>Delegación:</strong> {{ $evento->delegacion }}</p>
      <p><strong>Tipo:</strong> {{ $evento->tipo }}</p>
      @if($evento->fotos)
        <img src="{{ asset('images/eventos/' . $evento->fotos) }}" class="img-fluid mt-3 rounded shadow">
      @endif
    </div>

    {{-- formulario de inscripción --}}
    <div class="col-md-5">
      <div class="card shadow-sm p-3">
        <h4>Regístrate al evento</h4>
        <form method="POST" action="{{ route('eventos.registrarAsistente', $evento->id_evento) }}">
  @csrf

  {{-- Nombre completo --}}
  <div class="mb-3">
    <label class="form-label">Nombre completo</label>
    <input type="text" name="nombre_completo" class="form-control"
      value="{{ Auth::check() && Auth::user()->datosGenerales ? Auth::user()->datosGenerales->nombre . ' ' . Auth::user()->datosGenerales->apellido_paterno . ' ' . Auth::user()->datosGenerales->apellido_materno : '' }}"
      required>
  </div>

  {{-- CURP --}}
  <div class="mb-3">
    <label class="form-label">CURP</label>
    <input type="text" name="curp" class="form-control"
      value="{{ Auth::check() && Auth::user()->datosGenerales ? Auth::user()->datosGenerales->curp : '' }}"
      required>
  </div>

  {{-- Teléfono --}}
  <div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="telefono" class="form-control"
      value="{{ Auth::check() && Auth::user()->datosGenerales ? Auth::user()->datosGenerales->telefono : '' }}"
      required>
  </div>

  {{-- Email --}}
  <div class="mb-3">
    <label class="form-label">Correo electrónico</label>
    <input type="email" name="email" class="form-control"
      value="{{ Auth::check() ? Auth::user()->email : '' }}"
      required>
  </div>

 

  <button type="submit" class="btn btn-purple">Registrarme</button>
</form>

      </div>
    </div>
  </div>
</div>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: '¡Registro exitoso!',
    text: '{{ session('success') }}',
    confirmButtonText: 'Perfecto'
});
</script>
@endif

@if(session('info'))
<script>
Swal.fire({
    icon: 'info',
    title: 'Ya inscrita',
    text: '{{ session('info') }}',
    confirmButtonText: 'Entendido'
});
</script>
@endif

@endsection
