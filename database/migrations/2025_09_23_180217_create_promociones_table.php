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
        Schema::create('promocion', function (Blueprint $table) {
            $table->id('id_promocion');
            $table->string('nombre', 100);
            $table->date('inicio');
            $table->date('fin')->nullable();
            $table->integer('cantidad_usos')->default(0);
            $table->enum('estado', ['Activa', 'Inactiva'])->default('Activa');
            $table->string('descripcion', 255)->nullable();
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
        Schema::dropIfExists('promocion');
    }
};
