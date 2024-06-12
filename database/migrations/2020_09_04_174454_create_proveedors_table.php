<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {

            $table->id();            
            $table->string('nombre',100) ;
            $table->foreignId('iddocumento')->constrained('documentos'); 
            $table->string('num_documento',15) ->nullable();
            $table->string('direccion',100) ->nullable();
            $table->string('telefono',15) ->nullable(); 
            $table->string('email',100) ->nullable(); 
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
        Schema::dropIfExists('proveedors');
    }
}
