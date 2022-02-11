<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlanoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("pesquisa");
        $planos = Plano::planosPaginado($search);
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

    public function store(Request $request)
    {
        $request->validate([
            "nome" => "required|max:255|min:3|unique:planos,nome",
            "descricao" => "nullable|max:255|min:3",
            "duracao" => "required|integer|min:1",
            "valor" => "required|numeric"
        ]);

        $plano = Plano::create($request->all());

        return response()->json($plano);
    }

    public function update(Request $request, $idPlano)
    {
        //withTrashed: trazer alunos ativos e inativos
        $plano = Plano::planoPorID($idPlano);
        if (empty($plano)) {
            throw new NotFoundHttpException();
        }

        $request->validate([
            "nome" => "required|max:255|min:3|unique:planos,nome," . $idPlano . ",id",
            "descricao" => "nullable|max:255|min:3",
            "duracao" => "required|integer|min:1",
            "valor" => "required|numeric"
        ]);

        $plano->update($request->all());
        $plano->refresh();

        return response()->json($plano);
    }

    public function delete(Request $request, $idPlano)
    {
        //withTrashed: trazer alunos ativos e inativos
        $plano = Plano::planoPorID($idPlano);
        if (empty($plano)) {
            throw new NotFoundHttpException();
        }

        $plano->delete();

        return response()->json([], 204);
    }
}
