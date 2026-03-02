@extends('layouts.app')
@section('hideNavbar', '')

@section('content')

@section('styles')

<style>
  #openSidebar {
    display: none !important;
  }
</style>  

@endsection

<!-- Intro.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">
<!-- Estilos personalizados -->
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<div class="barra-superior d-flex justify-content-between align-items-center flex-wrap px-3 py-2">
  {{-- Logos a la izquierda --}}
  <div class="logos d-flex align-items-center gap-6 mb-2 mb-md-0">
    <img src="{{ asset('images/QuintanaRooLogo.png') }}" alt="Qroo" class="img-fluid" style="max-height:50px;">
    <img src="{{ asset('images/logosemujeres-01.png') }}" alt="Semujeres" class="img-fluid" style="max-height:50px;">
  </div>
</div>

{{-- Línea morada degradada de separación --}}
<hr
  style="border: 0;
         height: 4px;
         background: linear-gradient(to right, #7C3AED, #C084FC);
         margin-top: 0;
         margin-bottom: 30px;
         border-radius: 2px;"
>



{{-- CONTENEDOR PRINCIPAL DE PERFIL --}}
<div class="row m-0" style="min-height: calc(100vh - 80px);">

  {{-- COLUMNA IZQUIERDA - INFORMACIÓN --}}
  <div class="col-md-3 p-0">
    <div class="bg-lila h-100 d-flex flex-column align-items-center p-4">

      <h3 class="fw-bold text-purple mb-4 w-100 text-start">Información</h3>

      {{-- Tarjeta del usuario --}}
      <div class="info-card w-100 text-center bg-white shadow-sm p-4 rounded-4">

        {{-- FOTO O ÍCONO + OVERLAY --}}
        <div class="mb-3 d-flex justify-content-center">
          <div style="position: relative; width: 120px; height: 120px;">
            @if($datos->avatar)
              <img
                src="{{ asset('storage/' . $datos->avatar) }}"
                alt="Foto de perfil"
                class="rounded-circle"
                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #7C3AED;">
            @else
              <div
  class="rounded-circle d-flex justify-content-center align-items-center shadow-sm"
  style="width: 120px; height: 120px; background-color: #7C3AED; color: white; font-size: 3rem; border: 3px solid #7C3AED;">
  <i class="fas fa-user"></i>
</div>

            @endif

            {{-- Overlay --}}
            <div 
                style="position: absolute;
                top: 0;
                left: 0;
                width: 120px;
                height: 120px;
                border-radius: 50%;
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                display: flex;
                justify-content: center;
                align-items: center;
                opacity: 0;
                transition: opacity 0.3s;
                cursor: pointer;
                z-index: 10;"
              onmouseover="this.style.opacity=1"
              onmouseout="this.style.opacity=0"
              onclick="document.getElementById('avatarInput').click();">
              <i class="fas fa-camera fa-lg"></i>
            </div>

           <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;">

          </div>
        </div>

        {{-- DATOS --}}
        <h4 class="fw-bold text-purple mb-1">
          {{ $datos->nombre ?? '—' }} {{ $datos->apellido_paterno ?? '' }} {{ $datos->apellido_materno ?? '' }}
        </h4>
        <p class="text-muted small mb-1"><strong>CURP:</strong> {{ $datos->curp ?? 'No disponible' }}</p>
        <p class="text-muted small mb-1"><strong>Email:</strong> {{ $datos->email ?? 'No disponible' }}</p>
        <p class="text-muted small"><strong>Teléfono:</strong> {{ $datos->telefono ?? 'No disponible' }}</p>
       
@php
    $urlPerfil = route('perfil.publico', auth()->id());
@endphp

<!--  BOTÓN DE COMPARTIR -->
<button onclick="compartirPerfil('{{ $urlPerfil }}')" class="btn btn-outline-purple rounded-pill w-100">
  <i class="fas fa-share-alt me-2"></i> Compartir perfil
</button>

      </div>

    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function compartirPerfil(urlPerfil) {
    if (navigator.share) {
      navigator.share({
        title: 'Perfil de emprendimiento',
        text: '¡Conoce mi perfil en MujerEs Emprender!',
        url: urlPerfil
      });
    } else {
      Swal.fire({
        title: 'Compartir perfil',
        html: `
          <div class="d-flex flex-column gap-2 mt-3">
            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(urlPerfil)}" target="_blank" class="btn btn-primary w-100">
              <i class="fab fa-facebook-f me-2"></i> Facebook
            </a>
            <a href="https://wa.me/?text=${encodeURIComponent('Conoce mi perfil: ' + urlPerfil)}" target="_blank" class="btn btn-success w-100">
              <i class="fab fa-whatsapp me-2"></i> WhatsApp
            </a>
            <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent('Conoce mi perfil: ' + urlPerfil)}" target="_blank" class="btn btn-info w-100">
              <i class="fab fa-x-twitter me-2"></i> Twitter (X)
            </a>
            <a href="mailto:?subject=Conoce mi perfil&body=${encodeURIComponent('Mira mi perfil en: ' + urlPerfil)}" class="btn btn-dark w-100">
              <i class="fas fa-envelope me-2"></i> Correo
            </a>
          </div>
        `,
        confirmButtonText: 'Cerrar'
      });
    }
  }
</script>

@if(session('success'))



<script>
  Swal.fire({
    icon: 'success',
    title: '¡Listo!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif

<!-- Cropper.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Modal de recorte -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 400px; max-height: 500px;">

    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="cropperModalLabel">Recorta tu imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
       <img id="imagePreview" style="width: 300px; height: 300px; object-fit: cover;">

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary" id="cropAndUpload">Subir</button>
      </div>
    </div>
  </div>
</div>

<script>
  let cropper;
  const avatarInput = document.getElementById('avatarInput');
  const imagePreview = document.getElementById('imagePreview');
  const cropperModalEl = document.getElementById('cropperModal');
  const cropperModal = new bootstrap.Modal(cropperModalEl);

  // Mostrar imagen y abrir cropper
  avatarInput.addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file) {
      // Elimina cropper anterior si existe
      if (cropper) {
        cropper.destroy();
        cropper = null;
      }

      const reader = new FileReader();
      reader.onload = function (event) {
        imagePreview.src = event.target.result;
        cropperModal.show();

        setTimeout(() => {
          cropper = new Cropper(imagePreview, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            movable: false,
            zoomable: false,
            rotatable: false,
            scalable: false
          });
        }, 300);
      };
      reader.readAsDataURL(file);
    }
  });

  // Subir imagen recortada
  document.getElementById('cropAndUpload').addEventListener('click', function () {
    if (!cropper) return;

    cropper.getCroppedCanvas({
      width: 300,
      height: 300
    }).toBlob(function (blob) {
      const formData = new FormData();
      formData.append('avatar', blob, 'avatar.png');
      formData.append('_token', '{{ csrf_token() }}');

      fetch('{{ route('perfil.avatar') }}', {
        method: 'POST',
        body: formData
      }).then(response => {
        if (response.ok) {
          location.reload();
        } else {
          Swal.fire('Error', 'No se pudo subir la imagen.', 'error');
        }
      });
    });

    cropperModal.hide();
  });

  // LIMPIAR todo al cerrar modal
  cropperModalEl.addEventListener('hidden.bs.modal', function () {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }

    imagePreview.src = '';
    avatarInput.value = ''; // Reset input
  });
