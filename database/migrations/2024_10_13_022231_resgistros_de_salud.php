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
        schema::create('registros_de_salud',function(Blueprint $table){
            $table->id();
            $table->unsignedBiginteger('id_animal');
            $table->date('fecha_de_revision');
            $table->string('estado_de_salud');

            
            $table->foreign('id_animal')
            ->references('id')
            ->on('animales')
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
        Schema::dropIfExists('registros_de_salud');

    }
};
