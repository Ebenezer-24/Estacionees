<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComerciosTable extends Migration
{
    public function up()
    {
        Schema::create('comercios', function (Blueprint $table) {
            $table->id();
            $table->string('cuit')->unique();
            $table->string('razon_social');
            $table->string('direccion');
            $table->enum('estado', ['autorizado', 'suspendido'])->default('autorizado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comercios');
    }
}
