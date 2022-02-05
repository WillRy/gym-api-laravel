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
         \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->count(1)->state([
             "email" => "teste@teste.com"
         ])->create();

         $this->call(AlunosTableSeed::class);

         \App\Models\Plano::factory(10)->create();

         $alunos = Aluno::all();
         foreach ($alunos as $aluno) {
             $plano = Plano::all()->random();

             $dt_fim = (new \DateTime())
                 ->add(\DateInterval::createFromDateString("+{$plano->duracao}days"))
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
