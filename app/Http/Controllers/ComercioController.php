<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;

class ComercioController extends Controller
{
    public function index()
    {
        return response()->json(Comercio::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cuit' => 'required|numeric|unique:comercios',
            'razon_social' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $comercio = Comercio::create($validatedData);
        return response()->json($comercio, 201);
    }

    public function show($id)
    {
        $comercio = Comercio::find($id);

        if (!$comercio) {
            return response()->json(['message' => 'Comercio no encontrado'], 404);
        }

        return response()->json($comercio);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cuit' => 'integer|unique:comercios,cuit,' . $id,
            'razon_social' => 'string|max:255',
            'direccion' => 'string|max:255',
            'estado' => 'in:autorizado,suspendido'
        ]);

        $comercio = Comercio::find($id);

        if (!$comercio) {
            return response()->json(['message' => 'Comercio no encontrado.'], 404);
        }

        $comercio->fill($validatedData);
        $comercio->save();

        return response()->json(['message' => 'Comercio actualizado correctamente.'], 200);
    }

    public function destroy($id)
    {
        $comercio = Comercio::find($id);

        if (!$comercio) {
            return response()->json(['message' => 'Comercio no encontrado'], 404);
        }

        $comercio->estado = 'suspendido';
        $comercio->save();

        return response()->json(['message' => 'El comercio ha sido suspendido'], 200);
    }
}
