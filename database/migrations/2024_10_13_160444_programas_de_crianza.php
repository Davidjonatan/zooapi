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
        schema::create('programas_de_crianza',function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->date('fecha_de_inicio');
            $table->date('fecha_de_finalizacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programas_de_crianza');
    }
};