</script>


<style>
  .modal-body {
    overflow: hidden;
    text-align: center;
  }

  #imagePreview {
    width: 280px;
    height: 280px;
    object-fit: cover;
    display: inline-block;
  }
</style>


<!-- Lado derecho: catálogo y formulario -->
<div class="col-md-8 py-5">
  <div class="d-flex flex-wrap gap-2 mb-5">
    <a href="{{ route('perfil.index') }}" class="btn-pill">
      <i class="fas fa-arrow-left me-1"></i> Regresar a mi perfil
    </a>

    <button id="showCatalog" class="btn-pill" data-intro="Aquí puedes ver tus productos registrados." data-step="1">
      Mis productos
    </button>

    <button id="showEmprends" class="btn-pill" data-intro="Aquí puedes ver todos tus emprendimientos registrados." data-step="7">
      Mis emprendimientos
    </button>
  </div>

 
  <!-- Catálogo -->
  <div id="catalogSection">
    <h2 class="fw-bold text-purple mb-4">Mis productos</h2>

    <div class="d-flex justify-content-start gap-2 mb-4 px-3">
      <button id="showForm" class="btn-pill" data-intro="Haz clic para agregar un nuevo producto.">
        + Agregar producto
      </button>
      <button onclick="restartTutorial('producto')" class="btn-pill">
        ¿Cómo funciona?
      </button>
    </div>

    <div class="row">
      @forelse($products as $product)
        @php
          // Asegurarnos de tener el array de imágenes
          $imgs = is_array($product->fotosproduct)
                    ? $product->fotosproduct
                    : (json_decode($product->fotosproduct, true) ?: []);
          // Usamos explícitamente el id_producto
          $pid  = $product->id_producto;
        @endphp

        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden" style="min-height:320px;">
            @if(count($imgs))
              <div style="height:200px; overflow:hidden;">
                <img
                  src="{{ asset('storage/images/productos/'.$imgs[0]) }}"
                  class="w-100"
                  style="object-fit:cover; height:200px; cursor:pointer;"
                  data-bs-toggle="modal"
                  data-bs-target="#productModal{{ $pid }}"
                  alt="Producto {{ $pid }}"
                >
              </div>
            @else
              <div class="p-2 text-muted">Sin imágenes</div>
            @endif

            <div class="card-body d-flex flex-column justify-content-between p-3">
              <div>
                <h6 class="fw-bold text-purple mb-2">{{ $product->nombreproducto }}</h6>
                <p class="text-muted mb-3" style="font-size:.9rem;">
                  {{ Str::limit($product->descripcion, 70) }}
                </p>
                @isset($product->precio)
                  <p class="fw-bold">${{ number_format($product->precio, 2) }}</p>
                @endisset
              </div>
              <button
                type="button"
                class="btn btn-sm btn-outline-purple rounded-pill mt-3"
                data-bs-toggle="modal"
                data-bs-target="#productModal{{ $pid }}"
              >Ver más</button>
            </div>
          </div>
        </div>

        {{-- Modal detalle de producto --}}
        <div class="modal fade" id="productModal{{ $pid }}" tabindex="-1" aria-labelledby="productModalLabel{{ $pid }}" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
              <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel{{ $pid }}">{{ $product->nombreproducto }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                {{-- Carrusel --}}
                <div id="carousel{{ $pid }}" class="carousel slide mb-3" data-bs-ride="carousel">
                  <div class="carousel-indicators">
                    @foreach($imgs as $i => $f)
                      <button
                        type="button"
                        data-bs-target="#carousel{{ $pid }}"
                        data-bs-slide-to="{{ $i }}"
                        class="{{ $i===0 ? 'active' : '' }}"
                        aria-current="{{ $i===0 ? 'true' : '' }}"
                        aria-label="Foto {{ $i+1 }}"
                      ></button>
                    @endforeach
                  </div>
                  <div class="carousel-inner">
                    @foreach($imgs as $i => $f)
                      <div class="carousel-item {{ $i===0 ? 'active' : '' }}">
                        <img
                          src="{{ asset('storage/images/productos/'.$f) }}"
                          class="d-block w-100"
                          style="object-fit:contain; max-height:400px;"
                          alt="Foto {{ $i+1 }}"
                        >
                      </div>
                    @endforeach
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $pid }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $pid }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </button>
                </div>

                {{-- Miniaturas --}}
                <div class="d-flex justify-content-center gap-2 mb-3">
                  @foreach($imgs as $i => $f)
                    <img
                      src="{{ asset('storage/images/productos/'.$f) }}"
                      style="width:60px; height:60px; object-fit:cover; cursor:pointer;"
                      onclick="bootstrap.Carousel.getInstance(document.getElementById('carousel{{ $pid }}')).to({{ $i }});"
                      alt="Miniatura {{ $i+1 }}"
                    >
                  @endforeach
                </div>

                {{-- Descripción y precio --}}
                <p>{{ $product->descripcion }}</p>
                @isset($product->precio)
                  <p class="fw-bold">${{ number_format($product->precio, 2) }}</p>
                @endisset
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <p>No tienes productos aún.</p>
        </div>
      @endforelse
    </div>
  </div>




