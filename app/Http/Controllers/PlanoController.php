<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoRequest;
use App\Models\Plano;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlanoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("pesquisa");
        $filtroAtivo = $request->input("status", "todos");
        $planos = Plano::planosPaginado($search, $filtroAtivo);
        return response()->json($planos);
    }

    public function show(Request $request, $idPlano)
    {
        //withTrashed: trazer alunos ativos e inativos
        $plano = Plano::planoPorID($idPlano);
        if (empty($plano)) {
            throw new NotFoundHttpException();
        }

        return response()->json($plano);
    }

    public function store(PlanoRequest $request)
    {
        $plano = Plano::create($request->all());

        return response()->json($plano);
    }

    public function update(PlanoRequest $request, $idPlano)
    {
        //withTrashed: trazer alunos ativos e inativos
        $plano = Plano::planoPorID($idPlano);
        if (empty($plano)) throw new NotFoundHttpException();

        $plano->update($request->all());
        $plano->refresh();

        return response()->json($plano);
    }

    public function delete(Request $request, $idPlano)
    {
        //withTrashed: trazer alunos ativos e inativos
        $plano = Plano::planoPorID($idPlano);
        if (empty($plano)) throw new NotFoundHttpException();

        $plano->delete();

        return response()->json([], 204);
    }
}
