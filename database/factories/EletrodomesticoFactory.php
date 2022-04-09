<?php

namespace Database\Factories;

use App\Models\Eletrodomestico;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class EletrodomesticoFactory extends Factory
{
    protected $model = Eletrodomestico::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $descricao = ($this->faker->name) . ' - ' . ($this->faker->colorName);
        return [
            'marca_id' => $this->faker->numberBetween(Marca::min('id'), Marca::max('id')),
            'descricao' => $descricao
        ];
    }
}
