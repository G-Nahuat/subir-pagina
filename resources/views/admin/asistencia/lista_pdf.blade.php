<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Asistencia</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 4px; text-align: center; }
        th { background-color: #eee; }
        h3 { text-align: center; margin-bottom: 5px; }
        .nombre { text-align: left; }
    </style>
</head>
<body>

    <h3>Lista de Asistencia - Grupo {{ $grupo }}</h3>
    <p><strong>Curso:</strong> {{ $curso->nombre }}</p>
    <p><strong>Fechas:</strong> {{ $curso->fecha }}</p>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                @foreach($periodo as $dia)
                    <th>{{ \Carbon\Carbon::parse($dia)->format('d/m') }}</th>
                @endforeach
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistentes as $a)
                <tr>
                    <td class="nombre">{{ $a->nombre }}</td>
                    @php $total = 0; @endphp
                    @foreach($periodo as $dia)
                        @php
                            $asistio = $a->diasAsistidos->contains('fecha', $dia->format('Y-m-d'));
                            if ($asistio) $total++;
                        @endphp
                        <td>{{ $asistio ? 'X' : '' }}</td>
                    @endforeach
                    <td>{{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
