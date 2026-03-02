@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --purple: #7C3AED;
        --purple-light: #EDE9FE;
        --purple-dark: #5B21B6;
    }
    
    .text-purple { color: var(--purple) !important; }
    .bg-purple { background-color: var(--purple) !important; }
    .border-purple { border-color: var(--purple) !important; }
    
    .miniatura-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #ddd;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .miniatura-img:hover {
        border-color: var(--purple);
        transform: scale(1.05);
    }
    
    .main-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
        cursor: zoom-in;
        transition: transform 0.3s ease;
    }
    
    .main-img:hover {
        transform: scale(1.02);
    }
    
    .card-producto {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-producto:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    
    .user-avatar {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border: 4px solid var(--purple);
    }
    
    .modal-img-container {
        width: 100%;
        height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .modal-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
    }
    
    .emprendimiento-card {
        border-left: 4px solid var(--purple);
        background-color: #f9fafb;
    }
    
    .no-products {
        background-color: #FEF2F2;
        color: #B91C1C;
    }
    
    .contact-badge {
        background-color: var(--purple-light);
        color: var(--purple-dark);
        border-radius: 20px;
        padding: 8px 16px;
        font-weight: 500;
    }
    
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
    }
    
    .btn-whatsapp:hover {
        background-color: #128C7E;
        color: white;
    }
    
    .img-container {
        height: 220px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="container py-5">
    {{-- SECCIÓN DE USUARIO MEJORADA --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        {{-- Avatar --}}
                        <div class="mb-3 mb-md-0 me-md-4">
                            @if($datos->avatar)
                                <img src="{{ asset('storage/' . $datos->avatar) }}" 
                                     alt="Foto de perfil" 
                                     class="user-avatar rounded-circle shadow">
                            @else
                                <div class="user-avatar rounded-circle d-flex justify-content-center align-items-center mx-auto bg-purple">
                                    <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Información --}}
                        <div class="text-center text-md-start">
                            <h2 class="fw-bold text-purple mb-2">
                                {{ $datos->nombre }} {{ $datos->apellido_paterno }} {{ $datos->apellido_materno }}
                            </h2>
                            
                            <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 mb-3">
                                @if($datos->telefono)
                                <div class="contact-badge d-flex align-items-center">
                                    <i class="fas fa-phone-alt me-2"></i>{{ $datos->telefono }}
                                </div>
                                @endif
                                
                                @if($datos->email)
                                <div class="contact-badge d-flex align-items-center">
                                    <i class="fas fa-envelope me-2"></i>{{ $datos->email }}
                                </div>
                                @endif
                            </div>
                            
                            <div class="d-flex justify-content-center justify-content-md-start gap-2">
                                @if($datos->telefono)
                                <a href="tel:{{ $datos->telefono }}" class="btn btn-outline-purple btn-sm">
                                    <i class="fas fa-phone-alt me-2"></i>Contactar
                                </a>
                                @endif
                                
                                @if($datos->telefono)
                                <a href="https://wa.me/{{ $datos->telefono }}" class="btn btn-whatsapp btn-sm">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                </a>
                                @endif
                                
                                @if($datos->email)
                                <a href="mailto:{{ $datos->email }}" class="btn btn-outline-purple btn-sm">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MENSAJE SI NO HAY EMPRENDIMIENTOS --}}
    @if($emprendimientos->isEmpty())
    <div class="alert alert-warning text-center shadow-sm rounded p-4" role="alert">
        <i class="fas fa-store-alt fa-2x mb-3 text-purple"></i>
        <h4 class="fw-bold text-purple">Este usuario aún no cuenta con emprendimientos</h4>
        <p class="mb-0">Cuando registre emprendimientos y productos, aparecerán aquí.</p>
    </div>
    @endif

    {{-- LISTADO DE EMPRENDIMIENTOS --}}
    @foreach($emprendimientos as $empr)
    <div class="mb-5 p-4 rounded shadow-sm emprendimiento-card">
        {{-- Encabezado del emprendimiento --}}
        <div class="d-flex align-items-center mb-3">
            @if($empr->logo)
            <img src="{{ asset('storage/images/emprendimientos/' . $empr->logo) }}"
                class="rounded-circle me-3 shadow-sm"
                style="width: 60px; height: 60px; object-fit: cover;">
            @else
            <div class="rounded-circle me-3 shadow-sm d-flex justify-content-center align-items-center bg-purple"
                style="width: 60px; height: 60px;">
                <i class="fas fa-store text-white"></i>
            </div>
            @endif
            <div>
                <h4 class="mb-0 fw-bold">{{ $empr->nombre }}</h4>
                @if($empr->categoria)
                <span class="badge bg-purple">{{ $empr->categoria }}</span>
                @endif
            </div>
        </div>

        <p class="text-muted mb-4">{{ $empr->descripcion }}</p>

        {{-- Redes sociales del emprendimiento --}}
        @if($empr->whatsapp || $empr->instagram || $empr->facebook)
        <div class="d-flex gap-2 mb-4">
            @if($empr->whatsapp)
            <a href="https://wa.me/{{ $empr->whatsapp }}" class="btn btn-success btn-sm">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            @endif
            
            @if($empr->instagram)
            <a href="https://instagram.com/{{ $empr->instagram }}" class="btn btn-instagram btn-sm" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                <i class="fab fa-instagram"></i> Instagram
            </a>
            @endif
            
            @if($empr->facebook)
            <a href="https://facebook.com/{{ $empr->facebook }}" class="btn btn-primary btn-sm">
                <i class="fab fa-facebook-f"></i> Facebook
            </a>
            @endif
        </div>
        @endif

        {{-- Productos del emprendimiento --}}
        @if($empr->productos && count($empr->productos) > 0)
        <h5 class="mb-3 fw-bold text-dark">
            <i class="fas fa-box-open me-2 text-purple"></i> Productos
        </h5>
        
        <div class="row g-4">
            @foreach($empr->productos as $prod)
            @php
                $imagenes = is_array($prod->fotosproduct) ? $prod->fotosproduct : json_decode($prod->fotosproduct, true);
                $mainId = 'mainImg_' . $prod->id_producto;
            @endphp
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm card-producto">
                    {{-- Galería de imágenes --}}
                    @if(!empty($imagenes))
                    <div class="img-container">
                        <img id="{{ $mainId }}"
                            src="{{ asset('storage/images/productos/' . $imagenes[0]) }}"
                            onclick="verImagenModal(this.src)"
                            alt="{{ $prod->nombreproducto }}">
                    </div>
                    
                    <div class="p-3">
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            @foreach($imagenes as $img)
                            <img src="{{ asset('storage/images/productos/' . $img) }}"
                                onclick="cambiarImagen('{{ asset('storage/images/productos/' . $img) }}', '{{ $mainId }}')"
                                class="miniatura-img"
                                alt="Miniatura">
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="img-container bg-purple-light">
                        <i class="fas fa-image text-purple" style="font-size: 3rem;"></i>
                    </div>
                    @endif

                    {{-- Detalles del producto --}}
                    <div class="card-body pt-0">
                        <h5 class="fw-bold text-dark">{{ $prod->nombreproducto }}</h5>
                        <p class="text-muted small">{{ Str::limit($prod->descripcion, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-bold text-purple">${{ number_format($prod->precio, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-3 rounded text-center no-products">
            <i class="fas fa-box-open me-2"></i> Este emprendimiento aún no tiene productos registrados.
        </div>
        @endif
    </div>
    @endforeach
</div>

<!-- Modal para ver imagen ampliada -->
<div class="modal fade" id="modalImagen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="modal-img-container bg-dark rounded">
                    <img id="imgModal" src="" class="modal-img" alt="Imagen ampliada">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para cambiar la imagen principal al hacer clic en una miniatura
    function cambiarImagen(src, targetId) {
        document.getElementById(targetId).src = src;
    }

    // Función para mostrar la imagen en el modal
    function verImagenModal(src) {
        const modal = new bootstrap.Modal(document.getElementById('modalImagen'));
        document.getElementById('imgModal').src = src;
        modal.show();
    }
    
    // Asegurar que todas las imágenes tengan un tamaño consistente
    document.addEventListener('DOMContentLoaded', function() {
        const productImages = document.querySelectorAll('.img-container img');
        productImages.forEach(img => {
            img.style.objectFit = 'cover';
            img.style.height = '220px';
            img.style.width = '100%';
        });
    });
</script>

@endsection