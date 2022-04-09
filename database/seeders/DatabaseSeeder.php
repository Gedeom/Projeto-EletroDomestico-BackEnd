<?php

namespace Database\Seeders;

use App\Models\Eletrodomestico;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        $eletrodomesticos = Eletrodomestico::factory(20)->make();
        $eletrodomesticos->each(function ($eletrodomestico) {
            Eletrodomestico::hasEletrodomestico($eletrodomestico->descricao, $eletrodomestico->marca_id) ?: $eletrodomestico->save();
        });
    }
}
