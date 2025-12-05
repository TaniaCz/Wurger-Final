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
        Schema::create('detalle_movimiento', function (Blueprint $table) {
            $table->id('id_detalle_movimiento');
            $table->integer('cantidad');
            $table->unsignedBigInteger('id_movimiento');
            $table->timestamps();
            
            $table->foreign('id_movimiento')->references('id_movimiento')->on('movimiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_movimiento');
    }
};
