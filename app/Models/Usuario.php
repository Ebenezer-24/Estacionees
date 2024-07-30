<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni', 'nombre', 'apellido', 'domicilio', 'email', 'fecha_nacimiento', 'patente', 'saldo', 'contraseña'
    ];

    protected $hidden = [
        'contraseña',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function setContraseñaAttribute($value)
    {
        $this->attributes['contraseña'] = bcrypt($value);
    }
}

