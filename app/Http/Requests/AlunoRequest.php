<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AlunoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Route::current()->parameter("idAluno") ?? Route::current()->parameter("aluno");
        return [
            "nome" => "required|max:255|min:3",
            'email' => 'required|email|unique:alunos,email,' . $id . ',id', //unique permite o email do proprio usuario
            "sexo" => "required|in:masculino,feminino,outro",
            "dt_nascimento" => "required|date_format:Y-m-d"
        ];
    }
}
