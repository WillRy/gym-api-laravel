<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlunoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("pesquisa");
        $alunos = Aluno::alunosPaginados($search);
        return response()->json($alunos);
    }

    public function show(Request $request, $idAluno)
    {
        $aluno = Aluno::alunoDetalhes($idAluno);
        if (empty($aluno)) {
            throw new NotFoundHttpException();
        }

        return response()->json($aluno);
    }

    public function store(Request $request)
    {
        $request->validate([
            "nome" => "required|max:255|min:3",
            "email" => "required|email|unique:alunos,email",
            "sexo" => "required|in:masculino,feminino,outro",
            "dt_nascimento" => "required|date_format:Y-m-d"
        ]);

        $aluno = Aluno::create($request->all());

        return response()->json($aluno);
    }

    public function update(Request $request, $idAluno)
    {
        $aluno = Aluno::alunoPorID($idAluno);
        if (empty($aluno)) {
            throw new NotFoundHttpException();
        }

        $request->validate([
            "nome" => "required|max:255|min:3",
            'email' => 'required|email|unique:alunos,email,' . $idAluno . ',id', //unique permite o email do proprio usuario
            "sexo" => "required|in:masculino,feminino,outro",
            "dt_nascimento" => "required|date_format:Y-m-d"
        ]);

        $aluno->update($request->all());
        $aluno->refresh();

        return response()->json($aluno);
    }

    public function delete(Request $request, $idAluno)
    {
        $aluno = Aluno::alunoPorID($idAluno);
        if (empty($aluno)) {
            throw new NotFoundHttpException();
        }

        $aluno->delete();

        return response()->json([], 204);
    }
}
