<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacionamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'patente',
        'usuario_id',
        'estado',
        'tiempo_estacionamiento'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
