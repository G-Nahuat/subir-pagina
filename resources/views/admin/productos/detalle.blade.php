@extends('layouts.admin')

@section('hideNavbar')
@endsection

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-center text-primary">Detalles de la Solicitud</h2>

    <div class="card shadow p-4">
        <h4 class="fw-semibold border-bottom pb-2 mb-3 text-dark">Datos Generales</h4>
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Nombre:</strong> {{ $registro->nombre }} {{ $registro->apellido_paterno }} {{ $registro->apellido_materno }}</p>
                <p><strong>CURP:</strong> {{ $registro->curp }}</p>
                <p><strong>Teléfono:</strong> {{ $registro->telefono }}</p>
                <p><strong>Correo:</strong> {{ $registro->email }}</p>
                <p><strong>Comprobante domicilio:</strong> {{ $registro->comprobante_domicilio }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Estado:</strong> {{ $registro->estado->nombre ?? 'Sin estado' }}</p>
                <p><strong>Municipio:</strong> {{ $registro->municipio->municipio ?? 'Sin municipio' }}</p>
                <p><strong>Grado de estudios:</strong> {{ $registro->gradoEstudios->nombre ?? 'Sin grado' }}</p>
            </div>
        </div>

        <h4 class="fw-semibold border-bottom pb-2 mb-3 text-dark">Datos Laborales</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nombre del negocio:</strong> {{ $registro->nombre_negocio }}</p>
                <p><strong>Dirección:</strong> {{ $registro->direccion_negocio }}</p>
                <p><strong>Actividad económica:</strong> {{ $registro->actividad_economica }}</p>
                <p><strong>Redes del negocio:</strong> {{ $registro->redes_negocio }}</p>
                <p><strong>Tiempo de emprendimiento:</strong> {{ $registro->tiempo_emprendimiento }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Interés en capacitación:</strong> {{ $registro->interes_capacitacion }}</p>
                <p><strong>Negocio dado de alta:</strong> {{ $registro->negocio_alta }}</p>
                <p><strong>Razón por la que no tiene alta:</strong> {{ $registro->razon_no_alta }}</p>
                <p><strong>Interés en financiamiento:</strong> {{ $registro->interes_financiamiento }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
