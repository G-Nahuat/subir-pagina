<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción Confirmada</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Estimado(a) {{ $nombreTutor }},</h2>

    <p>Le informamos que la inscripción de su hij@ <strong>{{ $nombreParticipante }}</strong> al curso <strong>{{ $curso->nombre }}</strong> ha sido registrada correctamente.</p>

    @php
        $rango = explode(' - ', $curso->fecha);
        $fechaInicio = isset($rango[0]) ? \Carbon\Carbon::parse(trim($rango[0]))->format('d/m/Y') : '';
        $fechaFin = isset($rango[1]) ? \Carbon\Carbon::parse(trim($rango[1]))->format('d/m/Y') : '';
    @endphp

    <p><strong>Detalles del curso:</strong></p>
    <ul>
        <li><strong>Fecha:</strong> {{ $fechaInicio }} - {{ $fechaFin }}</li>
        <li><strong>Horario:</strong> {{ $curso->hora }}</li>
        <li><strong>Lugar:</strong> {{ $curso->lugar }}</li>
        <li><strong>Ciudad:</strong> {{ $curso->ciudad }}</li>
    </ul>

    <p>Gracias por confiar en nuestras actividades. Para cualquier duda puede responder este correo.</p>

    <p>Atentamente,<br>Equipo Mujer Es Emprender</p>
</body>
</html>