<!-- Formulario productos -->
<div id="formSection" style="display:none;">
  <div class="alert alert-info d-flex align-items-center" role="alert" style="border-radius: 1rem;">
    <i class="fas fa-exclamation-circle me-2"></i>
    <div><strong>Nota:</strong> Puede tardar entre <u>1 a 5 días hábiles</u> para que tu producto sea aprobado por la administración.</div>
  </div>

  <form id="productForm" action="{{ route('productos.temporales.store') }}" method="POST" enctype="multipart/form-data" data-intro="Debes llenar este formulario para poder registrar tus productos." data-step="0">
    @csrf

    {{-- Select de Emprendimiento --}}
    <select
      name="emprendimiento_id"
      id="emprendimiento_id"
      class="form-control border-purple">
      <option value="" disabled selected>-- Selecciona una opción --</option>
      @foreach($emprendimientos as $empr)
        <option value="{{ $empr->id_emprendimiento }}">{{ $empr->nombre }}</option>
      @endforeach
    </select>

    {{-- Nombre --}}
    <div class="mb-3">
      <label class="form-label">Nombre de Producto</label>
      <input type="text" class="form-control" name="name" id="name" data-intro="Escribe el nombre del producto que deseas registrar." data-step="2">
    </div>

    {{-- Descripción --}}
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea class="form-control" name="description" id="description" rows="3" data-intro="Describe brevemente tu producto." data-step="3"></textarea>
    </div>

    {{-- Precio --}}
    <div class="mb-3">
      <label class="form-label">Precio</label>
      <input type="number" class="form-control" name="price" id="price" step="0.01" min="0" data-intro="Establece el precio del producto en pesos mexicanos." data-step="4">
    </div>

  {{-- Imágenes --}}
  
<div class="mb-3">
  <label class="form-label d-block">Imágenes</label>
  <div id="dropZone" class="custom-upload" data-intro="Arrastra o haz clic para subir una o más imágenes del producto." data-step="5">
    <i class="fas fa-plus"></i> Arrastra o haz clic para agregar imágenes
  </div>
  <input type="file" id="imageUploader" name="images[]" accept="image/*" style="display: none;" multiple>
</div>
   <div id="imagePreviewContainer" class="mt-3 d-flex flex-wrap gap-2"></div>


    {{-- Botón final --}}
    <button type="submit" class="btn-purple" data-intro="Cuando termines, haz clic aquí para registrar tu producto." data-step="7">Subir producto</button>
  </form>
<script>
  const dropZone = document.getElementById('dropZone');
  const imageUploader = document.getElementById('imageUploader');
  const imagePreviewContainer = document.getElementById('imagePreviewContainer');
  let selectedFiles = [];

  dropZone.addEventListener('click', () => imageUploader.click());

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
    handleFiles(e.dataTransfer.files);
  });

  imageUploader.addEventListener('change', e => {
    handleFiles(e.target.files);
  });

  function handleFiles(files) {
    const filesArray = Array.from(files);

    filesArray.forEach(file => {
      if (!file.type.startsWith('image/')) return;

      // Evitar duplicados por nombre de archivo
      if (selectedFiles.find(f => f.name === file.name)) {
        console.warn(`Imagen duplicada ignorada: ${file.name}`);
        return;
      }

      selectedFiles.push(file);

      const reader = new FileReader();
      reader.onload = function (e) {
        const preview = document.createElement('div');
        preview.classList.add('position-relative');

        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'rounded';
        img.style.width = '80px';
        img.setAttribute('data-name', file.name);

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.innerHTML = '&times;';
        removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
        removeBtn.style.transform = 'translate(40%, -40%)';
        removeBtn.onclick = function () {
          preview.remove();
          selectedFiles = selectedFiles.filter(f => f.name !== file.name);
          updateInputFiles();
        };

        preview.appendChild(img);
        preview.appendChild(removeBtn);
        imagePreviewContainer.appendChild(preview);
      };

      reader.readAsDataURL(file);
    });

    updateInputFiles();
  }

  function updateInputFiles() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));
    imageUploader.files = dataTransfer.files;
  }
