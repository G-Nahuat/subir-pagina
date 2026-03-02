<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Producto Rechazado</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #fdf2f8;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      border-left: 12px solid #dc2626; /* Rojo más fuerte */
    }

    .header {
      padding: 25px 20px 10px;
      background-color: #ffffff;
    }

    .logos {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logos img {
      max-height: 55px;
    }

    .titulo {
      text-align: center;
      font-size: 28px;
      font-weight: 700;
      color: #dc2626;
      margin-top: 20px;
    }

    .body {
      padding: 30px;
      color: #333333;
    }

    .body h2 {
      color: #dc2626;
      font-size: 20px;
      margin-top: 0;
      font-weight: 700;
    }

    .body p {
      font-size: 15px;
      line-height: 1.7;
      margin-bottom: 16px;
    }

    .footer {
      background-color: #f5f5f5;
      color: #888;
      text-align: center;
      padding: 18px;
      font-size: 13px;
    }

    .badge {
      display: inline-block;
      background-color: #fee2e2;
      color: #991b1b;
      padding: 6px 14px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .text-red {
      color: #991b1b;
    }
  </style>
</head>
<body>

  <div class="container">

    <!-- Encabezado -->
    <div class="header">
      <div class="logos">
        <img src="https://emprender.semujeres.qroo.gob.mx/images/QuintanaRooLogo.png" alt="Gobierno de Quintana Roo">
        <img src="https://emprender.semujeres.qroo.gob.mx/images/logosemujeres-01.png" alt="SEMUJERES">
      </div>
      <div class="titulo">Producto Rechazado</div>
    </div>

    <!-- Cuerpo del mensaje -->
    <div class="body">
      <div class="badge">Secretaría de las Mujeres</div>

      <h2>Estimad@ {{ $nombre }}:</h2>

      <p>Lamentamos informarle que su producto <strong>{{ $producto->nombreproducto }}</strong> ha sido <strong>rechazado</strong> tras la revisión por parte del equipo de la plataforma <strong>Mujer Es Emprender</strong>.</p>

      <p><strong>Motivo del rechazo:</strong><br> {{ $razon }}</p>

      <p class="text-red">Le invitamos a revisar las observaciones y realizar las correcciones necesarias para volver a enviar su producto.</p>

      <p>Agradecemos su comprensión y reiteramos nuestro compromiso con el impulso a las emprendedoras de Quintana Roo.</p>

      <p>Cordialmente,</p>

      <p><strong>Equipo Mujer Es Emprender</strong><br>Secretaría de las Mujeres del Estado de Quintana Roo</p>
    </div>

    <!-- Pie de página -->
    <div class="footer">
      Este correo fue generado automáticamente. No es necesario responder a este mensaje.
    </div>

  </div>
</body>
</html>
