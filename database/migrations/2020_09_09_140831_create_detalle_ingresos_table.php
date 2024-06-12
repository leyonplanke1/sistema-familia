<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->foreignId('idingreso')->constrained('ingresos');
            $table->foreignId('idarticulo')->constrained('articulos');
            $table->integer('cantidad');
            $table->decimal('precio_compra',7,2) ; 
            $table->decimal('precio_venta',7,2) ;
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
        Schema::dropIfExists('detalle_ingresos');
    }
}
