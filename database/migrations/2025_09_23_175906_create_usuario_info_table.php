<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_info', function (Blueprint $table) {
            $table->id('id_usuario_info');
            $table->string('nombre', 100);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->unsignedBigInteger('id_usuario')->unique();
            $table->timestamps();
            
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_info');
    }
};
