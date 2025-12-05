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
        Schema::create('producto', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre_producto', 100);
            $table->integer('stock')->default(0);
            $table->integer('stock_min')->nullable();
            $table->integer('stock_max')->nullable();
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->string('tipo_producto', 50)->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->date('fecha_ingreso')->nullable();
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->timestamps();
            
            $table->foreign('id_categoria')->references('id_categoria')->on('categoria_producto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
};
