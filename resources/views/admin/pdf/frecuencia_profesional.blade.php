<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0; padding: 0;
      color: #2c3e50;
      background: #fff;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      border-bottom: 2px solid #ddd;
    }
    .top-bar img {
      height: 60px;
    }
    .top-bar .right-text {
      font-size: 0.9rem;
      text-align: right;
      color: #555;
    }
    .title-bar {
      background-color: #6f42c1;
      color: #fff;
      text-align: center;
      padding: 1.2rem 2rem;
    }
    .title-bar h1 {
      margin: 0;
      font-size: 1.6rem;
      letter-spacing: 0.5px;
    }
    .meta {
      padding: 0.8rem 2rem;
      font-size: 0.85rem;
      border-bottom: 1px solid #ccc;
      background: #fafafa;
    }
    .summary {
      display: flex;
      justify-content: space-around;
      padding: 1rem 2rem;
      background: #f9f9f9;
    }
    .summary .card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 1rem;
      width: 30%;
      text-align: center;
      box-shadow: 0 3px 6px rgba(0,0,0,0.05);
    }
    .summary h2 {
      color: #6f42c1;
      font-size: 1.5rem;
      margin-bottom: 0.3rem;
    }
    .summary p {
      margin: 0;
      font-size: 0.9rem;
      color: #666;
    }
    .table-container {
      padding: 0 2rem 2rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9rem;
      margin-top: 1rem;
    }
    th, td {
      padding: 0.6rem;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background: #6f42c1;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #f2f2f2;
    }
    .footer {
      text-align: center;
      font-size: 0.75rem;
      color: #999;
      position: fixed;
      bottom: 0.5rem;
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="top-bar">
    <div>
      <img src="{{ public_path('images/pagweb-03.png') }}" alt="Semujeres">
    </div>
    <div class="right-text">
      Secretaría de las Mujeres<br>
      Informe estadístico filtrado
    </div>
  </div>

  <div class="title-bar">
    <h1>Informe de Frecuencias: {{ ucfirst($type) }}</h1>
  </div>

 <div class="meta">
  @if($from && $to)
    Rango: {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}<br>
  @else
    Rango: últimos 6 meses<br>
  @endif
  Generado el {{ \Carbon\Carbon::now()->format('d/m/Y \a \l\a\s H:i') }}
</div>


  <div class="summary">
    <div class="card">
      <h2>{{ array_sum($counts) }}</h2>
      <p>Total de {{ ucfirst($type) }}</p>
    </div>
    <div class="card">
      <h2>{{ number_format(array_sum($counts) / count($counts), 2) }}</h2>
      <p>Promedio mensual</p>
    </div>
    <div class="card">
      <h2>{{ max($counts) }}</h2>
      <p>Máximo en un mes</p>
    </div>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Mes</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        @foreach($labels as $i => $mes)
          <tr>
            <td>{{ $mes }}</td>
            <td>{{ $counts[$i] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="footer">
    © {{ date('Y') }} Secretaría de las Mujeres. Todos los derechos reservados.
  </div>
</body>
</html>
