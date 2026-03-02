@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:85vh;">
  <div class="card shadow p-4" style="max-width:420px; width:100%;">
    <div class="text-center mb-4">
      <img src="{{ asset('images/logosemujeres-01.png') }}" alt="" style="height:60px;">
    </div>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="text-center mb-3">
      <strong>¿Cómo quieres iniciar sesión?</strong>
    </div>
    <div class="btn-group d-flex mb-4" role="group">
      <button type="button" class="btn btn-outline-purple flex-fill login-type-btn active" data-type="correo">Correo</button>
      <button type="button" class="btn btn-outline-purple flex-fill login-type-btn" data-type="curp">CURP</button>
    </div>

    <form action="{{ route('perfil.login') }}" method="POST">
      @csrf
      <input type="hidden" name="login_type" id="loginType" value="correo">

      <div class="mb-3">
        <input type="text" name="login_value" id="loginValue"
               class="form-control" placeholder="Correo">
      </div>

      <div class="mb-4 position-relative">
        <input type="password" name="password" id="passwordInput"
               class="form-control" placeholder="Contraseña">
        <button type="button" class="btn toggle-password" onclick="togglePassword()">
          <i id="toggleIcon" class="fas fa-eye"></i>
        </button>
      </div>
      <button type="submit" class="btn btn-purple w-100">Entrar</button>
    </form>

    <div class="text-center mt-3">
      <small>¿No tienes cuenta?</small>
      <br>
      <a href="{{ route('registro.create') }}" class="btn btn-link text-purple p-0">Registrate aquí</a>
    </div>
  </div>
</div>
<style>

body {
    background: url('{{ asset("images/fondo22(1)(1).png") }}') fixed;
    background-size: cover;
    background-position: center;
    position: relative;
    }
.btn-outline-purple {
  border: 2px solid #452166;
  color: #452166;
} 
.btn-outline-purple.active,
.btn-outline-purple:hover {
  background: #452166;
  color: #fff;
}
.btn-purple {
  background: #452166;
  color: #fff;
  border: none;
}
.toggle-password {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #452166;
  font-size: 1.2rem;
  cursor: pointer;
  z-index: 2;
}
#passwordInput {
  padding-right: 2.5rem;
}
</style>

<script>
const loginBtns = document.querySelectorAll('.login-type-btn');
const typeInput = document.getElementById('loginType');
const valueInput = document.getElementById('loginValue');

loginBtns.forEach(button => {
  button.addEventListener('click', () => {
    loginBtns.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
    const type = button.dataset.type;
    typeInput.value = type;
    valueInput.placeholder = button.textContent;
  });
});

function togglePassword() {
  const passwordInput = document.getElementById('passwordInput');
  const toggleIcon = document.getElementById('toggleIcon');
  const newType = passwordInput.type === 'password' ? 'text' : 'password';
  passwordInput.type = newType;
  toggleIcon.classList.toggle('fa-eye');
  toggleIcon.classList.toggle('fa-eye-slash');
}
</script>
@endsection
