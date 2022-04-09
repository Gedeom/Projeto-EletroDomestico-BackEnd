<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEletrodomesticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eletrodomestico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marca_id');
            $table->string('descricao');
            $table->timestamps();

            $table->foreign('marca_id','fk_eletrodomestico_marca_marca_id')->references('id')->on('marca');
            $table->unique(['descricao','marca_id'],'unique_eletrodomestico_descricao_marca_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eletrodomestico');
    }
}