</script>

</div>

  


  <!-- Sección: Emprendimientos -->
<div id="emprendsSection" style="display:none;">

  {{-- Botones arriba del listado --}}
 

  <h2 class="fw-bold text-purple mb-4">Mis emprendimientos</h2>
 <div class="d-flex justify-content-start gap-2 mb-4 px-3">
    <button
      id="showEmprendForm"
      class="btn-pill"
      data-intro="Haz clic para registrar un nuevo emprendimiento."
      data-step="2"
    >
      + Agregar emprendimiento
    </button>
    <button onclick="restartTutorial('emprendimiento')" class="btn-pill">
      ¿Cómo funciona?
    </button>
  </div>
  <div class="row">
    @forelse($emprendimientos as $empr)
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden" style="min-height: 320px;">

          @if($empr->logo)
            <div style="height: 150px; overflow: hidden;">
              <img
                src="{{ asset('storage/images/emprendimientos/'.$empr->logo) }}"
                class="w-100"
                alt="{{ $empr->nombre }}"
                style="height: 100%; object-fit: cover;"
              >
            </div>
          @endif

          <div class="card-body p-3 d-flex flex-column justify-content-between">
            <div>
              <h6 class="fw-bold text-purple mb-2">{{ $empr->nombre }}</h6>
              <p class="card-text text-muted" style="font-size: 0.9rem;">
                {{ Str::limit($empr->descripcion, 70) }}
              </p>
            </div>
            <button
              class="btn btn-sm btn-outline-purple rounded-pill mt-2"
              data-bs-toggle="modal"
              data-bs-target="#modalEmprendimiento{{ $empr->id_emprendimiento }}">
              Ver más
            </button>
          </div>
        </div>
      </div>

        <!-- Modal del emprendimiento -->
        <div class="modal fade" id="modalEmprendimiento{{ $empr->id_emprendimiento }}" tabindex="-1" aria-labelledby="modalLabel{{ $empr->id_emprendimiento }}">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
              <div class="modal-header bg-purple text-white">
                <h5 class="modal-title" id="modalLabel{{ $empr->id_emprendimiento }}">{{ $empr->nombre }}</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                @if($empr->logo)
                <img src="{{ asset('storage/images/emprendimientos/'.$empr->logo) }}" class="img-fluid rounded mb-3" alt="Logo de {{ $empr->nombre }}">
                @endif
                <p><strong>Nombre comercial:</strong> {{ $empr->emprendimiento }}</p>
                <p><strong>Descripción:</strong> {{ $empr->descripcion }}</p>
                <p><strong>Teléfono:</strong> {{ $empr->telefono }}</p>
                <p><strong>Redes sociales:</strong> {{ $empr->redes }}</p>
                <p><strong>Ubicación:</strong> {{ $empr->ubicacion }}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        @empty
        <div class="col-12">
          <p>No tienes emprendimientos aún.</p>
        </div>
        @endforelse
      </div>

    
    </div>

    <!-- Formulario emprendimiento -->
    <div id="emprendFormSection" style="display:none;">
      <h2 class="fw-bold text-purple mb-4">Registrar nuevo emprendimiento</h2>
      <div class="alert alert-info mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Nota:</strong> El registro será revisado por la administración. Tiempo estimado de validación: <u>1 a 5 días hábiles</u>.
      </div>
      <form action="{{ route('emprendimientos.temporales.store') }}" method="POST" enctype="multipart/form-data" id="emprendimientoForm">
        @csrf

    <div class="mb-3">
      <label class="form-label">Nombre del emprendimiento</label>
      <input type="text" class="form-control" name="nombre" id="nombre" >
    </div>

    <div class="mb-3">
      <label class="form-label">Nombre comercial o distintivo</label>
      <input type="text" class="form-control" name="emprendimiento" id="emprendimiento" >
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
    </div>

        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" class="form-control" name="telefono" id="telefono">
        </div>

        <div class="mb-3">
          <label class="form-label">Redes sociales</label>
          <input type="text" class="form-control" name="redes" id="redes">
        </div>

    <div class="mb-3">
      <label class="form-label">Ubicación</label>
      <input type="text" class="form-control" name="ubicacion" id="ubicacion">
    </div>

        <div class="mb-3">
          <label class="form-label d-block">Logo del emprendimiento (opcional)</label>
          <div id="logoDropZone" class="custom-upload">
            <i class="fas fa-plus"></i> Arrastra o haz clic para agregar logo
          </div>
          <input type="file" id="logoInput" name="logo" accept="image/*" style="display: none;">
          <div class="mt-3" id="logoPreviewContainer" style="display: none;">
            <div class="img-container position-relative d-inline-block">
              <img id="logoPreview" src="#" alt="Vista previa" class="img-fluid mt-2" style="max-height:180px;">
              <button type="button" class="remove-btn position-absolute top-0 end-0 btn btn-danger btn-sm rounded-circle" onclick="removeLogo()">×</button>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-purple" id="btnSubirEmprendimiento">Subir emprendimiento</button>
      </form>
    </div>
    <style>
      body {
        overflow-x: hidden;
      }

      .section {
        width: 100%;
        padding: 2rem 1rem;
      }

      .section--purple {
        background-color: #F5E8FF;
      }

      .section--white {
        background-color: #FFFFFF;
      }

      .container-fluid {
        max-width: 1200px;
        margin: 0 auto;
      }

      hr.divider {
        border: none;
        height: 4px;
        background: linear-gradient(to right, #7C3AED, #C084FC);
        margin: 0;
        border-radius: 2px;
      }

      .btn-toggle {
        cursor: pointer;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        background-color: #C084FC;
        color: white;
        display: inline-block;
      }

      .btn-toggle.active {
        background-color: #7C3AED;
      }

      .barra-superior {
        padding: 0.7rem 1rem;
        position: sticky;
        top: 0;
        background: white;
        z-index: 1000;
      }

      .bg-lila {
        background-color: #f5efff;
      }

.overflow-auto {
  overflow-y: auto;
  max-height: calc(100vh - 100px); /* ajusta según header */
}

</style>












<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const logoDropZone = document.getElementById('logoDropZone');
        const logoInput = document.getElementById('logoInput');
        const logoPreviewContainer = document.getElementById('logoPreviewContainer');
        const logoPreview = document.getElementById('logoPreview');

        if (logoDropZone && logoInput && logoPreviewContainer && logoPreview) {
          logoDropZone.addEventListener('click', () => logoInput.click());
          logoDropZone.addEventListener('dragover', e => {
            e.preventDefault();
            logoDropZone.classList.add('dragover');
          });
          logoDropZone.addEventListener('dragleave', () => logoDropZone.classList.remove('dragover'));
          logoDropZone.addEventListener('drop', e => {
            e.preventDefault();
            logoDropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length) {
              previewLogo(files[0]);
            }
          });
          logoInput.addEventListener('change', () => {
            if (logoInput.files[0]) previewLogo(logoInput.files[0]);
          });
        }

        function previewLogo(file) {
          const reader = new FileReader();
          reader.onload = e => {
            logoPreview.src = e.target.result;
            logoPreviewContainer.style.display = 'block';
          };
          reader.readAsDataURL(file);
        }

        window.removeLogo = function() {
          logoInput.value = '';
          logoPreview.src = '#';
          logoPreviewContainer.style.display = 'none';
        }

        // Validación del formulario
        const form = document.getElementById('emprendimientoForm');
        if (form) {
          form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nombre = this.nombre;
            const comercial = this.emprendimiento;
            const descripcion = this.descripcion;
            const ubicacion = this.ubicacion;

            [nombre, comercial, descripcion, ubicacion].forEach(f => f.classList.remove('border-danger'));

            if (!nombre.value.trim() || !comercial.value.trim() || !descripcion.value.trim() || !ubicacion.value.trim()) {
              Swal.fire({
                icon: 'warning',
                title: 'Faltan campos obligatorios',
                text: 'Completa todos los campos antes de enviar',
              });
              [nombre, comercial, descripcion, ubicacion].forEach(f => {
                if (!f.value.trim()) f.classList.add('border-danger');
              });
              return;
            }

            
          });
        }
      });
    </script>


    @if(session('success') === 'producto')
