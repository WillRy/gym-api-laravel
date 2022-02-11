<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Plano;
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
         \App\Models\User::factory(30)->create();

         \App\Models\User::factory()->count(1)->state([
             "email" => "teste@teste.com"
         ])->create();

         \App\Models\Aluno::factory(60)->create();

         \App\Models\Plano::factory(20)->create();

         $alunos = Aluno::all();
         foreach ($alunos as $aluno) {
             $plano = Plano::all()->random();

             $dt_fim = (new \DateTime())
                 ->add(\DateInterval::createFromDateString("+{$plano->duracao}months"))
                 ->format("Y-m-d");

             \App\Models\Matricula::factory()->count(1)->state([
                 "aluno_id" => $aluno->id,
                 "plano_id" => $plano->id,
                 "dt_inicio" => date("Y-m-d"),
                 "dt_fim" => $dt_fim
             ])->create();
         }

    }
}
