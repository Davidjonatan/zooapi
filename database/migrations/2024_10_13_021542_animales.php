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
        schema::create('animales',function(Blueprint $table){
            $table->id();
            $table->string('nombre');
            $table->unsignedBiginteger('edad');
            $table->enum('genero',['M','H']);
            $table->unsignedBigInteger('id_de_especie');
            $table->unsignedBigInteger('id_habitat');
            $table->foreign('id_de_especie')
            ->references('id')
            ->on('especies')
            ->ondelete('cascade');
            $table->foreign('id_habitat')
            ->references('id')
            ->on('habitats')
            ->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animales');
    }
};
