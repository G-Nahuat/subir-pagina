<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenida a Mujer Es Emprender</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
   <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f5f3ff;
      margin: 0;
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
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background-color: #5a2a83;
    }
    
    .header {
      padding: 40px 40px 25px;
      background-color: #ffffff;
      text-align: center;
      position: relative;
    }
    
    .header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 5%;
      width: 90%;
      height: 1px;
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
      transition: transform 0.3s ease;
      filter: drop-shadow(0 3px 5px rgba(90, 42, 131, 0.2));
    }
    
    .logos img:hover {
      transform: scale(1.05);
    }
    
    .titulo {
      font-size: 34px;
      font-weight: 800;
      color: #5a2a83;
      margin: 15px 0 10px;
      letter-spacing: -0.5px;
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
    
    .badge {
      display: inline-block;
      background-color: #5a2a83;
      color: white;
      padding: 10px 22px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 25px;
      box-shadow: 0 5px 15px rgba(90, 42, 131, 0.2);
      letter-spacing: 0.5px;
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
      color: white;
      padding: 18px 50px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 700;
      font-size: 18px;
      box-shadow: 0 8px 20px rgba(90, 42, 131, 0.3);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      border: none;
      cursor: pointer;
      letter-spacing: 0.5px;
    }
    
    .btn-verificar:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(90, 42, 131, 0.4);
      background-color: #6d38a0;
    }
    
    .btn-verificar:active {
      transform: translateY(0);
    }
    
    .advertencia {
      background-color: #faf5ff;
      border: 2px solid #ddd6fe;
      padding: 18px 25px;
      border-radius: 12px;
      margin: 30px 0;
      font-size: 15px;
      color: #5a2a83;
      box-shadow: 0 5px 15px rgba(90, 42, 131, 0.1);
    }
    
    .advertencia strong {
      color: #5a2a83;
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
      opacity: 0.9;
      filter: drop-shadow(0 5px 10px rgba(90, 42, 131, 0.2));
    }
    
    .firma {
      margin-top: 40px;
      padding-top: 25px;
      border-top: 2px dashed #ddd6fe;
    }
    
    .firma p {
      color: #5a2a83;
      font-weight: 600;
      margin-bottom: 8px;
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
    
    .redes {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px 0;
    }
    
    .redes a {
      display: inline-block;
      width: 42px;
      height: 42px;
      background-color: #5a2a83;
      border-radius: 50%;
      text-align: center;
      line-height: 42px;
      color: white;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 600;
      box-shadow: 0 5px 10px rgba(90, 42, 131, 0.2);
    }
    
    .redes a:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 15px rgba(90, 42, 131, 0.3);
      background-color: #7C3AED;
    }
    
    .corazon {
      color: #8e44ad;
      font-size: 1.2em;
    }
    
    @media (max-width: 650px) {
      .container {
        margin: 15px auto;
        border-radius: 15px;
      }
      
      .header, .body {
        padding: 25px;
      }
      
      .titulo {
        font-size: 28px;
      }
      
      .logos {
        flex-direction: column;
        gap: 15px;
      }
      
      .btn-verificar {
        padding: 16px 35px;
        font-size: 16px;
      }
    }

    .logo-placeholder {
      width: 180px;
      height: 65px;
      background-color: #5a2a83;
      border-radius: 8px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-weight: bold;
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
      <h1 class="titulo">¡Bienvenida a la comunidad!</h1>
      <p class="subtitulo">Plataforma Mujer Es Emprender</p>
    </div>

    <!-- Cuerpo del mensaje -->
    <div class="body">
   
      <h2 class="saludo">¡Hola!</h2>

      <p>¡Gracias por registrarte en la plataforma <span class="highlight">Mujer Es Emprender</span> y formar parte de este programa!</p>
      
      <p>Desde la Secretaría de las Mujeres de Quintana Roo estamos muy felices de darte la bienvenida a esta comunidad que impulsa el talento, la creatividad y la fuerza de las mujeres emprendedoras como tú.</p>

      <p>Para activar tu cuenta y comenzar a disfrutar de todos los beneficios, por favor confirma tu dirección de correo electrónico haciendo clic en el siguiente botón:</p>

      <div class="btn-container">
        <a href="{{ $url }}" class="btn-verificar" target="_blank">Activar mi cuenta</a>
      </div>

      <div class="advertencia">
        <strong>Importante:</strong> Este enlace de verificación expirará en <strong>60 minutos</strong> por motivos de seguridad. Si no puedes acceder ahora, puedes solicitar un nuevo enlace desde la plataforma.
      </div>

      <p>Si no realizaste este registro, por favor ignora este mensaje.</p>
      
      <p>Este es un espacio creado para acompañarte en tu camino emprendedor. <span class="corazon">💜</span></p>

      <div class="icono">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>

      <div class="firma">
        <p>Con cariño,</p>
        <p><strong>La Secretaría de las Mujeres de Quintana Roo</strong></p>
      </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
      <p>Este correo fue generado automáticamente. No es necesario responder a este mensaje.</p>
      <p>© 2025 Secretaría de las Mujeres - Gobierno de Quintana Roo. Todos los derechos reservados.</p>
    </div>

  </div>
</body>
</html>