<script>
Swal.fire({
  icon: 'success',
  title: '¡Producto registrado!',
  text: '{{ session('success_message') ?? 'Tu producto ha sido registrado y pasará a revisión. Recibirás notificaciones cuando sea aprobado.' }}',
  confirmButtonText: 'Ver productos'
});
</script>
@endif
@if(session('success') === 'emprendimiento')
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Emprendimiento registrado!',
      text: '{{ session("success_message") }}',
      confirmButtonText: 'Entendido'
    });
  </script>
@endif
    <script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
    <script>
      function restartTutorial(seccion = 'producto') {
        const showFormBtn = document.getElementById('showForm');
        const showEmprendFormBtn = document.getElementById('showEmprendForm');

        if (seccion === 'producto') {
          document.getElementById('showCatalog')?.click();

    setTimeout(() => {
      const tour = introJs();
      tour.setOptions({
        steps: [
          { element: '#catalogSection', intro: 'Esta es la sección donde se muestran todos los productos que has registrado.' },
          { element: '#showForm', intro: 'Haz clic aquí para abrir el formulario de registro de nuevo producto.' },
          { element: '#formSection', intro: 'Aquí puedes llenar los campos requeridos para registrar tu producto.' },
          { element: '#emprendimiento_id', intro: 'Selecciona el emprendimiento al que pertenece el producto.' },
          { element: '#name', intro: 'Ingresa el nombre del producto. Debe ser claro y representativo.' },
          { element: '#description', intro: 'Describe brevemente el producto.' },
          { element: '#price', intro: 'Indica el precio en pesos mexicanos.' },
          { element: '#dropZone', intro: 'Sube una o más imágenes del producto.' },
          { element: '#togglePreview', intro: 'Este botón permite ver la vista previa.' },
          { element: '.btn-purple', intro: 'Al terminar, haz clic para registrar el producto.' },
          { intro: 'Nota: Los productos serán revisados por la administración en un plazo de 1 a 5 días hábiles.' }
        ],
        nextLabel: 'Siguiente',
        prevLabel: 'Anterior',
        doneLabel: 'Entendido',
        showProgress: true,
        disableInteraction: true,
        exitOnOverlayClick: false,
        scrollToElement: true,
        tooltipClass: 'customTooltip',
        highlightClass: 'customHighlight'
      });
      tour.onbeforechange(element => {
        if (element?.id === 'showForm' || element?.id === 'catalogSection') {
          document.getElementById('formSection').style.display = 'none';
        }
      });
      tour.onchange(element => {
        if (element?.id === 'formSection') {
          showFormBtn?.click();
          setTimeout(() => tour.refresh(), 400);
        }
        if (element?.id === 'catalogSection') {
          document.getElementById('showCatalog')?.click();
        }
      });
      tour.start();
    }, 300);
  }
  else if (seccion === 'emprendimiento') {
    document.getElementById('showEmprends')?.click();

    setTimeout(() => {
      const tour = introJs();
      tour.setOptions({
        steps: [
          {
    element: '#emprendsSection',
    intro: 'En esta sección puedes consultar todos los emprendimientos que has registrado previamente.'
  },
  {
    element: '#showEmprendForm',
    intro: 'Haz clic aquí para iniciar el registro de un nuevo emprendimiento.'
  },
  {
    element: '#emprendFormSection',
    intro: 'Completa este formulario para dar de alta tu emprendimiento.'
  },
  {
    element: 'input[name="nombre"]',
    intro: 'Escribe el <strong>nombre oficial</strong> de tu emprendimiento, tal como aparece en documentos o registros formales.'
  },
  {
    element: 'input[name="emprendimiento"]',
    intro: 'Ingresa el <strong>nombre comercial o distintivo</strong> que los clientes reconocerán.'
  },
  {
    element: 'textarea[name="descripcion"]',
    intro: 'Agrega una breve descripción de las actividades de tu emprendimiento para que las personas sepan a qué se dedica.'
  },
  {
    element: 'input[name="telefono"]',
    intro: 'Si lo deseas, puedes incluir un número de teléfono de contacto para que los usuarios puedan comunicarse contigo.'
  },
  {
    element: 'input[name="redes"]',
    intro: 'Incluye aquí las redes sociales de tu negocio, como Facebook o Instagram, para mayor difusión.'
  },
  {
    element: 'input[name="ubicacion"]',
    intro: 'Especifica claramente la ubicación donde opera tu emprendimiento: colonia, fraccionamiento, calles cercanas, etc.'
  },
  {
    element: '#logoDropZone',
    intro: 'Arrastra o selecciona un archivo de imagen para subir el logotipo de tu emprendimiento. Este paso es opcional pero recomendado para dar identidad visual.'
  },
  {
    element: '#btnSubirEmprendimiento',
    intro: 'Cuando termines de llenar todos los campos, haz clic en este botón para enviar tu registro.'
  },
  {
    intro: 'Recuerda que el registro será revisado por la administración en un plazo de <strong>1 a 5 días hábiles</strong>.'
  }
        ],
        nextLabel: 'Siguiente',
        prevLabel: 'Anterior',
        doneLabel: 'Entendido',
        showProgress: true,
        disableInteraction: true,
        exitOnOverlayClick: false,
        scrollToElement: true,
        tooltipClass: 'customTooltip',
        highlightClass: 'customHighlight'
      });
      tour.onbeforechange(element => {
        if (element?.id === 'showEmprendForm' || element?.id === 'emprendsSection') {
          document.getElementById('emprendFormSection').style.display = 'none';
        }
        if (element?.id === 'btnSubirEmprendimiento') {
          document.getElementById('btnSubirEmprendimiento')?.setAttribute('tabindex', '-1');
        }
      });
      tour.onchange(element => {
        if (element?.id === 'emprendFormSection') {
          showEmprendFormBtn?.click();
          setTimeout(() => tour.refresh(), 400);
        }
        if (element?.id === 'emprendsSection') {
          document.getElementById('showEmprends')?.click();
        }
        if (element?.id === 'btnSubirEmprendimiento') {
          document.getElementById('emprendFormSection').style.display = 'block';
          document.getElementById('btnSubirEmprendimiento')?.setAttribute('tabindex', '0');
        }
      });
      tour.start();
    }, 300);
  }
  else {
    Swal.fire({
      icon: 'info',
      title: 'Primero entra a la sección',
      text: 'Abre la sección de productos o emprendimientos antes de iniciar la guía.',
      confirmButtonText: 'Entendido'
    });
  }
}





      // Toggle secciones// Mostrar secciones según el botón presionado

      document.getElementById('showCatalog')?.addEventListener('click', () => {
        document.getElementById('catalogSection').style.display = 'block';
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('emprendsSection').style.display = 'none';
        document.getElementById('emprendFormSection').style.display = 'none';
      });

      document.getElementById('showForm')?.addEventListener('click', () => {
        document.getElementById('catalogSection').style.display = 'none';
        document.getElementById('formSection').style.display = 'block';
        document.querySelector('main').removeAttribute('aria-hidden');
      });

      document.getElementById('showEmprends')?.addEventListener('click', () => {
        document.getElementById('catalogSection').style.display = 'none';
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('emprendsSection').style.display = 'block';
        document.getElementById('emprendFormSection').style.display = 'none';
      });

      document.getElementById('showEmprendForm')?.addEventListener('click', () => {
        document.getElementById('catalogSection').style.display = 'none';
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('emprendsSection').style.display = 'none';
        document.getElementById('emprendFormSection').style.display = 'block';
      });

      window.onload = function() {
        // tus listeners aquí
      };


      // Inicia mostrando productos
      document.getElementById('showProducts').click();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Intro.js -->
    <script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // Toggle mostrar secciones
      document.getElementById('showCatalog')?.addEventListener('click', () => {
        document.getElementById('catalogSection').style.display = 'block';
        document.getElementById('formSection').style.display = 'none';
      });
      document.getElementById('showForm')?.addEventListener('click', () => {
        document.getElementById('catalogSection').style.display = 'none';
        document.getElementById('formSection').style.display = 'block';
      });

      // Mantener visible al cargar
      document.getElementById('catalogSection').style.display = 'block';

      // Manejador de imágenes
      const dropZone = document.getElementById('dropZone'),
        imgInput = document.getElementById('imageUploader'),
        imgCont = document.getElementById('imagePreviewContainer'),
        prevImg = document.getElementById('previewImages');

      let files = [];

      function renderImages() {
        imgCont.innerHTML = '';
        prevImg.innerHTML = '';
        files.forEach((f, i) => {
          const reader = new FileReader();
          reader.onload = e => {
            const container = document.createElement('div');
            container.classList.add('img-container');
            const img = document.createElement('img');
            img.src = e.target.result;
            const btn = document.createElement('button');
            btn.textContent = '×';
            btn.className = 'remove-btn';
            btn.onclick = () => {
              files.splice(i, 1);
              renderImages();
            };
            container.append(img, btn);
            imgCont.append(container);
            prevImg.append(img.cloneNode());
          };
          reader.readAsDataURL(f);
        });
      }

      dropZone?.addEventListener('click', () => imgInput.click());
      dropZone?.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('dragover');
      });
      dropZone?.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
      });
      dropZone?.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        files = files.concat(Array.from(e.dataTransfer.files));
        renderImages();
      });
      imgInput?.addEventListener('change', () => {
        files = files.concat(Array.from(imgInput.files));
        renderImages();
      });

      // Vista previa del texto
      document.getElementById('name')?.addEventListener('input', e => {
        document.getElementById('previewName').textContent = e.target.value || 'Nombre del producto';
      });
      document.getElementById('description')?.addEventListener('input', e => {
        document.getElementById('previewDescription').textContent = e.target.value || 'Descripción breve';
      });
      document.getElementById('price')?.addEventListener('input', e => {
        const v = parseFloat(e.target.value);
        document.getElementById('previewPrice').textContent = isNaN(v) ? '$0.00' : `$${v.toFixed(2)}`;
      });

      // Toggle preview del producto
      document.getElementById('togglePreview')?.addEventListener('click', () => {
        const p = document.getElementById('productPreview');
        p.style.display = (p.style.display === 'none') ? 'block' : 'none';
      });

      // Validación de formulario con SweetAlert2
      document.getElementById('productForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('name'),
          desc = document.getElementById('description'),
          price = document.getElementById('price'),
          empr = document.getElementById('emprendimiento_id');

        [name, desc, price, empr].forEach(f => f.classList.remove('border-danger'));

        const emprValue = empr.value;

        if (!emprValue || emprValue === "") {
          Swal.fire({
            icon: 'error',
            title: '¡Ups!',
            text: 'Selecciona un emprendimiento válido.'
          });
          empr.classList.add('border-danger');
          empr.focus();
          return;
        }
        if (!name.value.trim()) {
          Swal.fire({
            icon: 'error',
            title: '¡Ups!',
            text: 'Ingresa el nombre del producto.'
          });
          name.classList.add('border-danger');
          name.focus();
          return;
        }
        if (!desc.value.trim()) {
          Swal.fire({
            icon: 'error',
            title: '¡Ups!',
            text: 'La descripción no puede estar vacía.'
          });
          desc.classList.add('border-danger');
          desc.focus();
          return;
        }
        if (!price.value || Number(price.value) < 0) {
          Swal.fire({
            icon: 'error',
            title: '¡Ups!',
            text: 'Ingresa un precio válido.'
          });
          price.classList.add('border-danger');
          price.focus();
          return;
        }

        this.submit();
      });

      // Alerta tras éxito
      @if(session('success') === 'emprendimiento')
    Swal.fire({
      icon: 'success',
      title: '¡Emprendimiento registrado!',
      html: 'Tu emprendimiento está en proceso de validación por el equipo administrativo.<br><br><b>Recibirás un correo de confirmación en máximo 5 días hábiles.</b>',
      confirmButtonText: 'Entendido'
    });
    @endif

    </script>

    <!-- Intro.js -->
    <script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>

    <script>
      // --- SECCIONES ---
      const showCatalog = document.getElementById('showCatalog');
      const showForm = document.getElementById('showForm');
      const catalogSection = document.getElementById('catalogSection');
      const formSection = document.getElementById('formSection');
      if (catalogSection) catalogSection.style.display = 'block';
      showCatalog?.addEventListener('click', () => {
        catalogSection.style.display = 'block';
        formSection.style.display = 'none';
      });
      showForm?.addEventListener('click', () => {
        catalogSection.style.display = 'none';
        formSection.style.display = 'block';
      });

      // --- PRODUCT PREVIEW ---
      document.getElementById('name')?.addEventListener('input', e => {
        document.getElementById('previewName').textContent = e.target.value || 'Nombre del producto';
      });
      document.getElementById('description')?.addEventListener('input', e => {
        document.getElementById('previewDescription').textContent = e.target.value || 'Descripción breve';
      });
      document.getElementById('price')?.addEventListener('input', e => {
        const v = parseFloat(e.target.value);
        document.getElementById('previewPrice').textContent = isNaN(v) ? '$0.00' : `$${v.toFixed(2)}`;
      });
      document.getElementById('togglePreview')?.addEventListener('click', () => {
        const p = document.getElementById('productPreview');
        p.style.display = p.style.display === 'none' ? 'block' : 'none';
      });

      // --- LOGO PREVIEW (emprendimiento) ---
      function previewLogo(event) {
        const input = event.target;
        const preview = document.getElementById('logoPreview');
        const container = document.getElementById('logoPreviewContainer');
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = e => {
            preview.src = e.target.result;
            container.style.display = 'block';
          };
          reader.readAsDataURL(input.files[0]);
        } else {
          container.style.display = 'none';
        }
      }

      function removeLogo() {
        const logoInput = document.getElementById('logoInput');
        const preview = document.getElementById('logoPreview');
        const container = document.getElementById('logoPreviewContainer');
        logoInput.value = '';
        preview.src = '#';
        container.style.display = 'none';
      }

