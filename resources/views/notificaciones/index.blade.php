@extends('layouts.app')

@section('hideNavbar')
@endsection

@section('content')
<div class="container py-4">

  <h2 class="mb-4">Notificaciones</h2>

  {{-- eventos próximos --}}
  <h4>Eventos en los próximos 30 días</h4>
  @forelse($eventosProximos as $evento)
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h5 class="fw-bold">{{ $evento->descripcion }}</h5>
        <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
        @php
          [$inicio, $fin] = explode(' - ', $evento->fecha);
        @endphp
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($inicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fin)->format('d/m/Y') }}</p>
        <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-purple mt-2">Ver detalles / Inscribirme</a>
      </div>
    </div>
  @empty
    <div class="alert alert-secondary">No hay eventos próximos.</div>
  @endforelse

</div>
@endsection
