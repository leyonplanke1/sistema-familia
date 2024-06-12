<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('idcliente')->constrained('clientes');
            $table->string('tipo_comprobante',20) ;
            $table->string('serie_comprobante',7);
            $table->string('num_comprobante',10) ; 
            $table->date('fecha') ;
            $table->integer('impuesto') ;
            $table->decimal('total_venta',7,2) ;
            $table->string('estado',20) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
