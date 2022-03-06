<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatriculaRequest;
use App\Models\Matricula;
use App\Models\Plano;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("pesquisa");
        $filtroAtivo = $request->input("status", "todos");
        $matriculas = Matricula::matriculasPaginadas($search, $filtroAtivo);
        return response()->json($matriculas);
    }

    public function show(Request $request, $idMatricula)
    {
        $plano = Matricula::detalhes($idMatricula);
        if (empty($plano)) throw new NotFoundHttpException();

        return response()->json($plano);
    }

    public function store(MatriculaRequest $request)
    {
        $plano = Plano::find($request->post("plano_id"));

        $matricula = Matricula::createComDuracao($request->all(), $plano->duracao);

        return response()->json($matricula);
    }

    public function update(MatriculaRequest $request, $idMatricula)
    {

        $matricula = Matricula::matriculaPorID($idMatricula);
        if (empty($matricula)) throw new NotFoundHttpException();

        $matricula->update($request->all());
        $matricula->refresh();

        return response()->json($matricula);
    }

    public function delete(Request $request, $idMatricula)
    {
        $matricula = Matricula::matriculaPorID($idMatricula);
        if (empty($matricula)) throw new NotFoundHttpException();

        $matricula->delete();

        return response()->json([], 204);
    }
}
