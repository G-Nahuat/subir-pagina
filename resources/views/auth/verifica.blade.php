@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h2 class="fw-bold text-purple mb-3">¡Confirma tu correo electrónico!</h2>
    <p class="lead">Te hemos enviado un correo a <strong>{{ $email }}</strong>.</p>
    <p>Por favor, revisa tu bandeja de entrada o correo no deseado.</p>

    @if(Auth::check() && Auth::user()->hasVerifiedEmail())
        <!-- Ya verificado directamente -->
        <div class="mt-4" id="mensaje-verificado-directo">
            <h4 class="text-success fw-bold">✅ ¡Correo ya confirmado!</h4>
            <p>Tu cuenta ha sido verificada. El administrador revisará tu información.</p>
            <p class="text-muted">El proceso puede tardar entre <strong>1 a 5 días hábiles</strong>.</p>
            <a href="/" class="btn btn-success mt-3">Listo</a>
        </div>
    @else
        <!-- Esperando verificación -->
        <div class="mt-5" id="estado-verificacion">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3">No cierres esta ventana. Esperando confirmación de tu correo...</p>
        </div>

        <div class="mt-4 d-none" id="mensaje-verificado">
            <h4 class="text-success fw-bold">✅ ¡Correo confirmado exitosamente!</h4>
            <p>Tu cuenta ha sido verificada. Espera la aprobación por parte del administrador.</p>
            <p class="text-muted">El proceso puede tardar entre <strong>1 a 5 días hábiles</strong>.</p>
            <a href="/" class="btn btn-success mt-3">Listo</a>
        </div>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <!-- Sonido de confirmación -->
        <audio id="successSound" preload="auto">
            <source src="{{ asset('sounds/success.mp3') }}" type="audio/mpeg">
        </audio>

        <script>
    const sound = document.getElementById('successSound');
    const seccionCargando = document.getElementById('estado-verificacion');
    const mensajeVerificado = document.getElementById('mensaje-verificado');

    async function verificarCorreo() {
        try {
            const response = await fetch('/verificar-estado');
            const data = await response.json();

            if (data.verificado) {
                clearInterval(intervalo);

                // Reproducir sonido con seguridad
                sound.volume = 1;
                sound.play().catch((e) => {
                    console.log('Error al reproducir el sonido:', e);
                });

                // Mostrar mensaje de éxito
                seccionCargando.classList.add('d-none');
                mensajeVerificado.classList.remove('d-none');

                // Alerta visual
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo confirmado!',
                    text: 'Tu cuenta ha sido verificada correctamente. El administrador debe aprobar tu solicitud.',
                    confirmButtonText: 'Aceptar'
                });
            }
        } catch (error) {
            console.error('Error al verificar el correo:', error);
        }
    }

    // Ejecutar cada 5 segundos
    const intervalo = setInterval(verificarCorreo, 5000);
</script>

    @endif
</div>
@endsection
