<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->foreignId('idproveedor')->constrained('proveedors');
            $table->string('tipo_comprobante',20) ;
            $table->string('serie_comprobante',10) ->nullable();
            $table->string('num_comprobante',10) ; 
            $table->date('fecha') ;
            $table->integer('impuesto') ;
            $table->string('estado',45) ;
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
        Schema::dropIfExists('ingresos');
    }
}
