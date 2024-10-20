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
        schema::create('cuidadores_de_animales',function(Blueprint $table){
            $table->id();
            $table->unsignedBiginteger('id_animal');
            $table->unsignedBiginteger('id_empleado');

            
            $table->foreign('id_animal')
            ->references('id')
            ->on('animales')
            ->ondelete('cascade');
            $table->foreign('id_empleado')
            ->references('id')
            ->on('empleados')
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
        Schema::dropIfExists('cuidadores_de_animales');
    }
};
