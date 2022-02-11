<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Plano;
use App\Rules\MatriculaUnica;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("pesquisa");
        $matriculas = Matricula::matriculasPaginadas($search);
        return response()->json($matriculas);
    }

    public function show(Request $request, $idMatricula)
    {
        $plano = Matricula::detalhes($idMatricula);
        if (empty($plano)) {
            throw new NotFoundHttpException();
        }

        return response()->json($plano);
    }

    public function store(Request $request)
    {
        $request->validate([
            "aluno_id" => ["required", "exists:alunos,id", new MatriculaUnica()],
            "plano_id" => "required|exists:planos,id",
            "dt_inicio" => "required|date_format:Y-m-d"
        ]);

        $plano = Plano::find($request->post("plano_id"));

        $matricula = Matricula::createComDuracao($request->all(), $plano->duracao);

        return response()->json($matricula);
    }

    public function update(Request $request, $idMatricula)
    {
        $request->validate([
            "dt_inicio" => "required|date_format:Y-m-d",
            "dt_fim" => "required|date_format:Y-m-d|after:" . $request->post("dt_inicio"),
            "plano_id" => "required|exists:planos,id"
        ]);

        $matricula = Matricula::matriculaPorID($idMatricula);
        if (empty($matricula)) {
            throw new NotFoundHttpException();
        }

        $matricula->update($request->all());
        $matricula->refresh();

        return response()->json($matricula);
    }

    public function delete(Request $request, $idMatricula)
    {
        //withTrashed: trazer alunos ativos e inativos
        $matricula = Matricula::matriculaPorID($idMatricula);
        if (empty($matricula)) {
            throw new NotFoundHttpException();
        }

        $matricula->delete();

        return response()->json([], 204);
    }
}
