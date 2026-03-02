<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EmprendimientoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InscripcionController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\TempProductController;
use App\Http\Controllers\TempEmprendController;
use App\Http\Controllers\NotificacionController;

use App\Http\Controllers\ConstanciaController;
use App\Http\Controllers\Admin\SolicitudController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProductoTempController;
use App\Http\Controllers\Admin\CursoController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\User;

// —————————————————————————————
// Favicon
// —————————————————————————————
Route::get('/favicon.ico', fn() => response()->noContent());

// —————————————————————————————
// Página principal y menú
// —————————————————————————————
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// —————————————————————————————
// Registro de emprendedoras
// —————————————————————————————
Route::get('/eventos/registro', [RegistroController::class, 'create'])->name('eventos.create');
Route::post('/eventos/registro', [RegistroController::class, 'store'])->name('eventos.store');
Route::get('/registro', [RegistroController::class, 'create'])->name('registro.create');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');
Route::get('/municipios/{estado_id}', [RegistroController::class, 'getMunicipios'])->name('municipios.porEstado');

// —————————————————————————————
// Inscripción a eventos
// —————————————————————————————
Route::get('/eventos/inscribirse', [EventoController::class, 'create'])->name('eventos.inscribirse');
Route::post('/eventos/inscribirse', [EventoController::class, 'store'])->name('eventos.inscribirse.store');

//Route::get('/evento/ver/{id}', [EventoController::class, 'show'])->name('evento.ver');
Route::get('/evento/detalle/{id}', [EventoController::class, 'detalleEvento'])->name('evento.detalle');

//Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');
// —————————————————————————————
// Catálogo de emprendimientos
// —————————————————————————————
Route::get('/emprendimientos/catalogo', [EmprendimientoController::class, 'catalogo'])->name('emprendimientos.catalogo');
Route::get('/emprendimientos/perfil/{id}', [EmprendimientoController::class, 'perfilVendedor'])->name('emprendimientos.perfil');
Route::get('/emprendimientos/vendedor/{id}', [EmprendimientoController::class, 'verVendedor'])->name('emprendimientos.ver');
Route::get('/emprendimientos/mostrar-vendedor/{id}', [EmprendimientoController::class, 'mostrarVendedor'])->name('emprendimientos.mostrar');

// —————————————————————————————
// Autenticación
// —————————————————————————————
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginCorreo'])->name('perfil.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// -----------------------------
// RUTA PARA AJAX (fuera del grupo con prefix 'admin')
// -----------------------------
Route::get('admin/contenido/solicitudes-usuarios', [InscripcionController::class, 'verSolicitudes']);


// -----------------------------
// RUTAS CON PREFIJO /admin Y MIDDLEWARE auth
// -----------------------------

