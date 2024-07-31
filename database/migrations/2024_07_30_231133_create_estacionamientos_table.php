<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionamientosTable extends Migration
{
    public function up()
    {
        Schema::create('estacionamientos', function (Blueprint $table) {
            $table->id();
            $table->string('patente')->unique();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->enum('estado', ['Estacionado', 'Libre'])->default('Libre');
            $table->integer('tiempo_estacionamiento')->default(0); // en fracciones de 15 minutos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacionamientos');
    }
}
