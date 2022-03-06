<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlunoRequest;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("pesquisa");
        $filtroAtivo = $request->input("status", "todos");
        $alunos = Aluno::alunosPaginados($search, $filtroAtivo);
        return response()->json($alunos);
    }

    public function show(Request $request, $idAluno)
    {
        $aluno = Aluno::alunoDetalhes($idAluno);
        if (empty($aluno)) throw new NotFoundHttpException();

        return response()->json($aluno);
    }

    public function store(AlunoRequest $request)
    {
        $aluno = Aluno::create($request->all());
        return response()->json($aluno);
    }

    public function update(AlunoRequest $request, $idAluno)
    {
        $aluno = Aluno::alunoPorID($idAluno);
        if (empty($aluno)) throw new NotFoundHttpException();

        $aluno->update($request->all());
        $aluno->refresh();

        return response()->json($aluno);
    }

    public function delete(Request $request, $idAluno)
    {
        $aluno = Aluno::alunoPorID($idAluno);
        if (empty($aluno)) throw new NotFoundHttpException();

        $aluno->delete();

        return response()->json([], 204);
    }
}