Route::get('/admin/usuarios', [AdminController::class, 'indexUsuarios'])->name('admin.usuarios.index');
Route::get('/admin/contenido/{seccion}', [AdminController::class, 'cargarVista']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/eventos/editar/{id}', [EventoController::class, 'edit'])->name('eventos.edit');
Route::post('/admin/eventos/actualizar/{id}', [EventoController::class, 'update'])->name('eventos.update');
Route::delete('/admin/eventos/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');

Route::get('admin/solicitudes-productos', [AdminController::class, 'solicitudesProductos'])->name('admin.productos.solicitudes');
Route::post('admin/solicitudes-productos/aprobar/{id}', [AdminController::class, 'aprobarProducto'])->name('admin.productos.aprobar');




Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('emprendimientos/solicitudes', [AdminController::class, 'mostrarSolicitudes'])->name('emprendimiento.solicitudes');


Route::get('contenido/cursos', [CursoController::class, 'contenido']);


// CURSOS
Route::get('cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('cursos/crear', [CursoController::class, 'create'])->name('cursos.create');
Route::post('cursos', [CursoController::class, 'store'])->name('cursos.store');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Usuarios
    Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/{user}', [UserController::class, 'show'])->name('usuarios.show');
Route::get('solicitudes-usuarios', [InscripcionController::class, 'verSolicitudes'])->name('admin.solicitudes.usuarios');
Route::get('solicitudes-usuarios/{id}/ver', [InscripcionController::class, 'mostrar'])->name('usuarios.solicitudes.show');
Route::post('solicitudes-usuarios/{id}/rechazar', [InscripcionController::class, 'rechazar'])->name('usuarios.solicitudes.reject');
Route::post('solicitudes-usuarios/{id}/aprobar', [InscripcionController::class, 'aprobar'])->name('solicitudes.usuarios.aprobar');


Route::get('solicitudes-usuarios', [InscripcionController::class, 'verSolicitudes'])->name('solicitudes.usuarios');
        Route::post('solicitudes-usuarios/{id}/aprobar', [InscripcionController::class, 'aprobar'])->name('solicitudes.usuarios.aprobar');

//
Route::post('solicitudes-usuarios/{id}/rechazar', [InscripcionController::class, 'rechazar'])->name('solicitudes.usuarios.rechazar');


    
    // Inscripciones
    Route::get('inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::get('solicitudes-usuarios', [InscripcionController::class, 'verSolicitudes'])->name('solicitudes.usuarios');
    Route::get('solicitudes-usuarios/{id}/ver', [InscripcionController::class, 'mostrar'])->name('usuarios.solicitudes.show');
    Route::post('solicitudes-usuarios/{id}/aceptar', [InscripcionController::class, 'aprobar'])->name('usuarios.solicitudes.approve');
    Route::post('solicitudes-usuarios/{id}/rechazar', [InscripcionController::class, 'rechazar'])->name('usuarios.solicitudes.reject');

    // Productos
    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('solicitudes-productos', [AdminController::class, 'solicitudesProductos'])->name('productos.solicitudes');
    Route::post('productos/solicitudes/{id}/aceptar', [ProductoController::class, 'aceptarSolicitud'])->name('productos.aceptar');
    Route::post('productos/solicitudes/{id}/rechazar', [ProductoController::class, 'rechazarSolicitud'])->name('productos.rechazar');
    Route::post('solicitudes-productos/aprobar/{id}', [AdminController::class, 'aprobarProducto'])->name('productos.aprobar');

    // Emprendimientos
    Route::get('emprendimientos', [AdminController::class, 'indexEmprendimientos'])->name('emprendimientos.index');
    Route::get('emprendimientos/{id}', [AdminController::class, 'verEmprendimiento'])->name('emprendimientos.ver');
    Route::delete('emprendimientos/{id}', [AdminController::class, 'eliminarEmprendimiento'])->name('emprendimientos.eliminar');
    Route::post('emprendimientos/solicitud/{id}/aceptar', [AdminController::class, 'aceptarSolicitudEmprendimiento'])->name('emprendimientos.solicitud.aceptar');
    
    Route::get('emprendimientos/solicitudes', [AdminController::class, 'mostrarSolicitudes'])->name('emprendimientos.solicitudes');
    Route::get('emprendimientos/solicitud/{id}', [AdminController::class, 'verSolicitud'])->name('emprendimientos.solicitud.ver');
Route::post('emprendimientos/solicitud/{id}/rechazar', [AdminController::class, 'rechazarSolicitudEmprendimiento'])->name('emprendimientos.solicitud.rechazar');





    // Eventos
    Route::get('eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('eventos/crear', [EventoController::class, 'create'])->name('eventos.create');
    Route::post('eventos/guardar', [EventoController::class, 'store'])->name('eventos.store');
    Route::get('eventos/detalle/{id}', [EventoController::class, 'show'])->name('eventos.show');
    Route::get('eventos/editar/{id}', [EventoController::class, 'edit'])->name('eventos.edit');
    Route::post('eventos/actualizar/{id}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('eventos/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');

    //INCRIPCION EVENTOS
    Route::get('inscripciones-eventos', [AdminController::class, 'verInscripcionesEventos'])->name('admin.inscripciones.eventos');

    // Vistas dinámicas
    Route::get('contenido/{seccion}', [AdminController::class, 'cargarVista']);
    Route::get('contenido/cursos', [CursoController::class, 'contenido']);


});


// —————————————————————————————
// Perfil de usuario autenticado
// —————————————————————————————
Route::middleware(['auth', 'is_vendedor'])->group(function () {
        Route::get('/mi-perfil', [PerfilController::class, 'perfil'])->name('perfil.index');
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.seccion');
    Route::post('/perfil', [PerfilController::class, 'seccion'])->name('perfil.store');
    Route::post('/productos-temporales', [TempProductController::class, 'store'])->name('productos.temporales.store');
    Route::post('/perfil/avatar', [PerfilController::class, 'actualizarAvatar'])->name('perfil.avatar');
    Route::post('/perfil/producto', [PerfilController::class, 'seccionProducto'])->name('perfil.producto.store');
    Route::post('/perfil/emprendimiento', [PerfilController::class, 'seccionEmprendimiento'])->name('perfil.emprendimiento.store');

    
    //
    Route::get('/perfil/cursos', [CursoController::class, 'mostrarCursos'])->name('perfil.cursos');
    Route::post('/perfil/cursos/inscribirse/{id}', [CursoController::class, 'inscribirse'])->name('cursos.inscribirse');
    Route::post('/inscribirme-curso/{id}', [InscripcionController::class, 'inscribirme'])->name('inscripcion.curso');
    Route::get('/inscribirme-curso/{id}', [InscripcionController::class, 'inscribirme'])->name('inscribirme.curso');
    Route::post('/inscribirme-curso/{id}', [CursoController::class, 'inscribirme'])->name('inscripcion.curso');
    Route::post('/inscribirme-evento/{id}', [\App\Http\Controllers\AsistenteEventoController::class, 'inscribirse'])->name('inscripcion.evento');



});

// —————————————————————————————
// Ruta de prueba de HasFactory
// —————————————————————————————
Route::get('/test-hasfactory', function () {
    return class_exists(\Illuminate\Database\Eloquent\Factories\HasFactory::class)
        ? 'Existe' : 'No existe';
});



Route::post('/logout', function () {
    Auth::logout();
    return redirect(''); 
})->name('logout');


Route::get('/notificaciones', [App\Http\Controllers\NotificacionController::class, 'index'])->name('notificaciones.index');


// producto temporal 


// EMPRENDIMIENTO TEMPORAL

Route::post('/emprendimientos-temporales', [TempEmprendController::class, 'store'])->name('emprendimientos.temporales.store');

Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
Route::post('/notificaciones/leido/{id}', [NotificacionController::class, 'marcarLeido'])->name('notificaciones.marcarLeido');






Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/eventos/crear', [EventoController::class, 'create'])->name('admin.eventos.create');
    Route::post('/eventos/guardar', [EventoController::class, 'store'])->name('admin.eventos.store');
});
Route::put('/admin/eventos/{id}', [EventoController::class, 'update'])->name('admin.eventos.update');


// routes/web.php

Route::post('/perfil/avatar', [PerfilController::class, 'actualizarAvatar'])->name('perfil.avatar')->middleware(['auth', 'is_vendedor']);


Route::get('/emprendimiento/{id_emprendimiento}', [EmprendimientoController::class, 'perfil'])->name('emprendimientos.perfil');




Route::prefix('admin')
     ->middleware(['auth', 'is_admin'])
     ->name('admin.')
     ->group(function() {
         // Panel principal
         Route::get('/', [DashboardController::class, 'index'])
              ->name('dashboard');

         // Usuarios
         Route::get('usuarios', [UserController::class, 'index'])
              ->name('usuarios.index');

         // Solicitudes de usuarios
         Route::get('solicitudes-usuarios', [InscripcionController::class, 'verSolicitudes'])->name('solicitudes-usuarios.index');

         // Productos
         Route::get('productos', [ProductoController::class, 'index'])
              ->name('productos.index');
     });

    

Route::prefix('admin')
     ->middleware(['auth','is_admin'])
     ->name('admin.')
     ->group(function() {
         // ... otras rutas ...
         Route::get('emprendimientos', [EmprendimientoController::class, 'index'])
              ->name('emprendimientos.index');
     });

Route::get('dashboard/pdf/{type}', [DashboardController::class,'exportPdf'])
     ->name('admin.dashboard.pdf');

Route::prefix('admin')
     ->middleware(['auth','is_admin'])
     ->name('admin.')
     ->group(function() {
         // ... tus rutas ...
         Route::get('dashboard/pdf/{type}', [DashboardController::class, 'exportPdf'])
              ->name('dashboard.pdf');
     });



Route::get('/contacto', [ContactoController::class, 'mostrarFormulario'])->name('contacto.formulario');
Route::post('/contacto/enviar', [ContactoController::class, 'enviarCorreo'])->name('contacto.enviar');


Route::get('/perfil-publico/{id}', [PerfilController::class, 'verPublico'])->name('perfil.publico');





// Mostrar formulario de registro
Route::get('/eventos/registro', [RegistroController::class, 'create'])->name('registro.create');

// Guardar datos del formulario en registro_temporal y enviar verificación
Route::post('/eventos/registro', [RegistroController::class, 'store'])->name('registro.store');

// Ruta para verificación desde el enlace del correo (se auto-loguea y regresa a la vista de espera)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    // Validar hash del correo
    if (!hash_equals((string) $hash, sha1($user->email))) {
        abort(403, 'El enlace no es válido o ha expirado');
    }

    // Verificar si aún no está marcado
    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    // Inicia sesión temporal (necesario para AJAX)
    Auth::login($user);

    // Regresa a la vista con la animación esperando validación
    return redirect()->route('registro.verifica');
})->name('verification.verify');

