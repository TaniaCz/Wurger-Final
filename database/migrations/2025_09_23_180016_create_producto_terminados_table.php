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
        Schema::create('producto_terminado', function (Blueprint $table) {
            $table->id('id_producto_terminado');
            $table->string('nombre', 100);
            $table->string('descripcion', 255)->nullable();
            $table->string('categoria', 50)->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_min')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->date('fecha_ingreso')->nullable();
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
        Schema::dropIfExists('producto_terminado');
    }
};
