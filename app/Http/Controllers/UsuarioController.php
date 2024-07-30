<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;


class UsuarioController extends Controller
{
    // Obtener lista de usuarios
    public function index()
{
    $usuarios = Usuario::select(['id', 'dni', 'nombre', 'apellido', 'domicilio', 'email', 'fecha_nacimiento', 'patente']);
    return DataTables::of($usuarios)->toJson();
}

   
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dni' => 'required|unique:usuarios|max:10',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'domicilio' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios|max:255',
                'fecha_nacimiento' => 'required|date',
                'patente' => 'nullable|string|max:10|unique:usuarios',
                'contraseña' => 'required|string|min:6',
            ], [
                'dni.required' => 'El campo DNI es obligatorio.',
                'dni.unique' => 'El DNI ya existe en la base de datos.',
                'email.unique' => 'El email ya está registrado.',
                'patente.unique' => 'La patente ya está registrada.',
                'contraseña.required' => 'La contraseña es obligatoria.',
            ]);

            $usuario = Usuario::create($validatedData);
            return response()->json($usuario, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Obtener información de un usuario específico
    public function show($id)
    {
        $usuario = Usuario::findOrFail($id);
        return response()->json($usuario);
    }

    // Actualizar la información de un usuario
    public function update(Request $request, $id)
    {
        // Buscar el usuario por ID
        $usuario = Usuario::findOrFail($id);

        try {
            // Validar y obtener datos, excluyendo el campo 'dni'
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'domicilio' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:usuarios,email,' . $usuario->id,
                'fecha_nacimiento' => 'required|date',
                'patente' => 'nullable|string|max:10|unique:usuarios,patente,' . $usuario->id,
                'contraseña' => 'nullable|string|min:6',
            ], [
                'email.unique' => 'El email ya está registrado.',
                'patente.unique' => 'La patente ya está registrada.',
                'nombre.required' => 'El nombre es obligatorio.',
                'apellido.required' => 'El apellido es obligatorio.',
                'domicilio.required' => 'El domicilio es obligatorio.',
                'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            ]);

            // Actualizar los datos del usuario, excluyendo el 'dni'
            $usuario->update($validatedData);

            return response()->json($usuario);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Eliminar un usuario
    public function destroy($id)
    {
        // Intentar encontrar el usuario por ID
        $usuario = Usuario::find($id);

        if (!$usuario) {
            // Responder con un mensaje de error si el usuario no existe
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        // Eliminar el usuario si existe
        $usuario->delete();

        // Responder con un mensaje de éxito
        return response()->json([
            'message' => 'Usuario eliminado con éxito.',
        ], 200);
    }
}

