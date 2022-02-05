<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("aluno_id")->unsigned();
            $table->bigInteger("plano_id")->unsigned();

            $table->foreign("aluno_id")->references("id")->on("alunos");
            $table->foreign("plano_id")->references("id")->on("planos");

            $table->date("dt_inicio")->useCurrent();
            $table->date("dt_fim");

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