// Vista de espera con animación (la misma que se muestra después de enviar el formulario)
Route::get('/verificacion/pending', function () {
    return view('auth.verifica', ['email' => session('email_verificacion')]);
})->middleware('auth')->name('registro.verifica');

// Ruta usada por AJAX cada 5 segundos para saber si ya se verificó el correo
Route::get('/verificar-estado', function () {
    return response()->json([
        'verificado' => Auth::check() && Auth::user()->hasVerifiedEmail()
    ]);
})->middleware(['web', 'auth'])->name('verificar.estado');

// (Opcional) Vista final de confirmación del registro completo
Route::get('/registro/completado', [RegistroController::class, 'finalizarRegistro'])
    ->middleware(['web', 'auth'])
    ->name('registro.finalizar');


Route::get('/cursos/ver/{id}', [CursoController::class, 'verCursoPublico'])->name('cursos.ver');

Route::get('/cursos/inscripcion/{id}', [CursoController::class, 'inscripcionCursoPublica'])->name('cursos.inscripcion');
Route::post('/cursos/inscripcion/{id}', [CursoController::class, 'guardarInscripcionPublica'])->name('cursos.inscripcion.guardar');
Route::get('/cursos/inscripcion/{id}', [CursoController::class, 'inscripcionCursoPublica'])->name('cursos.inscripcion');
Route::post('/cursos/inscripcion/{id}', [CursoController::class, 'guardarInscripcionPublica'])->name('cursos.inscripcion.guardar');



