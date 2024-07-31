<?php

namespace App\Http\Controllers;

use App\Models\Recarga;
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
class RecargaController extends Controller
{
    public function index()
    {
        return response()->json(Recarga::with('comercio')->get());
    }
    
public function store(Request $request)
{
    // Validación de los datos de la solicitud
    $validatedData = $request->validate([
        'numero_comercio' => 'required|exists:comercios,id',
        'dni' => 'required|exists:usuarios,dni',
        'patente' => 'required|exists:usuarios,patente',
        'importe' => 'required|numeric|min:0',
    ]);

    // Verificar que el comercio esté autorizado
    $comercio = Comercio::find($validatedData['numero_comercio']);
    if ($comercio->estado !== 'autorizado') {
        return response()->json(['message' => 'El comercio no está autorizado para realizar recargas.'], 403);
    }

    // Verificar que el usuario existe y la patente corresponde
    $usuario = Usuario::where('dni', $validatedData['dni'])
                      ->where('patente', $validatedData['patente'])
                      ->first();

    if (!$usuario) {
        return response()->json(['message' => 'Usuario no encontrado con el DNI y patente proporcionados.'], 404);
    }

    // Iniciar una transacción para garantizar la consistencia de los datos
    DB::beginTransaction();

    try {
        // Crear la recarga
        $recarga = Recarga::create([
            'numero_comercio' => $comercio->id,
            'dni' => $usuario->dni,
            'patente' => $usuario->patente,
            'importe' => $validatedData['importe'],
        ]);

        // Actualizar el saldo del usuario
        $usuario->saldo += $validatedData['importe'];
        $usuario->save();

        // Confirmar la transacción
        DB::commit();

        return response()->json(['message' => 'Recarga realizada con éxito.', 'recarga' => $recarga], 201);
    } catch (\Exception $e) {
        // Revertir la transacción en caso de error
        DB::rollBack();
        return response()->json(['message' => 'Error al realizar la recarga.'], 500);
    }
}
    public function show($id)
    {
        $recarga = Recarga::with('comercio')->find($id);

        if (!$recarga) {
            return response()->json(['message' => 'Recarga no encontrada'], 404);
        }

        return response()->json($recarga);
    }
}
