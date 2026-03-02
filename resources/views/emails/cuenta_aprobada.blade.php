<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cuenta Aprobada</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f5f3ff;
      padding: 20px;
      color: #4c1d95;
    }
    .container {
      max-width: 650px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(90, 42, 131, 0.15);
      overflow: hidden;
      position: relative;
    }
    .container::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 8px;
      background-color: #5a2a83;
    }
    .header {
      padding: 40px 40px 25px;
      text-align: center;
      position: relative;
    }
    .header::after {
      content: '';
      position: absolute;
      bottom: 0; left: 5%;
      width: 90%; height: 1px;
      background-color: #ddd6fe;
    }
    .logos {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 25px;
      margin-bottom: 25px;
    }
    .logos img {
      max-height: 65px;
      filter: drop-shadow(0 3px 5px rgba(90, 42, 131, 0.2));
    }
    .titulo {
      font-size: 34px;
      font-weight: 800;
      color: #5a2a83;
      margin: 15px 0 10px;
    }
    .subtitulo {
      color: #7C3AED;
      font-size: 17px;
      font-weight: 500;
      margin-bottom: 15px;
    }
    .body {
      padding: 40px;
    }
    .saludo {
      font-size: 24px;
      font-weight: 700;
      color: #5a2a83;
      margin-bottom: 20px;
    }
    .body p {
      font-size: 16px;
      line-height: 1.7;
      margin-bottom: 20px;
      color: #4b5563;
    }
    .highlight {
      color: #5a2a83;
      font-weight: 600;
    }
    .btn-container {
      text-align: center;
      margin: 35px 0;
    }
    .btn-verificar {
      display: inline-block;
      background-color: #5a2a83;
      color: #000000; /* Cambiado a negro */
      padding: 18px 50px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 700;
      font-size: 18px;
      box-shadow: 0 8px 20px rgba(90, 42, 131, 0.3);
      transition: all 0.3s ease;
      border: none;
    }
    .btn-verificar:hover {
      transform: translateY(-3px);
      background-color: #6d38a0;
      box-shadow: 0 12px 25px rgba(90, 42, 131, 0.4);
    }
    .icono {
      display: flex;
      justify-content: center;
      margin: 30px 0;
    }
    .icono svg {
      width: 90px;
      height: 90px;
      fill: #5a2a83;
    }
    .firma {
      margin-top: 40px;
      padding-top: 25px;
      border-top: 2px dashed #ddd6fe;
    }
    .firma p {
      color: #5a2a83;
      font-weight: 600;
    }
    .footer {
      background-color: #f5f3ff;
      color: #5a2a83;
      text-align: center;
      padding: 30px;
      font-size: 14px;
      position: relative;
    }
    .footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 5%;
      width: 90%;
      height: 1px;
      background-color: #ddd6fe;
    }
    @media (max-width: 650px) {
      .container { margin: 15px auto; border-radius: 15px; }
      .header, .body { padding: 25px; }
      .titulo { font-size: 28px; }
      .logos { flex-direction: column; gap: 15px; }
      .btn-verificar { padding: 16px 35px; font-size: 16px; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="logos">
        <img src="https://emprender.semujeres.qroo.gob.mx/images/QuintanaRooLogo.png" alt="Gobierno de Quintana Roo">
        <img src="https://emprender.semujeres.qroo.gob.mx/images/logosemujeres-01.png" alt="SEMUJERES">
      </div>
      <h1 class="titulo">¡Tu cuenta ha sido aprobada!</h1>
      <p class="subtitulo">Plataforma Mujer Es Emprender</p>
    </div>

    <div class="body">
      <h2 class="saludo">Hola👋</h2>
      <p>Nos complace informarte que tu cuenta ha sido <span class="highlight">aprobada</span> por el equipo de la Secretaría de las Mujeres.</p>
      <p>Ahora puedes iniciar sesión en la plataforma <strong>Mujer Es Emprender</strong> y comenzar a aprovechar todos los beneficios disponibles para ti.</p>

      <div class="btn-container">
        <a href="#" class="btn-verificar" target="_blank">Ir a la plataforma</a>
      </div>

      <p>Si tienes alguna duda o necesitas ayuda, puedes comunicarte con nuestro equipo de soporte.</p>

      <div class="icono">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
      </div>

      <div class="firma">
        <p>Atentamente,</p>
        <p><strong>Equipo Mujer Es Emprender</strong></p>
        <p>Secretaría de las Mujeres del Estado de Quintana Roo</p>
      </div>
    </div>

    <div class="footer">
      <p>Este correo fue generado automáticamente. No es necesario responder a este mensaje.</p>
      <p>© 2025 Secretaría de las Mujeres - Gobierno de Quintana Roo. Todos los derechos reservados.</p>
    </div>
  </div>
</body>
</html>