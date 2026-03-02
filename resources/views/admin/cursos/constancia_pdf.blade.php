<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0cm;
        }
        body {
            margin: 0cm;
            background-image: url('{{ $plantilla }}');
            background-size: cover;
            font-family: DejaVu Sans;
        }
        .contenido {
            position: absolute;
            top: 58%; /* Ajusta según la plantilla */
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 80%;
        }
        .nombre {
            font-size: 24px;
            font-weight: bold;
            color: #AB0A3D;
        }
        .descripcion {
            margin-top: 10px;
            font-size: 14px;
            color: #3D3935;
        }
    </style>
</head>
<body>
    <div class="contenido">
        <div class="nombre">{{ $nombre }}</div>
        <div class="descripcion">{!! nl2br(e($descripcion)) !!}</div>
    </div>
</body>
</html>
