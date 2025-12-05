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
        Schema::create('tipo_descuento', function (Blueprint $table) {
            $table->id('id_tipo_descuento');
            $table->string('nombre', 50);
            $table->unsignedBigInteger('id_fp');
            $table->timestamps();
            
            $table->foreign('id_fp')->references('id_fp')->on('forma_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_descuento');
    }
};
