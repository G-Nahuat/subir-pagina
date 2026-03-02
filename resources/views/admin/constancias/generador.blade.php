@extends('layouts.admin')

@section('title', 'Generar Reconocimientos')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-purple mb-4">Generador de Reconocimientos</h2>

    <form method="POST" action="{{ route('admin.constancias.generar.manual') }}" id="form-reconocimientos">
        @csrf

        <div id="reconocimientos-container">
            <div class="card shadow p-4 mb-4 rounded-4 reconocimiento-block border-start border-purple border-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-purple reconocimiento-title">Reconocimiento #1</h5>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre del participante</label>
                    <input type="text" name="nombres[]" class="form-control nombre" placeholder="Ej. María Pérez">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción del reconocimiento</label>
                    <textarea name="descripciones[]" class="form-control descripcion summernote" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="mb-4 text-end">
            <button type="button" class="btn btn-outline-purple" onclick="agregarReconocimiento()">
                <i class="fas fa-plus me-1"></i> Agregar otro reconocimiento
            </button>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-purple px-5 py-2">
                <i class="fas fa-file-pdf me-2"></i> Generar todos los PDF
            </button>
        </div>
    </form>
</div>

<script>
    function agregarReconocimiento() {
        const contenedor = document.getElementById('reconocimientos-container');
        const nuevoBloque = document.createElement('div');
        nuevoBloque.classList.add('card', 'shadow', 'p-4', 'mb-4', 'rounded-4', 'reconocimiento-block', 'border-start', 'border-purple', 'border-4');

        const count = document.querySelectorAll('.reconocimiento-block').length + 1;

        nuevoBloque.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-purple reconocimiento-title">Reconocimiento #${count}</h5>
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmarEliminacion(this)">
                    <i class="fas fa-times"></i> Eliminar
                </button>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre del participante</label>
                <input type="text" name="nombres[]" class="form-control nombre" placeholder="Ej. María Pérez">
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción del reconocimiento</label>
                <textarea name="descripciones[]" class="form-control descripcion summernote" rows="3"></textarea>
            </div>
        `;

        contenedor.appendChild(nuevoBloque);
        renumerarReconocimientos();
        inicializarSummernote();
    }

    function confirmarEliminacion(btn) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Este reconocimiento será eliminado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarReconocimiento(btn);
            }
        });
    }

    function eliminarReconocimiento(btn) {
        const bloque = btn.closest('.reconocimiento-block');
        bloque.remove();
        renumerarReconocimientos();
    }

    function renumerarReconocimientos() {
        const bloques = document.querySelectorAll('.reconocimiento-block');
        bloques.forEach((bloque, index) => {
            const titulo = bloque.querySelector('.reconocimiento-title');
            if (titulo) {
                titulo.textContent = `Reconocimiento #${index + 1}`;
            }
        });
    }

    function inicializarSummernote() {
        $('.summernote').summernote({
            height: 200,
            lang: 'es-ES',
            placeholder: 'Escribe la descripción...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        renumerarReconocimientos();
        inicializarSummernote();

        // Validación
        document.getElementById('form-reconocimientos').addEventListener('submit', function (e) {
            const nombres = document.querySelectorAll('.nombre');
            const descripciones = document.querySelectorAll('.descripcion');

            for (let i = 0; i < nombres.length; i++) {
                if (nombres[i].value.trim() === '' || descripciones[i].value.trim() === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos incompletos',
                        text: `Debes completar todos los campos del reconocimiento #${i + 1}`,
                        confirmButtonColor: '#6f42c1'
                    });
                    return false;
                }
            }
        });
    });
</script>

{{-- Summernote --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<style>
    .border-purple { border-color: #6f42c1 !important; }
    .btn-purple { background-color: #6f42c1; color: white; border: none; }
    .btn-purple:hover { background-color: #5a32a3; }
    .btn-outline-purple { border: 2px solid #6f42c1; color: #6f42c1; background-color: white; }
    .btn-outline-purple:hover { background-color: #6f42c1; color: white; }
    .form-control:focus { border-color: #6f42c1; box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25); }
</style>
@endsection