// --- FORM EMPRENDIMIENTO ---
document.getElementById('emprendimientoForm')?.addEventListener('submit', function(e) {
  e.preventDefault();

  const nombre = this.querySelector('input[name="nombre"]');
  const comercial = this.querySelector('input[name="emprendimiento"]');
  const descripcion = this.querySelector('textarea[name="descripcion"]');
  const ubicacion = this.querySelector('input[name="ubicacion"]');
  const telefono = this.querySelector('input[name="telefono"]');
  const redes = this.querySelector('input[name="redes"]');

  [nombre, comercial, descripcion, ubicacion, telefono, redes].forEach(f => f.classList.remove('border-danger'));

  if (!nombre.value.trim()) {
    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Por favor ingresa el nombre del emprendimiento.' });
    nombre.classList.add('border-danger'); nombre.focus(); return;
  }
  if (!comercial.value.trim()) {
    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Completa el nombre comercial.' });
    comercial.classList.add('border-danger'); comercial.focus(); return;
  }
  if (!descripcion.value.trim()) {
    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Agrega una breve descripción.' });
    descripcion.classList.add('border-danger'); descripcion.focus(); return;
  }
  if (!ubicacion.value.trim()) {
    Swal.fire({ icon: 'error', title: 'Campo requerido', text: 'Especifica la ubicación.' });
    ubicacion.classList.add('border-danger'); ubicacion.focus(); return;
  }
  if (telefono.value && !/^[0-9]{7,15}$/.test(telefono.value)) {
    Swal.fire({ icon:'error', title:'Teléfono no válido', text:'Ingresa solo números, mínimo 7 dígitos.' });
    telefono.classList.add('border-danger'); telefono.focus(); return;
  }

  Swal.fire({
    icon: 'info',
    title: '¿Registrar emprendimiento?',
    text: 'Verifica tus datos antes de enviarlos.',
    showCancelButton: true,
    confirmButtonText: 'Sí, registrar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      this.submit();
    }
  });
});

      // ========== TIMER DE INACTIVIDAD ==========

      let timeout;
      let activeSection = null;

      // cuando entra a formulario de producto
      document.getElementById('showForm')?.addEventListener('click', () => {
        console.log('🟢 Entraste a PRODUCTO');
        activeSection = 'producto';
        startInactivityTimer();
      });

      // cuando entra a formulario de emprendimiento
      document.getElementById('showEmprendForm')?.addEventListener('click', () => {
        console.log('🟢 Entraste a EMPRENDIMIENTO');
        activeSection = 'emprendimiento';
        startInactivityTimer();
      });

      // cuando vuelve a catálogo o lista de emprendimientos cancela el timer
      ['showCatalog', 'showEmprends'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', () => {
          console.log('🔴 Cancelando timer por cambio de sección');
          clearTimeout(timeout);
          activeSection = null;
        });
      });

      // cuando envía el formulario
      document.getElementById('productForm')?.addEventListener('submit', () => {
        console.log('✅ Submit producto');
        clearTimeout(timeout);
        activeSection = null;
      });
      document.getElementById('emprendimientoForm')?.addEventListener('submit', () => {
        console.log('✅ Submit emprendimiento');
        clearTimeout(timeout);
        activeSection = null;
      });

      // detectar si ya estaba abierto al cargar
      window.addEventListener('load', () => {
        if (document.getElementById('formSection')?.style.display !== 'none') {
          console.log('🟢 Detectado formulario producto abierto al cargar');
          activeSection = 'producto';
          startInactivityTimer();
        }
        if (document.getElementById('emprendFormSection')?.style.display !== 'none') {
          console.log('🟢 Detectado formulario emprendimiento abierto al cargar');
          activeSection = 'emprendimiento';
          startInactivityTimer();
        }
      });

      // iniciar el timer
      function startInactivityTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
          preguntarAyuda();
        }, 300000); // 5 minutos
        console.log(`⏳ Timer iniciado para ${activeSection}`);
      }

      // pregunta ayuda
      function preguntarAyuda() {
        if (!activeSection) return;
        console.log(`🤖 Preguntando ayuda para: ${activeSection}`);
        Swal.fire({
          title: '¿Necesitas ayuda?',
          text: 'Notamos que llevas un rato aquí. ¿Quieres ver una guía rápida?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sí, mostrar guía',
          cancelButtonText: 'No, gracias'
        }).then((result) => {
          if (result.isConfirmed) {
            restartTutorial(activeSection);
          }
        });
      }
    </script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @endsection
    