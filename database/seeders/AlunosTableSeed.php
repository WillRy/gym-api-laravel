<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AlunosTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Aluno::factory(10)->create();
    }
}
