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
        Schema::create('movimiento', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->enum('tipo', ['Entrada', 'Salida']);
            $table->integer('cantidad');
            $table->date('fecha');
            $table->string('descripcion', 100)->nullable();
            $table->unsignedBigInteger('id_producto')->nullable();
            $table->timestamps();
            
            $table->foreign('id_producto')->references('id_producto')->on('producto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento');
    }
};
