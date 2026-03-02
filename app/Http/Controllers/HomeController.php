<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Testimonio;
use App\Models\Emprendimiento;
use App\Models\Evento;
use App\Models\Curso; // Asegúrate de importar el modelo Curso

class HomeController extends Controller
{
    public function index()
    {
        $eventos = DB::table('eventos')->get(); 
        $testimonios = Testimonio::latest()->take(9)->get(); 
        $cursos = Curso::where('estado', 'aceptado')->get(); // Nueva línea
        $emprendimientos = Emprendimiento::orderByDesc('id_emprendimiento')
        ->paginate(6); // o ->take(12)->get() si no quieres paginar

        return view('home', compact('eventos', 'testimonios', 'cursos','emprendimientos')); // Ahora incluye $cursos

}

    
}
