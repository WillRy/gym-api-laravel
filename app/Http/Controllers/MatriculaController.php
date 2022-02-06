<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Plano;
use App\Rules\MatriculaUnica;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::withTrashed()->with("aluno")->with("plano")->paginate(10);
        return response()->json($matriculas);
    }

    public function show(Request $request, $idMatricula)
    {
        //withTrashed: trazer alunos ativos e inativos
        $plano = Matricula::withTrashed()->with("aluno")->with("plano")->where(["id" => $idMatricula])->first();
        if(empty($plano)) {
            throw new NotFoundHttpException();
        }

        return response()->json($plano);
    }

    public function store(Request $request)
    {
        $request->validate([
            "aluno_id" => ["required","exists:alunos,id", new MatriculaUnica()],
            "plano_id" => "required|exists:planos,id",
            "dt_inicio" => "required|date_format:Y-m-d"
        ]);

        $dados = $request->all();
        $plano = Plano::find($request->post("plano_id"));

        $dataInicio = (new \DateTime($request->post("dt_inicio")))->format("Y-m-d");
        $dataFim = (new \DateTime($request->post("dt_inicio")))
            ->add(\DateInterval::createFromDateString("+{$plano->duracao}months"))
            ->format("Y-m-d");

        $dados["dt_inicio"] = $dataInicio;
        $dados["dt_fim"] = $dataFim;

        $matricula = Matricula::create($dados);

        return response()->json($matricula);
    }

    public function update(Request $request, $idMatricula)
    {
        $request->validate([
            "dt_inicio" => "required|date_format:Y-m-d",
            "dt_fim" => "required|date_format:Y-m-d|after:".$request->post("dt_inicio"),
        ]);

        $matricula = Matricula::withTrashed()->where(["id" => $idMatricula])->first();
        if(empty($matricula)) {
            throw new NotFoundHttpException();
        }

        $matricula->update($request->all());
        $matricula->refresh();

        return response()->json($matricula);
    }

    public function delete(Request $request, $idMatricula)
    {
        //withTrashed: trazer alunos ativos e inativos
        $matricula = Matricula::withTrashed()->where(["id" => $idMatricula])->first();
        if(empty($matricula)) {
            throw new NotFoundHttpException();
        }

        $matricula->delete();

        return response()->json([], 204);
    }
}
