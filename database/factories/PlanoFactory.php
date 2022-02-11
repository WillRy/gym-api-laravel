<?php

namespace Database\Factories;

use App\Models\Plano;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanoFactory extends Factory
{
    protected $model = Plano::class;

    public function definition()
    {
        $duracoes = [30, 90, 365];

        return [
            "nome" => $this->faker->word,
            "descricao" => $this->faker->paragraph,
            "duracao" => $this->faker->randomFloat(0,1,12),
            "valor" => $this->faker->randomFloat(2,'10','100')
        ];
    }
}
