<?php
namespace App\Http\Controllers;

use App\Models\Estacionamiento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstacionamientoController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patente' => 'required|string|max:255|unique:estacionamientos,patente',
            'usuario_id' => 'required|integer|exists:usuarios,id',
            'tiempo_estacionamiento' => 'required|integer|min:1',
            'contraseña' => 'required|string',
        ]);

        $usuario = Usuario::find($validatedData['usuario_id']);
        if (!$usuario || !Hash::check($validatedData['contraseña'], $usuario->contraseña)) {
            return response()->json(['message' => 'Usuario o contraseña incorrecta'], 403);
        }

        $costoTotal = $this->calcularCosto($validatedData['tiempo_estacionamiento']);
        if ($usuario->saldo < $costoTotal) {
            $maxTiempo = intdiv($usuario->saldo, $this->costoPorMinuto());
            return response()->json([
                'message' => "Saldo insuficiente. Puede estacionar hasta $maxTiempo minutos."
            ], 400);
        }

        $estacionamiento = Estacionamiento::create([
            'patente' => $validatedData['patente'],
            'usuario_id' => $usuario->id,
            'estado' => 'Estacionado',
            'tiempo_estacionamiento' => $validatedData['tiempo_estacionamiento'],
        ]);

        return response()->json($estacionamiento, 201);
    }

    public function show($patente)
    {
        $estacionamiento = Estacionamiento::with('usuario')->where('patente', $patente)->first();

        if (!$estacionamiento) {
            return response()->json(['message' => 'Estacionamiento no encontrado.'], 404);
        }

        return response()->json($estacionamiento);
    }

    public function update(Request $request, $patente)
    {
        $validatedData = $request->validate([
            'estado' => 'required|in:Estacionado,Libre',
            'tiempo_estacionamiento' => 'nullable|integer|min:1',
            'contraseña' => 'required|string'
        ]);

        $estacionamiento = Estacionamiento::where('patente', $patente)->first();

        if (!$estacionamiento) {
            return response()->json(['message' => 'Estacionamiento no encontrado.'], 404);
        }

        $usuario = Usuario::find($estacionamiento->usuario_id);
        if (!$usuario || !Hash::check($validatedData['contraseña'], $usuario->contraseña)) {
            return response()->json(['message' => 'Contraseña incorrecta'], 403);
        }

        if ($estacionamiento->estado === $validatedData['estado']) {
            return response()->json([
                'message' => 'No se puede realizar la misma acción consecutiva.'
            ], 400);
        }

        if ($validatedData['estado'] === 'Estacionado') {
            if ($usuario->saldo < $this->calcularCosto($validatedData['tiempo_estacionamiento'])) {
                $maxTiempo = intdiv($usuario->saldo, $this->costoPorMinuto());
                return response()->json([
                    'message' => "Saldo insuficiente. Puede estacionar hasta $maxTiempo minutos."
                ], 400);
            }
            $estacionamiento->update([
                'estado' => 'Estacionado',
                'tiempo_estacionamiento' => $validatedData['tiempo_estacionamiento'],
            ]);
        } else {
            $estacionamiento->update([
                'estado' => 'Libre',
                'tiempo_estacionamiento' => 0,
            ]);
        }

        return response()->json(['message' => 'Estado actualizado con éxito.'], 200);
    }

    private function calcularCosto($tiempo)
    {
        // Calcula el costo según las fracciones de 15 minutos
        return $tiempo * $this->costoPorMinuto();
    }

    private function costoPorMinuto()
    {
        return 2; // Ejemplo de costo por minuto
    }
}
