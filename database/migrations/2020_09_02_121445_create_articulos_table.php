<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idcategoria')->constrained('categorias');
            $table->string('codigo',45)->nullable();
            $table->string('nombre',100) ;
            $table->integer('stock') ;
            $table->string('descripcion',512)->nullable();
            $table->string('imagen',100)->nullable();
            $table->string('estado',50) ;
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
        Schema::dropIfExists('articulos');
    }
}
