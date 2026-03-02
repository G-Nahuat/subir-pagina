<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    public function buscar(Request $request)
    {
        $criterio = $request->input('criterio');

        $documentos = DB::table('documentos_emitidos')
            ->join('cursos', 'documentos_emitidos.id_curso', '=', 'cursos.id')
            ->where('documentos_emitidos.correo', $criterio)
            ->orWhere('documentos_emitidos.telefono', $criterio)
            ->select('documentos_emitidos.*', 'cursos.nombre as curso_nombre', 'cursos.fecha')
            ->get();

        return view('documentos.resultados', compact('documentos', 'criterio'));
    }
}
