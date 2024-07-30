<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

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

