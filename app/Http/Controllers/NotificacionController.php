<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    public function contarPendientes()
    {
        $usuarios = DB::table('registro_temporal')->count();
        $emprendimientos = DB::table('temp_emprendimientos')->count();
        $productos = DB::table('temp_products')->count();

        $totalPendientes = $usuarios + $emprendimientos + $productos;

        return response()->json([
            'total' => $totalPendientes,
            'usuarios' => $usuarios,
            'emprendimientos' => $emprendimientos,
            'productos' => $productos

      ]);
}
}

