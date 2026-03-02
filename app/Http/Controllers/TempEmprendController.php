<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TempEmprendController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'emprendimiento' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
            'telefono' => 'nullable',
            'redes' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192'
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $img = Image::make($file);

            // Redimensionar si excede 2 MB
            if ($file->getSize() > 2 * 1024 * 1024) {
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $filename = uniqid() . '.webp';

            Storage::disk('public')->put('emprendimientos_temp/' . $filename, $img->encode('webp', 80));

            $logoPath =  $filename;
        }

        DB::table('temp_emprendimientos')->insert([
            'id_users' => auth()->id(),
            'nombre_emprendimiento' => $request->nombre,
            'nombre_comercial' => $request->emprendimiento,
            'descripcion' => $request->descripcion,
            'telefono' => $request->telefono,
            'redes' => $request->redes,
            'ubicacion' => $request->ubicacion,
            'logo' => $logoPath,
            'estado' => 'pendiente',
            'created_at' => now(),
            'updated_at' => now()
        ]);

       return redirect()->back()
    ->with('success', 'emprendimiento')
    ->with('success_message', 'Tu emprendimiento está en proceso de validación. Recibirás notificaciones pronto.');

    }
}
