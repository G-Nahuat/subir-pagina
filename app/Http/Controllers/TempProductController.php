<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\TempProduct;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TempProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'emprendimiento_id' => 'nullable|integer|exists:emprendimiento,id_emprendimiento',
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'price'             => 'required|numeric|min:0',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpeg,png,jpg,webp|max:8192'
        ]);

        $imagenes = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $img = Image::make($image);

                // Redimensionar si es muy grande
                if ($image->getSize() > 2 * 1024 * 1024) {
                    $img->resize(1280, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                // Convertir a .webp
                $filename = Str::random(20) . '.webp';
                Storage::disk('public')->put('temp_products/' . $filename, $img->encode('webp', 80));
                $imagenes[] = $filename;
            }
        }

        TempProduct::create([
            'id_users'          => Auth::id(),
            'id_emprendimiento' => $request->emprendimiento_id,
            'id_producto'       => null,
            'nombreproducto'    => $request->name,
            'descripcion'       => $request->description,
            'precio'            => $request->price,
            'fotosproduct'      => json_encode($imagenes),
            'estado'            => 'pendiente',
        ]);

        return redirect()->back()
            ->with('success', 'producto')
            ->with('success_message', 'Tu producto fue enviado correctamente y está pendiente de aprobación.');
    }
}
