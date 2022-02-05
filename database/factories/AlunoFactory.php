<?php

namespace Database\Factories;

use App\Models\Aluno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlunoFactory extends Factory
{
    protected $model = Aluno::class;

    public function definition()
    {
        $sexo = $this->faker->randomElement(["masculino", "feminino", "outro"]);
        $genero = $sexo === "masculino" ? "male" : "female";

        $dataAtual = (new \DateTime());
        $timestampNascimento = $dataAtual->sub(new \DateInterval('P18Y'))->getTimestamp();

        return [
            "nome" => $this->faker->name($genero),
            "email" => $this->faker->safeEmail(),
            "dt_nascimento" => $this->faker->date("Y-m-d", $timestampNascimento),
            "sexo" => $sexo
        ];
    }
}
