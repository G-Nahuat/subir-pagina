<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error 404 - Página no encontrada</title>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
    }
    .lottie-fullscreen {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
    }
    .lottie-fullscreen lottie-player {
      width: 100%;
      height: 100%;
    }
    .error-overlay {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #7C3AED;
      text-align: center;
      z-index: 2;
    }
    .btn-purple {
      background-color: #7C3AED;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      text-decoration: none;
    }
    .btn-purple:hover {
      background-color: #5b21b6;
    }
  </style>
</head>
<body>
  <div class="lottie-fullscreen">
    <lottie-player
      src="{{ asset('animations/404-error-doodle-animation.json') }}"
      background="transparent"
      speed="1"
      loop
      autoplay
    ></lottie-player>
  </div>

  <div class="error-overlay">
    <h2>No deberías estar aquí</h2>
    <p>¿Te perdiste?</p>
    <a href="{{ url()->previous() }}" class="btn-purple">Regresar</a>
  </div>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>
</html>
