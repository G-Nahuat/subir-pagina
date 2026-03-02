<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción Confirmada</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>¡Hola {{ $nombre }}!</h2>

    <p>Tu inscripción al curso <strong>{{ $curso->nombre }}</strong> ha sido registrada exitosamente.</p>

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

    <p>Te esperamos puntual el día del curso. Si tienes dudas, puedes responder este mensaje.</p>

    <p>Saludos cordiales,<br>Equipo Mujer Es Emprender</p>
</body>
</html>