Route::get('/inscripcion-curso', [CursoController::class, 'mostrarFormularioInscripcion'])->name('inscripcion.publica');
Route::post('/inscripcion-curso', [CursoController::class, 'guardarInscripcionPublica'])->name('inscripcion.publica.enviar');
Route::get('/admin/cursos/{id}', [CursoController::class, 'show'])->name('admin.cursos.show');
Route::post('/admin/asistencia/marcar/{id}', [CursoController::class, 'marcarAsistencia'])->name('admin.asistencia.marcar');
Route::post('/admin/asistencia/agregar', [CursoController::class, 'agregarAsistente'])->name('admin.asistencia.agregar');

//Cursos
// Ruta para vista ejecutiva de detalles del curso
Route::get('/admin/cursos/{id}/detalle', [\App\Http\Controllers\Admin\CursoController::class, 'detalle'])
    ->name('admin.cursos.detalle');

Route::get('contenido/cursos', [CursoController::class, 'contenido'])
     ->name('admin.cursos.contenido');


Route::get('/documentos/buscar', function () {
    return view('documentos.buscar');
})->name('documentos.buscar');

Route::get('/documentos/resultados', [App\Http\Controllers\DocumentoController::class, 'buscar'])->name('documentos.resultados');
Route::post('/admin/cursos/{id}/mover-inscripciones', [CursoController::class, 'moverInscripcionesAAsistentes'])->name('admin.cursos.mover');
Route::post('/admin/cursos/{id}/guardar-temario', [CursoController::class, 'guardarTemario'])->name('admin.cursos.guardarTemario');
Route::get('/admin/cursos/{id}/temario-pdf', [CursoController::class, 'exportarTemarioPDF'])->name('admin.temario.pdf');


