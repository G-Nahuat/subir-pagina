@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .miniatura-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #ccc;
        cursor: pointer;
    }

    .main-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
        cursor: zoom-in;
    }

    .modal-img {
        max-width: 90vw;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 12px;
    }

    .modal-dark-bg {
        background-color: rgba(0, 0, 0, 0.95);
    }
</style>

<div class="container py-5">
    {{-- FOTO Y DATOS DEL USUARIO --}}
    <div class="text-center mb-5">
        @if($datos->avatar)
        <img src="{{ asset('storage/' . $datos->avatar) }}" alt="Foto de perfil"
            class="rounded-circle shadow"
            style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #7C3AED;">
        @else
        <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto shadow"
            style="width: 130px; height: 130px; background-color: #7C3AED; color: white; font-size: 2.5rem;">
            <i class="fas fa-user"></i>
        </div>
        @endif

        <h3 class="mt-3 fw-bold text-purple">
            {{ $datos->nombre }} {{ $datos->apellido_paterno }} {{ $datos->apellido_materno }}
        </h3>
        <p class="text-muted mb-0"><i class="fas fa-phone-alt me-2"></i>{{ $datos->telefono ?? 'No disponible' }}</p>
    </div>
    @if($emprendimientos->isEmpty())
    <div class="alert alert-warning text-center shadow-sm rounded p-4" role="alert">
        <h5 class="fw-bold text-purple">Este usuario aún no cuenta con emprendimientos ni productos registrados.</h5>
    </div>
    @endif

    {{-- EMPRENDIMIENTOS Y PRODUCTOS --}}
    @foreach($emprendimientos as $empr)
    <div class="mb-5 p-4 bg-light rounded shadow-sm">
        {{-- Logo y nombre --}}
        <div class="d-flex align-items-center mb-3">
            @if($empr->logo)
            <img src="{{ asset('storage/images/emprendimientos/' . $empr->logo) }}"
                class="rounded-circle me-3"
                style="width: 60px; height: 60px; object-fit: cover;">
            @endif
            <h5 class="mb-0 fw-bold text-dark">{{ $empr->nombre }}</h5>
        </div>

        <p class="text-muted">{{ $empr->descripcion }}</p>

        {{-- Productos --}}
        @if($empr->productos && count($empr->productos) > 0)
        <div class="row">
            @foreach($empr->productos as $prod)
            @php
            $imagenes = is_array($prod->fotosproduct) ? $prod->fotosproduct : json_decode($prod->fotosproduct, true);
            $mainId = 'mainImg_' . $prod->id_producto;
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow border-0 p-2">
                    @if(!empty($imagenes))
                    <img id="{{ $mainId }}"
                        src="{{ asset('storage/images/productos/' . $imagenes[0]) }}"
                        class="main-img"
                        onclick="verImagenModal(this.src)">

                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
                        @foreach($imagenes as $img)
                        <img src="{{ asset('storage/images/productos/' . $img) }}"
                            onclick="cambiarImagen('{{ asset('storage/images/productos/' . $img) }}', '{{ $mainId }}')"
                            
                            class="miniatura-img">
                        @endforeach
                    </div>
                    @endif

                    <div class="card-body">
                        <h6 class="fw-bold text-purple">{{ $prod->nombreproducto }}</h6>
                        <p class="text-muted small mb-2">{{ $prod->descripcion }}</p>
                        <p class="fw-semibold text-dark"><i class="fas fa-dollar-sign"></i> {{ number_format($prod->precio, 2) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-3 rounded" style="background-color: #fce4ec; color: #880e4f;">
            <i class="fas fa-box-open me-2"></i> Este emprendimiento aún no tiene productos registrados.
        </div>
        @endif
    </div>
    @endforeach
</div>

<!-- Modal para ver imagen -->
<div class="modal fade" id="modalImagen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body d-flex justify-content-center align-items-center p-0" style="background-color: rgba(0,0,0,0.8); border-radius: 1rem;">
                <div style="width: 600px; height: 400px; display: flex; justify-content: center; align-items: center;">
                    <img id="imgModal"
                        src=""
                        alt="Imagen ampliada"
                        style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 0.5rem;">
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function cambiarImagen(src, targetId) {
        document.getElementById(targetId).src = src;
    }

    function verImagenModal(src) {
        const modal = new bootstrap.Modal(document.getElementById('modalImagen'));
        document.getElementById('imgModal').src = src;
        modal.show();
    }
</script>

@endsection