<?php

namespace App\Http\Requests;

use App\Rules\MatriculaUnica;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class MatriculaRequest extends FormRequest
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
        $method = Request::method();
        if($method === "POST") {
            return [
                "aluno_id" => ["required", "exists:alunos,id", new MatriculaUnica()],
                "plano_id" => "required|exists:planos,id",
                "dt_inicio" => "required|date_format:Y-m-d"
            ];
        } elseif($method === "PUT") {
            return [
                "dt_inicio" => "required|date_format:Y-m-d",
                "dt_fim" => "required|date_format:Y-m-d|after:" . $this->dt_inicio,
            ];
        }

        return [];
    }
}