Route::get('/admin/cursos/{id}/temario', [CursoController::class, 'editarTemario'])->name('admin.cursos.temario.editar');
Route::post('/admin/cursos/{id}/temario', [CursoController::class, 'guardarTemario'])->name('admin.cursos.temario.guardar');
Route::get('/admin/cursos/{id}/temario/pdf', [CursoController::class, 'generarTemarioPDF'])->name('admin.cursos.temario.pdf');

Route::get('/admin/constancia/generar/{id}', [ConstanciaController::class, 'generar'])->name('admin.constancia.generar');
Route::get('/admin/cursos/{id}/constancia/{asistente_id}', [CursoController::class, 'generarConstancia'])->name('admin.cursos.constancia');
Route::get('/admin/constancia/generar/{id}', [ConstanciaController::class, 'generar'])->name('constancia.generar');




Route::get('/admin/constancia/generar/{id}', [ConstanciaController::class, 'generar'])
    ->name('admin.constancia.generar');

Route::get('admin/constancias/zip/{curso}', [ConstanciaController::class, 'descargarTodas'])
     ->name('admin.constancias.zip');



// Rutas de cursos (index, show, edit, update, etc)
Route::prefix('admin')->name('admin.')->group(function() {
    Route::resource('cursos', CursoController::class)
         ->except(['create','store','destroy']);

    // Generar ZIP de constancias
    Route::get('constancias/zip/{curso}', [ConstanciaController::class, 'descargarTodas'])
         ->name('constancias.zip');

    // Completar campos faltantes
    Route::get('cursos/{curso}/complete', [CursoController::class, 'complete'])
         ->name('cursos.complete');

    // Editar un solo campo
    Route::get('cursos/{curso}/edit-field/{field}', [CursoController::class, 'editField'])
         ->name('cursos.editField');
    Route::post('cursos/{curso}/update-field/{field}', [CursoController::class, 'updateField'])
         ->name('cursos.updateField');

    // Guardar temario (ya lo tenías)
    Route::post('cursos/{curso}/guardar-temario', [CursoController::class, 'guardarTemario'])
         ->name('cursos.guardarTemario');});

// Mostrar formulario de edición de un asistente
Route::get('asistentes/{id}/edit', [CursoController::class, 'editAsistente'])
     ->name('admin.asistentes.edit');

// Actualizar datos del asistente
Route::post('asistentes/{id}/update', [CursoController::class, 'updateAsistente'])
     ->name('admin.asistentes.update');
