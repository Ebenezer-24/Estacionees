<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstacionamientoController;
use App\Http\Controllers\ComercioController;

Route::get('/usuarios', function () {
    return view('usuarios.index');
});

Route::get('/estacionamientos', function () {
    return view('estacionamiento.index');
});
Route::get('/comercios', function () {
    return view('comercio.index');
});