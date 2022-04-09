<?php

use Database\Seeders\MarcaSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marca', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        $seed = new MarcaSeeder();
        $seed->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marca');
    }
}
