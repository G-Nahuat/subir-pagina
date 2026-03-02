@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Bootstrap Bundle (incluye Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="py-5 px-3" style="background-color:;min-height:100vh;">
  <div class="container p-4 rounded shadow-lg bg-white" style="max-width:950px;">
    <div class="card-body">
     <form method="POST" action="{{ route('registro.store') }}" id="formSolicitud" enctype="multipart/form-data">
        @csrf

        <div class="section-underline">
          <h3 class="section-title">Datos Personales</h3>
        </div>

        <div class="row">
          <!-- Nombre(s) -->
          <div class="col-lg-4 col-md-6 mb-3">
            <input name="nombre" required placeholder="Nombre(s)*" class="form-control border-purple rounded-pill" autocomplete="given-name" />
          </div>
          <!-- Primer Apellido -->
          <div class="col-lg-4 col-md-6 mb-3">
            <input name="primer_apellido" required placeholder="Primer Apellido*" class="form-control border-purple rounded-pill" autocomplete="family-name" />
          </div>
          <!-- Segundo Apellido -->
          <div class="col-lg-4 col-md-6 mb-3">
            <input name="segundo_apellido" placeholder="Segundo Apellido" class="form-control border-purple rounded-pill" autocomplete="additional-name" />
          </div>

        <!-- Email -->
<div class="col-lg-4 col-md-6 mb-3">
  <input name="email" type="email" required placeholder="Correo Electrónico*" id="emailInput"
    class="form-control border-purple rounded-pill" autocomplete="email" />
  <div id="emailError" class="invalid-feedback d-none">
    Este correo ya está registrado. Usa otro.
  </div>
</div>

          <!-- Contraseña -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="position-relative">
              <input name="password" id="password" type="password" required placeholder="Contrasena*" class="form-control border-purple rounded-pill pr-5" style="padding-right:40px;" autocomplete="new-password" />
              <i class="bi bi-eye position-absolute" onclick="togglePassword('password',this)" style="top:50%;right:15px;transform:translateY(-50%);cursor:pointer;"></i>
            </div>
            <div class="progress mt-2" style="height:8px;">
              <div id="password-strength-fill" class="progress-bar bg-danger" style="width:0%;transition:width 0.3s;"></div>
            </div>
            <small id="password-strength-text" class="form-text"></small>
          </div>
          <!-- Confirmar contraseña -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div class="position-relative">
              <input name="password_confirmation" id="confirmPassword" type="password" required placeholder="Confirmar Contrasena*" class="form-control border-purple rounded-pill pr-5" style="padding-right:40px;" autocomplete="new-password" />
              <i class="bi bi-eye position-absolute" onclick="togglePassword('confirmPassword',this)" style="top:50%;right:15px;transform:translateY(-50%);cursor:pointer;"></i>
            </div>
            <small id="passwordMatchMessage" class="form-text text-danger"></small>
          </div>
          <!-- CURP -->
          <div class="col-lg-4 col-md-6 mb-3">
            <input name="curp" required placeholder="CURP*" maxlength="18" class="form-control border-purple rounded-pill" autocomplete="off" />
            <small><a href="https://www.gob.mx/curp/" class="text-purple" target="_blank">No sabes cual es tu CURP?</a></small>
          </div>

            <!-- Edad -->
<div class="col-lg-4 col-md-6 mb-3">
  <input name="edad" type="number" min="1" max="120" required placeholder="Edad*" class="form-control border-purple rounded-pill sin-spinners" />
</div>

          <!-- Foto de INE -->
          <div class="col-lg-4 col-md-6 mb-3">
            <div id="ineDrop" class="ine-drop-zone rounded-pill border-purple d-flex align-items-center justify-content-center text-center px-3 py-2">
              <span class="ine-drop-text"><i class="bi bi-card-image me-1"></i>Subir INE</span>
            </div>
           <input type="file" name="foto_ine[]" id="fotoIne" accept=".pdf" required multiple class="d-none" />
            <div id="inePreviewWrapper" class="mt-2 d-none">
              <img id="inePreviewImg" src="" alt="Preview INE" class="img-thumbnail" style="max-height:120px;" />
            </div>
          </div>

          <!-- Telefono -->
          <div class="col-lg-4 col-md-6 mb-3">
            <input name="telefono" required placeholder="Numero de Telefono*" class="form-control border-purple rounded-pill" autocomplete="tel" />
          </div>
          <!-- Municipio -->

<div class="col-lg-4 col-md-6 mb-3">
  <select name="municipio_id" class="form-control border-purple rounded-pill" required>
    <option value="">Seleccione un municipio</option>
    @foreach($municipios as $municipio)
      <option value="{{ $municipio->id_municipio }}">{{ $municipio->municipio }}</option>
    @endforeach
  </select>
</div>

          
          <!-- Nivel de Estudios -->
          <div class="col-lg-4 col-md-6 mb-3">
            <select name="grado_estudios" id="gradoEstudios" class="form-control border-purple rounded-pill">
              <option value="">Nivel de Estudios</option>
              @foreach($grados as $grado)
                <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
              @endforeach
            </select>
          </div>
          <!-- Direccion Particular -->
          <div class="col-lg-8 col-md-6 mb-3">
            <input name="direccion_particular" required placeholder="Direccion Particular*" class="form-control border-purple rounded-pill" autocomplete="street-address" />
          </div>

          <!-- Continuar Estudios -->
          <div class="col-lg-4 col-md-6 mb-3 d-none" id="continuarEstudiosBox">
            <select name="quiere_continuar" id="quiereContinuar" class="form-control border-purple rounded-pill">
              <option value="">Deseas continuar estudiando?</option>
              <option value="Si">Si</option>
              <option value="No">No</option>
            </select>
          </div>
          <!-- Razon No Estudiar -->
          <div class="col-12 mb-3 d-none" id="razonNoEstudiarBox">
            <input type="text" name="razon_no_estudiar" placeholder="Por que no deseas continuar estudiando?" class="form-control border-purple rounded-pill" />
          </div>
        </div>

        <!-- Separador antes del aviso -->
        <hr class="my-5" />

        <div class="text-center mt-5">
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="aceptaAviso" required>
           <label class="form-check-label fw-bold text-dark" for="aceptaAviso">
  He leído el <a href="#" data-bs-toggle="modal" data-bs-target="#modalAvisoPrivacidad">Aviso de Privacidad</a> y estoy de acuerdo con lo establecido.
</label>

          </div>
          <button type="submit" class="btn px-5 fw-bold rounded-pill" style="background-color:#6a1b9a;color:#fff;">
            ENVIAR SOLICITUD
          </button>
        </div>

      </form>
      
<!-- Modal Aviso de Privacidad con estilo consistente -->
<div class="modal fade" id="modalAvisoPrivacidad" tabindex="-1" aria-labelledby="modalAvisoPrivacidadLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4 border-0 shadow aviso-purple">
      <div class="modal-header bg-purple text-white rounded-top-4 py-3 px-4">
        <h5 class="modal-title fw-bold w-100 text-center" id="modalAvisoPrivacidadLabel">Aviso de Privacidad</h5>
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body px-5 py-4 text-dark" style="line-height: 1.8;">
        <p>La información personal recabada será utilizada exclusivamente para fines del programa <strong>"Mujer Es Emprender"</strong>, incluyendo la verificación de identidad, contacto, análisis estadístico, entre otros relacionados.</p>
        <p>Usted puede ejercer sus derechos de acceso, rectificación, cancelación u oposición (ARCO) conforme a la legislación vigente. Para mayor información, contacte a la institución responsable del programa.</p>
        <p>Al aceptar este aviso, usted consiente que sus datos sean tratados conforme a las disposiciones señaladas.</p>
      </div>
      <div class="modal-footer border-0 justify-content-center pb-4">
        <button type="button" class="btn btn-purple rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Aceptar y cerrar</button>
      </div>
    </div>
  </div>
</div>




    </div>
  </div>
</div>

<style>.bg-purple {
  background-color: #6a1b9a !important;
    background: url('{{ asset("images/fondo22(1)(1).png") }}') fixed;
            background-size: cover;
            background-position: center;
            position: relative;
}

  body {
            background: url('{{ asset("images/fondo22(1)(1).png") }}') fixed;
            background-size: cover;
            background-position: center;
            position: relative;
        }

.btn-purple {
  background-color: #6a1b9a;
  color: white;
  border: none;
}
.btn-purple:hover {
  background-color: #4a0c72;
  color: white;
}

.aviso-purple {
  border: 3px solid #6a1b9a;
  background-color: #ffffff;
}



  /* Oculta flechas en Chrome, Safari, Edge */
  .sin-spinners::-webkit-outer-spin-button,
  .sin-spinners::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Oculta flechas en Firefox */
  .sin-spinners {
    -moz-appearance: textfield;
  }
  .section-underline {
    border-bottom:2px solid #6a1b9a;
    margin-bottom:1.5rem;
    padding-bottom:10px;
    width:100%;
  }
  .section-title {
    color:#6a1b9a;
    font-weight:bold;
    margin:0;
  }
  input::placeholder,
  select {
    color:#6a1b9a;
  }
  .form-control,
  .form-select {
    box-shadow:none!important;
  }
  .form-control.rounded-pill,
  .form-select.rounded-pill {
    border-width:2px!important;
    border-color:#6a1b9a!important;
    border-radius:50px!important;
  }
  .form-check-label a {
    color:#6a1b9a;
    text-decoration:underline;
  }
  input::-ms-reveal,
  input::-ms-clear,
  input::-webkit-contacts-auto-fill-button,
  input::-webkit-credentials-auto-fill-button {
    display:none!important;
  }
  .border-purple {
    border:2px solid #6a1b9a!important;
  }
  .text-purple {
    color:#6a1b9a!important;
  }
  /* INE drop zone */
  .ine-drop-zone {
    border:2px dashed #6a1b9a;
    min-height:46px;
    cursor:pointer;
    transition:background-color .2s,border-color .2s;
    color:#6a1b9a;
    font-weight:600;
    font-size:.95rem;
  }
  .ine-drop-zone:hover,
  .ine-drop-zone.dragover {
    background-color:rgba(106,27,154,.08);
    border-color:#5b1788;
  }
  .ine-drop-text i {
    font-size:1.1rem;
    vertical-align:middle;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const emailInput = document.getElementById('emailInput');
  const emailError = document.getElementById('emailError');
  const form = document.getElementById('formSolicitud');

  let emailDuplicado = false;

  async function verificarCorreo() {
    const email = emailInput.value.trim();
    if (email === '') return false;

    try {
      const response = await fetch(`/verificar-email?email=${encodeURIComponent(email)}`);
      const data = await response.json();

      if (data.exists) {
        emailInput.classList.add('is-invalid');
        emailError.classList.remove('d-none');
        emailDuplicado = true;
      } else {
        emailInput.classList.remove('is-invalid');
        emailError.classList.add('d-none');
        emailDuplicado = false;
      }
    } catch (err) {
      console.error('Error al verificar el correo:', err);
      emailDuplicado = false;
    }
  }


  // Validar al salir del campo
  if (emailInput) {
    emailInput.addEventListener('blur', verificarCorreo);
  }


  // Validación al enviar
  form.addEventListener('submit', async function (event) {
    event.preventDefault();
    event.stopPropagation();

    await verificarCorreo(); // Esperar verificación de correo

    if (!form.checkValidity() || emailDuplicado) {
      form.classList.add('was-validated');
      return; // 
    }

    Swal.fire('¡Éxito!', 'Solicitud enviada correctamente (puede tardar 1 a 5 días hábiles).', 'success')
      .then(() => form.submit());

    form.classList.add('was-validated');
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded',function(){

  // toggle contrasena
  window.togglePassword=function(inputId,icon){
    const inp=document.getElementById(inputId);
    if(!inp)return;
    if(inp.type==='password'){
      inp.type='text';
      icon.classList.replace('bi-eye','bi-eye-slash');
    }else{
      inp.type='password';
      icon.classList.replace('bi-eye-slash','bi-eye');
    }
  };

  // fuerza y match
  const pwd=document.getElementById('password');
  const confirm=document.getElementById('confirmPassword');
  const bar=document.getElementById('password-strength-fill');
  const text=document.getElementById('password-strength-text');
  const matchMsg=document.getElementById('passwordMatchMessage');

  function evalStrength(){
    if(!pwd)return;
    const v=pwd.value;
    const checks=[
      v.length>=6,
      /[A-Z]/.test(v),
      /[0-9]/.test(v),
      /[^A-Za-z0-9]/.test(v)
    ].filter(c=>c).length;
    let width=0,cls='bg-danger',label='Debil';
    if(checks===1)width=25;
    if(checks===2){width=50;cls='bg-warning';label='Media';}
    if(checks===3){width=75;cls='bg-info';label='Buena';}
    if(checks===4){width=100;cls='bg-success';label='Fuerte';}
    bar.style.width=width+'%';
    bar.className='progress-bar '+cls;
    text.textContent=label;
  }

  function checkMatch(){
    if(!confirm)return;
    if(confirm.value&&pwd.value!==confirm.value){
      matchMsg.textContent='Las contrasenas no coinciden';
    }else{
      matchMsg.textContent='';
    }
  }

  if(pwd)pwd.addEventListener('input',()=>{evalStrength();checkMatch();});
  if(confirm)confirm.addEventListener('input',checkMatch);

  // negocio alta -> razon
  const altaSat=document.getElementById('negocioAlta');
  const boxRaz=document.getElementById('razonNoAltaBox');
  if(altaSat&&boxRaz){
    altaSat.addEventListener('change',function(){
      boxRaz.classList.toggle('d-none',this.value!=='No');
    });
  }

  // estudios -> continuar / razon
  const gradoSelect=document.getElementById('gradoEstudios');
  const continuarBox=document.getElementById('continuarEstudiosBox');
  const razonBox=document.getElementById('razonNoEstudiarBox');
  const deseaContinuar=document.getElementById('quiereContinuar');
  const opcionesQuePreguntan=[
    'Sin escolaridad','Preescolar Inconclusa','Preescolar','Primaria Inconclusa','Primaria','Secundaria Inconclusa','Secundaria','Preparatoria Inconclusa'
  ];
  if(gradoSelect){
    gradoSelect.addEventListener('change',function(){
      const textoSel=this.options[this.selectedIndex].text;
      if(opcionesQuePreguntan.includes(textoSel)){
        continuarBox.classList.remove('d-none');
      }else{
        continuarBox.classList.add('d-none');
        razonBox.classList.add('d-none');
        deseaContinuar.value='';
      }
    });
  }

  if(deseaContinuar){
    deseaContinuar.addEventListener('change',function(){
      if(this.value==='No'){
        razonBox.classList.remove('d-none');
        razonBox.querySelector('input').setAttribute('required','required');
      }else{
        razonBox.classList.add('d-none');
        const inp=razonBox.querySelector('input');
        inp.removeAttribute('required');
        inp.value='';
      }
    });
  }

  // INE drag, click, preview, validacion
  const ineDrop=document.getElementById('ineDrop');
  const fotoIne=document.getElementById('fotoIne');
  const ineFileInfo=document.getElementById('ineFileInfo');
  const inePreviewWrapper=document.getElementById('inePreviewWrapper');
  const inePreviewImg=document.getElementById('inePreviewImg');
  const allowedTypes = ['application/pdf']; // ← aquí limita a PDF
  const maxSize=8*1024*1024;

  function resetInePreview(){
    inePreviewWrapper.classList.add('d-none');
    inePreviewImg.src='';
    ineFileInfo.textContent='Formatos: JPG, PNG, WEBP o PDF. Max 8MB.';
  }

  function handleIneFile(file){
    if(!file)return;
    if(!allowedTypes.includes(file.type)){
      Swal.fire('Formato no valido','Solo archivos JPG, PNG, WEBP o PDF.','error');
      fotoIne.value='';
      resetInePreview();
      return;
    }
    if(file.size>maxSize){
      Swal.fire('Archivo muy grande','Maximo 8MB.','error');
      fotoIne.value='';
      resetInePreview();
      return;
    }
    ineFileInfo.textContent='Seleccionado: '+file.name;
    if(file.type==='application/pdf'){
      inePreviewWrapper.classList.add('d-none');
    }else{
      const reader=new FileReader();
      reader.onload=e=>{
        inePreviewImg.src=e.target.result;
        inePreviewWrapper.classList.remove('d-none');
      };
      reader.readAsDataURL(file);
    }
  }

  if(ineDrop&&fotoIne){
    ineDrop.addEventListener('click',()=>fotoIne.click());
    ineDrop.addEventListener('dragover',e=>{
      e.preventDefault();
      ineDrop.classList.add('dragover');
    });
    ineDrop.addEventListener('dragleave',()=>ineDrop.classList.remove('dragover'));
    ineDrop.addEventListener('drop',e=>{
      e.preventDefault();
      ineDrop.classList.remove('dragover');
      if(e.dataTransfer.files.length){
        fotoIne.files=e.dataTransfer.files;
        handleIneFile(fotoIne.files[0]);
      }
    });
    fotoIne.addEventListener('change',function(){
      handleIneFile(this.files[0]);
    });
  }

  

});

//
document.addEventListener('DOMContentLoaded', () => {
  const dropZone = document.getElementById('ineDrop');
  const inputFile = document.getElementById('fotoIne');
  const textPreview = dropZone.querySelector('.ine-drop-text');

  const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
  const maxFileSize = 8 * 1024 * 1024; // 8MB

  function resetInput() {
    inputFile.value = '';
    textPreview.textContent = 'Subir INE';
  }

  function validarArchivos(files) {
    if (files.length > 2) {
      alert('Solo puedes subir un máximo de 2 archivos (frente y reverso de la INE).');
      resetInput();
      return false;
    }

    for (let file of files) {
      if (!allowedTypes.includes(file.type)) {
        alert('Solo se permiten archivos JPG, PNG, WEBP o PDF.');
        resetInput();
        return false;
      }

      if (file.size > maxFileSize) {
        alert('Cada archivo debe pesar como máximo 8MB.');
        resetInput();
        return false;
      }
    }

    return true;
  }

  // Drag and drop
  dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.classList.add('dragover');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
  });

  dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const archivos = e.dataTransfer.files;

    if (validarArchivos(archivos)) {
      inputFile.files = archivos;
      textPreview.textContent = `${archivos.length} archivo(s) seleccionado(s)`;
    }
  });

  // Cambio manual por input
  inputFile.addEventListener('change', function () {
    const archivos = this.files;
    if (validarArchivos(archivos)) {
      textPreview.textContent = `${archivos.length} archivo(s) seleccionado(s)`;
    }
  });

});
</script>



@endsection
