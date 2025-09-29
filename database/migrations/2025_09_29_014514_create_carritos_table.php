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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // Para carritos de usuarios no autenticados
            $table->unsignedBigInteger('user_id')->nullable(); // Para usuarios autenticados
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('producto_id')->references('id_producto')->on('producto')->onDelete('cascade');
            $table->index(['session_id', 'producto_id']);
            $table->index(['user_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carritos');
    }
};
