<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecargasTable extends Migration
{
    public function up()
    {
        Schema::create('recargas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_comercio');
            $table->foreign('numero_comercio')->references('id')->on('comercios')->onDelete('cascade');
            $table->unsignedBigInteger('dni');
            $table->string('patente');
            $table->decimal('importe', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recargas');
    }
}
