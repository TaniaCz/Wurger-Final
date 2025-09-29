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
        Schema::create('pedido', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->date('fecha');
            $table->string('observaciones', 255)->nullable();
            $table->enum('estado', ['Pendiente', 'Entregado', 'Cancelado'])->default('Pendiente');
            $table->unsignedBigInteger('id_usuario_info');
            $table->timestamps();
            
            $table->foreign('id_usuario_info')->references('id_usuario_info')->on('usuario_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido');
    }
};
