<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EstacionamientoController;
use App\Http\Controllers\ComercioController;

use App\Http\Controllers\RecargaController;


// Ruta para obtener la lista de usuarios
Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

// Ruta para crear un nuevo usuario
Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

// Ruta para obtener los detalles de un usuario específico
Route::get('usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');

// Ruta para actualizar la información de un usuario específico
Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');

// Ruta para eliminar un usuario específico
Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');



// Ruta para obtener la lista de todos los estacionamientos
Route::get('estacionamientos', [EstacionamientoController::class, 'index']);

// Ruta para obtener un estacionamiento específico por ID
Route::get('estacionamientos/{id}', [EstacionamientoController::class, 'show']);

// Ruta para crear un nuevo estacionamiento
Route::post('estacionamientos', [EstacionamientoController::class, 'store']);

// Ruta para actualizar un estacionamiento existente por ID
Route::put('estacionamientos/{id}', [EstacionamientoController::class, 'update']);

Route::get('test', function () {
    return 'Test route works!';
});


// Ruta para obtener todas las recargas o una recarga específica por patente, DNI o número de comercio
Route::get('recargas', [RecargaController::class, 'index']);
Route::get('recargas/{id}', [RecargaController::class, 'show']); // Consultar una recarga específica por ID
// Ruta para crear una nueva recarga
Route::post('recargas', [RecargaController::class, 'store']);



Route::get('comercios', [ComercioController::class, 'index']);          // Obtener todos los comercios
Route::post('comercios', [ComercioController::class, 'store']);         // Crear un nuevo comercio
Route::get('comercios/{id}', [ComercioController::class, 'show']);      // Mostrar un comercio específico
Route::put('comercios/{id}', [ComercioController::class, 'update']);    // Actualizar un comercio existente
Route::delete('comercios/{id}', [ComercioController::class, 'destroy']); // Eliminar un comercio