Route::get('/admin/constancia/generar/{id}', [ConstanciaController::class, 'generar'])
    ->name('admin.constancia.generar');
Route::get('/admin/cursos', [CursoController::class, 'index'])->name('admin.cursos.index');



Route::post('/validar-correo', [App\Http\Controllers\RegistroController::class, 'validarCorreo'])->name('validar.correo');
Route::get('/verificar-email', function (Illuminate\Http\Request $request) {
    $email = $request->query('email');
    $exists = \App\Models\User::where('email', $email)->exists();
    return response()->json(['exists' => $exists]);
});


Route::get('/admin/constancias/generador', [ConstanciaController::class, 'generadorReconocimiento'])->name('admin.constancias.generador');
Route::post('/admin/constancias/generar/manual', [ConstanciaController::class, 'generarReconocimientoManual'])->name('admin.constancias.generar.manual');

Route::post('/admin/asistencia-dias', [CursoController::class, 'guardarAsistenciaDias'])->name('admin.asistencia.guardarDias');

Route::get('/admin/asistencia/exportar/{curso}/{grupo}', [CursoController::class, 'exportarAsistencia'])->name('admin.asistencia.exportar');

Route::get('/admin/asistencia/exportar-excel/{idCurso}/{grupo}', [CursoController::class, 'exportarAsistenciaExcel'])->name('admin.asistencia.excel');
Route::get('/admin/asistencia/exportar-pdf/{idCurso}/{grupo}', [CursoController::class, 'exportarAsistenciaPDF'])->name('admin.asistencia.pdf');
Route::get('/admin/asistencia/exportar-pdf/{id}/{grupo}', [CursoController::class, 'exportarAsistenciaPDF'])->name('admin.asistencia.exportarPDF');

Route::get('/admin/asistencia/exportar-excel/{id}/{grupo}', [CursoController::class, 'exportarAsistenciaExcel'])->name('admin.asistencia.exportarExcel');
Route::get('/admin/asistencia/exportar-pdf/{id}/{grupo}', [CursoController::class, 'exportarAsistenciaPDF'])->name('admin.asistencia.exportarPDF');
Route::get('/admin/cursos/{curso}/edit-field/{field}', [CursoController::class, 'editField'])
     ->name('admin.cursos.editField');

     Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('admin/cursos/{curso}/update-field/{field}', [CursoController::class, 'updateField'])
    ->name('admin.cursos.updateField');



Route::get('/constancia/descargar/{id}', [ConstanciaController::class, 'descargar'])
    ->middleware(['auth', 'signed'])
    ->name('constancia.usuario.descargar');
Route::post('/admin/solicitudes-usuarios/aprobar/{id}', [UserController::class, 'aprobarSolicitud'])
    ->name('solicitudes.usuarios.aprobar');


    // Ruta para vista ejecutiva de detalles del curso
Route::get('/admin/cursos/{id}/detalle', [\App\Http\Controllers\Admin\CursoController::class, 'detalle'])
    ->name('admin.cursos.detalle');

Route::get('contenido/cursos', [CursoController::class, 'contenido'])
     ->name('admin.cursos.contenido');

     Route::get('/admin/constancias/pdf/{cursoId}', [ConstanciaController::class, 'descargarTodasEnPDF'])
    ->name('admin.constancias.pdf');

Route::post('/admin/profile/update-avatar', [ProfileController::class, 'updateAvatar'])
    ->name('admin.profile.update-avatar');


    Route::get('/notificaciones/pendientes', [NotificacionController::class, 'contarPendientes'])->name('notificaciones.pendientes');


Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('cursos')->group(function() {
            Route::get('{id}/actualizar-detalles', [CursoController::class, 'actualizarDetalles'])
                ->name('cursos.actualizardetalles');
            
            Route::post('{id}/actualizar-detalles', [CursoController::class, 'guardarActualizacionDetalles'])
                ->name('cursos.guardarActualizacionDetalles');
        });
    });