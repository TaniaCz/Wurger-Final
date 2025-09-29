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
        Schema::table('venta', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pedido')->nullable()->after('id_usuario');
            
            $table->foreign('id_pedido')->references('id_pedido')->on('pedido')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venta', function (Blueprint $table) {
            $table->dropForeign(['id_pedido']);
            $table->dropColumn('id_pedido');
        });
    }
};
