<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_comercio',
        'dni',
        'patente',
        'importe'
    ];

    public $timestamps = true;

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'numero_comercio');
    }
}
